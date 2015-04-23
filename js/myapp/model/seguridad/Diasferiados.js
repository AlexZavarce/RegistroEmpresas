Ext.define('myapp.model.seguridad.Diasferiados', {
    extend: 'Ext.data.Model',
    idProperty: 'id',
    fields: [
        { name: 'id' },
        { name: 'fecha',type: 'date', dateFormat: 'Y-m-d'},
         { name: 'descripcion' }
    ]
});