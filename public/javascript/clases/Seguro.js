class Seguro{

    constructor(id, nombre){
        this.id = id;
        this.nombre = nombre;
    }

    static getAllSeguros(callback) {
        $.getJSON('https://localhost:8000/api/seguro', function (data) {
            const segurosJSON = data.seguros;
            const segurosObjetos = segurosJSON.map(seguro => new Seguro(seguro.id, seguro.nombre));
            callback(segurosObjetos);
        });
    }

    static putSeguro( seguro ){
        
    }

    
}