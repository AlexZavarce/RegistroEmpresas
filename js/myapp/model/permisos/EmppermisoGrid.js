Ext.define('myapp.model.permisos.EmppermisoGrid', { 
   extend: 'Ext.data.Model',
    idProperty: 'id',
    fields: [
        { name: 'id'},
        { name: 'foto'},
        { name: 'idemp'},
        { name: 'nacionalidad'},
        { name: 'cedula'}, 
        { name: 'nombres'},
        { name: 'tiposolicitud'},
        { name: 'cmbtiposolicitud'},
        { name: 'fecha'},
        { name: 'fechadesde'},
        { name: 'fechahasta'},
        { name: 'nrodia'},
        { name: 'salida'},
        { name: 'entrada'}, 
        { name: 'lugar'},  
        { name: 'motivo'},
        { name: 'tipopermiso'},
        { name: 'tipoperm'},
        { name: 'fechaentrada'},
        { name: 'fechasalida'},
        { name: 'status'},
        { name: 'statuscord'},
        { name: 'division'},
        { name: 'observacion',type:'string'},
        { name: 'tipo',type:'int'},
    ] 
});