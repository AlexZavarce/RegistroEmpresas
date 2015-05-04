Ext.define('myapp.store.empresa.VerempresaStore', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.empresa.Verempresagrid',
    // autoLoad: true,
    proxy: {
        type: 'ajax',
        url: BASE_URL + 'empresa/empresa/Obtenerverempresa',
        reader: {
            type: 'json',
            root: 'data'
        }
    }
});