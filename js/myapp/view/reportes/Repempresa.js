Ext.define('myapp.view.reportes.Repempresa', {
    extend: 'Ext.window.Window',
    alias: 'widget.repempresa',
    autoShow: true,
    height: "41%",
    width:'70%',
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
            width:'100%',
            //bodyPadding: 30,
            items:[{
                xtype: 'fieldset',
                flex: 2,
                width:'100%',
                title:'Criterios de Selección',
                style: 'padding:10px',
                 margin: '10 10 10 10',
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
                        labelWidth: 70,
                        width: '15%',
                        margins:'5 5 5 0',
                        selecOnFocus: true,
                        store: Ext.create('myapp.store.seguridad.Rif'),
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
                        margins:'5 5 5 0',
                        maskRe: /[0-9]/,
                        name: 'rif1',
                        width: '20%',
                        minLength:6,
                        maxLength:8,
                        allowBlank: false
                    },{
                        xtype: 'textfield',
                        labelWidth: 50,
                        margins:'5 5 5 0',
                        maskRe: /[0-9]/,
                        name: 'rif2',
                        width: '8%',
                        minLength:1,
                        maxLength:1,
                        allowBlank: false
                    },{
                         xtype: 'textfield',
                        name: 'nombrecomer',
                        margins:'5 5 5 0',
                        width: '40%',
                        fieldLabel: 'Nombre Comercial',
                        labelWidth: 115,
                    },{
                        xtype: 'textfield',
                        name: 'anoact',
                        width: '15%',
                        //margins:'0 0 0 1',
                        fieldLabel: 'Años en Actividad',
                        labelWidth: 70,
                    },]
                    },{
                    xtype: 'fieldcontainer', 
                    layout: {type: 'hbox'}, 
                    items: [{
                        xtype: 'combobox',
                        margins:'5 5 5 0',
                        width: '44%',
                        allowBlank: false,
                        fieldLabel: 'Municipio',
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
                        labelWidth: 70,
                   },{
                        xtype: 'combobox',
                         margins:'5 5 5 0',
                        width: '55%',
                        fieldLabel: 'Parroquia',
                        allowBlank: false,
                       
                        labelWidth: 70,
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
                        margins:'5 5 5 0',
                        width: '44%',
                        fieldLabel: 'Comunidad',
                        allowBlank: false,
                       
                        labelWidth: 70,
                        valueField: 'id',
                        displayField: 'nombre', 
                        forceSelection:true,
                        name: 'cmbcomunidad',
                        store: Ext.create('myapp.store.registrar.Comunidad'),  
                        queryMode: 'remote',
                        emptyText:'Seleccionar',
                    },{
                        xtype: 'combobox',
                         margins:'5 5 5 0',
                        width: '55%',
                        allowBlank: false,
                        fieldLabel: 'Tipo',
                      
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
                        labelWidth: 70,       
                    }]
                },{
                    xtype: 'fieldcontainer', 
                    layout: {type: 'hbox'}, 
                    items: [{
                        xtype: 'combobox',
                        margins:'5 5 5 0',
                        width: '44%',
                        allowBlank: false,
                        fieldLabel: 'Seccion',
                       
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
                        labelWidth: 70,      
                    },{
                        xtype: 'combobox',
                        margins:'5 5 5 0',
                        width: '55%',
                        allowBlank: false,
                        fieldLabel: 'Division',
                       
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
                        labelWidth: 70,      
                    }]
                },{
                    xtype: 'fieldcontainer', 
                    layout: {type: 'hbox'}, 
                    items: [{
                        xtype: 'combobox',
                         margins:'5 5 5 0',
                        width: '44%',
                        allowBlank: false,
                        fieldLabel: 'Grupo',
                       
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
                        labelWidth: 70,  
                    },{
                        xtype: 'combobox',
                        margins:'5 5 5 0',
                        width: '55%',
                        allowBlank: false,
                        fieldLabel: 'Clase',
                        
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
                        labelWidth: 70,  
                    }]
                },,{
                    xtype: 'fieldcontainer', 
                    layout: {type: 'hbox'}, 
                    items: [{
                        xtype: 'combobox',
                         margins:'5 5 5 0',
                        width: '44%',
                        allowBlank: false,
                        fieldLabel: 'Rama',
                       
                        name: 'cmbrama',
                        allowBlank: false,
                        valueField: 'id',
                        forceSelection:true,
                        displayField: 'nombre', 
                        store: Ext.create('myapp.store.empresa.Rama'),
                        editable: false,  
                        queryMode: 'local',
                        emptyText:'Seleccionar',
                        triggerAction: 'all',
                        labelWidth: 70,  
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
                        xtype: 'combobox',
                        editable: false,  
                        name: 'formatoReporte',
                        editable: false, 
                        fieldLabel: 'Formato de Reporte', 
                        labelWidth: 120,
                        width: '25%',
                        margins:'5 5 5 0',
                        selecOnFocus: true,
                        store: Ext.create('myapp.store.formatoReporte'),
                        valueField: 'id',
                        displayField: 'nombre', 
                        queryMode: 'local',
                        allowBlank: false, 
                        forceSelection: true,
                        triggerAction: 'all',           
                        editable:false
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
     


          