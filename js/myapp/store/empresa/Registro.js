Ext.define('myapp.store.empresa.Registro', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.empresa.Registro',
    autoLoad: true,
    proxy: {
        type: 'ajax',
        url: BASE_URL + 'empresa/empresa/Registro',
        reader: {
            type: 'json',
            root: 'data'
        }
    }
});