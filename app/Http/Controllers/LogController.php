<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        // Simulando alguns dados de logs
        $logsSimulados = [
            ['data' => '2024-10-01', 'hora' => '12:00', 'temperatura' => 25, 'umidade' => 70],
            ['data' => '2024-10-02', 'hora' => '13:00', 'temperatura' => 26, 'umidade' => 72],
            ['data' => '2024-10-03', 'hora' => '14:00', 'temperatura' => 27, 'umidade' => 75],
            // Adicione mais registros simulados conforme necessário
        ];

        // Verifica se há filtro de data no request
        if ($request->has('dataInicio') && $request->has('dataFim')) {
            $dataInicio = $request->input('dataInicio');
            $dataFim = $request->input('dataFim');
            
            // Filtra os logs simulados entre as datas fornecidas
            $logs = collect($logsSimulados)->filter(function ($log) use ($dataInicio, $dataFim) {
                return $log['data'] >= $dataInicio && $log['data'] <= $dataFim;
            });
        } else {
            $logs = collect($logsSimulados); // Exibe todos os logs se não houver filtro
        }

        return view('logs', ['logs' => $logs]);
    }
}
