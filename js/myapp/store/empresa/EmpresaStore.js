Ext.define('myapp.store.empresa.EmpresaStore', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.empresa.EmpresaStore',
   // autoLoad: true,
    proxy: {
        type: 'ajax',
        url: BASE_URL + 'empresa/empresa/obtenerEmpresa',
        reader: {
            type: 'json',
            root: 'data'
        }
    }
});