Ext.define('myapp.view.seguridad.RegistroDiaFeriado', {
 extend: 'Ext.panel.Panel',
  alias: 'widget.registrodiaferiado',
  itemId: 'registrodiaferiado',
  height: 360,
  width: 655,
  modal:true,
  requires: [
   'myapp.view.seguridad.Griddiaferiado'
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
      xtype: 'griddiaferiado',
    }]
  },
  buildDockedItems : function(){
    return [{
      xtype : 'toolbar',
      flex  : 1,
      dock  : 'top',
      items: [{
        xtype   :'label',
        text:'Año'
      },{
        xtype   :'label',
        text: new Date(),
        name: 'fecha2',
        value: (new Date(),'h:i:s A'), //Valor por defecto
        format: 'Y', //Formato de la fecha,{
        listeners : {
          render :function() {
            this.setText(Ext.Date.format(new Date(),'Y')); 
          }
        }
      },{
        xtype   : 'button',
        iconCls : 'icon-responsable',
        tooltip : 'adicionar',
        id      :'add',
        scope   : this,
      }]
    }] 
  }
});