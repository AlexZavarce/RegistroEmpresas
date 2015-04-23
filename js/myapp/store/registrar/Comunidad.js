Ext.define('myapp.store.registrar.Comunidad', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.Comunidad',
    storeId: 'obtenerComunidad',
    autoLoad: true,
    proxy: {
        type: 'ajax',
        url:  BASE_URL + 'parroquia/obtenerComunidad',
        reader: {
            type: 'json',
            root: 'data'
        }
    }
});
