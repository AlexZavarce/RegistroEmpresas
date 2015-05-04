Ext.define('myapp.store.empresa.Verempresagrid', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.empresa.Verempresagrid',
     autoLoad: true,
    proxy: {
        type: 'ajax',
        url: BASE_URL + 'empresa/empresa/Obtenerempresagrid',
        reader: {
            type: 'json',
            root: 'data'
        }
    }
});