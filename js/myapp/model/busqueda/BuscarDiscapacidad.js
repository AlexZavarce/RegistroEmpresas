Ext.define('myapp.model.busqueda.BuscarDiscapacidad', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'idnivelapoyo'},
        {name: 'iddiscapacidad'},
        {name: 'cmbtipod', type:'int'},
        {name: 'descripciond', type: 'string'},
        {name: 'cmbapoyo' , type: 'int'},
        {name: 'txtnbrecompletoinst', type: 'string'},
        {name: 'cmbtipoayuya', type: 'int'}, 
    ]
});