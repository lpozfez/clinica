$(function () {
  const pacientes = [];
  const pacientesObj = [];
  var buscar = $("button#buscar");
  const notasNuevas = $("#notasConsulta");
  const notasPrevias = $("#notasanteriores");
  const btnGuardaConsulta = $("#guardar-consulta");
  //const btnCancelarConsulta = $("#cancelar-consulta");


  //---------------------------------------------Datos del paciente--------------------------------------------------
  //Traer tipos de consulta
  $.getJSON("https://localhost:8000/api/tipoconsulta", function (data) {
    $.each(data["tiposConsultas"], function (i, v) {
      var option = $("<option>")
        .val(data["tiposConsultas"][i].id)
        .text(data["tiposConsultas"][i].descripcion)
        .attr("id", "consulta-" + i)
        .appendTo($("#tipoConsulta"));
      option[0].objtipoConsulta = data["tiposConsultas"][i];
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
  /**Función para rellenar el formulario con los datos del paciente */
  function rellenarFormulario(selectedPaciente) {
    // Limpiar el formulario antes de llenarlo
    $("#dni").val("");
    $("#seguro").val("");
    $("#paciente").val("");
    $("#foto-paciente").attr("src", "/imagenes/mujer.png");
    let pacienteSeleccionado = "";
    if (typeof selectedPaciente === "object" && selectedPaciente !== null) {
      selectedPaciente = selectedPaciente.nombreCompleto();
    }

    // Recorremmos el array de pacientes para encontrar el paciente seleccionado
    for (let i = 0; i < pacientes.length; i++) {
      if (pacientesObj[i].nombreCompleto() === selectedPaciente) {
        pacienteSeleccionado = pacientesObj[i];
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
        $("#fotoPaciente").attr("src", pacienteSeleccionado.foto);
      }
    }

    let idPAc = pacienteSeleccionado.id;
    if (!notasPrevias.textContent) {
      $.getJSON(
        "https://localhost:8000/api/paciente/notas/" + idPAc,
        function (data) {
          //Tratamos las fechas
          const fechaNota = deJsonADate(data["notas_clinicas"][0].date);
          const fecha = formateaFecha(fechaNota);
          //Creamos las notas y las añadimos a una lista
          const notas = fecha + " -- " + data["notas_clinicas"][1];
          console.log(notas);
          let listado = $("<ul>");
          let nuevoParrafo = $("<li>").text(notas);
          listado.append(nuevoParrafo);
          notasPrevias.append(listado);
        }
      );
    }
  }

  //---------------------------------------------TRAER DATOS--------------------------------------------------
  /**Función para obtener los datos de pacientes de la API */
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
          "ui-autocomplete": "highlight",
        },
      });
    });
  }

  /**Función que busca los pacientes por DNI */
  function obtenerDni() {
    var dni = $("#dni").val();
    $.getJSON("https://localhost:8000/api/paciente/" + dni, function (data) {
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
        data["paciente"].seguro
      );
      //pacientes.push(paciente);
      pacientes.push(paciente.nombreCompleto());
      pacientesObj.push(paciente);
      rellenarFormulario(paciente);
    });
  }

  //----EVENTOS DE BÚSQUEDA----
  /**Asignar evento para obtener datos de pacientes y configurar el autocompletado */
  $("#paciente").on("keyup", function (ev) {
    ev.preventDefault();
    obtenerDatosPacientes();
  });

  /**Buscar por dni */
  buscar.on("click", function (ev) {
    ev.preventDefault();
    obtenerDni();
  });

  //---------------------------------------------Notas médicas del paciente-----------------------------------------------

  /**Función para añadir una nota nueva una nota */
  function addNotas() {
    let contenido = notasNuevas.val();
    let nuevoItem = $("<li>").prop('id', 'ultimaNota').text(contenido);
    if (notasNuevas.children() == "") {
      let nuevoListado = $("<ul>");
      nuevoListado.append(nuevoItem);
      notasPrevias.append(nuevoListado);
    } else {
      notasPrevias.children('ul').append(nuevoItem);
    }
  }

  /**Función para editar una nota */
  function editarNota() {
    const notaTexto = $(this).siblings(".nota-texto");//evuelve todos los elementos que comparten el mismo padre que el elemento actual, excepto el propio elemento
    const nuevoContenido = prompt("Edita la nota:", notaTexto.text());
    const ultimaNota = $(this)[0].lastChild.lastChild;
    console.log(ultimaNota);
    if (nuevoContenido !== null) {
      ultimaNota.text(nuevoContenido);
    }
  }

  //Eventos para notas 
  $("#guardaNota").click(addNotas);
  notasPrevias.click(editarNota);

  /**Función para guardar la consuta */
  function guardaConsulta(event){
    
    event.preventDefault();

    //Datos del formulario
    const notaClinicas = $('#ultimaNota').text();
    const pacienteId = pacientesObj[0].id;
    const tConsulta = $("#tipoConsulta").val();
    const fecha = new Date();
    const datosConsulta = {
      "notas_clinicas": notaClinicas,
      "paciente_id":pacienteId,
      "tipo_id": Number(tConsulta),
      "fecha":fecha
    };

    // Mostrar un mensaje de progreso
    const mensajeProgreso = $('<div>').text('Guardando datos...').appendTo('body');


    //Medicación
    const medicamento = $("#medicamento").val();
    const posologia = $("#posologia").val();
    const suspension = $("#suspension").val();
    const motivo = $("#motivo").val();

    if(medicamento && posologia){
      datosMedicacion = {
        'fecha': new Date(),
        'medicamento':medicamento,
        'posologia':posologia,
        'suspension':suspension,
        'motivo':motivo,
        'paciente': pacienteId
      }

      $.ajax({
        url: 'https://localhost:8000/api/prescripcion',
        method: 'POST',
        contentType: "application/json",
        data:  JSON.stringify(datosMedicacion),
        dataType: "json",
        success: function (response) {
          const respuesta = {
            mensaje: 'Datos guardados con éxito.',
          };
          //Respuesta
          mostrarDialogo(respuesta.mensaje);
        },
        error: function (error) {
          console.error("Error en la solicitud AJAX", error);
          alert($('<span>').text('Error al enviar los datos.'));
        }
      });
    }

    // Realizamos la solicitud POST
    $.ajax({
      url: "https://localhost:8000/api/consulta",
      method: "POST",
      contentType: "application/json",
      data: JSON.stringify(datosConsulta),
      dataType: "json",
      beforeSend: function () {
        // Se ejecuta antes de enviar la solicitud
        mensajeProgreso.show();
      },
      success: function (respuesta) {
        console.log(respuesta);
        mensajeProgreso.hide();
        alert("Datos guardados con éxito.");
      },
      error: function (error) {
        console.error("Error en la solicitud AJAX", error);
        mensajeProgreso.hide();
        alert("Error al enviar los datos.");
      },
    });



  }

  btnGuardaConsulta.click(guardaConsulta);






});