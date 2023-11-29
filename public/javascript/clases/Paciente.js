//Clase Paciente
class Paciente {
    constructor(id, nombre, apellido1, apellido2, dni, foto = null, user, seguro = null, dataObj = null) {
        this.id = id;
        this.nombre = nombre;
        this.apellido1 = apellido1;
        this.apellido2 = apellido2;
        this.dni = dni;
        this.foto = foto;
        this.user = user;
        this.seguro = seguro;
        this.dataObj = dataObj;
    }
}

Paciente.prototype.nombreCompleto=function(){
    return this.ap1+" "+this.ap2+", "+this.nombre;
}

