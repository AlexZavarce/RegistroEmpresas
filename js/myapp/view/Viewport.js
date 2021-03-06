Ext.define('myapp.view.Viewport', {
  extend: 'Ext.container.Viewport',
  alias: 'widget.mainviewport',
  requires:[
    'myapp.view.Header',
    'myapp.view.menu.Accordion',
    'myapp.view.menu.MainPanel',
  ],
  store: Ext.create('myapp.store.Session'),
  layout: {type: 'border'  },
  initComponent : function(){
    var me = this;
    me.items = me.buildItem();
    me.callParent();
  },
  buildItem : function(){
    return [{
      xtype: 'mainmenu',
      width: '15%',
      collapsible: true,
      region: 'west',
      'text':'Base',
    },{
      xtype: 'appheader',
      width: '100%',
      height: '15%',  
      region: 'north'
    },{
      xtype: 'mainpanel',
      width: '100%',
      height: '100%',
      region: 'center',
      bodyCls:'degradado',
      bodyStyle: "background­color:#999999;", 
    },{
      xtype: 'container',
      region: 'south',
      height: '3%',
      style: 'border-top: 1px solid #4c72a4;',
      html: '<div id="titleHeader"><center><span style="font-size:10px;">Oficina de Informática-División de Desarrollo de Sistemas </span></center></div>'
    }]
  }
});

