<?php

// app/Models/WeatherInfo.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'latitude',
        'longitude',
        'temperature',
        'weather_description',
        'timezone',
        'date_time'
    ];
}
