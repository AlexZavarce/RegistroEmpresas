Ext.define('myapp.model.busqueda.BuscarResponsable', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'txtnombre', type:'string'},{name: 'txtapellido',type:'string'},
        {name: 'txtfdireccionsocio',type:'text'},{name: 'vivediscapacitado',type:'string'}
    ]
});