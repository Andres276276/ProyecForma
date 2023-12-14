<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayuda - Tu Aplicación de Riego</title>

    @include('plantillas.navinicio')
    <!-- Incluir Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/ayuda.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    

</head>
<body>


    <!-- Titulo y IMG -->
    <h2 class="titulo display-5 font-weight-light ">Información - Tu Aplicación de Riego</h2>
    <img src="{{ asset('images/nav6.png') }}" class="imgnav">



<div class="todocont">
    <div class="container">
        <h1 class="my-4">Descubre la Agricultura Inteligente</h1>

        <section class="mb-4">
        <h2>Introducción</h2>
    <p>
        Bienvenido al mundo de la agricultura inteligente. Hemos creado una aplicación móvil diseñada para ayudarte a cuidar de tus cultivos de una manera más eficiente. Esta innovadora herramienta te permite monitorear y controlar tus sistemas de riego a través de dispositivos Arduino, incluso si no eres un experto en tecnología.
    </p>
    <p>
        Imagina tener el control total sobre el suministro de agua de tus cultivos directamente desde tu teléfono móvil. Nuestra aplicación está pensada para agricultores y amantes de la jardinería como tú, ofreciéndote una solución práctica y eficiente para gestionar el riego de manera inteligente y sin complicaciones.
    </p>
</section>

<section class="mb-4">
    <h2>Objetivos</h2>
    <h3>Objetivos Generales</h3>
    <ul>
        <li>Facilitar el monitoreo y control del riego de forma intuitiva.</li>
        <li>Ajustar el riego según las necesidades específicas de tus cultivos.</li>
        <li>Mejorar la eficiencia y la productividad en el manejo del agua.</li>
        <li>Recibir notificaciones útiles y contar con registros detallados.</li>
        <li>Fomentar prácticas sostenibles y el uso responsable del agua.</li>
    </ul>

    <h3>Objetivos Específicos</h3>
    <ul>
        <li>Proporcionar información en tiempo real sobre la humedad del suelo mediante sensores.</li>
        <li>Ofrecer una interfaz fácil de entender y utilizar, incluso para quienes no son expertos en tecnología.</li>
        <!-- Agregar más objetivos específicos según tus necesidades -->
    </ul>
</section>

<section class="mb-4">
    <h2>Propósito</h2>
    <p>
        Nuestro propósito es poner en tus manos una aplicación móvil que te permita monitorear y controlar los dispositivos Arduino encargados del riego en tus cultivos. Queremos facilitarte la gestión del riego, ayudándote a tomar decisiones informadas de manera accesible y amigable. Esta aplicación está diseñada para mejorar la eficiencia y la gestión del riego en la agricultura y la jardinería, haciéndola accesible para todos.
    </p>
</section>

<section class="mb-4">
    <h2>Ámbito del Sistema</h2>
    <p>
        El sistema que hemos desarrollado tiene como objetivo ser tu aliado en el cuidado de tus cultivos. No te preocupes por la tecnología; nosotros nos encargamos. Utilizamos sensores para medir la humedad del suelo y te notificamos directamente en tu móvil cuando tus plantas necesitan agua. Queremos simplificar tu vida agrícola, proporcionándote información valiosa de manera sistemática y eficiente.
    </p>
</section>
    </div>
    

    <div class="bg-white py-5">
  <div class="container py-5">
    <div class="contenedor">
    <span class="icono-font-awesome"><i class="fas fa-info-circle fa-4x"></i></span>
        <img src="{{ asset('images/IMG_PNG.png') }}" alt="Imagen"  id="imagen">
        <div class="texto-oculto font-italic text-muted mb-4" id="texto">
        <h2 class="display-4 font-weight-light">Cultivando Armonía</h2>
        <p style="text-align: left;">
"En cada gota de riego, encontramos la sinfonía de la naturaleza. <br>
Recordemos que nuestras elecciones son semillas para un futuro sostenible.  <br>
Que cada acto construya un puente hacia el equilibrio armonioso, <br>
celebrando la maravilla de la vida y preservando la belleza de <br>
nuestro hogar compartido."</p>
      </div>    
    </div>

      </div>
    </div>
  </div>
</div>

  </div>
</div>




    <script src="{{ asset('js/quienessomos.js') }}"></script>


    <!-- <img src="images/IMG_PNG.png" alt=""> -->

    </div>

    @include('plantillas.Terminos_condiciones')
    @include('plantillas.fooster')
    @include('plantillas.Animacion')

    <!-- Incluir Bootstrap JS y Popper.js al final del cuerpo para un mejor rendimiento -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
