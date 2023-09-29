$(function () {
  const pacientes = [];
  const pacientesObj=[];

  //Traer seguros
  $.getJSON("https://localhost:8000/api/seguro", function (data) {
    console.log(data["seguros"]);
    $.each(data["seguros"], function (i, v) {
      var option=$("<option>").val(data["seguros"][i].id).text(data["seguros"][i].nombre).attr("id", "option-"+i).appendTo($("#seguro"));
      option[0].objtipoConsulta=data["seguros"][i]; 
    });
  });

  //Traer tipos de consulta
  $.getJSON("https://localhost:8000/api/tipoconsulta", function (data) {
    console.log(data["tiposConsultas"]);
    $.each(data["tiposConsultas"], function (i, v) {
      var option=$("<option>").val(data["tiposConsultas"][i].id).text(data["tiposConsultas"][i].descripcion).attr("id", "option-"+i).appendTo($("#tipoConsulta"));
      option[0].objtipoConsulta=data["tiposConsultas"][i]; 
    });
  });

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
  

  //---------------------------------------------TRATAR DATOS--------------------------------------------------
  //Función para rellenar el formulario con los datos del paciente
  function rellenarFormulario(selectedPaciente) {
    // Recorremmos el array de pacientes para encontrar el paciente seleccionado
    for (let i = 0; i < pacientes.length; i++) {
      if (pacientesObj[i].nombreCompleto() === selectedPaciente) {
        const pacienteSeleccionado = pacientesObj[i];
        // Rellena los campos del formulario con los datos del paciente
        $("#dni").val(pacienteSeleccionado.dni);
        //$("#seguro").val(pacienteSeleccionado.seguro.id);
        //console.log($("#seguro")[0]);
        for(let z = 0; z < $("#seguro")[0].length; z++){
          if(pacienteSeleccionado.seguro.id===z){
            console.log($("#option-"+pacienteSeleccionado.seguro.id));
            $("#seguro").option("#option-"+pacienteSeleccionado.seguro.id).selected(true);
          }
        }
      }
    }
  }

  //---------------------------------------------TRAER DATOS--------------------------------------------------
  // Función para obtener los datos de pacientes de la API
  function obtenerDatosPacientes() {
    $.getJSON("https://localhost:8000/api/paciente", function (data) {
      pacientes.splice(0, pacientes.length); // Limpiar el array
      $.each(data["pacientes"], function (i, v) {
        const paciente = new Paciente(
          data["pacientes"][i].id,
          data["pacientes"][i].nombre,
          data["pacientes"][i].ap1,
          data["pacientes"][i].ap2,
          data["pacientes"][i].dni,
          data["pacientes"][i].foto,
          data["pacientes"][i].user,
          data["pacientes"][i].seguro,
          data["pacientes"][i]
        );
        //pacientes.push(paciente);
        pacientes.push(paciente.nombreCompleto());
        pacientesObj.push(paciente);
        //console.log(pacientes);
      });
      // Configurar el autocompletado dentro de esta función después de obtener los datos
      $("#paciente").autocomplete({
        source: pacientes,
        change: function (ev) {
          ev.preventDefault();
          pacientes.splice(0, pacientes.length); //limpiamos el array para evitar duplicidades
        },
        select: function (event, ui) {
          rellenarFormulario(ui.item.value);
        },
        classes: {
          "ui-autocomplete": "highlight"
        },
      });
    });
  }

  //---------------------------------------------EVENTOS DE AUTOCOMPLETADO--------------------------------------------------
  // Asignar evento click para obtener datos de pacientes y configurar el autocompletado
  $("#paciente").on("click", function (ev) {
    ev.preventDefault();
    obtenerDatosPacientes();
  });

});
