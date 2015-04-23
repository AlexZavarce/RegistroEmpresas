Ext.define('myapp.store.empresa.Seccion', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.empresa.Seccion',
    storeId: 'obtenerSeccion',
    autoLoad: true,
    proxy: {
        type: 'ajax',
        url:BASE_URL + 'empresa/seccion/obtenerSeccion',
        reader: {
            type: 'json',
            root: 'data'
        }
    }
});
