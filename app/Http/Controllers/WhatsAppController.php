<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use App\Models\SensorReading;

class WhatsAppController extends Controller
{
    public function sendAlert()
    {
        // Obtem os últimos dados do banco de dados
        $latestReading = SensorReading::latest()->first();

        // Verifica se existem dados para enviar
        if ($latestReading) {
            $temperature = $latestReading->temperature;
            $humidity = $latestReading->humidity;
            $soilMoisture = $latestReading->soil_moisture;

            $toNumber = 'whatsapp:+5511999999999'; // Substitua pelo número de destino

            // Monta a mensagem
            $message = "🌡️ Temperatura: {$temperature}°C\n";
            $message .= "💧 Umidade: {$humidity}%\n";
            $message .= "🌱 Umidade do Solo: {$soilMoisture}%\n";
            $message .= "⚠️ Verifique os parâmetros!";

            // Envia a mensagem via Twilio
            $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

            try {
                $twilio->messages->create(
                    $toNumber,
                    [
                        'from' => env('TWILIO_WHATSAPP_NUMBER'),
                        'body' => $message
                    ]
                );

                return response()->json(['message' => 'Mensagem enviada com sucesso!'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['error' => 'Nenhum dado encontrado para enviar'], 404);
        }
    }
}
