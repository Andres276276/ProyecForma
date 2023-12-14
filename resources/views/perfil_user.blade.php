<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="icon" href="{{ asset('images/icono2.png') }}">
    <link rel="stylesheet" href="{{ asset('css/Perfil.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-ez0pTlREpLjoTqRi0z3tA4yXa5L7oV7Gz5DkRE5eNIIAtS2mQQE9PQFMIhW38R" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-ez0pTlREpLjoTqRi0z3tA4yXa5L7oV7Gz5DkRE5eNIIAtS2mQQE9PQFMIhW38R" crossorigin="anonymous">
</head>
<body>

<!-- Titulo y img -->

    <img src="{{ asset('images/nav6.png') }}" class="imgnav">
    <h2 class="titulo display-5 font-weight-light">Mi Espacio Digital</h2>
<br>


    <!-- Contenedor del formulario de editar perfil -->
    <!-- Contenedor principal -->
    <div class="card-container">

    @if (session('success'))
      <div class="alert alert-success" style=" text-align: center; padding: 9px; border: 1px solid #f5c6cb;">
          {{ session('success') }}
      </div>
    @endif

        <!-- Sección superior -->
        <div class="upper-container">
            <div class="image-container">
                <img src="{{ asset('images/Icono.png') }}" alt="User Image" />
            </div>
        </div>

        <!-- Sección inferior (formulario) -->
        <div class="lower-container">
            <div>

                <!-- Formulario de actualización de perfil -->
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Campo: Nombre -->
                    <div class="form-group">
                        <label for="name"><i class="fa fa-user"></i> Nombre</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>

                    <!-- Campo: Email -->
                    <div class="form-group">
                        <label for="email"><i class="fa fa-envelope"></i> Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>

                    <!-- Campo: Nueva Contraseña -->
                    <div class="form-group">
                        <label for="password"><i class="fa fa-lock"></i> Nueva Contraseña</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>

                    <!-- Campo: Confirmar Contraseña -->
                    <div class="form-group">
                        <label for="password_confirmation"><i class="fa fa-lock"></i> Confirmar Contraseña</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                    </div>

                    <!-- Contenedor de botones -->
                    <div class="button-container">
                        <button type="submit" class="btn custom-button">Guardar cambios</button>
                        <a href="{{ route('privada') }}" class="btn btn-primary mb-2 float-right mt-2"style="text-decoration: none;">Volver a Home</a>
                    </div>

                </form>

            </div>
        </div>

    </div>


    @include('plantillas.Animacion')


</body>
</html>
