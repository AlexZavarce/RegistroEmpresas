Ext.define('myapp.store.vacaciones.EmppermisoVacGrid', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.vacaciones.EmppermisoVacGrid',
    storeId: 'id',
    autoLoad: true,
    groupField: 'division',
    proxy: {
        type: 'ajax',
        url: BASE_URL + 'vacaciones/Solvacaciones/obtenerEmppermisoVacGrid',
        reader: {
            type: 'json',
            root: 'data',
            idemp:'idemp'
        }
    }
});
