<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class WhatsAppController extends Controller
{
    public function sendStatus()
    {
        try {
            $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    
            // Enviar mensagem para o WhatsApp
            $whatsappMessage = $twilio->messages->create(
                'whatsapp:+5519983224023', // Número do destinatário no WhatsApp
                [
                    'from' => env('TWILIO_WHATSAPP_FROM'), // Número Twilio para WhatsApp
                    'body' => '⚡ Status Atual: Temperatura 28°C, Umidade 55%, Umidade do Solo 60%. Confira sua estufa!'
                ]
            );
    
            // Enviar alerta por SMS
            $smsMessage = $twilio->messages->create(
                '+5519983224023', // Número do destinatário no SMS
                [
                    'from' => env('TWILIO_PHONE'), // Número Twilio para SMS
                    'body' => '📢 Alerta de Estufa: Temperatura 28°C, Umidade 55%, Umidade do Solo 60%. Mantenha sua plantação saudável!'
                ]
            );
    
            return response()->json([
                'message' => 'Mensagens enviadas com sucesso!',
                'whatsapp_sid' => $whatsappMessage->sid,
                'sms_sid' => $smsMessage->sid,
            ]);
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar mensagens', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao enviar mensagens: ' . $e->getMessage()], 500);
        }
    }
    
}
