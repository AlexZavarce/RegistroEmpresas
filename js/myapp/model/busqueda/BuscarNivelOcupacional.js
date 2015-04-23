 Ext.define('myapp.model.busqueda.BuscarNivelOcupacional', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'idnivelocupacional'},
        {name: 'idhabilidades'},
        {name: 'idoficio'},
        {name: 'habilidad',type:'int'},
        {name: 'poseeexp'},
        {name: 'describaexp'},
        {name: 'cmbtipoactividad',type:'int'}, 
        {name: 'idactividades'}, 
        {name: 'descripcionactividad'},
        {name: 'actividadprod',type:'int'},
        {name: 'condicionoficio'},
        {name: 'deseeooficio'},
        {name: 'tipooficio',type:'int'}
    ]
});