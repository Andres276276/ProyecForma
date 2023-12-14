<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    public function register(Request $request)
    {
        // Verificar si el usuario ya está registrado
        $existingUser = User::where('email', $request->email)->first();
    
        if ($existingUser) {
            return redirect()->route('home')->withErrors(['error' => 'Este correo electrónico ya está registrado.']);
        }
    
        $user = new User();
    
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
    
            $file->storeAs('public/profile_photos', $fileName);
    
            $user->profile_photo = $fileName;
        }
    
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->id_cargo = '2';
    
        $user->save();
    
        Auth::login($user);
    
        return redirect(route('privada'));
    }
    
    
    
    public function login(Request $request)
    {
        $credentials = [
            "email" => $request->email,
            "password" => $request->password,
        ];
    
        $remember = ($request->has('remember') ? true : false);
    
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
    
            $user = auth()->user();
    
            if (Auth::attempt($credentials)) {
                return redirect()->route('privada')->with('success', 'Inicio de sesión exitoso');
           
            }
        }
        
        return redirect()->route('home')
        ->withErrors(['error' => 'Credenciales incorrectas. Vuelve a intentarlo.']);   
     }


     
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('home'));
    }





}
