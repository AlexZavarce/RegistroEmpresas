Ext.define('myapp.store.empresa.Clase', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.empresa.Clase',
    storeId: 'obtenerClase',
    autoLoad: true,
    proxy: {
        type: 'ajax',
        url:BASE_URL + 'empresa/clase/obtenerClase',
        reader: {
            type: 'json',
            root: 'data'
        }
    }
});