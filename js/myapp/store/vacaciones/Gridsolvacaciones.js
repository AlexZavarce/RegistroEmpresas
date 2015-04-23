Ext.define('myapp.store.vacaciones.Gridsolvacaciones', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.vacaciones.Gridsolvacaciones',
    proxy: {
        type: 'ajax',
        url: BASE_URL + 'vacaciones/Solvacaciones/obtenergridsolvacaciones',
        reader: {
            type: 'json',
            root: 'data',
            idemp:'idemp'
        }
    }
});