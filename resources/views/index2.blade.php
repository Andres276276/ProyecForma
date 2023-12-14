<!DOCTYPE html>
<html>
<head>
    <title>Index2</title>
</head>
<body>
    <h1>Datos Meteorológicos</h1>

    @if(isset($datos))
        <pre>{{ json_encode($datos, JSON_PRETTY_PRINT) }}</pre>
    @else
        <p>No se pudieron obtener datos meteorológicos.</p>
    @endif
</body>
</html>
