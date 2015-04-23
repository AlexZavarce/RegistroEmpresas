Ext.define('myapp.store.registrar.Parroquia', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.Parroquia',
    storeId: 'obtenerParroquia',
    autoLoad: true,
    proxy: {
        type: 'ajax',
        url:  BASE_URL + 'parroquia/obtenerParroquia',
        reader: {
            type: 'json',
            root: 'data'
        }
    }
});
