<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streaming Estadisticas</title>

    <!-- Plantillas nav -->
    @include('plantillas.navinicio')

    <!-- HOJA DE ESTILOS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="{{ asset('css/estadisticas.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-cv9NDf10nsH79GzrPPPrpF3x5pCmgd78unBJlEj2aAz1fp1QlGYuVp5X1Hoof1J" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>

    <!-- TITULO + IMG ONDULADA SUPERIOR -->
    <h2 class="titulo display-5 font-weight-light">Control de Sensores</h2>
    <img src="{{ asset('images/nav6.png') }}" class="imgnav">


    <!-- BOTONES DE RIEGOS -->

    <div class="row" style="background-color: rgba(212, 211, 211, 0.712); width: 970px; margin: 0 auto; border-top-left-radius: 10px; border-top-right-radius: 10px;">
        <div class="col-md-4 pr-2">

        <div style="text-align: center;">
    <h4>Riego Manual</h4>
    <button id="toggleRelay" class="btn {{ Auth::user()->relay_state == 1 ? 'btn-danger' : 'btn-success' }}">Manual</button>
</div>


            <!-- <div class="centered-container">
                <h4>Riego Manual</h4>
                <form method="POST" action="{{ route('toggle_relay') }}">
                    @csrf
                    <button type="submit" class="btn {{ Auth::user()->relay_state == 1 ? 'btn-danger' : 'btn-success' }}">Manual</button>
                    <p>{{ Auth::user()->relay_state == 1 ? 'Apagado' : 'Encendido' }}</p>
                </form>
            </div> -->
        </div>
        <div class="col-md-4 pl-2">
            <div class="centered-container">
                <h4>Riego Automático</h4>
                <button id="btnToggle" class="btn btn-primary" onclick="alternarFuncion()">Automático</button>
                <p><span id="estadoFuncion">Apagado</span></p>
            </div>
        </div>
        <div class="col-md-4 pl-2">
            <div class="centered-container">
                <h4>Detector de Humedad</h4>
                <button id="btnHumedad" class="btn btn-warning" onclick="detectarHumedad()">Detector</button>
                <p><span id="resultadoHumedad">Apagado</span></p>

            </div>
        </div>
    </div>

</div>




<!-- TABLA DE DATOS EN UTIMO DATO -->
<div class="sensor-container">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
              <th class="text-center"><i class="fas fa-microchip" style="color: #27ae60;"></i> Sensor</th>
              <th class="text-center"><i class="fas fa-database" style="color: #8e44ad;"></i> Datos</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><i class="fas fa-tint" style="color: #3498db;"></i> Humedad</td>
                <td id="humedad">Recopilando Datos..</td>
            </tr>
            <tr>
                <td><i class="fas fa-thermometer-half" style="color: #e74c3c;"></i> Temperatura</td>
                <td id="temperatura">Recopilando Datos..</td>
            </tr>
            <tr> 
                <td><i class="fas fa-seedling" style="color: #2ecc71;"></i> Humedad del Suelo</td>
                <td id="humedad_suelo">Recopilando Datos..</td>
            </tr>
            <tr>
                <td><i class="fas fa-tint" style="color: #f39c12;"></i> Flujo de Agua</td>
                <td id="flujo_agua">Recopilando Datos..</td>
            </tr>
        </tbody>
    </table>
</div>

<style>

.row{
    margin-right: 50px;
    margin-left: 50px;

}

</style>
    
<!-- GRAFICAS -->

    <div class="row"style="padding: 30px;">
        <div class="col-md-6">
            <div class="chart-container">
                <canvas id="chartHumedad"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="chart-container">
                <canvas id="chartHumedadSuelo"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="chart-container">
                <canvas id="chartTemperatura"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="chart-container">
                <canvas id="chartFlujoAgua"></canvas>
            </div>
        </div>
    </div>
    <div class="text-center">
    <img src="{{ asset('images/natura.png') }}" alt="Menú" class="img2s">
    </div>
   


    <!-- Manual  -->
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleRelayBtn = document.getElementById('toggleRelay');
        const statusText = document.getElementById('statusText');

        toggleRelayBtn.addEventListener('click', function (e) {
            e.preventDefault();

            // Realiza una solicitud POST al servidor
            fetch('http://192.168.1.58/toggle_relay', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Actualiza el color del botón según el nuevo estado
                toggleRelayBtn.className = data.relay_state == 1 ? 'btn btn-danger' : 'btn btn-success';

                // Actualiza el texto según el nuevo estado
                statusText.textContent = data.relay_state == 1 ? 'Apagado' : 'Encendido';
            })
            .catch(error => {
                console.error('Error en la solicitud Fetch:', error);
            });
        });
    });
