Ext.Loader.setConfig({enabled: true});
Ext.Loader.setPath('Ext.ux', '../../js/ext/examples/ux');
Ext.application({
	name		: "myapp",
	appFolder 	: BASE_PATH+"js/myapp",
	controllers	: [
		'myapp.controller.Menu',
		'myapp.controller.login.Login',
		'myapp.controller.empresa.RegistroEmpresa',
		//'myapp.controller.registro.Retiro',
		
		//'myapp.controller.empresa.TabOficioController',
		//'myapp.controller.empresa.TabActoAdministrativoController',
		//'myapp.controller.registrar.TabSolicitudAyudaController'
		//'myapp.controller.permisos.Permisos'
	],
	requires:    [
		
		'myapp.vtypes.Validadores'
	],
	launch		: function(){
		Ext.create('myapp.vtypes.Validadores').init();
		var win = Ext.create("myapp.view.Viewport1")
	}
});
