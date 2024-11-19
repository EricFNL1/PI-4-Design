<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ArduinoController extends Controller
{
    private $esp32Ip = 'http://192.168.6.5'; // Endereço do ESP32

    // Obtém os dados dos sensores do ESP32
    public function getSensorData()
    {
        try {
            return Cache::remember('sensor_data', 15, function () {
                $response = Http::timeout(5)->get('http://192.168.6.5/data');

                if ($response->successful()) {
                    return $response->json();
                }

                throw new \Exception('Erro na resposta do ESP32: ' . $response->body());
            });
        } catch (\Exception $e) {
            Log::error('Erro ao obter dados do ESP32', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Não foi possível obter os dados do ESP32.'], 500);
        }
    }

    // Liga a luz (relay 1)
    public function turnRelayOn()
    {
        return $this->sendCommand('toggleRelayOn', 'Luz Ligada');
    }

    // Desliga a luz (relay 1)
    public function turnRelayOff()
    {
        return $this->sendCommand('toggleRelayOff', 'Luz Desligada');
    }

    // Liga a ventilação (relay 3)
    public function turnVentilationOn()
    {
        return $this->sendCommand('toggleRelay3On', 'Ventilação Ligada');
    }

    // Desliga a ventilação (relay 3)
    public function turnVentilationOff()
    {
        return $this->sendCommand('toggleRelay3Off', 'Ventilação Desligada');
    }

    // Ativa a bomba de água (relay 4)
    public function activatePump()
    {
        return $this->sendCommand('activatePump', 'Bomba Ativada');
    }

    // Alterna o modo entre manual e automático
    public function toggleMode()
    {
        try {
            $response = Http::timeout(5)->get("{$this->esp32Ip}/toggleMode");

            if ($response->successful()) {
                $currentMode = $response->body(); // Resposta do ESP32
                return response()->json(['mode' => $currentMode], 200);
            }

            throw new \Exception('Falha ao alternar o modo no ESP32.');
        } catch (\Exception $e) {
            Log::error('Erro ao alternar o modo automático:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Não foi possível alternar o modo automático.'], 500);
        }
    }

    // Função genérica para enviar comandos ao ESP32
    private function sendCommand($endpoint, $successMessage)
    {
        try {
            $response = Http::timeout(5)->get("{$this->esp32Ip}/{$endpoint}");

            if ($response->successful()) {
                Log::info("Comando enviado: {$endpoint}", ['response' => $response->body()]);
                return response()->json(['message' => $successMessage], 200);
            }

            throw new \Exception('Falha ao enviar comando.');
        } catch (\Exception $e) {
            Log::error("Erro ao enviar comando: {$endpoint}", ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao conectar ao ESP32.'], 500);
        }
    }
}
