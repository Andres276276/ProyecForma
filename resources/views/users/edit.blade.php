<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <!-- Plantilla nav -->

    @include('plantillas.navinicio')
    <link rel="stylesheet" href="{{ asset('css/Admin.css') }}">
    <!-- Estilos etc -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
          
</head>
<body>




<!-- Formulario de edicion de usuarios -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0"style="color: white;">Actualizar Usuario <a href="{{ route('privada_admin') }}" class="btn btn-danger float-right">Regresar</a></h1>
                </div>

                <div class="card-body">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <!-- Cambiar contraseña -->
                        <div class="form-group">
                            <label for="password"><i class="fa fa-lock"></i> Nueva Contraseña</label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation"><i class="fa fa-lock"></i> Confirmar Nueva Contraseña</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="id_cargo">Cargo:</label>
                            <select class="form-control" id="id_cargo" name="id_cargo">
                                <option value="1" {{ $user->id_cargo == 1 ? 'selected' : '' }}>Administrador</option>
                                <option value="2" {{ $user->id_cargo == 2 ? 'selected' : '' }}>Usuario</option>
                            </select>
                        </div>

                        <div class="text-center">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>



<!-- Demas plantillas -->

@include('plantillas.fooster')
@include('plantillas.Animacion')

</body>
</html>