</script>










    <!-- JS GRAFICAS -->

    <script>
        var datos = @json($datos);

        var fechas = datos.map(function (dato) {
            return dato.fecha_hora;
        });

        // Transformación de humedad, humedad_suelo, temperatura y flujo_agua
        var humedad = transformarDatos(datos.map(dato => dato.humedad), 0, 100);
        var humedadSuelo = transformarDatos(datos.map(dato => dato.humedad_suelo), 2100, 4095);
        var temperatura = transformarDatos(datos.map(dato => dato.temperatura), 0, 100);
        var flujoAgua = transformarDatos(datos.map(dato => dato.flujo_agua), 0, 100);

        function transformarDatos(originales, min, max) {
            return originales.map(function (original) {
                return (original - min) / (max - min) * (100 - 1) + 1;
            });
        }

        // Configuración de la gráfica para humedad
        var ctxHumedad = document.getElementById('chartHumedad').getContext('2d');
        var chartHumedad = new Chart(ctxHumedad, {
            type: 'line',
            data: {
                labels: fechas,
                datasets: [
                    {
                        label: 'Humedad (%)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        data: humedad,
                        fill: false,
                        pointRadius: 5,
                    }
                ],
            },
            options: {
                scales: {
                    x: {
                        type: 'category',
                        position: 'bottom',
                        color: 'white',
                        ticks: {
                            color: 'black'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 102,
                        ticks: {
                            color: 'black',
                        }
                    },
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'black'
                        }
                    }
                }
            },
        });

        // Configuración de la gráfica para humedad del suelo
        var ctxHumedadSuelo = document.getElementById('chartHumedadSuelo').getContext('2d');
        var chartHumedadSuelo = new Chart(ctxHumedadSuelo, {
            type: 'line',
            data: {
                labels: fechas,
                datasets: [
                    {
                        label: 'Humedad del Suelo (%)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        data: humedadSuelo,
                        fill: false,
                        pointRadius: 5,
                    }
                ],
            },
            options: {
                scales: {
                    x: {
                        type: 'category',
                        position: 'bottom',
                        color: 'white',
                        ticks: {
                            color: 'black'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 102,
                        ticks: {
                            color: 'black',
                        }
                    },
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'black'
                        }
                    }
                }
            },
        });

        // Configuración de la gráfica para temperatura
        var ctxTemperatura = document.getElementById('chartTemperatura').getContext('2d');
        var chartTemperatura = new Chart(ctxTemperatura, {
            type: 'line',
            data: {
                labels: fechas,
                datasets: [
                    {
                        label: 'Temperatura (°C)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        data: temperatura,
                        fill: false,
                        pointRadius: 5,
                    }
                ],
            },
            options: {
                scales: {
                    x: {
                        type: 'category',
                        position: 'bottom',
                        color: 'white',
                        ticks: {
                            color: 'black'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 102,
                        ticks: {
                            color: 'black',
                        }
                    },
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'black'
                        }
                    }
                }
            },
        });

        // Configuración de la gráfica para flujo de agua
        var ctxFlujoAgua = document.getElementById('chartFlujoAgua').getContext('2d');
        var chartFlujoAgua = new Chart(ctxFlujoAgua, {
            type: 'line',
            data: {
                labels: fechas,
                datasets: [
                    {
                        label: 'Flujo de Agua (Mil)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        data: flujoAgua,
                        fill: false,
                        pointRadius: 5,
                    }
                ],
            },
            options: {
                scales: {
                    x: {
                        type: 'category',
                        position: 'bottom',
                        color: 'white',
                        ticks: {
                            color: 'black'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 102,
                        ticks: {
                            color: 'black',
                        }
                    },
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'black'
                        }
                    }
                }
            },
        });
    </script>



