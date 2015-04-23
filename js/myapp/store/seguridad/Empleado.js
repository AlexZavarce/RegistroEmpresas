Ext.define('myapp.store.seguridad.Empleado', {
    extend: 'Ext.data.Store',
    requires: ['myapp.model.seguridad.Empleado' ],
    model: 'myapp.model.seguridad.Empleado', // #2
    groupField: 'divisionnombre',
    proxy: { 
        type:'ajax', 
        url: BASE_URL + 'seguridad/empleado/buscarempleado',
        reader: { 
            type: 'json', 
            root: 'data'   
        }  
    },
    autoLoad: true
});