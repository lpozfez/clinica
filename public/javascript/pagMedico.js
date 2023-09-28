$(function () {
  const pacientes = [];

  // Acordeón
  var icons = {
    header: "ui-icon-circle-arrow-e",
    activeHeader: "ui-icon-circle-arrow-s",
  };
  $("#nav-consulta").accordion({
    collapsible: true,
    active: false,
    icons: icons,
  });

  // Función para obtener los datos de pacientes de la API
  function obtenerDatosPacientes() {
    $.getJSON("https://localhost:8000/api/paciente", function (data) {
      pacientes.splice(0, pacientes.length); // Limpiar el array
      $.each(data["pacientes"], function (i, v) {
        const paciente=new Paciente (data["pacientes"][i].id,data["pacientes"][i].nombre,data["pacientes"][i].ap1,data["pacientes"][i].ap2,data["pacientes"][i].dni,data["pacientes"][i].foto,data["pacientes"][i].user,data["pacientes"][i].seguro,data["pacientes"][i]);
        pacientes.push(paciente.nombreCompleto());
        console.log(pacientes);
      });
      // Configurar el autocompletado dentro de esta función después de obtener los datos
      $("#paciente").autocomplete({
        source: pacientes,
        change: function(ev){
          ev.preventDefault();
          pacientes.splice(0, pacientes.length);//limpiamos el array para evitar duplicidades
        },
        select: function( event, ui ) {
          
        },
      });
    });
  }

  // Asignar evento click para obtener datos de pacientes y configurar el autocompletado
  $("#paciente").on("click", function (ev) {
    ev.preventDefault();
    obtenerDatosPacientes();
  });


});