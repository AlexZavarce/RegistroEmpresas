    Ext.define('myapp.view.empresa.TabRegistro1', {
    extend : 'Ext.form.Panel',
    alias: 'widget.tabregistro1',
    itemId: 'tabregistro1',
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
                title: 'Ubicación de la Empresa',
                itemId:'ubicacion',
                items: [{
                    xtype: 'container',
                    layout: 'hbox',
                    labelWidth:300,
                    items: [{
                        xtype: 'combobox',
                        width: 300,
                        allowBlank: false,
                        fieldLabel: 'Estado',
                        margins:'0 0 2 5',
                        name: 'cmbestado',
                        allowBlank: false,
                        displayField: 'nombre',
                        valueField: 'id', 
                        store: Ext.create('myapp.store.registrar.Estado'),
                        queryMode: 'local',
                        emptyText:'Seleccionar',
                        triggerAction: 'all',
                        labelWidth: 60,        
                    },{
                       xtype: 'combobox',
                        width: 400,
                        allowBlank: false,
                        fieldLabel: 'Municipio',
                        margins:'0 0 2 7',
                        name: 'cmbmunicipio',
                        allowBlank: false,
                        valueField: 'id',
                        forceSelection:true,
                        displayField: 'nombre', 
                        store: Ext.create('myapp.store.registrar.Municipio'),
                        editable: false,  
                        queryMode: 'local',
                        emptyText:'Seleccionar',
                        triggerAction: 'all',
                        labelWidth: 115,  
                   },{
                        xtype: 'combobox',
                        width: 390,
                        fieldLabel: 'Parroquia',
                        allowBlank: false,
                        margins:'0 0 2 15',
                        labelWidth: 80,
                        valueField: 'id',
                        displayField: 'nombre', 
                        forceSelection:true,
                        name: 'cmbparroquia',
                        store: Ext.create('myapp.store.registrar.Parroquia'),  
                        queryMode: 'remote',
                        emptyText:'Seleccionar',
                   },
                ]
            },{
                xtype: 'container',
                layout: 'hbox',
                items: [{
                    xtype: 'combobox',
                    width: 300,
                    fieldLabel: 'Comunidad',
                    allowBlank: false,
                    margins:'2 0 2 5',
                    labelWidth: 60,
                    valueField: 'id',
                    displayField: 'nombre', 
                    forceSelection:true,
                    name: 'cmbcomunidad',
                    store: Ext.create('myapp.store.registrar.Comunidad'),  
                    queryMode: 'remote',
                    emptyText:'Seleccionar',
                },{
                    xtype: 'container',
                    layout: 'hbox',
                    items: [{
                        xtype: 'textareafield',
                        name: 'direccion',
                        width:805,
                        height:40,
                        margins   : '0 0 2 7',
                        fieldLabel: 'Dirección',
                        labelWidth: 115,
                    }],
                }],
            },{
                    xtype       : 'fieldcontainer',
                    layout      : 'hbox',
                    //margins     : '0 0 0 10',
                    //labelWidth: 80,
                   
                    items:[{
                        xtype       : 'combobox',
                        width       : 122,
                        fieldLabel  : 'Tlf.Movil',
                        labelWidth: 60,
                        margins:'2 0 2 5',
                        name        : 'codmovilemp',
                        store       : Ext.create('myapp.store.registrar.TelefonoCelular'),
                        displayField:'codigo',
                        valueField  :'codigo',
                        editable    : false
                    },{
                        xtype       : 'textfield',
                        //flex        : 1,
                        //allowBlank:false,
                        width       : 180,
                        margins:'2 0 2 0',
                        name        : 'movilemp',
                        minLength   : 7,
                        maxLength   : 7,
                        maskRe: /[0-9]/,
                    },{
                        xtype       : 'combobox',
                        width       : 180,
                        fieldLabel: ' Tlf.Local',
                        margins     : '2 0 2 7',
                        labelWidth: 115,
                        name        : 'codfijoemp',
                        store       : Ext.create('myapp.store.registrar.TelefonoFijo'),
                        displayField:'codigo',
                        valueField  :'codigo',
                        editable    : false,
                     },{
                        xtype       : 'textfield',
                        //flex        : 1,
                        width       : 220,
                        margins     : '2 0 2 0',
                        name        : 'fijoemp',
                        minLength   : 7,
                        maxLength   : 7,
                        
                        vtype       : 'numero'
                    },{
                        xtype       : 'combobox',
                        width       : 160,
                        fieldLabel: ' Fax ',
                        margins     : '2 0 2 20',
                        labelWidth: 70,
                        name        : 'codfaxemp',
                        store       : Ext.create('myapp.store.registrar.TelefonoFijo'),
                        displayField:'codigo',
                        valueField  :'codigo',
                        editable    : false,
                     },{
                        xtype       : 'textfield',
                        //flex        : 1,
                        width       : 225,
                        margins     : '2 0 2 0',
                        name        : 'faxemp',
                        minLength   : 7,
                        maxLength   : 7,
                        
                        vtype       : 'numero'
                    }]
                }]
            },,{
                xtype: 'fieldset',
                flex: 2,
                type: 'hbox', 
                title: 'Sitio Web/Redes Sociales',
                items: [{
                    xtype: 'container',
                    layout: 'hbox',
                    items: [{
                        xtype       : 'textfield',
                        fieldLabel  : 'E-mail',
                        width       : 300,
                        margins     : '5 0 0 7',
                        labelWidth  : 60,
                        name        :'correoemp',
                        vtype       :'correo',
                        allowBlank  : false,
                    },{
                        xtype       : 'textfield',
                        fieldLabel  : 'Página Web',
                        width       : 805,
                        margins     : '5 0 0 7',
                        labelWidth  : 80,
                        name        :'pagwebemp',
                        allowBlank  : false,
                    }],
                },{
                    xtype: 'container',
                    layout: 'hbox',
                    items: [{
                        xtype       : 'textfield',
                        fieldLabel  : 'Facebook',
                        width       : 300,
                        margins     : '5 0 0 7',
                        labelWidth  : 60,
                        name        :'facebookemp',
                        vtype       :'facebook',
                        allowBlank  : false,
                    },{
                        xtype       : 'textfield',
                        fieldLabel  : 'Twitter',
                        width       : 805,
                        margins     : '5 0 0 7',
                        labelWidth  : 80,
                        name        :'twitteremp',
                        vtype       :'twitter',
                        allowBlank  : false,
                    }],
                }]
            
            }]
        }]
    }
   
});