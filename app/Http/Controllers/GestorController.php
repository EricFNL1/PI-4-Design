<?php

namespace App\Http\Controllers;

use App\Models\Estufa;
use App\Models\Sensor;
use Illuminate\Http\Request;

class GestorController extends Controller
{
    // Exibir estufas e sensores na mesma view
    public function index()
    {
        $estufas = Estufa::all();
        $sensores = Sensor::all();

        return view('gerenciador', compact('estufas', 'sensores'));
    }

    // Atualizar o nome de uma estufa
    public function updateEstufa(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255'
        ]);

        $estufa = Estufa::findOrFail($id);
        $estufa->nome = $request->input('nome');
        $estufa->save();

        return redirect()->route('gerenciador.index')->with('success', 'Estufa atualizada com sucesso!');
    }

    // Excluir uma estufa
    public function destroyEstufa($id)
    {
        $estufa = Estufa::findOrFail($id);
        $estufa->delete();

        return redirect()->route('gerenciador.index')->with('success', 'Estufa excluída com sucesso!');
    }

    // Atualizar o nome de um sensor
    public function updateSensor(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255'
        ]);

        $sensor = Sensor::findOrFail($id);
        $sensor->nome = $request->input('nome');
        $sensor->save();

        return redirect()->route('gerenciador.index')->with('success', 'Sensor atualizado com sucesso!');
    }

    // Excluir um sensor
    public function destroySensor($id)
    {
        $sensor = Sensor::findOrFail($id);
        $sensor->delete();

        return redirect()->route('gerenciador.index')->with('success', 'Sensor excluído com sucesso!');
    }
}
