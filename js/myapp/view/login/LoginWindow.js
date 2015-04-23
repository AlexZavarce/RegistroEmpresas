Ext.define("MyApp.view.login.LoginWindow",{
	extend 		: "Ext.window.Window",
	requires	: ["MyApp.modules.login.LoginForm"],
	//modal		: true, //Fondo GRis
	draggable 	: false,
	resizable	: true,
	bodyPadding	: 10,
	//layout		: "auto",
	width		: 450,
	height		: 310,
	closable	: false,
	forward		: false,
	itemId 		: 'winLogin',

	initComponent: function() {
		this.items = this.buildItems();
		this.callParent();
	},

	buildItems	: function(){
		return [{
			xtype:'component',
			cls: 'titulo',
			html:'<center>Taller "Redes Sociales y Marketing Político"</center>'
			
		},{
			xtype:'component',
			html:'<center><img src="'+MyApp.Constants.LOGIN_IMAGE+'" /></center>'
		},
			Ext.create("MyApp.modules.login.LoginForm")
		];
	}
});