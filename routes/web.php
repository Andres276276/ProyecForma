<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\PublicoController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuienesSomosController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\RelayController;
use App\Http\Controllers\AguaController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ArduinoController;
use App\Http\Controllers\CultivoController;
use App\Http\Controllers\ConfiguracionArduinoController;
use App\Http\Controllers\WeatherController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});


//HOME//
Route::view('/home', "home")->name('home');
Route::get('/ayuda', 'App\Http\Controllers\UserController@ayuda')->middleware('auth')->name('ayuda');;

//LOGIN//
Route::view('/privada', "secret")->middleware('auth')->name('privada');
Route::post('/validar-registro',[LoginController::class,'register'])->name('validar-registro');
Route::post('/iniciar-sesión',[LoginController::class,'login'])->name('iniciar-sesión');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');

//Perfil//
Route::middleware(['auth'])->group(function () {
Route::get('/profile', 'App\Http\Controllers\ProfileController@show')->name('profile.show');
Route::put('/profile/update', 'App\Http\Controllers\ProfileController@update')->name('profile.update');});
Route::get('/perfil', 'App\Http\Controllers\ProfileController@vista')->middleware('auth')->name('perfil');;

//Arduino//
Route::get('/arduino', 'App\Http\Controllers\SensorController@mostrarDatos')->middleware('auth')->name('arduino');;
Route::get('/eliminar-dato/{id}', 'App\Http\Controllers\SensorController@eliminarDato')->name('eliminar_dato');
Route::get('/vista-ultimo-dato', [SensorController::class, 'vistaUltimoDato']);
Route::get('/vista-ultimo-dato', [SensorController::class, 'vistaUltimoDato'])->middleware('auth')->name('vista-ultimo-dato');
Route::get('/sensores', 'App\Http\Controllers\SensorController@index')->name('sensor.index');
Route::delete('/eliminar-registros', 'App\Http\Controllers\SensorController@eliminarRegistros')->name('eliminar-registros');
Route::get('/obtener-datos', 'App\Http\Controllers\SensorController@indexJson')->name('obtenerDatosJson');
Route::get('/mostrar-grafica', [SensorController::class, 'mostrarGrafica'])->name('mostrar.grafica');
Route::delete('/sensores/vaciar', [ArduinoController::class, 'vaciar'])->name('sensores.vaciar');

//ARDUINO RELE_BOMBA//
Route::get('/control_relay', 'App\Http\Controllers\RelayController@index')->name('control_relay');
Route::post('/toggle_relay', 'App\Http\Controllers\RelayController@toggle')->name('toggle_relay');
Route::get('/toggle-device', 'App\Http\Controllers\DeviceController@toggleDevice');
Route::get('/toggle-device/{userId}', 'App\Http\Controllers\DeviceController@toggleDevice')->name('toggle-device');
Route::post('/toggle-relay', 'RelayController@toggle')->name('toggle-relay');
Route::get('/obtener-ultima-lectura', [SensorController::class, 'obtenerUltimaLectura'])->name('obtener-ultima-lectura');


//ARDUINO CONFIGURAR//   
Route::get('/arduinoconfig', 'App\Http\Controllers\ArduinoController@index')->middleware('auth')->name('arduino.index');
Route::post('/arduino/update', 'ArduinoController@update')->name('arduino.update');

//CULTIVO//   
Route::get('/cultivos/create', [CultivoController::class, 'create'])->name('cultivos.create');
Route::post('/cultivos/store', [CultivoController::class, 'store'])->name('cultivos.store');
Route::middleware(['auth'])->group(function () {
Route::get('/cultivo', 'App\Http\Controllers\CultivoController@index');});
Route::delete('/eliminar-cultivo/{id}', 'App\Http\Controllers\CultivoController@eliminarCultivo')->name('cultivos.eliminar');
Route::delete('/sensores/vaciar', [ArduinoController::class, 'vaciar'])->name('sensores.vaciar');

Route::get('/cultivos/create', [CultivoController::class, 'create'])->name('cultivos.create');
Route::post('/cultivos/store', [CultivoController::class, 'store'])->name('cultivos.store');

// Rutas para mostrar el formulario de edición y actualizar un cultivo 
Route::get('/cultivos/{id}/edit', [CultivoController::class, 'edit'])->name('cultivos.edit');
Route::put('/cultivos/{id}/update', [CultivoController::class, 'update'])->name('cultivos.update');


//TIEMPO
Route::get('/weather', [WeatherController::class, 'index']);
Route::get('/get-weather', [WeatherController::class, 'getWeather']);



//Contact//
Route::get('/contacto', 'App\Http\Controllers\ContactoController@index')->name('contacto');
Route::post('/contacto', 'App\Http\Controllers\ContactoController@enviarCorreo');
 
//ADMINISTRADOR//
Route::get('/privada_admin', function () {return view('privada_admin');})->name('privada_admin');

// Rutas para ver la lista de usuarios
Route::get('/privada_admin', [UserController::class, 'index'])->middleware('auth')->name('privada_admin');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}/update', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}/destroy', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/users/create', 'App\Http\Controllers\UserController@create')->name('users.create');
Route::get('/users/{id}/edit', 'App\Http\Controllers\UserController@edit')->name('users.edit');
Route::delete('/eliminar-cuenta-propia', [UserController::class, 'eliminarPropiaCuenta'])->middleware('auth')->name('eliminar-cuenta-propia');
       
//QUIENES SOMOS//
Route::get('/quienes-somos', 'App\Http\Controllers\QuienesSomosController@index')->name('quienes_somos');

//RECUPERAR CONTRASEÑA//
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

//Rele//
Route::get('/control-bomba', 'App\Http\Controllers\AguaController@showControlBomba')->name('controlBomba');
Route::post('/toggle-bomba', 'App\Http\Controllers\AguaController@toggleBomba')->name('toggleBomba');

//configuracion arduino//
Route::get('/formulario', [ConfiguracionArduinoController::class, 'formulario'])->middleware('auth')->name('formulario');
Route::post('/guardar-configuracion', [ConfiguracionArduinoController::class, 'guardar'])->middleware('auth')->name('configuracion-arduino.guardar');
Route::get('/ardcong', [ConfiguracionArduinoController::class, 'ardcong'])->middleware('auth')->name('configuracion-arduino.ardcong');
