Ext.define('myapp.store.Menu', {
	extend: 'Ext.data.Store',
	requires: [
		'myapp.model.menu.Root'
	],
	model: 'myapp.model.menu.Root',
	proxy: {
		type: 'ajax',
		url: BASE_URL + 'menu/menus',
		reader: {
			type: 'json',
			root: 'items'
		},
		listeners: {
            exception: function(proxy, response, operation){
                Ext.MessageBox.show({
                    title: 'REMOTE EXCEPTION',
                    msg: operation.getError(),
                    icon: Ext.MessageBox.ERROR,
                    buttons: Ext.Msg.OK
                });
          	}   
      	}
	}	
});