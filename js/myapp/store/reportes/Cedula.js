Ext.define('myapp.store.reportes.Cedula', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.reportes.Cedula',
    storeId: 'cedula',
    autoLoad: true,
    autoSync: true,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        url: BASE_URL + 'reportes/criterios/cedula',
        reader: {
            type: 'json',
            root: 'data'
        }
    }
});