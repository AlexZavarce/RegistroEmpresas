Ext.Loader.setConfig({
  enabled : true,
  paths : {
    myapp : BASE_PATH+"js/myapp" ,
  }
});
Ext.application({
  name    : "myapp",
  appFolder   : BASE_PATH+"js/myapp",
  controllers : [
    'myapp.controller.Menu',
    'myapp.controller.registro.Asistencia',
    'myapp.controller.registro.Retiro',
  ],
  requires:[
    'myapp.view.registro.AsistenciaWin',
    'myapp.vtypes.Validadores'
  ]
});
Ext.onReady(function(){
  var MyViewPrincipal = Ext.create("myapp.view.registro.AsistenciaWin");
      MyViewPrincipal.show();
});
