<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\SensorData;
use App\Mail\AlertNotification;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retorna a listagem dos dados, se necessário
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados
        $dados = $request->validate([
            'temperatura' => 'required|numeric',
            'umidade' => 'required|numeric',
        ]);

        // Verifica os limites de temperatura e umidade
        $this->verificarLimites($dados['temperatura'], $dados['umidade']);

        // Registro no log e retorno da resposta
        \Log::info('Dados recebidos: ', $request->all());
        return response()->json(['message' => 'Dados recebidos com sucesso!'], 200);
    }

    /**
     * Verifica os limites de temperatura e umidade e envia um e-mail caso necessário.
     */
    private function verificarLimites($temperatura, $umidade)
    {
        $limiteTemperatura = 30; // Defina o limite de temperatura desejado
        $limiteUmidade = 70; // Defina o limite de umidade desejado

        if ($temperatura > $limiteTemperatura) {
            $this->enviarNotificacao('A temperatura ultrapassou o limite!', $temperatura);
        }

        if ($umidade > $limiteUmidade) {
            $this->enviarNotificacao('A umidade ultrapassou o limite!', $umidade);
        }
    }

    /**
     * Envia uma notificação por e-mail.
     */
    


     private function enviarNotificacao($mensagem, $valor)
     {
         $user = Auth::user(); // Pega o usuário logado
         if ($user && $user->email) {
             Mail::send('emails.alerta', ['mensagem' => $mensagem, 'valor' => $valor], function ($message) use ($user) {
                 $message->to($user->email)
                         ->subject('Alerta de Sensores');
             });
         } else {
             \Log::warning('Nenhum usuário autenticado ou e-mail não encontrado.');
         }
     }
     

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Mostra um recurso específico
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Atualiza um recurso específico
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Remove um recurso específico
    }

    /**
     * Método para injetar dados de teste e verificar alertas.
     */
    public function injetarDadosTeste()
    {
        // Dados de teste que você deseja injetar
        $dadosTeste = [
            'temperatura' => 35, // Ajuste para um valor alto para testar o envio de alerta
            'umidade' => 75 // Ajuste para um valor alto para testar o envio de alerta
        ];

        // Simula a chamada do método store com os dados de teste
        return $this->store(new Request($dadosTeste));
    }
}
