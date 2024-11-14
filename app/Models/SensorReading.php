<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorReading extends Model
{
    use HasFactory;

    protected $table = 'sensor_readings'; // Define explicitamente o nome da tabela
    protected $fillable = ['temperature', 'humidity', 'soil_moisture'];
}
