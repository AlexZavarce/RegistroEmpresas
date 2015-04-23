Ext.define('myapp.store.registrar.Municipio', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.Municipio',
    storeId: 'obtenerMunicipio',
    autoLoad: true,
    proxy: {
        type: 'ajax',
        url:BASE_URL + 'municipio/obtenerMunicipio',
        reader: {
            type: 'json',
            root: 'data'
        }
    }
});
