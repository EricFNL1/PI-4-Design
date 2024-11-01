<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;
use Carbon\Carbon;

class SensorDataController extends Controller
{
    // Método para armazenar dados no banco de dados
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
            'soil_moisture' => 'required|numeric'
        ]);

        // Cria um novo registro com os dados recebidos
        SensorData::create([
            'temperature' => $request->temperature,
            'humidity' => $request->humidity,
            'soil_moisture' => $request->soil_moisture
        ]);

        return response()->json(['message' => 'Dados armazenados com sucesso!'], 201);
    }

    // Método para buscar dados dos últimos "n" dias
    public function getData(Request $request)
    {
        $estufaId = $request->get('estufa_id');
        $days = $request->get('days', 7);
    
        $query = SensorData::where('created_at', '>=', Carbon::now()->subDays($days));
        
        if ($estufaId) {
            $query->where('estufa_id', $estufaId);
        }
    
        $sensorData = $query->orderBy('created_at')->get(['temperature', 'humidity', 'soil_moisture', 'created_at']);
    
        return response()->json($sensorData);
    }
    public function index(Request $request)
    {
        $query = SensorData::query();
    
        // Filtragem por data, se fornecida
        if ($request->has('dataInicio') && $request->has('dataFim')) {
            $dataInicio = Carbon::parse($request->dataInicio)->startOfDay();
            $dataFim = Carbon::parse($request->dataFim)->endOfDay();
            $query->whereBetween('created_at', [$dataInicio, $dataFim]);
        }
    
        // Busca todos os registros sem paginação, ordenados por data
        $logs = $query->orderBy('created_at', 'desc')->get();
    
        return view('logs', compact('logs'));
    }
    
}
