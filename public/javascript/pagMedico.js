$(function () {
  const pacientes = [];
  const pacientesObj=[];
  var buscar=$("button#buscar");

  //Traer seguros
  /*
  $.getJSON("https://localhost:8000/api/seguro", function (data) {
    console.log(data["seguros"]);
    $.each(data["seguros"], function (i, v) {
      var option=$("<option>").val(data["seguros"][i].id).text(data["seguros"][i].nombre).attr("id", "seguro-"+i).appendTo($("#seguro"));
      option[0].objtipoConsulta=data["seguros"][i]; 
    });
  });*/

  //Traer tipos de consulta
  $.getJSON("https://localhost:8000/api/tipoconsulta", function (data) {
    $.each(data["tiposConsultas"], function (i, v) {
      var option=$("<option>").val(data["tiposConsultas"][i].id).text(data["tiposConsultas"][i].descripcion).attr("id", "consulta-"+i).appendTo($("#tipoConsulta"));
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
  function rellenarFormulario(selectedPaciente) 
  { 
    // Limpiar el formulario antes de llenarlo
    $("#dni").val("");
    $("#seguro").val("");
    $("#paciente").val("");

    if(typeof(selectedPaciente)==="object" && selectedPaciente!==null){
      selectedPaciente=selectedPaciente.nombreCompleto();
    }

    // Recorremmos el array de pacientes para encontrar el paciente seleccionado
    for (let i = 0; i < pacientes.length; i++) {
      debugger
      if (pacientesObj[i].nombreCompleto() ===  selectedPaciente ) {
        const pacienteSeleccionado = pacientesObj[i];
        // Rellena los campos del formulario con los datos del paciente
        if ($("#dni").val() === "") {
          $("#dni").val(pacienteSeleccionado.dni);
        }
        if ($("#seguro").val() === "") {
          $("#seguro").val(pacienteSeleccionado.seguro.nombre);
        }
        if ($("#paciente").val() === "") {
          $("#paciente").val(pacientesObj[i].nombreCompleto());
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
        minLength: 3,
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

  //Función que busca los pacientes por DNI
  function obtenerDni(){
    var dni=$("#dni").val();
    $.getJSON("https://localhost:8000/api/paciente/"+dni, function (data) {
      console.log(data["paciente"]);
      pacientes.splice(0, pacientes.length); // Limpiar el array
      const paciente = new Paciente(
        data["paciente"].id,
        data["paciente"].nombre,
        data["paciente"].ap1,
        data["paciente"].ap2,
        data["paciente"].dni,
        data["paciente"].foto,
        data["paciente"].user,
        data["paciente"].seguro,
        data["paciente"]
      );
      //pacientes.push(paciente);
      pacientes.push(paciente.nombreCompleto());
      pacientesObj.push(paciente);
      debugger
      rellenarFormulario(paciente);
    });
  }

  //---------------------------------------------EVENTOS--------------------------------------------------
  // Asignar evento para obtener datos de pacientes y configurar el autocompletado
  $("#paciente").on("keyup", function (ev) {
    ev.preventDefault();
    obtenerDatosPacientes();
  });

  //Buscar por dni
  buscar.on("click", function(ev){
    ev.preventDefault();
    obtenerDni();
  });

});
