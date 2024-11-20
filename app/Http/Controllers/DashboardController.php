<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        // Carrega os últimos 10 registros salvos no banco
        $dados = SensorData::latest()->take(10)->get();

        // Retorna a view 'dashboard' com os dados
        return view('dashboard', compact('dados'));
    }
}
