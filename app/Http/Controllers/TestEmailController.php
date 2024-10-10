<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TestEmailController extends Controller
{
    public function sendTestEmail()
    {
        $user = Auth::user();
        
        if ($user && $user->email) {
            Mail::raw('Este é um teste de envio de e-mail.', function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Teste de E-mail');
            });

            return response()->json(['message' => 'E-mail de teste enviado com sucesso!']);
        } else {
            return response()->json(['error' => 'Usuário não autenticado ou e-mail não encontrado.'], 400);
        }
    }
}
