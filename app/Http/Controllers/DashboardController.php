<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $dados = SensorData::latest()->take(20)->get(); // Ajuste o número conforme necessário
        return view('dashboard', compact('dados'));
    }
}
