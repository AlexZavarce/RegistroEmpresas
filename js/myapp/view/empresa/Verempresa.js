Ext.define('myapp.view.empresa.Verempresa', {
extend: 'Ext.window.Window',
  alias: 'widget.verempresa',
  itemId: 'verempresa',
  height: 450,
  width: 600,
  modal:true,
  requires: [
   'myapp.view.empresa.Verempresagrid'
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
      xtype: 'verempresagrid',
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