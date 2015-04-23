Ext.define('myapp.store.vacaciones.Gridregperiodo', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.vacaciones.Vacperiodo',
    storeId: 'id',
    proxy: {
        type: 'ajax',
        url: BASE_URL + 'vacaciones/Vacperiodo/obtenergridregperiodo',
        reader: {
            type: 'json',
            root: 'data',
            idemp:'idemp'
        }
    }
});