<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;

class LogController extends Controller
{
    public function index(Request $request)
    {
        // Obtém os filtros de data, se fornecidos
        $dataInicio = $request->input('dataInicio');
        $dataFim = $request->input('dataFim');

        if ($dataInicio && $dataFim) {
            // Filtra os registros pelo intervalo de datas
            $logs = SensorData::whereBetween('created_at', [$dataInicio, $dataFim])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // Busca todos os registros se não houver filtro
            $logs = SensorData::orderBy('created_at', 'desc')->paginate(10);
        }

        // Retorna os logs para a view
        return view('logs', compact('logs'));
    }
}
