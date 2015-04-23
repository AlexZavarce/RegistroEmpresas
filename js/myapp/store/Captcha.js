Ext.define('myapp.store.Captcha', {
	extend: 'Ext.data.Store',
	fields 	: {name:'image'},
	proxy: {
		type: 'ajax',
		url: BASE_URL+'login/login/captcha',
		actionMethods: {read: 'POST'},
		reader: {
			type: 'json',
			root: 'data',
			totalProperty: 'total',
			messageProperty: 'msg',
			successProperty: 'success'
		}
	},
});
  