//Función que coge una fecha en string y devuelve la fecha Date()
function deJsonADate(fechaString) {
  var fecha = Date.parse(fechaString); //pasamos string a milisegundos
  fecha = new Date(fecha); //Pasamos de milisegundos a Date
  //var fechaEs = fecha.toLocaleString("es-es"); //Mostramos en castellano
  return fecha;
}

//Función que devuelve la fecha Date() formateada
function formateaFecha(fecha){

  console.log(fecha.getDate());
  var fechaHoraFormateada = fecha.getDate() + '-' + (fecha.getMonth() + 1) + '-' + fecha.getFullYear() + ' ' +fecha.getHours() + ':' + fecha.getMinutes() + ':' + fecha.getSeconds();

  return fechaHoraFormateada;
}



function mostrarDialogo(mensaje) {
  // Crea un diálogo simple con el mensaje
  $("<div>").text(mensaje).dialog({
    modal: true,
    buttons: {
      Ok: function () {
        $(this).dialog("close");
      }
    }
  });
}