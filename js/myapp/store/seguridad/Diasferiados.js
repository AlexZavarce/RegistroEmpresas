Ext.define('myapp.store.seguridad.Diasferiados', {
    extend: 'Ext.data.Store',
    requires: ['myapp.model.seguridad.Diasferiados' ],
    model: 'myapp.model.seguridad.Diasferiados', // #2
    proxy: { 
        type:'ajax', 
        url: BASE_URL + 'seguridad/diasferiados/obtenerdiasferiados',
        reader: { 
            type: 'json', 
            root: 'data'   
        }  
    },
    autoLoad: true
});