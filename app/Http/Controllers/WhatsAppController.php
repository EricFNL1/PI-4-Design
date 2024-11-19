<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class WhatsAppController extends Controller
{
    public function sendAlert()
    {
        try {
            $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

            $twilio->messages->create(
                'whatsapp:+5519983224023', // Substitua pelo número do destinatário
                [
                    'from' => env('TWILIO_WHATSAPP_FROM'), // Número do Twilio
                    'body' => 'Olá! Este é um alerta de teste via WhatsApp.'
                ]
            );

            return response()->json(['message' => 'Mensagem enviada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao enviar mensagem: ' . $e->getMessage()], 500);
        }
    }
}
