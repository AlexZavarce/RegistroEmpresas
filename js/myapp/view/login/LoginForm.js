Ext.define('myapp.view.login.LoginForm', {
	extend 			: "Ext.form.Panel",
	alias			: "widget.loginform",
	//bodyPadding		: 10,
	border			: false,
	forward			: true,
	defaultType: 'textfield',
	initComponent:function(){
		this.items		= this.construirItems();
		this.buttons	= this.crearButtons();
		this.callParent();
	},
//**Funciones
	construirItems : function(){
		return [{
			xtype		: "form",
			frame : false,
			border:false,
			layout		: "hbox",
			defaultType : "textfield",
			width	: '100%',
			items:[
				{
					labelAlign	: "top",
					msgTarget	: 'side',
					fieldLabel	: 'Correo',
					name		: 'usuario',
					allowBlank	: false,
					flex		: 1,
					vtype 		: 'email',
					margins		: {right:3}
				}, {
					labelAlign	: "top",
					msgTarget	: 'side',
					fieldLabel	: 'Clave',
					name		: 'clave',
					inputType	: 'password',
					allowBlank	: false,
					flex		: 1,
					margins		: {left:3,bottom:20},
					listeners	: {
						scope		: this,
						specialkey	: function(f,e){
							if (e.getKey() == e.ENTER) {
								this.login();
							}
						}
					} //listeners
			}]
		}]
	},
	crearButtons	:function(){
		return [{
			text: 'Login',
			formBind: true,
			disabled: true,
			scope: this,
			handler: this.login
		},{
			xtype: 'box',
			autoEl: {tag: 'a', href: '#', html: 'Registrarme'},
			listeners: {
			    click: {
			        element: 'el', //bind to the underlying el property on the panel
			        fn: function(){
			        	var ventana = Ext.create('MyApp.modules.login.Registro');
			        	Ext.ComponentQuery.query('#winLogin')[0].hide();
			        	Ext.ComponentQuery.query('#notificacion')[0].hide();
			        	ventana.show();
			        }
			    }
			}
		}]
	}, //Fin de crearBoton
	login 		:function(){
		if(this.getForm().isValid()){
			var values = this.getForm().getValues();
			this.getForm().submit({
				waitMsg: 'Espere por favor',
				waitTitle: 'Enviando datos',
				url		: MyApp.Constants.APP_LOGIN_URL,
				params	: values,
				el		: this.up("window").el,
				scope	: this,
				success	: this.onSuccess,
				failure	: this.onFailure
			});
			Ext.ComponentQuery.query('#notificacion')[0].hide();
		}
	},
	onSuccess	: function(data,response){
		if(response.success){
			if(this.forward){
				document.location = MyApp.Constants.APP_HOME_URL;
			}else{
				var win = this.up("window");
				if(win){
					win.close();
				}
			}
		}
	},
	onFailure	: function(form, action){
		if (action.failureType === Ext.form.action.Action.CLIENT_INVALID) {
			Ext.Msg.alert('CLIENTE INVALIDO', 'Algo se ha perdido. Compruebe y vuelva a intentarlo.');
		}
		if (action.failureType === Ext.form.action.Action.CONNECT_FAILURE) {
			Ext.Msg.alert('MALA CONEXIÓN CON EL SERVIDOR', 'Status: ' + action.response.status + ': ' + action.response.statusText);
		}
		if (action.failureType === Ext.form.action.Action.SERVER_INVALID) {
			Ext.Msg.alert('CONEXIÓN RECHAZADA', action.result.message);
			var passwrd = this.down("textfield[name=clave]");
			passwrd.markInvalid(action.result.message);
		}

	}

});