Ext.define('myapp.view.reportes.Reporte', {
    extend: 'Ext.window.Window',
    alias: 'widget.reporte',
    autoShow: true,
    //height: 450,
    width: 390,
    modal:true,
    title: 'Cambio de password',
   layout: {
        align: 'center',
        type: 'vbox'
    },
    initComponent: function() {
    var me = this;
    me.items = me.buildItem();
    me.callParent();
    },
    buildItem : function(){
        return [{ 
            items: [{    
                xtype: 'form',
                bodyPadding: 10,
                width: 380, 
                items: [{
                    xtype: 'textfield',
                    width: 250,
                    aling:'center',
                     margins:'0 2 20 0',
                    fieldLabel: 'Nombre',
                    name:'textnombre',
                    labelWidth: 50
                    },{
                    xtype: 'textfield',
                    width: 250,
                    aling:'center',
                     margins:'0 2 20 0',
                    fieldLabel: 'Apellido',
                    name:'textapellido',
                    labelWidth: 50
                    },{
                    xtype: 'combobox',
                    width: 200,
                    fieldLabel: 'Edo.Civil',
                    name:'cmbedocivil',
                    editable:false,
                    margins:'0 2 20 0',
                    forceSelection: true,
                    emptyText:' ',
                    store :Ext.create('myapp.store.registrar.Edocivil'),
                    valueField: 'id',
                    displayField: 'nombre',
                    queryMode: 'local',
                    triggerAction: 'all',           
                    labelWidth: 50
                },],
                dockedItems: [{
                xtype: 'toolbar',
                dock: 'bottom',
                ui: 'footer',
                items: [{
                   xtype: 'tbfill'
                    },{
                    xtype: 'button', 
                    itemId: 'generar',
                    iconCls: 'generar',        
                    text: "Generar reporte"
                    },{
                    xtype: 'button',
                    text: 'Limpiar',
                    iconCls:'limpiar',
                    tooltip: 'Limpiar',
                    itemId: 'limpiar',
                    }
                ]
            }]
        }]  }]
    }
});
