
// Simulación de horas ocupadas (debes obtenerlas dinámicamente de tu aplicación)
const horasOcupadas = ['08:00', '10:30', '14:00'];

// Función para abrir el diálogo de selección de hora
function abrirDialogoHora() {
  // Configuración del diálogo
  $('#dialog').html('<input type="text" id="horaPicker">');
  $('#horaPicker').timepicker({
    'scrollDefault': 'now',
    'step': 15,
    'minTime': '08:00',
    'maxTime': '18:00',
    'disableTimeRanges': horasOcupadas.map(hora => [hora, '23:59'])
  });

  // Abre el diálogo
  $('#dialog').dialog({
    modal: true,
    buttons: {
      "Aceptar": function() {
        // Obtiene la hora seleccionada
        const horaSeleccionada = $('#horaPicker').val();
        
        // Aquí puedes hacer lo que quieras con la hora seleccionada
        console.log('Hora seleccionada:', horaSeleccionada);

        // Cierra el diálogo
        $(this).dialog('close');
      },
      "Cancelar": function() {
        // Cierra el diálogo
        $(this).dialog('close');
      }
    }
  });
}

//abrirDialogoHora();
