Ext.define('myapp.model.Municipio', {
    extend: 'Ext.data.Model',
    idProperty:'id',
    fields: [
        { name: 'id', type:'int'},
        { name: 'nombre', type:'string'}
    ]
});