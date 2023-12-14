<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class UserController extends Controller
{

//MOSTRAR USUARIOS

    public function traertodos()
    {
        
        $users = User::all();
        
        return response()->json(['users' => $users]);
    }

//BUSCAR POR ID

    public function buscarporid($id)
{
    try {
        $usuario = User::findOrFail($id); // Encuentra al usuario por su ID

        return response()->json(['message' => 'Usuario encontrado correctamente', 'usuario' => $usuario], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Usuario no encontrado', 'message' => $e->getMessage()], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener el usuario', 'message' => $e->getMessage()], 500);
    }
}




//LOGIN

public function login(Request $request)
{
    // Validar
    $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Hace el intento de autenticar
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // Autenticación exitosa
        $user = Auth::user();

        // Revocar tokens existentes para el usuario (opcional)
        $user->tokens()->delete();

        // Crear un nuevo token único para el usuario
        $token = $user->createToken('authToken-' . $user->id)->accessToken;

        return response()->json(['message' => 'Inicio de sesión exitoso', 'token' => $token, 'user' => $user]);
    } else {
        // Autenticación error
        return response()->json(['error' => 'Credenciales incorrectas', 'message' => 'Inicio de sesión fallido'], 401);
    }
}


//LOGOUT
public function logout(Request $request)
{
    if ($request->user()) {
        $request->user()->token()->revoke();
    }

    return response()->json(['message' => '¡Sesión cerrada correctamente!']);
}





//REGISTRO

    public function registro(Request $request)
    {
        // Validar los datos users 
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8', 
        ]);
    
        // Crear nuevo usuario
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
    
        $user->id_cargo = 2;
    
        $user->save();
    
        return response()->json(['message' => 'Usuario actualizado con éxito', 'user' => $user]);
    }
    

//ACTUALIZAR USUARIO

    public function update(Request $request)
    {
        try {
            // Obtén el usuario autenticado
            $user = Auth::user();

            // Validar los campos que deseas permitir editar
            $this->validate($request, [
                'name' => 'string',
                'email' => 'email|unique:users,email,' . $user->id,
                'password' => 'nullable|min:6',
                'id_cargo' => 'integer',
            ]);

            // Actualizar los campos del usuario
            $user->fill($request->only(['name', 'email', 'password', 'id_cargo']));

            // Guardar los cambios
            $user->save();

            return response()->json(['message' => 'Usuario actualizado con éxito', 'user' => $user]);
        } catch (ValidationException $e) {
            // Si la validación falla, devuelve una respuesta con los errores de validación
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Si ocurre un error inesperado, devuelve una respuesta con el mensaje de error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


//ELIMINAR USUARIOS POR ID 

    public function eliminar($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Usuario eliminado con éxito']);
    }

  
    public function eliminarCuentapropia(Request $request)
    {
        $usuario = Auth::user();

        try {
            $usuario->delete();

            return response()->json(['message' => 'Cuenta eliminada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar la cuenta', 'message' => $e->getMessage()], 500);
        }
    }


    public function editarUsuarioPorId(Request $request, $id)
    {
        try {
            $usuario = User::findOrFail($id);
            $usuario->update($request->all());

            return response()->json(['message' => 'Usuario actualizado correctamente', 'usuario' => $usuario]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuario no encontrado', 'message' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar el usuario', 'message' => $e->getMessage()], 500);
        }
    }



} 



