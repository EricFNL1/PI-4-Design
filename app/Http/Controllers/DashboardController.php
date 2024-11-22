<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtenha os dados do banco
        $data = SensorData::all();

        // Construa o chartData para os gráficos
        $chartData = [
            'labels' => $data->pluck('created_at')->map(function ($date) {
                return $date->format('d/m/Y H:i'); // Formate as datas para o eixo X
            })->toArray(),
            'temperature' => $data->pluck('temperature')->toArray(),
            'humidity' => $data->pluck('humidity')->toArray(),
            'soil_moisture' => $data->pluck('soil_moisture')->toArray(),
        ];

        // Retorne os dados para a view
        return view('dashboard', [
            'data' => $data,
            'chartData' => $chartData,
        ]);
    }
}
