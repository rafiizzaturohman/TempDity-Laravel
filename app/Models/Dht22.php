<?php
// [file name]: Dht22.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dht22 extends Model
{
    protected $guarded = ['id'];
    
    // Tambah properti fillable jika perlu
    protected $fillable = [
        'temperature', 
        'humidity', 
        'max_temperature', 
        'max_humidity', 
        'min_temperature', 
        'min_humidity',
        'read_request'
    ];
}