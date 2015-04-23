Ext.define('myapp.model.Parroquia', {
    extend: 'Ext.data.Model',
     idProperty: 'id',
    fields: [
        { name: 'id', type:'int' },
        { name: 'nombre', type:'string'}
    ]
});