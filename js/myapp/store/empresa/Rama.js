Ext.define('myapp.store.empresa.Rama', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.empresa.Rama',
    storeId: 'obtenerRama',
    autoLoad: true,
    proxy: {
        type: 'ajax',
        url:BASE_URL + 'empresa/rama/obtenerRama',
        reader: {
            type: 'json',
            root: 'data'
        }
    }
});