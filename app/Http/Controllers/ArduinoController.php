<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class ArduinoController extends Controller
{
    private $esp32Ip = 'http://192.168.4.1'; // IP do ESP32

    // Liga o relé
    public function turnRelayOn()
    {
        try {
            $response = Http::timeout(5)->get("{$this->esp32Ip}/toggleRelayOn");
            return response()->json(['message' => $response->body()]);
        } catch (\Exception $e) {
            Log::error('Erro ao ligar o relé', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao conectar ao ESP32'], 500);
        }
    }

    // Desliga o relé
    public function turnRelayOff()
    {
        try {
            $response = Http::timeout(5)->get("{$this->esp32Ip}/toggleRelayOff");
            return response()->json(['message' => $response->body()]);
        } catch (\Exception $e) {
            Log::error('Erro ao desligar o relé', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao conectar ao ESP32'], 500);
        }
    }

    // Ativa a bomba
    public function activatePump()
    {
        try {
            $response = Http::timeout(5)->get("{$this->esp32Ip}/activatePump");
            return response()->json(['message' => $response->body()]);
        } catch (\Exception $e) {
            Log::error('Erro ao ativar a bomba', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao conectar ao ESP32'], 500);
        }
    }

    // Liga a ventilação
    public function turnVentilationOn()
    {
        try {
            $response = Http::timeout(5)->get("{$this->esp32Ip}/toggleRelay3On");
            return response()->json(['message' => $response->body()]);
        } catch (\Exception $e) {
            Log::error('Erro ao ligar a ventilação', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao conectar ao ESP32'], 500);
        }
    }

    // Desliga a ventilação
    public function turnVentilationOff()
    {
        try {
            $response = Http::timeout(5)->get("{$this->esp32Ip}/toggleRelay3Off");
            return response()->json(['message' => $response->body()]);
        } catch (\Exception $e) {
            Log::error('Erro ao desligar a ventilação', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao conectar ao ESP32'], 500);
        }
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

    public function fetchAndSaveSensorData()
    {
        try {
            // Faz a requisição ao ESP32 para obter os dados do sensor
            $response = Http::timeout(5)->get("{$this->esp32Ip}/data");

            if ($response->successful()) {
                $data = $response->json();

                // Verifica se os dados estão completos
                if (isset($data['temperature'], $data['humidity'], $data['soil_moisture'])) {
                    // Salva os dados no banco
                    SensorData::create([
                        'temperature' => $data['temperature'],
                        'humidity' => $data['humidity'],
                        'soil_moisture' => $data['soil_moisture'],
                    ]);

                    return response()->json(['message' => 'Dados salvos com sucesso!']);
                }

                return response()->json(['error' => 'Dados incompletos recebidos do ESP32.'], 400);
            }

            return response()->json(['error' => 'Falha na comunicação com o ESP32.'], $response->status());
        } catch (\Exception $e) {
            Log::error('Erro ao buscar ou salvar dados do ESP32', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao processar os dados: ' . $e->getMessage()], 500);
        }
    }
}

class WhatsAppController extends Controller
{
    public function sendAlert()
    {
        try {
            // Recupera os dados do sensor do cache ou diretamente do ESP32
            $data = Cache::get('sensor_data', function () {
                $response = Http::timeout(5)->get('http://192.168.4.1/data');
                if ($response->successful()) {
                    return $response->json();
                }
                throw new \Exception('Erro ao conectar ao ESP32: ' . $response->body());
            });

            // Valida os dados do sensor
            if (!$data || !isset($data['temperature'], $data['humidity'])) {
                return response()->json(['message' => 'Dados do sensor indisponíveis ou incompletos.'], 400);
            }

            // Dados do sensor
            $temperature = $data['temperature'];
            $humidity = $data['humidity'];
            $soilMoisture = $data['soil_moisture'] ?? 'Desconhecido';

            // Define mensagens de alerta
            $alertMessages = [];
            if ($temperature > 30) {
                $alertMessages[] = "⚠️ Temperatura alta: {$temperature}°C.";
            }
            if ($humidity < 40) {
                $alertMessages[] = "⚠️ Umidade baixa: {$humidity}%.";
            }

            // Envia mensagem se houver alertas
            if (!empty($alertMessages)) {
                $messageBody = implode("\n", $alertMessages) . "\n🌱 Umidade do solo: {$soilMoisture}.";

                // Envia mensagem pelo Twilio
                $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
                $twilio->messages->create(
                    'whatsapp:+5519983224023', // Substitua pelo número do destinatário
                    [
                        'from' => 'whatsapp:+14155238886', // Número do Twilio
                        'body' => "🚨 Alerta da Estufa:\n\n" . $messageBody
                    ]
                );

                return response()->json(['message' => 'Alerta enviado com sucesso!']);
            }

            return response()->json(['message' => 'Nenhum alerta necessário. Valores normais.']);
        } catch (\Exception $e) {
            Log::error('Erro ao enviar alerta via WhatsApp', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao enviar mensagem: ' . $e->getMessage()], 500);
        }
    }
}
