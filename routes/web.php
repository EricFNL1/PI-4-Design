<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\WeatherInfoController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\TestEmailController;


// Rota inicial redireciona para o login caso não esteja autenticado.
Route::get('/', function () {
    return redirect()->route('login');
});

// Rotas para usuários não autenticados
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Rotas para usuários autenticados
Route::middleware('auth')->group(function () {
    Route::get('/sensores', [SensorController::class, 'index']);
    Route::post('/sensores', [SensorController::class, 'store'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/weather-from-ip', [WeatherInfoController::class, 'getWeatherFromIP']);
    
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Redireciona para o dashboard ou página inicial após o login bem-sucedido.
    Route::get('/index', function () {
        return view('index');
    })->name('index');
});



// Rota para exibir o formulário de solicitação de recuperação de senha
Route::get('/password/forgot', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');

// Rota para enviar o e-mail de redefinição de senha
Route::post('/password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Rota para exibir o formulário de redefinição de senha (com o token do e-mail)
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

// Rota para processar a redefinição de senha
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


Route::get('/teste-email', [TestEmailController::class, 'sendTestEmail'])->middleware('auth');


// Rota para injetar dados de teste nos sensores
Route::get('/injetar-dados', [SensorController::class, 'injetarDadosTeste'])->middleware('auth');
