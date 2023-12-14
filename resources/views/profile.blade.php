<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuraciones</title>
    <!-- Menu -->
    @include('plantillas.navinicio')
    <!-- Estilos -->
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Titulo y img -->

    <h2 class="titulo display-5 font-weight-light">Opciones avanzadas</h2>
    <img src="{{ asset('images/nav6.png') }}" class="imgnav">

    <!-- Contenedor del formulario de editar perfil -->

    <div class="containertodo">

    @if (session('success'))
      <div class="alert alert-success" style="text-align: center; padding: 9px; border: 1px solid #f5c6cb;">
          {{ session('success') }}
      </div>
    @endif


    <div class="container">
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="bg-contain1 p-3">

                    <div class="containerperfil">
                    <h2 class="text-center"style="color: white; padding-top: 15px;">Apariencia</h2>
                  
                    <img src="{{ asset('images/Iconoh.png') }}" alt="Imagen de perfil" width="120" height="120" class="mx-auto d-block">
                    </div>
                    <br>

                    <!-- Selector de Tema -->
                    <div class="form-group">
                        <label for="theme-color"><i class="fa fa-paint-brush"></i> Tema del Sitio:</label>
                        <input type="color" id="theme-color" name="theme-color" class="form-control">
                    </div>

                    <!-- Selector de Tamaño de Texto -->

                    <div class="form-group">
                        <label for="font-size"><i class="fa fa-text-height"></i> Tamaño del Texto:</label>
                            <select id="font-size" name="font-size" class="form-control">
                               <option value="small">Pequeño</option>
                               <option value="medium" selected>Mediano</option>
                               <option value="large">Grande</option>
                            </select>
                    </div>


                    <!-- Configuración de Fondo de Pantalla -->
                    <div class="form-group">
                        <label for="background-image"><i class="fa fa-image"></i> Fondo de Pantalla:</label>
                        <input type="file" id="background-image" name="background-image" class="form-control">
                    </div>

                    <!-- Interruptores para Animaciones y Efectos -->
                    <div class="form-group">
                        <label><i class="fa fa-cogs"></i> Animaciones y Efectos:</label>
                        <div class="form-check">
                            <input class="form-check-input" style="transform: translateX(20px);" type="checkbox" id="enable-animations" name="enable-animations">
                            <label class="form-check-label" for="enable-animations">Habilitar Animaciones</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" style="transform: translateX(20px);" type="checkbox" id="enable-effects" name="enable-effects">
                            <label class="form-check-label" for="enable-effects">Habilitar Efectos</label>
                        </div>
                    </div>

                    </form>
                </div>
            </div>

            <script>
        $(document).ready(function () {
            const fontSizeSelect = $('#font-size');

            fontSizeSelect.change(function () {
                const selectedFontSize = fontSizeSelect.val();

                if (selectedFontSize === 'small') {
                    $('body').css('font-size', '50%');
                } else if (selectedFontSize === 'medium') {
                    $('body').css('font-size', '100%');
                } else if (selectedFontSize === 'large') {
                    $('body').css('font-size', '150%');
                }
            });
        });
    </script>



        <!-- COntenedor del formulario de Configuraciones -->

            <div class="col-md-6">
                <div class="bg-contain2 p-3">


                    <div class="containerperfil">
                    <h2 class="text-center"style="color: white; padding-top: 15px;">Cuenta y Privacidad</h2>
                  
                    <a href="{{ route('perfil') }}" class="img-container">
                       <img src="{{ asset('images/Icono.png') }}" alt="Imagen de perfil" width="120" height="120" class="mx-auto d-block">
                    </a>
                    </div>

                    <br>
                    <br>



                    <div class="form-group mt-3">
                        <label for="language"><i class="fa fa-language"></i> Idioma preferido</label>
                        <select class="form-control" id="language">
                            <option value="es">Español</option>
                            <option value="en">Inglés</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for "theme"><i class="fa fa-paint-brush"></i> Tema</label>
                        <select class="form-control" id="theme">
                            <option value="light">Claro</option>
                            <option value="dark">Oscuro</option>
                        </select>
                    </div>


                    <div class="form-group mt-3">
                        <label for="language"><i class="fa fa-globe"></i> Pais</label>
                        <select class="form-control" id="language">
                            <option value="es">Colombia</option>
                            <option value="en">Argentina</option>
                            <option value="en">Chile</option>
                            <option value="en">Panama</option>
                        </select>
                    </div>

                    

                    <div class="claseborrar">
                         <div class="button-containerd"> 
                            <h3 style="color: rgb(66, 20, 20);">ZONA DE PELIGRO</h3>
                            <form action="{{ route('eliminar-cuenta-propia') }}" method="POST" id="eliminarCuentaForm" style="display: inline">
                              @csrf
                                 @method('DELETE')
                                 <button type="submit" class="custom-delete btn-danger" onclick="confirmarEliminar()"><i class="fa fa-trash"></i> Eliminar cuenta</button> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


      <!-- Boton para guardar cambios -->
         <div class="button-containerd">
                 <button class="custom-save ">Guardar cambios</button>
         </div>

    </div>

    <script>
    function confirmarEliminar() {
        if (!confirm('¿Estás seguro de que quieres eliminar tu cuenta? Si la eliminas no hay vuelta atras.')) {
            event.preventDefault();
        }
    }
    </script>

    <script>
        function ejecutarBoton() {
            var boton = document.querySelector('.custom-buttonn');
            if (boton) {
                boton.click(); 
            } else {
                alert('El botón no se encontró en la página.');
            }
        }
    </script>

      <br>
      <br>

    <!-- Js -->
    <script src="{{ asset('js/Profile.js') }}"></script>
    
    <!-- Plantillas -->
    @include('plantillas.Terminos_condiciones')
    @include('plantillas.fooster')
    @include('plantillas.Animacion')

