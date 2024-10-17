<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdvancedSettingsController extends Controller
{
    public function index()
    {
        // Definindo as fases do cultivo do morango
        $phases = [
            'Germinação' => [
                'luz' => '14-16 horas por dia',
                'agua' => 'Solo úmido, mas não encharcado',
                'temperatura' => '18-22°C',
            ],
            'Crescimento vegetativo' => [
                'luz' => '12-14 horas por dia',
                'agua' => 'Rega moderada',
                'temperatura' => '16-24°C',
            ],
            'Florescimento' => [
                'luz' => '10-12 horas por dia',
                'agua' => 'Rega constante, sem encharcar',
                'temperatura' => '15-20°C',
            ],
            'Frutificação' => [
                'luz' => '8-10 horas por dia',
                'agua' => 'Manter o solo constantemente úmido',
                'temperatura' => '14-18°C',
            ],
        ];

        // Retorna a view com as fases do cultivo do morango
        return view('advanced-settings', ['phases' => $phases]);
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

