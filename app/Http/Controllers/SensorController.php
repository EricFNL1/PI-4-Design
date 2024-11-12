<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use App\Models\Estufa;
use Illuminate\Http\Request;

class SensorController extends Controller
{

    public function index(Request $request)
    {
        // Carrega todas as estufas para exibição no dropdown
        $estufas = Estufa::all();

        // Verifica se foi selecionada uma estufa no request
        $sensores = [];
        if ($request->has('estufa_id')) {
            $sensores = Sensor::where('estufa_id', $request->input('estufa_id'))->get();
        }

        return view('sensores.index', compact('estufas', 'sensores'));
    }
    public function create()
    {
        $estufas = Estufa::all();
        return view('sensor.create', compact('estufas'));
    }

    public function store(Request $request)
    {

        $data = $request->validate([
        'temperature' => 'required|numeric',
        'humidity' => 'required|numeric',
        'soil_moisture' => 'required|numeric',
    ]);

    // Código para salvar dados em banco de dados ou processar como necessário
    return response()->json(['success' => true]);

        
        
        
        
        /* 
        $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'estufa_id' => 'required|exists:estufas,id'
        ]);

        Sensor::create([
            'nome' => $request->nome,
            'tipo' => $request->tipo,
            'estufa_id' => $request->estufa_id
        ]);

        return redirect()->route('index')->with('success', 'Sensor cadastrado com sucesso.'); 
        */
    }

    
}
