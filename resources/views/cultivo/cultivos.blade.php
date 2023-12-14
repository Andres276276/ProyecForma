<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cultivos</title>
    <!-- Menu -->
    @include('plantillas.navinicio')
    <!-- Estilos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-df3L6iQkKjDQcXa8/I9tmDjsyP9g6zEpQnT+fd+9fgeg0T0u0L02qWvqELzU3Wug" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
    integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/cultivos.css') }}">
</head>
<body>

<!-- Titulo y IMG -->
<h2 class="titulo display-5 font-weight-light ">Jardín de la Abundancia</h2>
    <img src="{{ asset('images/nav6.png') }}" class="imgnav">



<!-- Prueba de errores -->

            <!-- EXITO CULTIVO -->
            @if(session('error'))
               <div class="alert alert-danger" style="text-align: center; padding: 9px; border: 1px solid #f5c6cb;">
                  {{ session('error') }}
               </div>
            @endif

            <!-- FALLIDA CULTIVO -->
            @if(session('success'))
            <div class="alert alert-success" style="text-align: center; padding: 9px; border: 1px solid #f5c6cb;">
                {{ session('success') }}
            </div>
            @endif

    <!-- Formulario para crear nuevo cultivo -->
    <div class="container">
         <button id="mostrarFormulario" class="boton_regis btn mx-auto"><i class="fas fa-seedling"></i> Registrar Cultivo</button>
         <div id="formularioContainer" style="display: none;">



            <form method="POST" action="{{ route('cultivos.store') }}">
                @csrf

                <h3 style="text-align: center;color: white; font-size: 35px;">Crear Cultivo</h3>

                <div class="form-group">
                <label for="nombre"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Información adicional"></i>Nombre del Cultivo</label>                    
                <input type="text" name="nombre" id="nombre" class="form-control" required>
                    @error('nombre')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                <label for="descripcion"><i class="fas fa-paragraph" data-toggle="tooltip" data-placement="top" title="Información adicional"></i>Descripción</label>                    
                <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                    @error('descripcion')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="nivel_humedad_optimo"><i class="fas fa-water" data-toggle="tooltip" data-placement="top" title="Información adicional"></i>Nivel Óptimo de Humedad</label>                    
                    <input type="number" name="nivel_humedad_optimo" id="nivel_humedad_optimo" class="form-control"
                        required>
                    @error('nivel_humedad_optimo')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">


                    <label for="tipo_plantas"><i class="fas fa-leaf" data-toggle="tooltip" data-placement="top" title="Información adicional"></i>Tipo de Plantas</label>
                        <select name="tipo_plantas" id="tipo_plantas" class="form-control">
                             <option value="" disabled selected>Seleccione...</option>
                             <option value="hortalizas">Hortalizas</option>
                             <option value="frutas">Frutas</option>
                             <option value="cereales">Cereales</option>
                             <option value="flores">Flores</option>
                             <option value="plantas_medicinales">Plantas Medicinales</option>
                             <option value="árboles_frutales">Árboles Frutales</option>
                             <option value="vegetales_de_raiz">Vegetales de Raíz</option>
                             <option value="legumbres">Legumbres</option>
                             <option value="hierbas_aromaticas">Hierbas Aromáticas</option>
                             <option value="arbustos_ornamentales">Arbustos Ornamentales</option>
                             <option value="plantas_acuaticas">Plantas Acuáticas</option>
                             <option value="musgos">Musgos</option>
                             <option value="helechos">Helechos</option>
                             <option value="cactus_suculentas">Cactus y Suculentas</option>
                             <option value="gramineas_ornamentales">Gramíneas Ornamentales</option>
                    </select>

                        @error('tipo_plantas')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>




                <div class="form-group">
                <label for="fecha_siembra"><i class="fas fa-calendar" data-toggle="tooltip" data-placement="top" title="Información adicional"></i>Fecha de Siembra</label>                   
                <input type="date" name="fecha_siembra" id="fecha_siembra" class="form-control">
                    @error('fecha_siembra')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="boton_regis btn"style="margin-left: auto; margin-right: auto; display: block;">Crear Cultivo</button>
            </form>
        </div>

    <br>    

 <!-- Muestra del cultivo con su img y detalles -->

        <div class="row">
    @foreach($cultivos as $cultivo)
        <div class="col-md-4 mb-3">
        <a href="{{ route('sensor.index', ['id' => $cultivo->id]) }}">
            <div class="card">
                <img src="{{ $cultivo->imagen ?? asset('images/img15.jpg') }}" class="card-img-top" alt="Imagen de Cultivo">
                <div class="card-body">
                    <h5 class="card-title">{{ $cultivo->nombre }}</h5>
                    <p class="card-text">{{ $cultivo->descripcion }}</p>
                    <p class="card-text"><strong>Tipo de Planta:</strong> {{ $cultivo->tipo_plantas }}</p>
                    </a>      
<br>


<!-- BORRAR CULTIVO -->
                    <a href="{{ route('cultivos.eliminar', ['id' => $cultivo->id]) }}"
   class="btn btn-danger"
   onclick="event.preventDefault(); if (confirm('¿Estás seguro de eliminar este cultivo?')) document.getElementById('eliminarCultivoForm{{ $cultivo->id }}').submit();">
    <i class="fas fa-trash-alt"></i>
