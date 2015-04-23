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
                            xtype: 'textfield',
                            name: 'cedula',
                            width:270,
                            fieldLabel: 'Cédula:',
                            margins:'0 0 2 5',
                            labelWidth: 60,
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
                        //margins     : '0 0 0 10',
                        //labelWidth: 80,
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
                        xtype: 'textfield',
                        name: 'nombrecont',
                        width:270,
                        margins     : '5 0 2 7',
                        fieldLabel: 'Nombre',
                        labelWidth: 60,
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
                            name        : 'codmovil',
                            store       : Ext.create('myapp.store.registrar.TelefonoCelular'),
                            displayField:'codigo',
                            valueField  :'codigo',
                            editable    : false
                        },{
                            xtype       : 'textfield',
                            //flex        : 1,
                            //allowBlank:false,
                            width       : 235,
                            name        : 'movil',
                            margins     : '2 0 2 7',
                            minLength   : 7,
                            maxLength   : 7,
                            maskRe: /[0-9]/,
                        }]
                    },{
                        xtype       : 'textfield',
                        fieldLabel  : 'E-mail',
                        width       : 390,
                        margins:'0 0 2 7',
                        labelWidth  : 80,
                        name        :'correocont',
                        vtype       :'correo',
                        allowBlank  : false,
                    }],
                }]
            
            }]
        }]
    }
   
});