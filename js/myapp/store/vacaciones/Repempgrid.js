Ext.define('myapp.store.vacaciones.Repempgrid', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.vacaciones.Repempgrid',
    storeId: 'id',
    autoLoad: true,
    groupField: 'division',
    proxy: {
        type: 'ajax',
        url: BASE_URL + 'reportes/Reportepersonalvacaciones/obtenerEmpleadosGrid',
        reader: {
            type: 'json',
            root: 'data',
            idemp:'idemp'
        }
    }
});