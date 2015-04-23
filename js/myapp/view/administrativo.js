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
		//'myapp.controller.Menu',
		'myapp.controller.seguridad.Contrasena',
		'myapp.controller.login.Login','myapp.controller.login.Registrarme'
	],
	requires:[
		'myapp.view.login.Login',
		'myapp.controller.login.Login',
		'myapp.vtypes.Validadores'
	]
});
Ext.onReady(function(){
	var MyViewPrincipal = Ext.create("myapp.view.login.Login");
	MyViewPrincipal.show();
});