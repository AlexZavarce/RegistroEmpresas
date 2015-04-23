Ext.define('myapp.model.busqueda.BuscarSocioFmiliar', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'idsociofamiliar'},
        {name: 'tipovivienda' , type: 'string'},
        {name: 'tenencia', type: 'string'},
        {name: 'necesidad', type: 'string'},
        {name: 'padrevivos', type: 'string'}, 
        {name: 'cuantosviven', type: 'string'},
        {name: 'cuantostrabajan', type: 'string'},
        {name: 'totalingresos', type: 'string'},
        {name: 'vivediscapacitado', type: 'string'}
    ]
});