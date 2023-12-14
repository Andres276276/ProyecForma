<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{

    public function index(){
        return view('index2');
     }



    public function getWeather()
    {
        try {
            $apiKey = 'MWakgPJ7uYg7xK5Cs7yuo1rh51xdavDI';
            $url = 'https://api.tomorrow.io/v4/weather/forecast?location=42.3478,-71.0466&apikey=' . $apiKey;

            $client = new Client();
            $response = $client->get($url);

            $datos = json_decode($response->getBody(), true);

            // Loguear los datos para verificar que estén llegando correctamente
            Log::info("Datos de la API: " . print_r($datos, true));

            // Pasa los datos a la vista index2
            return view('index2', ['datos' => $datos]);

        } catch (RequestException $e) {
            $statusCode = $e->getResponse() ? $e->getResponse()->getStatusCode() : null;
            $mensajeError = $e->getMessage();

            Log::error("Error en la solicitud API: $statusCode - $mensajeError");

            return response("Error en la solicitud API: $statusCode - $mensajeError", 500);
        }
    }
}