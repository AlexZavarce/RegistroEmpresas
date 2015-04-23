Ext.define('myapp.store.reportes.Tiponomina', {
    extend: 'Ext.data.Store',
    requires: ['myapp.model.reportes.Tiponomina' ],
    model: 'myapp.model.reportes.Tiponomina', 
    proxy: { 
        type:'ajax', 
        url: BASE_URL + 'reportes/criterios/buscarnomina',
        reader: { 
            type: 'json', 
            root: 'data'   
        }  
    },
    autoLoad: true
});