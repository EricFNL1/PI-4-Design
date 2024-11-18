<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorReading;

class SensorController extends Controller
{
    // Método para armazenar os dados enviados pelo ESP32
    public function storeData(Request $request)
    {
        // Valida os dados recebidos
        $validatedData = $request->validate([
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
            'soil_moisture' => 'required|numeric',
        ]);

        // Armazena os dados no banco de dados
        SensorReading::create($validatedData);

        return response()->json(['message' => 'Dados salvos com sucesso'], 200);
    }

    // Método para exibir os dados do sensor
    public function showData()
    {
        // Pega os últimos 10 registros, por exemplo
        $sensorData = SensorReading::orderBy('created_at', 'desc')->take(10)->get();

        return view('dadosensor', ['sensorData' => $sensorData]);
    }
}
