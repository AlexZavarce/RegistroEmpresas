var itemsPerPage = 10;
Ext.define('myapp.store.vacaciones.EmpleadosGridvac', {
    extend: 'Ext.data.Store',
    groupField: 'division',
    storeId: 'id',
    pageSize: itemsPerPage,
    model: 'myapp.model.vacaciones.EmpleadosGridvac',
    proxy: { 
        type:'ajax', 
        url: BASE_URL + 'vacaciones/Historicovac/obtenerEmpleadosGridvac',
        reader: {
            type:'json', 
            root: 'data'
        }
    },
   autoLoad: true
});