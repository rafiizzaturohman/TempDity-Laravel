<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'devices' => Device::all()
        ]);
    }

    public function toggle($id)
    {
        $device = Device::findOrFail($id);
        $device->status = !$device->status;
        $device->save();
        
        return response()->json([
            'id'=>$device->id,
            'name'=>$device->name,
            'status'=>$device->status,
        ]);
    }

    public function deviceStatus()
    {
        return response()->json(Device::select('id', 'status')->get());
    }
}
