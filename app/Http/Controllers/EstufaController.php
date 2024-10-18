<?php

namespace App\Http\Controllers;

use App\Models\Estufa;
use Illuminate\Http\Request;

class EstufaController extends Controller
{
    public function create()
    {
        return view('estufa.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nome' => 'required|string|max:255']);

        Estufa::create(['nome' => $request->nome]);

        return redirect()->route('index')->with('success', 'Estufa criada com sucesso.');
    }
}
