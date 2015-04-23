Ext.define('myapp.store.reportes.Meses', {
    extend: 'Ext.data.Store',
    autoLoad: true,
    fields: ['id', 'nombre'],
    data  : [
        {id: '01', nombre: 'Enero'}, 
        {id: '02', nombre:'Febrero'},
        {id: '03', nombre:'Marzo'},
        {id: '04', nombre:'Abril'},
        {id: '05', nombre:'Mayo'},
        {id: '06', nombre:'Junio'},
        {id: '07', nombre:'Julio'},
        {id: '08', nombre:'Agosto'},
        {id: '09', nombre:'Septiembre'},
        {id: '10', nombre:'Octubre'},
        {id: '11', nombre:'Noviembre'},
        {id: '12', nombre:'Diciembre'},
    ]
});