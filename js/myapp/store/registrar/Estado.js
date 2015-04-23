Ext.define('myapp.store.registrar.Estado',{
    extend: 'Ext.data.Store',
    autoLoad: true,

    fields: ['id', 'nombre'],
    data  : [
        {id: '11', nombre: 'Lara'}, 
    ]
    
});