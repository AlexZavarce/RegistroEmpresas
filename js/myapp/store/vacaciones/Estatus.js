Ext.define('myapp.store.vacaciones.Estatus', {
    extend: 'Ext.data.Store',
    autoLoad: true,
     fields: [ 'id','nombre'],
    data  : [
        { id:'1', nombre:'Procesada'}, 
        { id:'2',nombre:'Sin Procesar'}, 
        { id:'3',nombre:'Todas'}
    ]
    
});