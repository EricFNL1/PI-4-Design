<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData; // Certifique-se de que o Model SensorData está configurado

class LogController extends Controller
{
    public function index(Request $request)
    {
        // Verifica se há filtro de data no request
        if ($request->has('dataInicio') && $request->has('dataFim')) {
            $dataInicio = $request->input('dataInicio');
            $dataFim = $request->input('dataFim');

            // Busca os logs no banco de dados aplicando filtro por data
            $logs = SensorData::whereBetween('created_at', [$dataInicio, $dataFim])
                ->orderBy('created_at', 'desc')
                ->paginate(5); // Paginação com 5 registros por página
        } else {
            // Busca todos os logs se não houver filtro
            $logs = SensorData::orderBy('created_at', 'desc')->paginate(5);
        }

        return view('logs', compact('logs'));
    }
}
