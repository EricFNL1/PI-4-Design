<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ArduinoController extends Controller
{
    private $esp32Ip = 'http://192.168.4.1'; // IP do ESP32, ajuste conforme necessário

    public function turnRelayOn()
    {
        $response = Http::get("{$this->esp32Ip}/toggleRelayOn");
        return $response->body();
    }

    public function turnRelayOff()
    {
        $response = Http::get("{$this->esp32Ip}/toggleRelayOff");
        return $response->body();
    }

    public function activatePump()
    {
        $response = Http::get("{$this->esp32Ip}/activatePump");
        return $response->body();
    }

    public function turnVentilationOn()
    {
        $response = Http::get("{$this->esp32Ip}/toggleRelay3On");
        return $response->body();
    }

    public function turnVentilationOff()
    {
        $response = Http::get("{$this->esp32Ip}/toggleRelay3Off");
        return $response->body();
    }

    
}
