<?php

namespace App\Jobs;

use App\Http\Controllers\WhatsAppController;

class SendWhatsAppAlert extends Job
{
    public function handle()
    {
        $controller = new WhatsAppController();
        $controller->sendAlert();
    }
}
