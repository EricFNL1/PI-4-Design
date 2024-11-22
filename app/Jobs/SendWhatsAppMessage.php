<?php

namespace App\Jobs;

use Twilio\Rest\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsAppMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $messageBody;

    /**
     * Cria uma nova instância do job.
     *
     * @param string $messageBody
     */
    public function __construct($messageBody)
    {
        $this->messageBody = $messageBody;
    }

    /**
     * Executa o job.
     */
    public function handle()
    {
        try {
            $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
            $twilio->messages->create(
                'whatsapp:+5519983224023', // Número do destinatário
                [
                    'from' => env('TWILIO_WHATSAPP_FROM'), // Número do Twilio configurado
                    'body' => $this->messageBody
                ]
            );
        } catch (\Exception $e) {
            // Rejeita o job para ser tentado novamente
            $this->fail($e);
        }
    }
}
