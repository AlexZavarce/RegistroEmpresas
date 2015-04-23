Ext.define('myapp.store.registrar.Estado',{
    extend: 'Ext.data.Store',
    autoLoad: true,

    fields: ['id', 'nombre'],
    data  : [
        {id: '11', nombre: 'Lara'}, 
        {id: '2', nombre: 'Sucre'}, 
        {id: '3', nombre: 'Zulia'}, 
        {id: '4', nombre: 'Monagas'}
    ]
    
});