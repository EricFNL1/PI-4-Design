<?php

namespace App\Http\Controllers;

use App\Models\Estufa;

class HomeController extends Controller
{
    public function index()
    {
        // Buscando todas as estufas do banco de dados
        $estufas = Estufa::all();
    
        // Retornando a view e passando as estufas
        return view('index', compact('estufas'));
    }
    
}
