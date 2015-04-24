Ext.define('myapp.view.empresa.RegistroEmpresa', {
    extend: 'Ext.form.Panel',
    alias: 'widget.registroempresa',
    itemId: 'registroempresa',
    autoScroll: true,
    requires: [
        'Ext.form.*',
        'Ext.tab.Tab',
        'myapp.util.Util',
    ],
    height: '100%',
    width: '100%',
    title: 'Registro de Empresa',
    initComponent: function () {
        var me = this;
        me.items = me.buildItems();
        me.callParent(arguments);
    },
    buildItems: function () {
        return [{
                xtype: 'container',
                layout: 'vbox',
                width: '100%',
                border: false,
                flex: 1,
                items: [{
                        xtype: 'fieldset',
                        layout: 'vbox',
                        margin: '10 10 10 10',
                        style: 'padding:10px',
                        width: '100%',
                        flex: 1,
                        itemId: 'datos empresa',
                        title: 'Selección del Tipo de Documento',
                        items: [{
                                xtype: 'textfield',
                                name: 'id',
                                width: '0%',
                                fieldLabel: 'Id',
                                labelWidth: 70,
                                editable: false,
                                minLength: 6,
                                maxLength: 8,
                                hidden: true
                            }, {
                                xtype: 'container',
                                layout: 'hbox',
                                width: '100%',
                                items: [{
                                        xtype: 'combobox',
                                        name: 'rif',
                                        fieldLabel: '* R.I.F',
                                        margins: '0 5 5 0',
                                        labelWidth: 60,
                                        width: '10%',
                                        store: Ext.create('myapp.store.Nacionalidad'),
                                        valueField: 'nombre',
                                        displayField: 'nombre',
                                        allowBlank: false
                                    }, {
                                        xtype: 'textfield',
                                        labelWidth: 100,
                                        margins: '0 5 5 0',
                                        maskRe: /[0-9]/,
                                        name: 'rif1',
                                        width: '15.8%',
                                        minLength: 6,
                                        maxLength: 8,
                                        allowBlank: false
                                    }, {
                                        xtype: 'textfield',
                                        labelWidth: 50,
                                        margins: '0 5 5 0',
                                        maskRe: /[0-9]/,
                                        name: 'rif2',
                                        width: '4%',
                                        minLength: 1,
                                        maxLength: 1,
                                        allowBlank: false
                                    }, {
                                        xtype: 'textarea',
                                        name: 'razonsoc',
                                        margins: '0 5 5 0',
                                        width: '55%',
                                        allowBlank: false,
                                        fieldLabel: '* Razón Social',
                                        labelWidth: 115,
                                    }, {
                                        xtype: 'textfield',
                                        name: 'anoact',
                                        width: '15%',
                                        maskRe: /[0-9]/,
                                        margins: '0 5 5 0',
                                        fieldLabel: 'Años en Actividad',
                                        labelWidth: 60,
                                    }],
                            }, {
                                xtype: 'container',
                                layout: 'hbox',
                                width: '100%',
                                items: [{
                                        xtype: 'combobox',
                                        name: 'registromer',
                                        valueField: 'id',
                                        margins: '0 5 5 0',
                                        displayField: 'nombre',
                                        store: Ext.create('myapp.store.empresa.Registro'),
                                        width: '30%',
                                        fieldLabel: '* Registro Mercantil',
                                        allowBlank: false,
                                        labelWidth: 60,
                                    }, {
                                        xtype: 'textarea',
                                        name: 'nombrecomer',
                                        margins: '0 5 5 0',
                                        width: '55%',
                                        fieldLabel: 'Nombre Comercial',
                                        labelWidth: 115,
                                    }, {
                                        xtype: 'combobox',
                                        fieldLabel: 'Tipo',
                                        margins: '0 5 5 0',
                                        name: 'tipo',
                                        allowBlank: false,
                                        valueField: 'id',
                                        forceSelection: true,
                                        displayField: 'nombre',
                                        store: Ext.create('myapp.store.empresa.tipo'),
                                        editable: false,
                                        queryMode: 'local',
                                        emptyText: 'Seleccionar',
                                        triggerAction: 'all',
                                        width: '15%',
                                        labelWidth: 60,
                                    }],
                            }]

                    }]

            }, {
                xtype: 'tabpanel',
                border: false,
                itemId: 'mitabpanel',
                flex: 3,
                activeTab: 0,
                width: '100%',
                items: [{
                        xtype: 'form',
                        border: 0,
                        title: 'Representante Legal -Persona contacto',
                        itemId: 'TabRegistro3',
                        iconCls: 'd',
                        activeTab: 0,
                        items: [{
                                xtype: 'tabregistro3',
                                width: '100%',
                                flex: 2
                            }]
                    }, {
                        xtype: 'form',
                        border: 0,
                        title: 'Ubicación de la Empresa',
                        itemId: 'TabRegistro1',
                        iconCls: 'd',
                        activeTab: 1,
                        items: [{
                                xtype: 'tabregistro1',
                                width: '100%',
                                flex: 2
                            }]
                    }, {
                        xtype: 'form',
                        itemId: 'TabRegistro2',
                        activeTab: 2,
                        iconCls: 'd',
                        title: 'Camaras y Clasificador Venezolano de Actividad Economica',
                        items: [{
                                xtype: 'tabregistro2',
                                width: '100%',
                                flex: 2
                            }]
                    }]
            }]
    },
    dockedItems: [{
            xtype: 'toolbar',
            dock: 'bottom',
            height: 40,
            width: '100%',
            items: [{
                    xtype: 'tbfill'
                },
                {
                    xtype: 'label',
                    style: 'align:left',
                    text: '* Campos de Ingreso Obligatorio',
                }, , {
                    xtype: 'button',
                    name: 'btncatalogo',
                    text: 'Ver Empresas',
                    iconCls: 'listado'
                }, {
                    xtype: 'button',
                    iconCls: 'icon-limpiar',
                    name: 'limpiar',
                    text: 'Limpiar'
                }, {
                    xtype: 'button',
                    iconCls: 'save',
                    name: 'guardar',
                    text: 'Guardar',
                    //disabled:true,
                    scope: this,
                }]
        }]
});
/*
 Ext.define('myapp.view.empresa.RegistroEmpresa', {
 extend: 'Ext.form.Panel',
 alias: 'widget.registroempresa',
 autoShow: true,
 height: 650,
 width: 750,
 modal:true,
 title: 'Registro de Empresas Manufactureras de Productos y/o Servicios del Edo-Lara',
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
 xtype: 'form',
 bodyPadding: 5,
 type: 'hbox', 
 items:[{
 xtype: 'fieldset',
 flex: 2,
 title: 'Datos de la Empresa',
 items: [{
 xtype: 'textfield',
 name: 'id',
 width:300,
 fieldLabel: 'Id',
 labelWidth: 70,
 editable:false,
 minLength:6,
 maxLength:8,
 hidden: true
 },{
 xtype: 'container',
 layout: 'hbox',
 items: [{
 xtype: 'combobox',
 editable: false,  
 name: 'rif',
 editable: false, 
 fieldLabel: 'R.I.F', 
 labelWidth: 60,
 width: 130,
 value:'V',
 //margins:'10 5 5 0',
 selecOnFocus: true,
 store: Ext.create('myapp.store.Nacionalidad'),
 valueField: 'nombre',
 displayField: 'nombre', 
 queryMode: 'local',
 allowBlank: false, 
 forceSelection: true,
 triggerAction: 'all',           
 editable:false
 },{
 xtype: 'textfield',
 labelWidth: 100,
 //margins:'10 5 5 0',
 maskRe: /[0-9]/,
 name: 'rif1',
 width:100,
 minLength:6,
 maxLength:8,
 allowBlank: false
 },{
 xtype: 'textfield',
 labelWidth: 50,
 //margins:'10 5 5 0',
 maskRe: /[0-9]/,
 name: 'rif2',
 width:40,
 minLength:1,
 maxLength:1,
 allowBlank: false
 },{
 xtype: 'textfield',
 name: 'nombre',
 margins:'0 0 0 5',
 width:680,
 fieldLabel: 'Nombre Comercial',
 labelWidth: 115,
 },{
 xtype: 'textfield',
 name: 'anoact',
 width:110,
 //margins:'0 0 0 1',
 fieldLabel: 'Años en Actividad',
 labelWidth: 60,
 }],
 },{
 xtype: 'container',
 layout: 'hbox',
 items: [{
 xtype: 'combobox',
 name: 'registrom',
 //margins:'3 0 0 0',
 width:270,
 fieldLabel: 'Registro Mercantil',
 labelWidth: 60,
 },{
 xtype: 'textfield',
 name: 'razonsoc',
 margins:'0 0 0 5',
 width:790,
 fieldLabel: 'Razón Social',
 labelWidth: 115,
 }],
 }]
 },{
 xtype: 'container',
 layout: 'hbox',
 items: [{
 xtype: 'fieldset',
 flex: 2,
 title: 'Datos del Representante Legal',
 items: [{
 xtype: 'container',
 layout: 'hbox',
 items: [{
 xtype: 'textfield',
 name: 'cedula',
 width:270,
 fieldLabel: 'Cédula:',
 //margins:'2 0 2 5',
 labelWidth: 60,
 },{
 xtype: 'textfield',
 name: 'representante',
 width:420,
 margins:'0 0 0 5',
 fieldLabel: 'Nombres',
 labelWidth: 115,
 },{
 xtype: 'combobox',
 width: 380,
 allowBlank: false,
 fieldLabel: 'Tipo',
 margins:'0 0 0 15',
 name: 'tipo',
 allowBlank: false,
 valueField: 'id',
 forceSelection:true,
 displayField: 'nombre', 
 store: Ext.create('myapp.store.empresa.tipo'),
 editable: false,  
 queryMode: 'local',
 emptyText:'Seleccionar',
 triggerAction: 'all',
 labelWidth: 80,        
 }],
 }]  
 }]
 },{
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
 width: 210,
 allowBlank: false,
 fieldLabel: 'Estado',
 margins:'0 0 2 5',
 name: 'cmbestado',
 allowBlank: false,
 valueField: 'id',
 forceSelection:true,
 displayField: 'nombre', 
 store: Ext.create('myapp.store.registrar.Estado'),
 editable: false,  
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
 width: 400,
 fieldLabel: 'Parroquia',
 allowBlank: false,
 margins:'0 0 2 15',
 labelWidth: 80,
 valueField: 'id',
 displayField: 'nombre', 
 forceSelection:true,
 name: 'cmbparroquia',
 //store: Ext.create('myapp.store.registrar.Parroquia'),  
 queryMode: 'remote',
 emptyText:'Seleccionar',
 },
 ]
 },{
 xtype: 'container',
 layout: 'hbox',
 items: [{
 xtype: 'combobox',
 width: 210,
 fieldLabel: 'Comunidad',
 allowBlank: false,
 margins:'2 0 2 5',
 labelWidth: 60,
 valueField: 'id',
 displayField: 'nombre', 
 forceSelection:true,
 name: 'cmbcomunidad',
 //store: Ext.create('myapp.store.registrar.Parroquia'),  
 queryMode: 'remote',
 emptyText:'Seleccionar',
 },{
 xtype: 'container',
 layout: 'hbox',
 items: [{
 xtype: 'textareafield',
 name: 'direccion',
 width:810,
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
 name        : 'codmovil',
 store       : Ext.create('myapp.store.registrar.TelefonoCelular'),
 displayField:'codigo',
 valueField  :'codigo',
 editable    : false
 },{
 xtype       : 'textfield',
 //flex        : 1,
 //allowBlank:false,
 width       : 90,
 margins:'2 0 2 0',
 name        : 'movil',
 minLength   : 7,
 maxLength   : 7,
 maskRe: /[0-9]/,
 },{
 xtype       : 'combobox',
 width       : 180,
 fieldLabel: ' Tlf.Local',
 margins     : '2 0 2 7',
 labelWidth: 114,
 name        : 'codfijo',
 store       : Ext.create('myapp.store.registrar.TelefonoFijo'),
 displayField:'codigo',
 valueField  :'codigo',
 editable    : false,
 },{
 xtype       : 'textfield',
 //flex        : 1,
 width       : 215,
 margins     : '2 0 2 0',
 name        : 'fijo',
 minLength   : 7,
 maxLength   : 7,
 
 vtype       : 'numero'
 },{
 xtype       : 'combobox',
 width       : 135,
 fieldLabel: ' Fax ',
 margins     : '2 0 2 20',
 labelWidth: 70,
 name        : 'codfijo',
 store       : Ext.create('myapp.store.registrar.TelefonoFijo'),
 displayField:'codigo',
 valueField  :'codigo',
 editable    : false,
 },{
 xtype       : 'textfield',
 //flex        : 1,
 width       : 255,
 margins     : '2 0 2 0',
 name        : 'fijo',
 minLength   : 7,
 maxLength   : 7,
 
 vtype       : 'numero'
 }]
 }]
 },{
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
 width       : 210,
 margins     : '0 0 0 7',
 labelWidth  : 60,
 name        :'correo',
 vtype       :'correo',
 allowBlank  : false,
 },{
 xtype       : 'textfield',
 fieldLabel  : 'Página Web',
 width       : 820,
 margins     : '5 0 0 7',
 labelWidth  : 115,
 name        :'correo',
 vtype       :'correo',
 allowBlank  : false,
 }],
 },{
 xtype: 'container',
 layout: 'hbox',
 items: [{
 xtype       : 'textfield',
 fieldLabel  : 'Facebook',
 width       : 210,
 margins     : '5 0 0 7',
 labelWidth  : 60,
 name        :'facebook',
 vtype       :'facebook',
 allowBlank  : false,
 },{
 xtype       : 'textfield',
 fieldLabel  : 'Twitter',
 width       : 820,
 margins     : '0 0 0 10',
 labelWidth  : 115,
 name        :'twitter',
 vtype       :'twitter',
 allowBlank  : false,
 }],
 }]
 
 },{
 xtype: 'fieldset',
 flex: 2,
 type: 'hbox', 
 title: 'Datos del Contacto',
 items: [{
 xtype: 'container',
 layout: 'hbox',
 items: [{
 xtype: 'textfield',
 name: 'nombreper',
 width:210,
 margins     : '5 0 0 7',
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
 margins     : '0 0 0 0',
 name        : 'codmovil',
 store       : Ext.create('myapp.store.registrar.TelefonoCelular'),
 displayField:'codigo',
 valueField  :'codigo',
 editable    : false
 },{
 xtype       : 'textfield',
 //flex        : 1,
 //allowBlank:false,
 width       : 215,
 name        : 'movil',
 margins     : '0 0 0 0',
 minLength   : 7,
 maxLength   : 7,
 maskRe: /[0-9]/,
 }]
 },{
 xtype       : 'textfield',
 fieldLabel  : 'E-mail',
 width       : 410,
 margins:'0 0 2 15',
 labelWidth  : 80,
 name        :'correo',
 vtype       :'correo',
 allowBlank  : false,
 }],
 },{
 xtype: 'container',
 layout: 'hbox',
 items: [{
 xtype       : 'textfield',
 fieldLabel  : 'Sector',
 width       : 210,
 margins     : '0 0 0 7',
 labelWidth  : 60,
 name        :'facebook',
 vtype       :'facebook',
 allowBlank  : false,
 },{
 xtype       : 'textfield',
 fieldLabel  : 'Actividad',
 width       : 820,
 margins:'7 0 0 5',
 labelWidth  : 115,
 name        :'twitter',
 vtype       :'twitter',
 allowBlank  : false,
 }],
 }]
 
 }],
 dockedItems: [{
 xtype: 'toolbar',
 dock: 'bottom',
 ui: 'footer',
 items: [{
 xtype: 'tbfill'
 },{
 xtype: 'button',
 text: 'Cancelar',
 itemId: 'cancel',
 iconCls: 'cancel'
 },{
 xtype: 'button',
 text: 'Guardar',
 name:'guardar',
 iconCls: 'save'
 },]
 }]
 }]
 }
 });*/