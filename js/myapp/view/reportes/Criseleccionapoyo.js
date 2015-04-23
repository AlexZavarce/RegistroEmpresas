Ext.define('myapp.view.reportes.Criseleccionapoyo', {
    extend: 'Ext.window.Window',
    alias: 'widget.criseleccionapoyo',
    autoShow: true,
    height: 400,
    width: 850,
    title: 'Criterios de Selección',
    layout: {
        type: 'fit'
    },
    modal:true,
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
                title: 'Informaciòn del Usuario',
                items: [{
                    xtype: 'container',
                    layout: 'hbox',
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
                        },]
                    },{
                    xtype: 'fieldcontainer', 
                    layout: {type: 'hbox'}, 
                    items: [{
                        xtype: 'combobox',
                        width: 250,
                        allowBlank: false,
                        fieldLabel: 'Municipio',
                        margins:'0 2 20 0',
                        margins:{right:5},
                        name: 'cmbmunicipio',
                        emptyText:' ',
                        store: Ext.create('myapp.store.registrar.Municipio'),
                        editable: false,
                        valueField: 'id',
                        displayField: 'nombre',   
                        queryMode: 'remote',
                        triggerAction: 'all',
                        labelWidth: 50,
                        },{
                        xtype: 'combobox',
                        width: 250,
                        fieldLabel: 'Parroquia',
                        labelWidth: 50,
                        margins:'0 2 20 0',
                        name: 'cmbparroquia',
                        store: Ext.create('myapp.store.registrar.Parroquia'),
                        valueField: 'id',
                        displayField: 'nombre',   
                        queryMode: 'remote',
                        emptyText:' ',
                        triggerAction: 'all',
                        disabled: true,
                        },{
                        xtype: 'combobox',
                        width: 195,
                         margins:'0 2 20 0',
                        fieldLabel: 'Sexo',
                        name:'cmbsexo',
                        forceSelection: true,
                        editable:false,
                        emptyText:' ',
                        store :Ext.create('myapp.store.registrar.Sexo'),
                        valueField: 'id',
                        displayField: 'nombre', 
                        queryMode: 'local',
                        triggerAction: 'all',           
                        labelWidth: 45
                        }]
                    },{
                    xtype: 'fieldcontainer', 
                    layout:  'hbox', 
                    items: [{
                        xtype: 'combobox',
                        width: 505,
                        margins:'0 20 20 0',
                        name:'cmbinstitucion',
                        valueField:'id',
                        displayField:'nombre', 
                        querymode:'remote',
                        emptyText:' ',
                        triggerAction: 'all', 
                        store:Ext.create('myapp.store.registrar.Institucion'),
                        fieldLabel: 'Organo al que pertenece:',
                        labelWidth: 150,
                        },{
                        xtype: 'combobox',
                        width: 180,
                        margins:'0 2 20 0',
                        fieldLabel: 'Edad',
                        name:'cmbedad',
                        editable:true,
                        emptyText:' ',
                        store :Ext.create('myapp.store.reportes.Edad'),
                        displayField:'edad', 
                        queryMode: 'local',
                        triggerAction: 'all',           
                        labelWidth:25,
                        forceSelection:true,
                        }]
                    }]      
            },{
            xtype: 'container',
            layout: 'hbox',
            items:[{
                xtype: 'fieldset',
                flex: 2,
                title: 'Caracteristicas del Nivel de Apoyo Institucional ',
                items: [{
                    xtype: 'container',
                    layout: 'hbox',
                    items: [{
                        xtype: 'combobox',
                        width: 225,
                        margins:'0 2 15 0',
                        forceselection:true,
                        name:'cmbinstitucionapoyo',
                        valueField:'id',
                        displayField:'nombre',
                        querymode:'remote',
                        emptyText:' ',
                        triggerAction: 'all', 
                        store:Ext.create('myapp.store.registrar.InstitucionApoyo'),
                        fieldLabel: 'Institucion Apoyo:',
                        allowBlank: false,
                        labelWidth: 55,
                        },{
                        xtype: 'combobox',
                        width: 255,
                        fieldLabel: 'Tipo de Ayuda:',
                        name:'cmbtipoayuda',
                        editable:false,
                        margins:'0 2 40 0',
                        forceSelection: true,
                        emptyText:' ',
                        store :Ext.create('myapp.store.registrar.TipoAyudaTecnica'),
                        valueField: 'id',
                        displayField: 'nombre',
                        queryMode: 'remote',
                        triggerAction: 'all',           
                        labelWidth: 60
                        },{
                        xtype: 'combobox',
                        width: 210,
                        fieldLabel: 'Existe un Consejo Comunal:',
                        name:'cmbconsejo',
                        editable:false,
                        margins:'0 2 20 0',
                        forceSelection: true,
                        emptyText:' ',
                        store :Ext.create('myapp.store.reportes.Poseeinforme'),
                        valueField: 'id',
                        displayField: 'nombre',
                        queryMode: 'local',
                        triggerAction: 'all',           
                        labelWidth: 60
                        }]
                    },{
                    xtype: 'fieldcontainer', 
                    layout: {type: 'hbox'}, 
                    items: [{
                        xtype: 'combobox',
                        width: 230,
                        fieldLabel: 'Nombre:',
                        name:'cmbnombreconsejo',
                        editable:false,
                        margins:'0 2 15 0',
                        forceSelection: true,
                        emptyText:' ',
                        store :Ext.create('myapp.store.registrar.ConsejoComunal'),
                        displayField: 'nombre',
                        queryMode: 'remote',
                        disabled: true,
                        triggerAction: 'all',           
                        labelWidth: 50
                        },{
                        xtype: 'combobox',
                        width: 250,
                        fieldLabel: 'Comite Comunitario:',
                        name:'cmbcomite',
                        editable:false,
                        margins:'0 2 15 0',
                        forceSelection: true,
                        emptyText:' ',
                        store :Ext.create('myapp.store.reportes.Poseeinforme'),
                        valueField: 'id',
                        displayField: 'nombre',
                        queryMode: 'local',
                        triggerAction: 'all',           
                        labelWidth: 60
                        },{
                        xtype: 'combobox',
                        width: 210,
                        fieldLabel: 'Nombre:',
                        name:'cmbnombrecomite',
                        editable:false,
                        margins:'0 2 20 0',
                        forceSelection: true,
                        emptyText:' ',
                        store :Ext.create('myapp.store.registrar.Comite'),
                        valueField: 'id',
                        displayField: 'nombre',
                        queryMode: 'remote',
                        disabled: true,
                        triggerAction: 'all',           
                        labelWidth: 60
                        }]
                    },]      
                },],
            }],
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
                }]
            }]
        }]
    }
}); 