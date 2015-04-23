Ext.define('myapp.store.vacaciones.SolicitudprocesadaGrid', {
    extend: 'Ext.data.Store',
    autoLoad: true,
    groupField: 'division',
    model: 'myapp.model.vacaciones.SolicitudprocesadaGrid',
    pageSize: 15,
    proxy: { 
        type:'ajax', 
        url: BASE_URL + 'vacaciones/Solvacaciones/obtenersolicitudprocesada',
        reader: {
            type:'json', 
            root: 'data',
        }
    },
    
});