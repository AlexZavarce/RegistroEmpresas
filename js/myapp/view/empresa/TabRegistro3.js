 Ext.define('myapp.view.empresa.TabRegistro3', {
    extend : 'Ext.form.Panel',
    alias: 'widget.tabregistro3',
    itemId: 'tabregistro3',
    autoScroll:true,
    requires: [
        'Ext.tab.Tab',
        'Ext.form.Panel',
        'Ext.form.FieldSet',
        'Ext.form.field.ComboBox',
        'Ext.form.field.Date',
        'Ext.form.RadioGroup',
        'Ext.form.field.Radio',
        
        'Ext.form.*',
        'myapp.util.Util',
    ],
    initComponent: function() {
        var me   = this;
        me.items = me.buildItems();
        me.callParent(arguments);
    },
    buildItems : function(){
        return [{
            xtype: 'container',
            layout: 'vbox',
            width:'100%',
            items: [{
                xtype: 'fieldset',
                flex: 3,
                title: 'Datos del Representante Legal',
                itemId:'ubicacion',
                items: [{
                xtype: 'container',
                layout: 'hbox',
                xtype: 'container',
                layout: 'hbox',
                items: [{
                    xtype: 'container',
                    layout: 'hbox',
                        items: [{
                            xtype: 'combobox',
                            editable: false,  
                            name: 'nacionalidadrep',
                            editable: false, 
                            fieldLabel: 'Cedula', 
                            labelWidth: 80,
                            width: 130,
                            value:'V',
                            margins:'10 5 5 0',
                            selecOnFocus: true,
                            store: Ext.create('myapp.store.Nacionalidad'),
                            valueField: 'nombre',
                            displayField: 'nombre', 
                            queryMode: 'local',
                            allowBlank: false, 
                        },{
                            xtype: 'textfield',
                            labelWidth: 200,
                            margins:'10 5 5 0',
                            maskRe: /[0-9]/,
                            name: 'cedularep',
                            width:110,
                            minLength:6,
                            maxLength:8,
                            allowBlank: false
                        }]
                    },{
                        xtype: 'textfield',
                        name: 'representante',
                        width:420,
                        margins:'0 0 2 5',
                        fieldLabel: 'Nombres',
                        labelWidth: 115,
                    },{
                        xtype       : 'fieldcontainer',
                        layout      : 'hbox',
                        items:[{
                        xtype       : 'combobox',
                        width       : 180,
                        fieldLabel  : 'Tlf. Celular',
                        margins     : '2 0 2 7',
                        labelWidth: 114,
                        name        : 'codmovilrep',
                        store       : Ext.create('myapp.store.registrar.TelefonoCelular'),
                        displayField:'codigo',
                        valueField  :'codigo',
                        editable    : false
                    },{
                        xtype       : 'textfield',
                        //flex        : 1,
                        //allowBlank:false,
                        width       : 235,
                        name        : 'movilrep',
                        margins     : '2 0 2 7',
                        minLength   : 7,
                        maxLength   : 7,
                        maskRe: /[0-9]/,
                    }]
                }],
                    
            },]
            },,{
                xtype: 'fieldset',
                flex: 2,
                type: 'hbox', 
                title: 'Datos del Contacto',
                items: [{
                    xtype: 'container',
                    layout: 'hbox',
                    items: [{
                    xtype: 'container',
                    layout: 'hbox',
                        items: [{
                            xtype: 'combobox',
                            editable: false,  
                            name: 'nacionalidadcont',
                            editable: false, 
                            fieldLabel: 'Cedula', 
                            labelWidth: 80,
                            width: 130,
                            value:'V',
                            margins:'10 5 5 0',
                            selecOnFocus: true,
                            store: Ext.create('myapp.store.Nacionalidad'),
                            valueField: 'nombre',
                            displayField: 'nombre', 
                            queryMode: 'local',
                            allowBlank: false, 
                        },{
                            xtype: 'textfield',
                            labelWidth: 200,
                            margins:'10 5 5 0',
                            maskRe: /[0-9]/,
                            name: 'cedulacont',
                            width:110,
                            minLength:6,
                            maxLength:8,
                            allowBlank: false
                        }]
                    },{
                        xtype: 'textfield',
                        name: 'nombrecont',
                        width:420,
                        margins     : '5 0 2 7',
                        fieldLabel: 'Nombres',
                        labelWidth: 115,
                    },{
                        xtype       : 'fieldcontainer',
                        layout      : 'hbox',
                        //margins     : '0 0 0 10',
                        //labelWidth: 80,
                        items:[{
                            xtype       : 'combobox',
                            width       : 180,
                            fieldLabel  : 'Tlf. Celular',
                            margins     : '2 0 2 7',
                            labelWidth: 114,
                            name        : 'codmovilcont',
                            store       : Ext.create('myapp.store.registrar.TelefonoCelular'),
                            displayField:'codigo',
                            valueField  :'codigo',
                            editable    : false
                        },{
                            xtype       : 'textfield',
                            //flex        : 1,
                            //allowBlank:false,
                            width       : 235,
                            name        : 'movilcont',
                            margins     : '2 0 2 7',
                            minLength   : 7,
                            maxLength   : 7,
                            maskRe: /[0-9]/,
                        }]
                    }],
                }]
            
            }]
        }]
    }
   
});