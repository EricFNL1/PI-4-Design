<?php

namespace App\Http\Controllers;

class StatusController extends Controller
{
    public function index()
    {
        // Simulação dos status dos equipamentos
        $statusEquipamentos = [
            ['equipamento' => 'Sensor de Temperatura', 'status' => 'Funcionando'],
            ['equipamento' => 'Sensor de Umidade', 'status' => 'Atenção'],
            ['equipamento' => 'Atuador de Ventilação', 'status' => 'Desligado'],
            // Adicione mais status simulados conforme necessário
        ];

        return view('status', ['statusEquipamentos' => $statusEquipamentos]);
    }
}
