Ext.define('myapp.store.registrar.Edocivil',{
	extend: 'Ext.data.Store',
    autoLoad: true,

    fields: ['id', 'nombre'],
    data  : [
        {id: '0', nombre: 'Soltero(a)'}, 
        {id: '1', nombre:'Casado(a)'}, 
        {id: '2', nombre:'Viudo(a)'},
        {id: '3', nombre:'Divorciado(a)'}
    ]
    
});