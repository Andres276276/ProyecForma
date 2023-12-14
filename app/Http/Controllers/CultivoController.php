<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sensor;
use App\Models\Cultivo;

class CultivoController extends Controller
{

 

    public function create()
    {
        return view('cultivo.cultivos');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:cultivos|max:255',
            'nivel_humedad_optimo' => 'required|numeric|min:0|max:100',
            'tipo_plantas' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_siembra' => 'nullable|date',
            
        ]);

        Cultivo::create($request->all());

        return redirect ('http://localhost/Domoftware/public/cultivo')->with('success', 'Cultivo creado con éxito');
    }


    public function index(){
        
    $cultivos = Cultivo::all();
    return view('cultivo.cultivos')->with('cultivos', $cultivos);
}





public function edit($id)
{
    $cultivo = Cultivo::find($id);

    return view('cultivo.editar', compact('cultivo'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required|unique:cultivos,nombre,' . $id . '|max:255',
        'nivel_humedad_optimo' => 'required|numeric|min:0|max:100',
        'tipo_plantas' => 'nullable|string|max:255',
        'descripcion' => 'nullable|string',
        'fecha_siembra' => 'nullable|date',
    ], [
        'nombre.unique' => 'El nombre del cultivo ya existe.',
    ]);

    try {
        $cultivo = Cultivo::find($id);
        $cultivo->update($request->all());

        return redirect ('http://localhost/Domoftware/public/cultivo')->with('success', 'Cultivo actualizado correctamente.');
    } catch (\Exception $e) {
        return redirect ('http://localhost/Domoftware/public/cultivo')->withErrors(['error' => 'Hubo un problema al intentar actualizar el cultivo.']);
    }
}










public function eliminarCultivo(Request $request, $id)
{
    try {
        $cultivo = Cultivo::find($id);

        if (!$cultivo) {
            return redirect()->back()->with('error', 'Cultivo no encontrado');
        }

        $cultivo->delete();

        return redirect()->back()->with('success', 'Cultivo eliminado con éxito');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error al eliminar el cultivo: ' . $e->getMessage());
    }
}






}