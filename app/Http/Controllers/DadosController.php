<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DadosController extends Controller
{
    private $esp32Ip = 'http://192.168.4.1'; // IP do ESP32

    public function obterDados()
    {
        try {
            // Faz a requisição para o ESP32
            $response = Http::get("{$this->esp32Ip}/data");

            // Verifica se a resposta foi bem-sucedida
            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'Erro ao conectar ao ESP32'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Falha na requisição ao ESP32'], 500);
        }
    }
}
