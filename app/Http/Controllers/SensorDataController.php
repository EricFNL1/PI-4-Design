<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;

class SensorDataController extends Controller
{
    public function getSensorData(Request $request)
    {
        $days = $request->query('days', 7); // Obtém o período (dias) enviado pela query string, com padrão de 7 dias.

        // Busca os dados no banco de dados, filtrando pelo período definido.
        $sensorData = SensorData::where('created_at', '>=', now()->subDays($days))
            ->orderBy('created_at', 'asc')
            ->get(['temperature', 'humidity', 'soil_moisture', 'created_at']); // Inclui apenas as colunas necessárias.

        // Retorna os dados como JSON para consumo pelo front-end.
        return response()->json($sensorData);
    }
}
