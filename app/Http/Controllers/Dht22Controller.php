<?php

namespace App\Http\Controllers;

use App\Models\Dht22;
use App\Models\SensorLog;
use Illuminate\Http\Request;

class Dht22Controller extends Controller
{
    public function __construct() 
    {
        $dht = Dht22::count();
        if($dht == 0){
            Dht22::create([
                'temperature' => 0,
                'humidity' => 0,
                'read_request' => false
            ]);
        }
    }

    public function updateData($tmp, $hmd){
        $dht = Dht22::first();
        $dht->temperature = $tmp;
        $dht->humidity = $hmd;
        
        // Reset read_request setelah data diterima
        if($dht->read_request) {
            $dht->read_request = false;
            $dht->save(); // Simpan dulu sebelum update log
            
            // Update log terakhir yang statusnya pending
            $pendingLog = SensorLog::where('status', 'pending')
                                 ->orderBy('request_time', 'desc')
                                 ->first();
            
            if($pendingLog) {
                $pendingLog->update([
                    'response_time' => now(),
                    'temperature' => $tmp,
                    'humidity' => $hmd,
                    'status' => 'success'
                ]);
            }
        } else {
            $dht->save();
        }

        return response()->json([
            'message' => 'Data updated successfully',
            'data' => $dht
        ]);
    }

    public function getData(){
        $dht = Dht22::first();
        return response()->json($dht);
    }

    // TOMBOL BACA SENSOR SEKARANG - Set read_request ke true
    public function triggerReadSensor()
    {
        $dht = Dht22::first();
        $dht->read_request = true;
        $dht->save();

        // Buat log request manual
        $log = SensorLog::create([
            'request_time' => now(),
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Read sensor request sent',
            'read_request' => true,
            'log_id' => $log->id
        ]);
    }

    // API untuk polling NodeMCU - PERBAIKI FORMAT RESPONSE
    public function checkReadRequest()
    {
        $dht = Dht22::first();
        return response()->json([
            'read_request' => (bool)$dht->read_request, // Pastikan boolean
            'timestamp' => now()->toISOString()
        ]);
    }

    // API untuk mendapatkan log data
    public function getLogs(Request $request)
    {
        $page  = $request->query('page', 1);
        $limit = $request->query('limit', 5); 

        $query = SensorLog::orderBy('request_time', 'desc');

        $total = $query->count();

        $logs = $query->skip(($page - 1) * $limit)
                    ->take($limit)
                    ->get()
                    ->map(function($log) {
                            return [
                                'id' => $log->id,
                                'request_time' => $log->request_time->format('H:i:s'),
                                'response_time' => $log->response_time 
                                    ? $log->response_time->format('H:i:s') 
                                    : '--',
                                'temperature' => $log->temperature ?? '--',
                                'humidity'    => $log->humidity ?? '--',
                                'status'      => $log->status,
                                'status_badge'=> $this->getStatusBadge($log->status)
                            ];
                    });

        return response()->json([
            'data'  => $logs,
            'total' => $total,
            'page'  => intval($page),
            'limit' => intval($limit)
        ]);
    }

    private function getStatusBadge($status)
    {
        switch($status) {
            case 'pending':
                return '<span class="px-2 py-1 bg-yellow-500 text-white rounded-full text-xs">Pending</span>';
            case 'success':
                return '<span class="px-2 py-1 bg-green-500 text-white rounded-full text-xs">Sukses</span>';
            case 'failed':
                return '<span class="px-2 py-1 bg-red-500 text-white rounded-full text-xs">Gagal</span>';
            default:
                return '<span class="px-2 py-1 bg-gray-500 text-white rounded-full text-xs">Unknown</span>';
        }
    }

    public function updateNilaiMaksimal(Request $request){
        $nilai = $request->nilai;
        $jenisNilai = $request->jenis_nilai;
        $dht = Dht22::first();
        
        if ($jenisNilai == 'max_temperature'){
            $dht->max_temperature = $nilai;
            $dht->save();
        } else if ($jenisNilai == 'max_humidity'){
            $dht->max_humidity = $nilai;
            $dht->save();
        } else {
            return response()->json([
                'error' => 'Gagal upload data',
            ]);
        }

        return redirect()->to('/');
    }

    public function updateNilaiMinimal(Request $request){
        $nilai = $request->nilai;
        $jenisNilai = $request->jenis_nilai;
        $dht = Dht22::first();
        
        if ($jenisNilai == 'min_temperature'){
            $dht->min_temperature = $nilai;
            $dht->save();
        } else if ($jenisNilai == 'min_humidity'){
            $dht->min_humidity = $nilai;
            $dht->save();
        } else {
            return response()->json([
                'error' => 'Gagal upload data',
            ]);
        }

        return redirect()->to('/');
    }
}