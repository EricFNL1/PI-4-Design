<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class WhatsAppController extends Controller
{
    public function sendMessage()
{
    try {
        $twilio = new \Twilio\Rest\Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        $message = $twilio->messages->create(
            'whatsapp:+5519983224023', // Substitua pelo número de destino
            [
                'from' => 'whatsapp:+14155238886', // Número Twilio
                'body' => 'Mensagem simples enviada durante a janela de 24 horas.'
            ]
        );

        return response()->json(['message' => 'Mensagem enviada com sucesso!', 'sid' => $message->sid]);
    } catch (\Exception $e) {
        \Log::error('Erro ao enviar mensagem WhatsApp', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Erro ao enviar mensagem: ' . $e->getMessage()], 500);
    }
}

    public function sendTestMessage()
    {
        try {
            // Mensagem de teste simples
            $messageBody = "Teste de envio de mensagem via WhatsApp usando Twilio.";

            // Inicializa o cliente Twilio
            $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
            $twilio->messages->create(
                'whatsapp:+5519983224023', // Número do destinatário
                [
                    'from' => env('TWILIO_WHATSAPP_FROM'), // Número do Twilio
                    'body' => $messageBody
                ]
            );

            return response()->json(['message' => 'Mensagem enviada com sucesso!']);
        } catch (\Exception $e) {
            // Log do erro e resposta em caso de falha
            \Log::error('Erro ao enviar mensagem no WhatsApp', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao enviar mensagem: ' . $e->getMessage()], 500);
        }
    }
}
