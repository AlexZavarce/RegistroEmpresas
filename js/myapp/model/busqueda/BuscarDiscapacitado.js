Ext.define('myapp.model.busqueda.BuscarDiscapacitado', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'iddiscapacitado'},
        {name: 'poseeinforme' , type: 'tinyint'},
        {name: 'poseepartida', type: 'string'},
        {name:'cmbmunicipio',type:'int'},
        {name: 'utilizamedicamento', type: 'tinyint'},
        {name: 'nombremedicamento', type: 'string'},
        {name: 'requiereayuda', type: 'string'},
        {name: 'institucion', type: 'int'},
        {name: 'cmbparroquia', type: 'int'},
        {name: 'condicion', type: 'string'},
        {name: 'idcomunidad'},
        {name: 'consejo' , type: 'tinyint'},
        {name: 'comite', type: 'tinyint'},
        {name: 'nombreconsejo', type: 'int'},
        {name: 'cmbnombrecomite', type: 'int'}
    ]
});