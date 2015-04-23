Ext.define('myapp.store.reportes.Unidad', {
    extend: 'Ext.data.Store',
    requires: ['myapp.model.reportes.Unidad' ],
    model: 'myapp.model.reportes.Unidad', 
    proxy: { 
        type:'ajax', 
        url: BASE_URL + 'reportes/criterios/buscarunidad',
        reader: { 
            type: 'json', 
            root: 'data'   
        }  
    },
    autoLoad: true
});