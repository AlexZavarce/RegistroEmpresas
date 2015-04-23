 Ext.define('myapp.model.busqueda.BuscarPersona', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'nombres', type:'string'},
        {name: 'apellidos', type:'string'},
        {name: 'edocivil', type:'string'},
        {name: 'fecha'}, 
        {name: 'sexo', type:'string'},
        {name: 'cmbcelular', type:'string'},
        {name: 'TelefonoCelular', type:'string'},
        {name: 'cmbfijo', type:'string'},
        {name: 'TelefonoFijo', type:'string'},
        {name: 'txtfdireccion', type:'string'},
        {name: 'status', type:'tinyint'}
    ]
});