<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdvancedSettingsController extends Controller
{
    public function index()
    {
        // Retorna a view com o controle da velocidade das ventoinhas
        return view('advanced-settings');
    }

    public function updateFanSpeed(Request $request)
    {
        // Valida a entrada do usuário
        $validatedData = $request->validate([
            'fan_speed' => 'required|integer|min:1|max:100',
        ]);

        // Simulação de atualização de configuração de velocidade das ventoinhas
        $fanSpeed = $validatedData['fan_speed'];

        // Aqui você poderia, por exemplo, salvar em um banco de dados ou enviar para o microcontrolador

        return redirect()->back()->with('success', 'Velocidade da ventoinha atualizada para ' . $fanSpeed . '%');
    }
}
