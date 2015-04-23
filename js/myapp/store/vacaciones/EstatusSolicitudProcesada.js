Ext.define('myapp.store.vacaciones.EstatusSolicitudProcesada', {
    extend: 'Ext.data.Store',
    autoLoad: true,
     fields: ['nombre'],
    data  : [
        { nombre:'Procesada'}, 
        { nombre:'Sin procesar'}, 
        { nombre:'Todas'}
    ]
    
});