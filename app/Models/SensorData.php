<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    use HasFactory;

    protected $table = 'sensor_data';

    protected $fillable = [
        'temperature',
        'humidity',
        'soil_moisture',
    ];

    public $timestamps = true; // Garante que created_at e updated_at sejam manipulados automaticamente
}
