Ext.define('myapp.view.reportes.Repempresa', {
    extend: 'Ext.window.Window',
    alias: 'widget.repempresa',
    autoShow: true,
    height: 400,
    width: 850,
    modal:true,
    title: 'Criterios de Selección',
    layout: {
        type: 'fit'
    },
    initComponent: function() {
    var me = this;
    me.items = me.buildItem();
    me.callParent();
    },
    buildItem : function(){
        return [{   
            xtype: 'form',
            bodyPadding: 30,
            items:[{
                xtype: 'fieldset',
                flex: 2,
                title: '',
                items: [{
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
                        name: 'nombrecomer',
                        margins:'0 0 0 5',
                        width:380,
                        fieldLabel: 'Nombre Comercial',
                        labelWidth: 115,
                    },{
                        xtype: 'textfield',
                        name: 'anoact',
                        width:80,
                        //margins:'0 0 0 1',
                        fieldLabel: 'Años en Actividad',
                        labelWidth: 60,
                    },]
                    },{
                    xtype: 'fieldcontainer', 
                    layout: {type: 'hbox'}, 
                    items: [{
                       xtype: 'combobox',
                        width: 270,
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
                        labelWidth: 75,  
                   },{
                        xtype: 'combobox',
                        width: 370,
                        fieldLabel: 'Parroquia',
                        allowBlank: false,
                        margins:'0 0 2 15',
                        labelWidth: 75,
                        valueField: 'id',
                        displayField: 'nombre', 
                        forceSelection:true,
                        name: 'cmbparroquia',
                        store: Ext.create('myapp.store.registrar.Parroquia'),  
                        queryMode: 'remote',
                        emptyText:'Seleccionar',
                   }]
                    },{
                    xtype: 'fieldcontainer', 
                    layout:  'hbox', 
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
                        xtype: 'combobox',
                        width: 390,
                        allowBlank: false,
                        fieldLabel: 'Tipo',
                        margins:'0 0 2 15',
                        name: 'cmbtipo',
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
                    }]
                },{
                    xtype: 'fieldcontainer', 
                    layout: {type: 'hbox'}, 
                    items: [{
                        xtype: 'combobox',
                        width: 410,
                        allowBlank: false,
                        fieldLabel: 'Seccion',
                        margins:'0 0 2 7',
                        name: 'cmbseccion',
                        allowBlank: false,
                        valueField: 'id',
                        forceSelection:true,
                        displayField: 'nombre', 
                        store: Ext.create('myapp.store.empresa.Seccion'),
                        editable: false,  
                        queryMode: 'local',
                        emptyText:'Seleccionar',
                        triggerAction: 'all',
                        labelWidth: 115,  
                    },{
                        xtype: 'combobox',
                        width: 620,
                        allowBlank: false,
                        fieldLabel: 'Division',
                        margins:'0 0 2 7',
                        name: 'cmbdivision',
                        allowBlank: false,
                        valueField: 'id',
                        forceSelection:true,
                        displayField: 'nombre', 
                        store: Ext.create('myapp.store.empresa.Division'),
                        editable: false,  
                        queryMode: 'local',
                        emptyText:'Seleccionar',
                        triggerAction: 'all',
                        labelWidth: 115,  
                    }]
                },{
                    xtype: 'fieldcontainer', 
                    layout: {type: 'hbox'}, 
                    items: [{
                        xtype: 'combobox',
                        width: 410,
                        allowBlank: false,
                        fieldLabel: 'Grupo',
                        margins:'0 0 2 7',
                        name: 'cmbgrupo',
                        allowBlank: false,
                        valueField: 'id',
                        forceSelection:true,
                        displayField: 'nombre', 
                        store: Ext.create('myapp.store.empresa.Grupo'),
                        editable: false,  
                        queryMode: 'local',
                        emptyText:'Seleccionar',
                        triggerAction: 'all',
                        labelWidth: 115,  
                    },{
                        xtype: 'combobox',
                        width: 620,
                        allowBlank: false,
                        fieldLabel: 'Clase',
                        margins:'0 0 2 7',
                        name: 'cmbclase',
                        allowBlank: false,
                        valueField: 'id',
                        forceSelection:true,
                        displayField: 'nombre', 
                        store: Ext.create('myapp.store.empresa.Clase'),
                        editable: false,  
                        queryMode: 'local',
                        emptyText:'Seleccionar',
                        triggerAction: 'all',
                        labelWidth: 115,  
                    }]
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
                    itemId: 'ejecutar',
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
        }]
    }
}); 
     


          