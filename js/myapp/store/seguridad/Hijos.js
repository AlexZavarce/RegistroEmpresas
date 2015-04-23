Ext.define('myapp.store.seguridad.Hijos',{
	extend: 'Ext.data.Store',
    autoLoad: true,
    fields: ['id', 'nombre'],
    data  : [
        {id: '1', nombre: 'Si'}, 
        {id: '0', nombre:'No'}
    ]
});