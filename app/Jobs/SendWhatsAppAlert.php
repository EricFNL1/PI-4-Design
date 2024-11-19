<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Twilio\Rest\Client;

class WhatsAppController extends Controller
{
    public function sendAlert()
    {
        // Recupera os dados do sensor do cache
        $data = Cache::get('sensor_data');

        if ($data && isset($data['temperature']) && $data['temperature'] > 30) {
            try {
                // Cria uma instância do cliente Twilio
                $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

                // Envia a mensagem via WhatsApp
                $message = $twilio->messages->create(
                    'whatsapp:+5519983224023', // Número de destino no formato WhatsApp
                    [
                        'from' => 'whatsapp:+14155238886', // Número Twilio Sandbox para WhatsApp
                        'body' => 'Alerta! Temperatura acima de 30°C: ' . $data['temperature'] . '°C'
                    ]
                );

                return response()->json(['message' => 'Mensagem enviada com sucesso!', 'sid' => $message->sid]);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Erro ao enviar mensagem: ' . $e->getMessage()], 500);
            }
        }

        return response()->json(['message' => 'Nenhum alerta necessário.'], 200);
    }
}
