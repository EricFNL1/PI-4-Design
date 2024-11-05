<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        // Gerando dados simulados
        $dados = collect([
            (object) ['temperatura' => rand(20, 40), 'umidade' => rand(50, 100)],
            (object) ['temperatura' => rand(20, 40), 'umidade' => rand(50, 100)],
            (object) ['temperatura' => rand(20, 40), 'umidade' => rand(50, 100)],
        ]);

        // Retorna a view 'dashboard' com os dados simulados
        return view('dashboard', compact('dados'));
    }
}
