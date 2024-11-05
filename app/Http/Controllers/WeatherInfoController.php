<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeatherInfo;
use Illuminate\Support\Facades\Http;

class WeatherInfoController extends Controller
{
    public function getWeatherFromIP(Request $request)
{
    // Obter o IP do cliente
    $ip = $request->ip();

    // Busca a localização pelo IP usando ipinfo.io
    $ipInfoUrl = "https://ipinfo.io/{$ip}?token=" . env('IPINFO_API_KEY');
    $ipInfoResponse = Http::get($ipInfoUrl);
    $locationData = $ipInfoResponse->json();

    if (isset($locationData['loc'])) {
        list($latitude, $longitude) = explode(',', $locationData['loc']);
    } else {
        return response()->json(['error' => 'Não foi possível determinar a localização pelo IP'], 400);
    }

    // Busca o clima pela API OpenWeatherMap
    $openWeatherUrl = "https://api.openweathermap.org/data/2.5/weather";
    $openWeatherResponse = Http::get($openWeatherUrl, [
        'lat' => $latitude,
        'lon' => $longitude,
        'appid' => env('OPENWEATHER_API_KEY'),
        'units' => 'metric',
        'lang' => 'pt_br'
    ]);

    $weatherData = $openWeatherResponse->json();
    $temperature = $weatherData['main']['temp'] ?? null;
    $weatherDescription = $weatherData['weather'][0]['description'] ?? null;

    return response()->json([
        'latitude' => $latitude,
        'longitude' => $longitude,
        'temperature' => $temperature,
        'weather_description' => $weatherDescription
    ]);
}

}
