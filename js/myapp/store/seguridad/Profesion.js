Ext.define('myapp.store.seguridad.Profesion', {
    extend: 'Ext.data.Store',
    autoLoad: true,
	fields: ['id', 'nombre'],
    data  : [
        {id: '0', nombre: 'Ninguno'},
        {id: '1', nombre: 'Primaria'},
        {id: '2', nombre: 'Bachiller'},
        {id: '3', nombre: 'Técnico superior'},
        {id: '4', nombre: 'Universitario'},
        {id: '5', nombre: 'Ingeniero'},
        {id: '6', nombre: 'Licenciado'},
        {id: '7', nombre: 'Contador'},
        {id: '8', nombre: 'Otro'},
    ]
});