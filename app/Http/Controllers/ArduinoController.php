<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ArduinoController extends Controller
{

    public function getSensorData()
{
    return Cache::remember('sensor_data', 15, function () {
        $response = Http::timeout(5)->get('http://192.168.6.5/dados');
        return $response->json();
    });
}
    // Atualiza o IP do ESP32
    private $esp32Ip = 'http://192.168.6.5'; // Novo IP do ESP32 na rede Wi-Fi

    public function turnRelayOn()
    {
        try {
            $response = Http::timeout(5)->get("{$this->esp32Ip}/toggleRelayOn");
            Log::info('Comando de ligar relay enviado', ['response' => $response->body()]);
            return $response->body();
        } catch (\Exception $e) {
            Log::error('Erro ao enviar comando de ligar relay', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao conectar ao ESP32'], 500);
        }
    }

    public function turnRelayOff()
    {
        try {
            $response = Http::timeout(5)->get("{$this->esp32Ip}/toggleRelayOff");
            Log::info('Comando de desligar relay enviado', ['response' => $response->body()]);
            return $response->body();
        } catch (\Exception $e) {
            Log::error('Erro ao enviar comando de desligar relay', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao conectar ao ESP32'], 500);
        }
    }

    public function activatePump()
    {
        try {
            $response = Http::timeout(5)->get("{$this->esp32Ip}/activatePump");
            Log::info('Comando de ativar bomba enviado', ['response' => $response->body()]);
            return $response->body();
        } catch (\Exception $e) {
            Log::error('Erro ao enviar comando de ativar bomba', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao conectar ao ESP32'], 500);
        }
    }

    public function turnVentilationOn()
    {
        try {
            $response = Http::timeout(5)->get("{$this->esp32Ip}/toggleRelay3On");
            Log::info('Comando de ligar ventilação enviado', ['response' => $response->body()]);
            return $response->body();
        } catch (\Exception $e) {
            Log::error('Erro ao enviar comando de ligar ventilação', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao conectar ao ESP32'], 500);
        }
    }

    public function turnVentilationOff()
    {
        try {
            $response = Http::timeout(5)->get("{$this->esp32Ip}/toggleRelay3Off");
            Log::info('Comando de desligar ventilação enviado', ['response' => $response->body()]);
            return $response->body();
        } catch (\Exception $e) {
            Log::error('Erro ao enviar comando de desligar ventilação', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao conectar ao ESP32'], 500);
        }
    }
}
