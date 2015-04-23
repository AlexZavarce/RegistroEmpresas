Ext.define('myapp.store.reportes.Formatorep', {
    extend: 'Ext.data.Store',
    autoLoad: true,
    fields: [ 'nombre'],
    data  : [
        { nombre: 'excel'}, 
        { nombre:'pdf'}, 
    ]
});