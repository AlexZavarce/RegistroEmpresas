Ext.define('myapp.view.seguridad.Empleado', { 
  extend: 'Ext.panel.Panel', 
  alias: 'widget.empleado',
  requires: [  
   'myapp.view.seguridad.Empleadolista'
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
      xtype: 'empleadolista',
    }]
  },    
  buildDockedItems : function(){
    return [{
    xtype: 'toolbar', 
    flex: 1, 
    dock: 'top', 
    items: [{ 
        xtype: 'button', 
        text: 'Nuevo', 
        name: 'agregar', 
        iconCls: 'useradd' 
      },{ 
        xtype: 'button', 
        text: 'Editar', 
        name: 'editar',
        iconCls: 'useredit'
      }]
    }]   
  }    
}); 
