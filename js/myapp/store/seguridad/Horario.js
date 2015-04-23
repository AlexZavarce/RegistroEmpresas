Ext.define('myapp.store.seguridad.Horario', {
    extend: 'Ext.data.Store',
    requires: ['myapp.model.seguridad.Horario' ],
    model: 'myapp.model.seguridad.Horario', // #2
    proxy: { 
        type:'ajax', 
        url: BASE_URL + 'seguridad/empleado/horario',
        reader: { 
            type: 'json', 
            root: 'data'   
        }  
    },
    autoLoad: true
});