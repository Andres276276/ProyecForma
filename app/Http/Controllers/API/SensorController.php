<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TablaSensor;

class SensorController extends Controller
{

    //Mostrar todos los registros de los sensores

    public function M_Datos()
    {
        $sensorData = TablaSensor::all();

        return response()->json([
            'message' => 'Datos obtenidos correctamente',
            'data' => $sensorData,
        ], 200);
    }

    //Eliminar todos los registros 
    
    public function EliminarTodo()
    {
        TablaSensor::truncate();

        return response()->json(['message' => 'Todos los registros eliminados correctamente']);
    }
    
}
