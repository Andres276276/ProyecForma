<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Cargo;
use PharIo\Manifest\Email; 

class UserController extends Controller
{
    
    public function ayuda()
    {
        return view('ayuda');
    }


    public function updateRelayState(Request $request) {
        $user = Auth::user(); 
    
        if ($request->input('toggle') == 'on') {
            $user->relay_state = 1;
        } else {
            $user->relay_state = 0;
        }
    
        $user->save();
    
        return redirect()->back()->with('success', 'Estado del relé actualizado correctamente');
    }


public function index()
{
    $users = User::with('cargo')->get()->sortBy('id_cargo');
    return view('privada_admin', compact('users'));
}

    public function create()
    {
        $cargos = Cargo::all();
        return view('users.create', compact('cargos'));
    }

    public function store(Request $request)
    {
        
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'id_cargo' => 'required|exists:cargos,id',
            ]);
        
            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'id_cargo' => $request->input('id_cargo'),
            ]);
        
            return redirect()->route('privada_admin')->with('success', 'Usuario creado correctamente.');
        }


    public function edit($id)
    {
        $user = User::find($id);
        $cargos = Cargo::all();
        return view('users.edit', compact('user', 'cargos'));
    }


    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, 
            'password' => 'nullable|string|min:8', 
            'id_cargo' => 'required|exists:cargos,id', 
        ]);

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->id_cargo = $request->input('id_cargo');
        $user->save();

        return redirect()->route('privada_admin')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('privada_admin')->with('success', 'Usuario eliminado correctamente.');
    }

    public function eliminarPropiaCuenta()
    {
        $user = Auth::user();
 
        if ($user) {
            $user->delete();
 
            Auth::logout();
 
            return redirect('/home')->with('success', 'Cuenta eliminada con éxito.');
        } else {
            return redirect('/home')->with('error', 'No se pudo eliminar la cuenta. Por favor, inténtalo de nuevo.');
        }
    }
 



}
