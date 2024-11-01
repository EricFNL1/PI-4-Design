<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;

class SensorDataController extends Controller
{
    public function store(Request $request)
    {
        // Validação opcional dos dados
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
}
