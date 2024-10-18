<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use App\Models\Estufa;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function create()
    {
        $estufas = Estufa::all();
        return view('sensor.create', compact('estufas'));
    }

    public function store(Request $request)
    {
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
    }
}
