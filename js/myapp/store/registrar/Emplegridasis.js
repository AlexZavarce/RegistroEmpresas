var itemsPerPage = 10;
Ext.define('myapp.store.registrar.Emplegridasis', {
    extend: 'Ext.data.Store',
    groupField: 'division',
    storeId: 'id',
    pageSize: itemsPerPage,
    model: 'myapp.model.registrar.Emplegridasis',
    proxy: { 
        type:'ajax', 
        url: BASE_URL + 'registro/asistenciamanual/obtenerEmplegridasis',
        reader: {
            type:'json', 
            root: 'data'
        }
    },
   autoLoad: true
});