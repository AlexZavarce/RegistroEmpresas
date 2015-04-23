Ext.define('myapp.store.empresa.tipo',{
	extend: 'Ext.data.Store',
    autoLoad: true,
    fields: ['id', 'nombre'],
    data  : [
        {id: '0', nombre: 'Servicio'}, 
        {id: '1', nombre:'Producción'}, 
        {id: '2', nombre:'Ambos'},
    ]
    
});