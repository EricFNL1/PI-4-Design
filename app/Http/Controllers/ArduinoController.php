<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class WhatsAppController extends Controller
{
    public function sendAlert()
    {
        try {
            // Busca os dados do sensor do cache ou do ESP32
            $data = Cache::get('sensor_data', function () {
                $response = Http::timeout(5)->get('http://192.168.6.5/data');
                if ($response->successful()) {
                    return $response->json();
                }
                throw new \Exception('Erro na resposta do ESP32: ' . $response->body());
            });

            if (!$data || !isset($data['temperature'], $data['humidity'])) {
                return response()->json(['message' => 'Dados do sensor indisponíveis ou incompletos.'], 400);
            }

            // Verifica os limites
            $temperature = $data['temperature'];
            $humidity = $data['humidity'];
            $soilMoisture = $data['soil_moisture'] ?? 'Desconhecido';

            $alertMessages = [];
            if ($temperature > 30) {
                $alertMessages[] = "⚠️ Temperatura alta: {$temperature}°C.";
            }
            if ($humidity < 40) {
                $alertMessages[] = "⚠️ Umidade baixa: {$humidity}%.";
            }

            // Se houver alertas, envia a mensagem
            if (!empty($alertMessages)) {
                $messageBody = implode("\n", $alertMessages) . "\n🌱 Umidade do solo: {$soilMoisture}.";

                $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

                $twilio->messages->create(
                    'whatsapp:+5519983224023', // Número do destinatário
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
