Ext.define('myapp.store.seguridad.Cargos', {
    extend: 'Ext.data.Store',
    requires: ['myapp.model.seguridad.Cargos' ],
    model: 'myapp.model.seguridad.Cargos', // #2
    proxy: { 
        type:'ajax', 
        url: BASE_URL + 'seguridad/empleado/cargos',
        reader: { 
            type: 'json', 
            root: 'data'   
        }  
    },
    autoLoad: true
});