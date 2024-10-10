<?php

// app/Http/Controllers/WeatherInfoController.php

// app/Http/Controllers/WeatherInfoController.php
// app/Http/Controllers/WeatherInfoController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeatherInfo;
use Illuminate\Support\Facades\Http;

class WeatherInfoController extends Controller
{ public function getWeatherFromIP(Request $request)
    {
        // Obter o IP do cliente
        $ip = $request->ip();

        // Busca a localização pelo IP usando ipinfo.io, ignorando a verificação do certificado SSL
        $ipInfoUrl = "https://ipinfo.io/{$ip}?token=" . env('IPINFO_API_KEY');
        $ipInfoResponse = Http::withOptions(['verify' => false])->get($ipInfoUrl);
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

        // Busca o fuso horário pela Google Timezone API
        $googleTimezoneUrl = "https://maps.googleapis.com/maps/api/timezone/json";
        $googleTimezoneResponse = Http::get($googleTimezoneUrl, [
            'location' => "$latitude,$longitude",
            'timestamp' => time(),
            'key' => env('GOOGLE_API_KEY')
        ]);

        $timezoneData = $googleTimezoneResponse->json();
        $timezone = $timezoneData['timeZoneId'] ?? null;
        $formattedDateTime = $timezone ? (new \DateTime('now', new \DateTimeZone($timezone)))->format('Y-m-d H:i:s') : null;

        // Armazena as informações na base de dados
        $weatherInfo = WeatherInfo::create([
            'latitude' => $latitude,
            'longitude' => $longitude,
            'temperature' => $temperature,
            'weather_description' => $weatherDescription,
            'timezone' => $timezone,
            'date_time' => $formattedDateTime
        ]);

        // Retorna a view com os dados armazenados
        return view('weather_info', compact('weatherInfo'));
    }
}
