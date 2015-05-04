Ext.define('myapp.view.empresa.TabRegistro2', {
    extend: 'Ext.form.Panel',
    alias: 'widget.tabregistro2',
    itemId: 'tabregistro2',
    autoScroll: true,
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
                items: [{
                        xtype: 'fieldset',
                        flex: 2,
                        type: 'hbox',
                        width: '100%',
                        margin: '10 10 10 10',
                        style: 'padding:10px',
                        title: 'Camaras del Estado Lara',
                        items: [{
                                xtype: 'container',
                                layout: 'hbox',
                                width: '100%',
                                items: [{
                                        xtype: 'checkboxgroup',
                                        layout: 'hbox',
                                        align: 'center',
                                        name: 'rdselfoto',
                                        width: '100%',
                                        pack: 'center',
                                        columns: 2,
                                        items: [{
                                                xtype: 'checkboxfield',
                                                name: 'seleccioncamara1',
                                                boxLabel: 'Camara de Comercio',
                                                style: 'margin-bottom: 30px',
                                                inputValue: '2',
                                                margins: '0 0 0 50',
                                            }, {
                                                xtype: 'checkboxfield',
                                                name: 'seleccioncamara2',
                                                boxLabel: 'Camara de Industriales ',
                                                style: 'margin-bottom: 30px',
                                                inputValue: '3',
                                                margins: '0 0 0 50',
                                                //checked:false
                                            }, {
                                                xtype: 'checkboxfield',
                                                name: 'seleccioncamara3',
                                                boxLabel: 'Camara de Artesanos,Pequeños y Medianos Industriales',
                                                style: 'margin-bottom: 30px',
                                                inputValue: '4',
                                                margins: '0 0 0 50',
                                            }, {
                                                xtype: 'checkboxfield',
                                                name: 'seleccioncamara4',
                                                boxLabel: 'Fedecamaras Lara',
                                                style: 'margin-bottom: 30px',
                                                inputValue: '5',
                                                margins: '0 0 0 50',
                                                //checked:false
                                            }, {
                                                xtype: 'checkboxfield',
                                                name: 'seleccioncamara5',
                                                boxLabel: 'Otra',
                                                style: 'margin-bottom: 30px',
                                                inputValue: '5',
                                                margins: '0 0 0 50',
                                                //checked:false
                                            }

                                            ],
                                    }],
                            },{
                                xtype       : 'button',
                                width       :  40,
                                iconCls     : 'pdf32',
                                iconAlign   : 'right',
                                name        : 'pdfClasificador',
                                tooltip     : 'Clasificador de Empresa',
                                scale       : 'large',
                                fieldLabel:'Clasificador',
                                margin: '0 10 10 50',
                            },{
                                xtype: 'label',
                                style: 'align:left',
                                text: 'Clasificador Venezolano de Actividades Económicas CAEV',
                            }]
                    }, {
                        xtype: 'fieldset',
                        flex: 2,
                        type: 'hbox',
                        width: '100%',
                        margin: '10 10 10 10',
                        style: 'padding:10px',
                        title: 'Ubique la Empresa en el Clasificador Venezolano de Actividades Económicas',
                        items: [{
                                xtype: 'container',
                                layout: 'hbox',
                                width: '100%',
                                items: [
                                    {
                                        xtype: 'combobox',
                                         width: '49%',
                                        allowBlank: false,
                                        fieldLabel: '* Seccion',
                                        margins: '0 0 2 7',
                                        name: 'cmbseccion',
                                        displayField: 'nombre',
                                        valueField: 'id',
                                        store: Ext.create('myapp.store.empresa.Seccion'),
                                        queryMode: 'local',
                                        emptyText: 'Seleccionar',
                                        triggerAction: 'all',
                                        editable: false,
                                        allowBlank: false,
                                        labelWidth: 115
                                    },
                                    {
                                        xtype: 'combobox',
                                         width: '49%',
                                        allowBlank: false,
                                        fieldLabel: '* Division',
                                        margins: '0 0 2 7',
                                        name: 'cmbdivisionact',
                                        displayField: 'nombre',
                                        valueField: 'id',
                                        store: Ext.create('myapp.store.empresa.Division'),
                                        queryMode: 'local',
                                        emptyText: 'Seleccionar',
                                        triggerAction: 'all',
                                        editable: false,
                                        allowBlank: false,
                                        labelWidth: 115,
                                        disabled:true,
                                    }]
                            }, {
                                xtype: 'container',
                                layout: 'hbox',
                                items: [{
                                        xtype: 'combobox',
                                         width: '49%',
                                        allowBlank: false,
                                        fieldLabel: '* Grupo',
                                        margins: '0 0 2 7',
                                        name: 'cmbgrupo',
                                        displayField: 'nombre',
                                        valueField: 'id',
                                        store: Ext.create('myapp.store.empresa.Grupo'),
                                        queryMode: 'local',
                                        emptyText: 'Seleccionar',
                                        triggerAction: 'all',
                                        editable: false,
                                        allowBlank: false,
                                        labelWidth: 115,
                                        disabled:true,
                                    }, {
                                        xtype: 'combobox',
                                         width: '49%',
                                        allowBlank: false,
                                        fieldLabel: '* Clase',
                                        margins: '0 0 2 7',
                                        name: 'cmbclase',
                                        displayField: 'nombre',
                                        valueField: 'id',
                                        store: Ext.create('myapp.store.empresa.Clase'),
                                        queryMode: 'local',
                                        emptyText: 'Seleccionar',
                                        triggerAction: 'all',
                                        editable: false,
                                        allowBlank: false,
                                        labelWidth: 115,
                                        disabled:true,
                                    }]
                            },{
                                xtype: 'container',
                                layout: 'hbox',
                                items: [{
                                        xtype: 'combobox',
                                         width: '49%',
                                        allowBlank: false,
                                         fieldLabel: '* Rama',
                                        margins: '0 0 2 7',
                                        name: 'cmbrama',
                                        displayField: 'nombre',
                                        valueField: 'id',
                                        store: Ext.create('myapp.store.empresa.Rama'),
                                        queryMode: 'local',
                                        editable: false,
                                        emptyText: 'Seleccionar',
                                        triggerAction: 'all',
                                        allowBlank: false,
                                        labelWidth: 115,
                                        disabled:true,
                                    }]
                            }]

                    }]

            }];
    }

});