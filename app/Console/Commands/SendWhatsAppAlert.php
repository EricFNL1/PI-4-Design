<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\WhatsAppController;

class SendWhatsAppAlert extends Command
{
    protected $signature = 'alert:send';
    protected $description = 'Envia alertas automáticos do status da estufa';

    public function handle()
    {
        $controller = new WhatsAppController();
        $controller->sendAlert();
        $this->info('Alertas enviados com sucesso!');
    }
}

