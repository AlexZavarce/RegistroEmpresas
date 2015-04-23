Ext.define('myapp.model.busqueda.BuscarPersonaSocio', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'txtcedula', type:'int'},{name: 'cmbnacionalidadsocio',type:'char'},
        {name: 'txtnombre', type:'string'},{name: 'txtapellido',type:'string'},
        {name: 'txtfdireccionsocio',type:'text'},{name: 'vivediscapacitado',type:'string'}
    ]
});