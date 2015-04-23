Ext.define('myapp.store.registrar.Sexo', {
    extend: 'Ext.data.Store',
    autoLoad: true,
    fields: ['id', 'nombre'],
    data: [
		{id:'0', nombre:'Masculino'},
		{id:'1', nombre:'Femenino'}
    ]
});