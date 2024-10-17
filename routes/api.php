<?php

use App\Http\Controllers\SensorController;

Route::middleware('api')->group(function () {
    Route::post('/sensores', [SensorController::class, 'receberDados']);
});
