<!DOCTYPE html>
<html>
<head>
    <title>Registros</title>

    <!-- Plantilla -->
    @include('plantillas.navinicio')


    <!-- Estilos y cosas referentes -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="{{ asset('css/arduino.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>



</head>
<body>

<!-- Titulo y IMG -->

    <h2 class="titulo display-5 font-weight-light">Registro de sensores</h2>
    <img src="{{ asset('images/nav6.png') }}" class="imgnav">

    <div class="black-container">
        <div class="container mt-5">
            <div class="text-center mb-3">
                
    <div class="container mt-4">
        <form id="dateFilterForm">
            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control" id="startDate" placeholder="Fecha de inicio (dd/mm/aaaa)">
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="endDate" placeholder="Fecha de fin (dd/mm/aaaa)">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Filtrar</button>
        </form>
        <div id="searchResults" class="mt-4">
        </div>
    </div>



    <!-- Grafica -->

    <div style="width: 80%; margin: auto;     background-color: rgba(218, 215, 215, 0.534);
 border-radius: 5px; padding: 40px;backdrop-filter: blur(5px);">
    <canvas id="myChart"></canvas>
     </div>

            <div class="Graficas">
            <div id="graficaContainer" style="display: none;">
                <canvas id="myChart"></canvas>
            </div>
            </div>

        </div>

<!-- BOTONES ELIMINAR Y EXPORTAR -->

        <div class="d-flex justify-content-between mb-3">
    <div>
        <form id="deleteForm" action="{{ route('sensores.vaciar') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-danger" onclick="confirmarEliminacion()">
                <i class="fas fa-trash"></i> Vaciar registros
            </button>
        </form>
    </div>

    <div class="ml-auto">
        <button type="button" class="btn btn-primary" onclick="exportarPDF()">
            <i class="fas fa-file-pdf"></i> Exportar a PDF
        </button>
    </div>
</div>

<div>


<!-- TABLA DE DATOS -->
        
