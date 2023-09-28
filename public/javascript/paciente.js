//Clase Paciente
function Paciente(id,nombre,ap1,ap2,dni, foto=null,user,seguro=null, dataObj=null){
    this.id=id;
    this.nombre=nombre;
    this.ap1=ap1;
    this.ap2=ap2;
    this.dni=dni;
    this.foto=foto;
    this.user=user;
    this.seguro=seguro;
    this.dataObj=dataObj;
}

Paciente.prototype.nombreCompleto=function(){
    return this.ap1+" "+this.ap2+", "+this.nombre;
}

