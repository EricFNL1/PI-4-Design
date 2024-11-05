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

        // Fase selecionada pelo usuário, exemplo armazenado em sessão
        $selectedPhase = session('selectedPhase', 'Germinação');

        return view('advanced-settings', [
            'phases' => $phases,
            'selectedPhase' => $selectedPhase,
        ]);
    }

    public function selecionarFase(Request $request)
    {
        // Validar a fase selecionada
        $request->validate([
            'fase' => 'required|string',
        ]);
    
        $faseSelecionada = $request->input('fase');
    
        // Aqui você pode fazer algo com a fase selecionada, como salvar em um banco de dados ou realizar outras ações
    
        return redirect()->back()->with('success', 'Fase selecionada: ' . $faseSelecionada);
    }
    
}