<div class="Tablad">

 <table id="tablaDatos" class="table table-striped">
    <thead class="thead-dark">
        <tr>
            <th><i class="fas fa-tint text-primary"></i> Humedad</th>
            <th><i class="fas fa-thermometer-half text-danger"></i> Temperatura</th>
            <th><i class="fas fa-tint text-info"></i> Humedad Suelo</th>
            <th><i class="fas fa-tint text-success"></i> Flujo de Agua</th>
            <th><i class="far fa-clock text-secondary"></i> Fecha y Hora</th>
        </tr>
    </thead>
    <tbody>
        @if(count($datos) > 0)
            @foreach($datos as $dato)
                <tr>
                    <td>{{ $dato['humedad'] }} %</td>
                    <td>{{ $dato['temperatura'] }} °C</td>
                    <td>{{ $dato['humedad_suelo'] }} %</td>
                    <td>{{ $dato['flujo_agua'] }} Mil</td>
                    <td>{{ $dato['fecha_hora'] }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5">No hay registros disponibles.</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
      
        </div>
    </div>


<!-- JS que permite graficarlos -->

    <script>
    var datos = @json($datos);

    // Extrae las fechas y los valores de cada sensor
    var fechas = datos.map(function (dato) {
        return dato.fecha_hora;
    });

    // Transformación de humedad
    var humedad = datos.map(function (dato) {
        var humedadOriginal = dato.humedad;
        var MIN_RANGO_ACTUAL_HUMEDAD = 0;  // Reemplaza con el valor mínimo en tu rango actual de humedad
        var MAX_RANGO_ACTUAL_HUMEDAD = 100;  // Reemplaza con el valor máximo en tu rango actual de humedad
        var humedadTransformada = (humedadOriginal - MIN_RANGO_ACTUAL_HUMEDAD) / (MAX_RANGO_ACTUAL_HUMEDAD - MIN_RANGO_ACTUAL_HUMEDAD) * (100 - 1) + 1;
        return humedadTransformada;
    });

    // Transformación de humedad_suelo
    var humedadSuelo = datos.map(function (dato) {
        var humedadSueloOriginal = dato.humedad_suelo;
        var MIN_RANGO_ACTUAL_HUMEDAD_SUELO = 2100;  // Reemplaza con el valor mínimo en tu rango actual de humedad_suelo
        var MAX_RANGO_ACTUAL_HUMEDAD_SUELO = 4095;  // Reemplaza con el valor máximo en tu rango actual de humedad_suelo
        var humedadSueloTransformada = ((humedadSueloOriginal - MIN_RANGO_ACTUAL_HUMEDAD_SUELO) / (MAX_RANGO_ACTUAL_HUMEDAD_SUELO - MIN_RANGO_ACTUAL_HUMEDAD_SUELO)) * 100;

        // Asegurar que el porcentaje esté en el rango del 1 al 100
        humedadSueloTransformada = Math.max(1, Math.min(100, humedadSueloTransformada));

        return humedadSueloTransformada;
    });

    // Transformación de temperatura
    var temperatura = datos.map(function (dato) {
        var temperaturaOriginal = dato.temperatura;
        var MIN_RANGO_ACTUAL_TEMPERATURA = 0;  // Reemplaza con el valor mínimo en tu rango actual de temperatura
        var MAX_RANGO_ACTUAL_TEMPERATURA = 100;  // Reemplaza con el valor máximo en tu rango actual de temperatura
        var temperaturaTransformada = (temperaturaOriginal - MIN_RANGO_ACTUAL_TEMPERATURA) / (MAX_RANGO_ACTUAL_TEMPERATURA - MIN_RANGO_ACTUAL_TEMPERATURA) * (100 - 1) + 1;
        return temperaturaTransformada;
    });

    // Transformación de flujo_agua
    var flujoAgua = datos.map(function (dato) {
        var flujoAguaOriginal = dato.flujo_agua;
        var MIN_RANGO_ACTUAL_FLUJO_AGUA = 0;  // Reemplaza con el valor mínimo en tu rango actual de flujo_agua
        var MAX_RANGO_ACTUAL_FLUJO_AGUA = 100;  // Reemplaza con el valor máximo en tu rango actual de flujo_agua
        var flujoAguaTransformada = (flujoAguaOriginal - MIN_RANGO_ACTUAL_FLUJO_AGUA) / (MAX_RANGO_ACTUAL_FLUJO_AGUA - MIN_RANGO_ACTUAL_FLUJO_AGUA) * (100 - 1) + 1;
        return flujoAguaTransformada;
    });

    // Configuración de la gráfica para humedad, humedad_suelo, temperatura y flujo_agua
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: fechas,
            datasets: [
                {
                    label: 'Humedad (%)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    data: humedad,
                    fill: false,
                    pointRadius: 5,
                },
                {
                    label: 'Humedad del Suelo (%)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    data: humedadSuelo,
                    fill: false,
                    pointRadius: 5,
                },
                {
                    label: 'Temperatura (°C)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    data: temperatura,
                    fill: false,
                    pointRadius: 5,
                },
                {
                    label: 'Flujo de Agua (Mil)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    data: flujoAgua,
                    fill: false,
                    pointRadius: 5,
                },
            ],
        },
        options: {
            scales: {
                x: {
                    type: 'category',
                    position: 'bottom',
                    color: 'white',  
                        ticks: {
                            color: 'rgb(44, 44, 44)'  
                        }
                },

                y: {
                    beginAtZero: true,
                    max: 102,
                    ticks: {
                        color: 'rgb(44, 44, 44)',  
                    }
                },
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'rgb(44, 44, 44)'  
                    }
                }
            }
        },
    });
</script>



<!-- Implementeacion jss -->

<script src="{{ asset('js/RegistrosHistorial.js') }}"></script>

<!-- Implementacion demas plantillas -->

    @include('plantillas.Terminos_condiciones')
    @include('plantillas.fooster')
    @include('plantillas.Animacion')

    
</body>
</html>
