Ext.define('myapp.store.reportes.Retardos', {
    extend: 'Ext.data.Store',
    autoLoad: true,
    fields: ['id', 'nombre'],
    data  : [
        {id: '1', nombre: 'Si'}, 
        {id: '2', nombre:'No'}, 
    ]
});