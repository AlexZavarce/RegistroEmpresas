Ext.define('myapp.view.reportes.Criseleccionnivaca', {
    extend: 'Ext.window.Window',
    alias: 'widget.criseleccionnivaca',
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
                        },]}, 
                        {
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
                            width: 200,
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
                            labelWidth: 50
                        }]},
                        {
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
                        }]}
                       
                    ]      
                },{
                    xtype: 'container',
                    layout: 'hbox',
                    items:[{
                    xtype: 'fieldset',
                    flex: 2,
                    title: 'Caracteristicas del nivel academico del Discapacitado',

                        items: [{
                            xtype: 'container',
                            layout: 'hbox',
                            items: [{
                                xtype: 'combobox',
                                width: 505,
                                margins:'0 2 15 0',
                                forceselection:true,
                                name:'cmbgradoins',
                                valueField:'id',
                                displayField:'nombre',
                                querymode:'local',
                                emptyText:' ',
                                triggerAction: 'all', 
                                store:Ext.create('myapp.store.registrar.NivelAcademico'),
                                fieldLabel: 'Grado Instrucción:',
                                labelWidth: 140,
                            },{
                                xtype: 'combobox',
                                width: 200,
                                fieldLabel: 'Condición Fisc/Ment:',
                                name:'cmbcondiciones',
                                editable:false,
                                margins:'0 2 40 0',
                                forceSelection: true,
                                emptyText:' ',
                                store :Ext.create('myapp.store.reportes.Poseeinforme'),// cargar lo que esta en la clase store
                                valueField: 'id',
                                displayField: 'nombre',
                                queryMode: 'local',
                                triggerAction: 'all',           
                                labelWidth: 50
                            }]}, 
                        {
                            xtype: 'fieldcontainer', 
                            layout: {type: 'hbox'}, 
                            items: [{
                                xtype: 'combobox',
                                width: 505,
                                fieldLabel: 'Limitaciones de Estudio:',
                                name:'cmblimitaciones',
                                editable:false,
                                margins:'0 2 15 0',
                                forceSelection: true,
                                emptyText:' ',
                                store :Ext.create('myapp.store.registrar.LimitacionEstudio'),// cargar lo que esta en la clase store
                                valueField: 'id',
                                displayField: 'nombre',
                                queryMode: 'remote',
                                triggerAction: 'all',           
                                labelWidth: 140
                            },{
                                xtype: 'combobox',
                                width: 200,
                                fieldLabel: 'Deseo/ Estudiar:',
                                name: 'cmbdeseoestudiar',
                                emptyText:' ',
                                store: Ext.create('myapp.store.reportes.Poseeinforme'),
                                editable: false,
                                valueField: 'id',
                                displayField: 'nombre',   
                                queryMode: 'local',
                                triggerAction: 'all',
                                labelWidth: 50,
                            }]},
                        ]      
                    },
                ],
                    
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
                    }
                ]
            }]
        }]
    }
}); 