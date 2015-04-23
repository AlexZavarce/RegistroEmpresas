Ext.define('myapp.store.vacaciones.Emphisvac', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.vacaciones.Emphisvac',
    storeId: 'id',
    proxy: {
        type: 'ajax',
        url: BASE_URL + 'vacaciones/Historicovac/obtenerhisvac',
        reader: {
            type: 'json',
            root: 'data',
            idemp:'idemp'
        }
    }
});