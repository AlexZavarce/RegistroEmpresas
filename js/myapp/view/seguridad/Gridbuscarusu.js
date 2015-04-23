Ext.define('myapp.view.seguridad.Gridbuscarusu', {
extend: 'Ext.window.Window',
  alias: 'widget.gridbuscarusu',
  itemId: 'gridbuscarusu',
  height: 360,
  width: 655,
  modal:true,
  requires: [
   'myapp.view.seguridad.Gridbuscarempusu'
  ],
  layout: {
   	type: 'fit'
  },
  initComponent: function() {
    var me = this;
    me.items = me.buildItem();
    me.dockedItems = me.buildDockedItems();
    me.callParent();
  },
  buildItem : function(){
    return [{
      xtype: 'gridbuscarempusu',
    }]
  },
  buildDockedItems : function(){
    return [{
      xtype : 'toolbar',
      flex  : 1,
      dock  : 'top',
      items: []
    }]
  }
});