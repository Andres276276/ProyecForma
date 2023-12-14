<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\TablaSensor;
use App\Models\Sensor;
use App\Models\Cultivo;




class SensorController extends Controller
{


     //Traer datos de sensor registros
 
     public function index()
     {
         try {
             $response = Http::get('https://domofticaweb-production.up.railway.app/api/sensor');

             if ($response->successful()) {

                 $datos = $response->json()['data'];

                 return view('sensor.index', compact('datos'));


             } else {
                 return view('sensor.index')->with('error', 'Error al obtener datos');
             }
         } catch (\Exception $e) {
             return view('sensor.index')->with('error', $e->getMessage());
         }
     }


    //Traer datos de sensor registros

    public function mostrarDatos(Request $request)
    {
        $datos = TablaSensor::orderBy('id', 'desc')->get();
    
        return view('arduino', compact('datos'));
    }




//Mostrar ultimo dato Index, Sensor

public function obtenerUltimaLectura()
{
    try {
        $response = Http::get('https://domofticaweb-production.up.railway.app/api/sensor/ultimalec');

        if ($response->successful()) {
            $datos = $response->json();
            
            return response()->json(['success' => true, 'data' => $datos['data']]);
        } else {
            return response()->json(['success' => false, 'message' => 'Error al obtener datos de la API']);
        }
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}




    }



