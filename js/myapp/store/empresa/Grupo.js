Ext.define('myapp.store.empresa.Grupo', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.empresa.Grupo',
    storeId: 'obtenerGrupo',
    autoLoad: true,
    proxy: {
        type: 'ajax',
        url:BASE_URL + 'empresa/grupo/obtenerGrupo',
        reader: {
            type: 'json',
            root: 'data'
        }
    }
});