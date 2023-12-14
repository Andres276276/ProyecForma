<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ArduinoController extends Controller
{
   
        public function index()
        {
            return view('updatearduino');
        }
        
    


        public function vaciar()
        {
            try {
                $response = Http::delete('https://domofticaweb-production.up.railway.app/api/datos_eliminar');
    
                if ($response->successful()) {
                   
                   
                    return redirect()->route('arduino')->with('success', 'Datos eliminados exitosamente');
                    
                } else {
                    return redirect()->route('arduino')->with('error', 'Error al vaciar datos a través de la API');
                }
            } catch (\Exception $e) {
                return redirect()->route('arduino')->with('error', $e->getMessage());
            }
        }


    
}
