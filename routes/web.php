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
use App\Http\Controllers\LogController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\AdvancedSettingsController;
use App\Http\Controllers\EstufaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArduinoController;
use App\Http\Controllers\SensorDataController;
use App\Http\Controllers\GestorController;
use App\Http\Controllers\DadosController;
use App\Http\Controllers\WhatsAppController;

Route::post('/send-status', [WhatsAppController::class, 'sendStatus'])->name('send-status');


Route::post('/send-message', [WhatsAppController::class, 'sendMessage'])->name('send.message');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/send-test-message', [WhatsAppController::class, 'sendTestMessage']);

Route::get('/send-status', [WhatsAppController::class, 'sendStatus']);
Route::get('/send-alert', [WhatsAppController::class, 'sendAlert']);

Route::get('/sensor-data', [SensorDataController::class, 'fetchData']);


Route::get('/logs', [LogController::class, 'index'])->name('logs');

Route::get('/fetch-data', [SensorDataController::class, 'fetchAndStore']);


Route::get('/logs', [LogController::class, 'index']);

Route::get('/sensor-data', [SensorDataController::class, 'fetchSensorData']);
Route::get('/send-status', [WhatsAppController::class, 'sendStatus'])->name('send-status');

Route::get('/fetch-data', [ArduinoController::class, 'fetchAndSaveSensorData']);
use App\Models\SensorData;


Route::get('/sensor-data', function (Request $request) {
    $days = $request->get('days', 7);
    $startDate = now()->subDays($days);
    $data = SensorData::where('created_at', '>=', $startDate)->get();
    return response()->json($data);
});

Route::post('/sensor-data', [SensorDataController::class, 'store']);

// Rota para envio automático de alertas
Route::get('/send-alert', [WhatsAppController::class, 'sendAlert'])->name('send-alert');

Route::get('/sensor-data', [SensorDataController::class, 'getSensorData'])->name('sensor.data');

Route::get('/dados-esp32', [ArduinoController::class, 'getSensorData']);
Route::get('/toggle-mode', [ArduinoController::class, 'toggleMode']);
//Route::get('/send-alert', [WhatsAppController::class, 'sendAlert']);

Route::get('/test-whatsapp', [WhatsAppController::class, 'sendTestMessage']);
Route::get('/test-whatsapp', [WhatsAppController::class, 'sendAlert']);

Route::get('/test-whatsapp-alert', [WhatsAppController::class, 'sendAlert']);

Route::get('/fetch-sensor-data', [ArduinoController::class, 'fetchAndSaveSensorData']);



// Adicione essas rotas no web.php para testar diretamente cada função
Route::get('/ventilation/on', [ArduinoController::class, 'turnVentilationOn']);
Route::get('/ventilation/off', [ArduinoController::class, 'turnVentilationOff']);
Route::get('/dados-esp32', [ArduinoController::class, 'getSensorData']);

Route::get('/dados-esp32', [DadosController::class, 'obterDados']);

Route::get('/relay/on', [ArduinoController::class, 'turnRelayOn'])->name('relay.on');
Route::get('/relay/off', [ArduinoController::class, 'turnRelayOff'])->name('relay.off');
Route::get('/pump/activate', [ArduinoController::class, 'activatePump'])->name('pump.activate');



Route::post('/sensor-data/store', [SensorDataController::class, 'store'])->name('sensorData.store');
Route::get('/sensor-data', [SensorDataController::class, 'getData'])->name('sensorData.get');

Route::post('/toggle-mode', function (Request $request) {
    // Atualiza o estado do modo no backend (banco, cache, etc.)
    $mode = $request->input('mode'); // 'automatic' ou 'manual'

    // Exemplo: salvar o estado no cache (ou banco de dados)
    Cache::put('operation_mode', $mode);

    return response()->json(['message' => 'Modo atualizado com sucesso!', 'mode' => $mode]);
});


