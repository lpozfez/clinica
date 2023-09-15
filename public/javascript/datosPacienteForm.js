$(document).ready(function(){
    var ruta="https://localhost:8000/api/";
    //Traemos los datos
    const ap1=$("#ap1");
    const resultado=$("#resultadoBusqueda");
    
    if(ap1!=null){
        buscarPacientes();
    }
    /*
    ap1.on(function(){
        buscarPacientes();
    });*/

    //Función para que cuando se selecciona un paciente se añadan sus datos a al formulario
    resultado.on('input', function(){

    });

    //Función para traer los pacientes
    function buscarPacientes(){
        //debugger
        //Hacemos llamada a api
        //ev.preventDefault();
        //ap1.empty();
        $.getJSON(ruta+"paciente", function (data) {
            $.each(data, function(i, v){
                var opcion=$("<option>").val(data[0][i].id).text(data[0][i].ap1+' '+data[0][i].ap2+' ,'+data[0][i].nombre).attr("id", "option-"+i).appendTo(resultado);
                opcion[0].objPaciente=data[0][i];
                //console.log(li);
            });
        });

        //Filtramos y devolvemos los datos
    }
});