</a>

<form id="eliminarCultivoForm{{ $cultivo->id }}" action="{{ route('cultivos.eliminar', ['id' => $cultivo->id]) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- EDITAR CULTIVOS -->
<a href="#" data-toggle="modal" data-target="#editarCultivoModal{{ $cultivo->id }}" class="btn btn-primary">
    <i class="fas fa-edit"></i>
</a>

<!-- Configurar cultivo -->

<a href="{{ url('formulario/') }}" class="btn btn-danger">
    <i class="fas fa-cog"></i>
</a>


<!-- Boton Detalles  -->
                    <button type="button" class="boton_deta btn" data-toggle="modal" data-target="#detalleModal{{ $cultivo->id }}">
                        Detalles
                    </button>
                </div>

<!-- Prueba de errores, Configuracion de cultivos a arduino  -->

                <h4 class="text-center" style="color: #fff; font-size: 17px;">Configuracion por defecto</h4>

            </div>




            
<!-- Modal de edición -->
<div class="modal fade" id="editarCultivoModal{{ $cultivo->id }}" tabindex="-1" role="dialog" aria-labelledby="editarCultivoModalLabel{{ $cultivo->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarCultivoModalLabel{{ $cultivo->id }}">Editar Cultivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <form action="{{ route('cultivos.update', ['id' => $cultivo->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $cultivo->nombre }}" required>
                    </div>

                    <div class="form-group">
                        <label for="nivel_humedad_optimo">Nivel de Humedad Óptimo:</label>
                        <input type="number" class="form-control" id="nivel_humedad_optimo" name="nivel_humedad_optimo" value="{{ $cultivo->nivel_humedad_optimo }}" required>
                    </div>

                    <div class="form-group">
                               <label for="tipo_plantas">Tipo de Plantas:</label>
                                    <select name="tipo_plantas" id="tipo_plantas" class="form-control">
                                      <option value="" disabled selected>Seleccione...</option>
                                      <option value="hortalizas" {{ $cultivo->tipo_plantas == 'hortalizas' ? 'selected' : '' }}>Hortalizas</option>
                                      <option value="frutas" {{ $cultivo->tipo_plantas == 'frutas' ? 'selected' : '' }}>Frutas</option>
                                      <option value="cereales" {{ $cultivo->tipo_plantas == 'cereales' ? 'selected' : '' }}>Cereales</option>
                                      <option value="flores" {{ $cultivo->tipo_plantas == 'flores' ? 'selected' : '' }}>Flores</option>
                                      <option value="plantas_medicinales" {{ $cultivo->tipo_plantas == 'plantas_medicinales' ? 'selected' : '' }}>Plantas Medicinales</option>
                                      <option value="árboles_frutales" {{ $cultivo->tipo_plantas == 'árboles_frutales' ? 'selected' : '' }}>Árboles Frutales</option>
                                      <option value="Otros" {{ $cultivo->tipo_plantas == 'Otros' ? 'selected' : '' }}>Otros</option>
                                   </select>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion">{{ $cultivo->descripcion }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="fecha_siembra">Fecha de Siembra:</label>
                        <input type="date" class="form-control" id="fecha_siembra" name="fecha_siembra" value="{{ $cultivo->fecha_siembra }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style>


</style>


            <!-- Modal para detalles -->
            <div class="modal fade" id="detalleModal{{ $cultivo->id }}" tabindex="-1" role="dialog" aria-labelledby="detalleModalLabel" aria-hidden="true">
                <div class="detalles modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detalleModalLabel">Detalles del Cultivo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                        <table class="table table-bordered">
                    <tr>
                        <th class="tablaperso">Cultivo</th>
                        <td class="tablaperso">{{ $cultivo->nombre }}</td>
                    </tr>
                    <tr>
                        <th class="tablaperso">Descripción</th>
                        <td class="tablaperso">{{ $cultivo->descripcion }}</td>
                    </tr>
                    <tr>
                        <th class="tablaperso">Nivel Óptimo</th>
                        <td class="tablaperso">{{ $cultivo->nivel_humedad_optimo }} %</td>
                    </tr>
                    <tr>
                        <th class="tablaperso">Tipo de Plantas</th>
                        <td class="tablaperso">{{ $cultivo->tipo_plantas }}</td>
                    </tr>
                    <tr>
                        <th class="tablaperso">Fecha de Siembra</th>
                        <td class="tablaperso">{{ $cultivo->fecha_siembra }}</td>
                    </tr>
                </table>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var botonMostrarFormulario = document.getElementById('mostrarFormulario');
            var formularioContainer = document.getElementById('formularioContainer');

            botonMostrarFormulario.addEventListener('click', function () {
                formularioContainer.style.display = formularioContainer.style.display === 'none' ? 'block' : 'none';
            });
        });
    </script>







    @include('plantillas.Terminos_condiciones')
    @include('plantillas.fooster')
    @include('plantillas.Animacion')


</body>
</html>
