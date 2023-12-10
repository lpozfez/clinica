$(function(){
    const pacientesEnTabla = [];

    //Traemos los pacientes mediante ajax
    $.getJSON("https://localhost:8000/api/paciente", function (data) {
        $.each(data["pacientes"], function (i, v) {
            //Creamos la fila
            let row = $("<tr>")
            .val(data["pacientes"][i].id)
            .attr("id", "paciente-" + i);
            
            //Añadimos los datos que queremos
            let nombre = $("<td>").text(data["pacientes"][i].ap1+' '+data["pacientes"][i].ap2+' '+data["pacientes"][i].nombre).appendTo(row);
            let dni = $("<td>").text(data["pacientes"][i].dni).appendTo(row);
            let seguro = $("<td>").text(data["pacientes"][i].seguro.nombre).appendTo(row);

            pacientesEnTabla.push(data["pacientes"][i]);

            //Editar
            let btnEditar = $("<button>")
            .addClass("btn btn-outline-primary")
            .html('<img class="c-icono" src="/imagenes/iconos/editar.svg">')
            .on("click", function() {
                // Lógica para editar
                console.log("Editar", data["pacientes"][i]);
                editaPaciente(data["pacientes"][i].id);
            })
            .appendTo(row);

            //Borrar
            let btnBorrar = $("<button>")
            .addClass("btn btn-outline-danger")
            .html('<img class="c-icono"  src="/imagenes/iconos/basura.svg">')
            .on("click", function() {
                // Lógica para borrar
                console.log("Borrar", data["pacientes"][i]);
            })
            .appendTo(row);
    
            //Añadimos la fila a la tabla
            row.appendTo($('#tBodyPacientes'));
                
        });


    });


    /**Función para editar pacientes */
    function editaPaciente( idPaciente ){
        const usuarioParaEditar = pacientesEnTabla.find(p => p.id === idPaciente);

        //Rellenamos un formulario con los datos del usuario para editar
        $('#formNombre').val(usuarioParaEditar.nombre);
        $('#formDni').val(usuarioParaEditar.dni);
        $('#formap1').val(usuarioParaEditar.ap1);
        $('#formap2').val(usuarioParaEditar.ap2);
        $('#formtarjeta').val(usuarioParaEditar.tarjeta);

        Seguro.getAllSeguros(function (seguros) {
            $('#formSeguro').empty();
            console.log(seguros);
            seguros.forEach(seguro => {
                let op = $('<option>').attr('id', 'opSeguro-'+seguro.id).text(seguro.nombre).appendTo($('#formSeguro'));
                if(usuarioParaEditar.seguro.id === seguro.id){
                    op.prop('selected', true);
                }
            });
        });

        

        // Mostramos el modal de edición
        $('#modalEdicion').modal('show');
    }

});