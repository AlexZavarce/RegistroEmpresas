Ext.define('myapp.store.formatoReporte', {
    extend: 'Ext.data.Store',
    autoLoad: true,
    fields: ['id', 'nombre'],
    data: [
        {id: '1', nombre: 'PDF'},
        {id: '2', nombre: 'EXCEL'}
    ]
});