Ext.define('myapp.store.empresa.Riflista', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.empresa.Riflista',
    autoLoad: true,
    proxy: {
        type: 'ajax',
        url: BASE_URL + 'empresa/empresa/Riflista',
        reader: {
            type: 'json',
            root: 'data'
        }
    }
});