// Exemplo de rota no Laravel
Route::get('/toggle-mode', [ArduinoController::class, 'toggleMode']);






// Rota inicial redireciona para o login caso não esteja autenticado.
// Verifica se o usuário está autenticado
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('index'); // Redireciona para o index se autenticado
    }
    return redirect()->route('login'); // Redireciona para o login se não autenticado
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
    Route::get('/weather-from-ip', [WeatherInfoController::class, 'getWeatherFromIP'])->middleware('auth');

    
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/index', [HomeController::class, 'index'])->name('index');

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




// Rota para a página de Logs com filtro de data
Route::get('/logs', [LogController::class, 'index'])->name('logs')->middleware('auth');

// Rota para a página de Status dos equipamentos
Route::get('/status', [StatusController::class, 'index'])->name('status')->middleware('auth');



Route::get('/advanced-settings', [AdvancedSettingsController::class, 'index'])->name('advanced.settings')->middleware('auth');
Route::post('/fase/selecionar', [AdvancedSettingsController::class, 'selecionarFase'])->name('fase.selecionar')->middleware('auth');


Route::post('/sensores', [SensorController::class, 'receberDados'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);




// Rota para a página de criação de estufa
Route::get('/estufa/create', [EstufaController::class, 'create'])->name('estufa.create');
Route::post('/estufa/store', [EstufaController::class, 'store'])->name('estufa.store');

Route::get('/sensor/create', [SensorController::class, 'create'])->name('sensor.create');
Route::post('/sensor/store', [SensorController::class, 'store'])->name('sensor.store');

Route::get('/sensores', [SensorController::class, 'index'])->name('sensores.index');


Route::get('/gerenciador', [GestorController::class, 'index'])->name('gerenciador.index');
Route::put('/estufa/{id}/update', [GestorController::class, 'updateEstufa'])->name('estufa.update');
Route::delete('/estufa/{id}/destroy', [GestorController::class, 'destroyEstufa'])->name('estufa.destroy');
Route::put('/sensor/{id}/update', [GestorController::class, 'updateSensor'])->name('sensor.update');
Route::delete('/sensor/{id}/destroy', [GestorController::class, 'destroySensor'])->name('sensor.destroy');


// Rota para editar um sensor
Route::get('/sensor/{id}/edit', [SensorController::class, 'edit'])->name('sensor.edit');
Route::put('/sensor/{id}', [SensorController::class, 'update'])->name('sensor.update');

// Rota para editar uma estufa
Route::get('/estufa/{id}/edit', [EstufaController::class, 'edit'])->name('estufa.edit');
Route::put('/estufa/{id}', [EstufaController::class, 'update'])->name('estufa.update');


Route::post('/data', [ArduinoController::class, 'storeSensorData']);

Route::post('/data', [SensorDataController::class, 'store']);
Route::get('/data', function() {
    return response()->json(['message' => 'Endpoint funcionando.']);
});


Route::post('/data', [SensorController::class, 'storeData']); // Rota para receber dados do ESP32
Route::get('/dadosensor', [SensorController::class, 'showData']); // Rota para exibir dados do sensor


Route::get('/send-alert', [WhatsAppController::class, 'sendAlert']);


Route::get('/relay-on', [ArduinoController::class, 'turnRelayOn']);
Route::get('/relay-off', [ArduinoController::class, 'turnRelayOff']);
Route::get('/pump-on', [ArduinoController::class, 'activatePump']);
Route::get('/ventilation-on', [ArduinoController::class, 'turnVentilationOn']);
Route::get('/ventilation-off', [ArduinoController::class, 'turnVentilationOff']);


Route::get('/test-whatsapp', function () {
    // Simula os dados do sensor no cache
    Cache::put('sensor_data', [
        'temperature' => 35, // Temperatura de teste acima do limite
        'humidity' => 60,    // Umidade de teste
    ], 60); // Expira em 60 segundos

    $controller = new WhatsAppController();
    return $controller->sendAlert();
});