<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\SensorData;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;
use Carbon\Carbon;

class SensorDataController extends Controller
{
    public function fetchData(Request $request)
    {
        // Número de dias enviados pelo frontend
        $days = $request->query('days', 7);

        // Calcula a data inicial com base no número de dias
        $startDate = Carbon::now()->subDays($days);

        // Filtra os dados no banco de dados
        $data = SensorData::where('created_at', '>=', $startDate)
                          ->orderBy('created_at', 'asc')
                          ->get();

        // Retorna os dados como JSON
        return response()->json($data);
    }
}
