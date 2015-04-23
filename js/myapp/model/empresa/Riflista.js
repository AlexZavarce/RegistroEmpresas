Ext.define('myapp.model.empresa.Riflista', { 
   extend: 'Ext.data.Model',
    idProperty: 'id',
    fields: [    
        { name: 'id' }, 
        { name: 'cedula' },
        { name: 'nacionalidad'},
        { name: 'correo' },
        { name: 'status' },
        { name: 'rif'}
    ] 
});