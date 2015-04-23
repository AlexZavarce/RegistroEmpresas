 Ext.define('myapp.model.busqueda.BuscarNivelAcademico', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'idnivelacademico'},
        {name: 'cmbgrado' ,type: 'string'},
        {name: 'condicionestudio',type: 'string'},
        {name: 'cmblimitacion', type:'int'},
        {name: 'deseeoestudio',type: 'string'}
    ]
});