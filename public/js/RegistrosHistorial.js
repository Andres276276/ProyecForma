//VISTA ARDUINO

//Funcion para eliminar datos, para dar mensaje de pregunta
function confirmarEliminacion() {
    if (confirm('¿Estás seguro de eliminar los registros?')) {
        document.getElementById('deleteForm').submit();
    }
}


//Guardar como pdf registros
function exportarPDF() {
    // Obtén el contenido de la tabla en formato HTML
    var contenidoTabla = document.getElementById('tablaDatos');

    // Convertir la tabla a una imagen usando html2canvas
    html2canvas(contenidoTabla).then(canvasTabla => {
        // Obtén el contenido de la gráfica
        var canvasGrafica = document.getElementById('myChart');
        var imgDataGrafica = canvasGrafica.toDataURL('image/png');

        // Crea el PDF
        var pdf = new pdfMake.createPdf({
            content: [
                // Sección de la tabla (convertida a imagen)
                {
                    image: canvasTabla.toDataURL('image/png'),
                    width: 500,
                },
                // Sección de la gráfica
                {
                    image: imgDataGrafica,
                    width: 500,
                }
            ]
        });

        // Descarga el PDF
        pdf.download('Registros.pdf');
    });
}
