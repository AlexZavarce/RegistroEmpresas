Ext.define('myapp.store.vacaciones.Unidad', {
    extend: 'Ext.data.Store',
    requires: ['myapp.model.vacaciones.Unidad' ],
    model: 'myapp.model.vacaciones.Unidad', 
    proxy: { 
        type:'ajax', 
        url: BASE_URL + 'vacaciones/Solvacaciones/buscarunidad',
        reader: { 
            type: 'json', 
            root: 'data'   
        }  
    },
    autoLoad: true
});