<!-- FUNCION BOTON AUTOMATICA  -->

<script>
let funcionActiva = false;
let bucleFuncion;

function alternarFuncion() {
    // Alterna entre encender y apagar la función
    if (funcionActiva) {
        desactivarFuncion();
    } else {
        activarFuncion();
    }
}

function activarFuncion() {
    // Verifica si la función ya está activa
    if (!funcionActiva) {
        // Activa la función y actualiza el estado
        funcionActiva = true;
        actualizarEstado();
        
        // Inicia el bucle que enciende y apaga el relé cada 5 segundos
        bucleFuncion = setInterval(() => {
            simularLlamadaAPI(true); // Enciende el relé
            setTimeout(() => {
                simularLlamadaAPI(false); // Apaga el relé después de 1 segundo
            }, 1000);
        }, 5000);
    }
}

function desactivarFuncion() {
    // Verifica si la función está activa antes de desactivarla
    if (funcionActiva) {
        // Desactiva la función, actualiza el estado y detiene el bucle
        funcionActiva = false;
        actualizarEstado();
        clearInterval(bucleFuncion);
    }
}

function actualizarEstado() {
    // Actualiza el texto que muestra el estado
    const estadoSpan = document.getElementById('estadoFuncion');
    estadoSpan.textContent = funcionActiva ? 'Encendido' : 'Apagado';
}

function simularLlamadaAPI(encender) {
    // Simula la llamada a la API local
    const userId = 1; // Reemplaza con tu userId
    const url = `http://192.168.1.58/`;
    
    // Simula una petición POST (puedes ajustar según las necesidades de tu API)
    const xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    
    // Simula el cuerpo de la solicitud
    const body = JSON.stringify({ encender: encender });
    
    // Maneja la respuesta (puedes ajustar según las necesidades de tu API)
    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log('API Response:', xhr.responseText);
        } else {
            console.error('Error en la llamada a la API:', xhr.statusText);
        }
    };
    
    xhr.send(body);
}
</script>




<!-- FUNCION PARA ACTUALIZAR -->

<script>
    // Llama a la función al cargar la página para obtener la primera lectura
    obtenerUltimaLectura();

    // Actualiza los datos cada 5 segundos (ajusta el intervalo según tus necesidades)
    setInterval(obtenerUltimaLectura, 5000);

    function obtenerUltimaLectura() {
        $.ajax({
            url: "{{ route('obtener-ultima-lectura') }}",
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    actualizarDatos(response.data);
                } else {
                    console.error("Error al obtener el último dato:", response.message);
                }
            },
            error: function(error) {
                console.error("Error en la solicitud AJAX:", error);
            }
        });
    }

    function actualizarDatos(datos) {
        $('#humedad').text(datos.humedad + '%');
        $('#temperatura').text(datos.temperatura + ' °C');
        $('#humedad_suelo').text(transformarDatoHumedadSuelo(datos.humedad_suelo));
        $('#flujo_agua').text(datos.flujo_agua + ' Mililitros');
        $('#fecha_hora').text(datos.fecha_hora);
    }

    function transformarDatoHumedadSuelo(original) {
        // Realiza la transformación de rango de 2100 a 4095 a 1 a 100
        var porcentaje = ((original - 2100) / (4095 - 2100)) * 100;

        // Asigna una categoría según el porcentaje
        if (porcentaje >= 80) {
            return 'Muy seco (' + porcentaje.toFixed(2) + '%)';
        } else if (porcentaje >= 60 && porcentaje < 80) {
            return 'Seco (' + porcentaje.toFixed(2) + '%)';
        } else if (porcentaje >= 40 && porcentaje < 60) {
            return 'Estable (' + porcentaje.toFixed(2) + '%)';
        } else if (porcentaje >= 20 && porcentaje < 40) {
            return 'Húmedo (' + porcentaje.toFixed(2) + '%)';
        } else {
            return 'Muy húmedo (' + porcentaje.toFixed(2) + '%)';
        }
    }
</script>

    @include('plantillas.Terminos_condiciones')
    @include('plantillas.fooster')
    @include('plantillas.Animacion')

</body>
</html>
