Ext.define('myapp.view.seguridad.Gridempext', {
extend: 'Ext.window.Window',
  alias: 'widget.gridempext',
  itemId: 'gridempext',
  height: 360,
  width: 655,
  modal:true,
  requires: [
   'myapp.view.seguridad.Gridbuscarempext'
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
      xtype: 'gridbuscarempext',
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