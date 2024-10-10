<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validação e lógica para armazenar os dados
    $dados = $request->validate([
        'temperatura' => 'required|numeric',
        'umidade' => 'required|numeric',
    ]);

    \Log::info('Dados recebidos: ', $request->all());
    // Aqui você pode armazenar os dados no banco de dados ou realizar outra ação
    return response()->json(['message' => 'Dados recebidos com sucesso!'], 200);
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
