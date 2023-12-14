<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\SensorController;
use App\Http\Controllers\API\CultivoController;
use App\Http\Controllers\API\RelayStateController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//ADMINISTRADOR
Route::delete('/users/{id}', [UserController::class, 'eliminar']);
Route::get('/users/{id}', [UserController::class, 'buscarporid']);
Route::get('/users', [UserController::class, 'traertodos']);
Route::put('/users/{id}', [UserController::class, 'editarUsuarioPorId']);


//DATOS DE USUARIO, REGISTRO Y TRAERLOS
Route::post('/login', [UserController::class, 'login']);
Route::post('/users', [UserController::class, 'registro']);
Route::post('/logout', [UserController::class, 'logout']);
Route::middleware(['auth'])->group(function () {
    Route::put('update', [UserController::class, 'update']);
});
Route::middleware('auth:api')->delete('/eliminar-cuenta', [UserController::class, 'eliminarCuentapropia']);

//ARDUINO DATOS
Route::get('/sensor', [SensorController::class, 'M_Datos']);
Route::delete('/datos_eliminar', [SensorController::class, 'EliminarTodo']);


//CULTIVO PARA VER CULTIVOS, VER POR ID y REGISTRAR CULTIVOS
Route::get('/cultivos', [CultivoController::class, 'traertodos']);
Route::get('/cultivos/{id}', [CultivoController::class, 'buscarporid']);
Route::post('/cultivos', [CultivoController::class, 'registrar']);
Route::put('/cultivos/{id}', [CultivoController::class, 'editar']);
Route::delete('/cultivos/{id}', [CultivoController::class, 'eliminar']);

//RELE
Route::post('/actualizar-rele/{userId}', [RelayStateController::class, 'actualizarRelayState']);
