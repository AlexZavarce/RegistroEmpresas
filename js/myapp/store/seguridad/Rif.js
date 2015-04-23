Ext.define('myapp.store.seguridad.Rif', {
    extend: 'Ext.data.Store',
    autoLoad: true,
	fields: ['id', 'nombre'],
    data  : [
        {id: '1', nombre: 'V'},
        {id: '2', nombre: 'E'},
        {id: '3', nombre: 'J'},
        {id: '4', nombre: 'G'}
    ]
});