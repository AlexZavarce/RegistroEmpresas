Ext.define('myapp.store.empresa.Division', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.empresa.Division',
    storeId: 'obtenerDivision',
    autoLoad: true,
    proxy: {
        type: 'ajax',
        url:BASE_URL + 'empresa/division/obtenerDivision',
        reader: {
            type: 'json',
            root: 'data'
        }
    }
});