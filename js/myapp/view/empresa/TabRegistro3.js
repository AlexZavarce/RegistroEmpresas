Ext.define('myapp.view.empresa.TabRegistro3', {
    extend: 'Ext.form.Panel',
    alias: 'widget.tabregistro3',
    itemId: 'tabregistro3',
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
                        margin: '10 10 10 10',
                        width: '100%',
                        style: 'padding:10px',
                        flex: 3,
                        title: 'Datos del Representante Legal',
                        itemId: 'ubicacion',
                        items: [{
                                xtype: 'container',
                                width: '100%',
                                layout: 'hbox',
                                xtype: 'container',
                                        layout: 'hbox',
                                        items: [{
                                                xtype: 'container',
                                                width: '100%',
                                                layout: 'hbox',
                                                items: [{
                                                        xtype: 'combobox',
                                                        width: '15%',
                                                        allowBlank: false,
                                                        fieldLabel: 'Cedula',
                                                        margins: '10 5 5 0',
                                                        name: 'nacionalidadrep',
                                                        displayField: 'nombre',
                                                        valueField: 'id',
                                                        store: Ext.create('myapp.store.Nacionalidad'),
                                                        queryMode: 'local',
                                                        emptyText: 'Seleccionar',
                                                        triggerAction: 'all',
                                                        labelWidth: 80
                                                    },
                                                    , {
                                                        xtype: 'textfield',
                                                        width: '20%',
                                                        margins: '10 5 5 0',
                                                        maskRe: /[0-9]/,
                                                        name: 'cedularep',
                                                        minLength: 6,
                                                        maxLength: 8,
                                                        allowBlank: false
                                                    }, {
                                                        xtype: 'textfield',
                                                        name: 'representante',
                                                        width: '30%',
                                                        margins: '10 5 5 0',
                                                        fieldLabel: 'Nombres',
                                                        labelWidth: 80,
                                                    }, {
                                                        xtype: 'combobox',
                                                        width: '15%',
                                                        allowBlank: false,
                                                        fieldLabel: 'Tlf. Celular',
                                                        margins: '10 5 5 0',
                                                        name: 'codmovilrep',
                                                        displayField: 'nombre',
                                                        valueField: 'id',
                                                        store: Ext.create('myapp.store.registrar.TelefonoCelular'),
                                                        queryMode: 'local',
                                                        emptyText: 'Seleccionar',
                                                        triggerAction: 'all',
                                                        labelWidth: 80,
                                                    }, {
                                                        xtype: 'textfield',
                                                        //flex        : 1,
                                                        //allowBlank:false,
                                                        width: '20%',
                                                        name: 'movilrep',
                                                        margins: '10 5 5 0',
                                                        minLength: 7,
                                                        maxLength: 7,
                                                        maskRe: /[0-9]/,
                                                    }
                                                ]
                                            }],
                            }, ]
                    }, , {
                        xtype: 'fieldset',
                        flex: 2,
                        type: 'hbox',
                        margin: '10 10 10 10',
                        width: '100%',
                        style: 'padding:10px',
                        title: 'Datos del Contacto',
                        items: [{
                                xtype: 'container',
                                layout: 'hbox',
                                width: '100%',
                                items: [{
                                        xtype: 'container',
                                        layout: 'hbox',
                                        width: '100%',
                                        items: [{
                                                xtype: 'combobox',
                                                width: '15%',
                                                allowBlank: false,
                                                fieldLabel: 'Cedula',
                                                margins: '10 5 5 0',
                                                name: 'nacionalidadcont',
                                                displayField: 'nombre',
                                                valueField: 'id',
                                                store: Ext.create('myapp.store.Nacionalidad'),
                                                queryMode: 'local',
                                                emptyText: 'Seleccionar',
                                                triggerAction: 'all',
                                                labelWidth: 80
                                            }, {
                                                xtype: 'textfield',
                                                width: '20%',
                                                margins: '10 5 5 0',
                                                maskRe: /[0-9]/,
                                                name: 'cedulacont',
                                               
                                                        minLength: 6,
                                                maxLength: 8,
                                                allowBlank: false
                                            }
                                            , {
                                                xtype: 'textfield',
                                                name: 'nombrecont',
                                                width: '30%',
                                                margins: '5 0 2 7',
                                                fieldLabel: 'Nombres',
                                                labelWidth: 80
                                            }, {
                                                xtype: 'combobox',
                                                width: '15%',
                                                fieldLabel: 'Tlf. Celular',
                                                margins: '2 0 2 7',
                                                labelWidth: 80,
                                                name: 'codmovilcont',
                                                store: Ext.create('myapp.store.registrar.TelefonoCelular'),
                                                displayField: 'codigo',
                                                valueField: 'codigo',
                                                editable: false
                                            }, {
                                                xtype: 'textfield',
                                                
                                                width: '19%',
                                                name: 'movilcont',
                                                margins: '2 0 2 7',
                                                minLength: 7,
                                                maxLength: 7,
                                                maskRe: /[0-9]/,
                                            }]}],
                            }]

                    }]
            }]
    }

});