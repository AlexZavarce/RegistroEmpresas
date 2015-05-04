Ext.define('myapp.view.empresa.TabRegistro1', {
extend: 'Ext.form.Panel',
        alias: 'widget.tabregistro1',
        itemId: 'tabregistro1',
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
                        flex: 3,
                        title: 'Ubicación de la Empresa',
                        margin: '10 10 10 10',
                        width: '100%',
                        style: 'padding:10px',
                        itemId: 'ubicacion',
                        items: [{
                        xtype: 'container',
                                layout: 'hbox',
                                labelWidth: 300,
                                items: [{
                                xtype: 'combobox',
                                        width: '33%',
                                        allowBlank: false,
                                        fieldLabel: '* Estado',
                                        margins: '2 0 8 5',
                                        name: 'cmbestado',
                                        displayField: 'nombre',
                                        valueField: 'id',
                                        store: Ext.create('myapp.store.registrar.Estado'),
                                        queryMode: 'local',
                                        emptyText: 'Seleccionar',
                                        value:'Lara',
                                        triggerAction: 'all',
                                        allowBlank: false,
                                        editable: false,
                                        labelWidth: 80
                                }, {
                                xtype: 'combobox',
                                        width: '33%',
                                        allowBlank: false,
                                        fieldLabel: '* Municipio',
                                        
                                        margins: '2 0 8 5',
                                        name: 'cmbmunicipio',
                                        displayField: 'nombre',
                                        valueField: 'id',
                                        store: Ext.create('myapp.store.registrar.Municipio'),
                                        queryMode: 'local',
                                        emptyText: 'Seleccionar',
                                        editable: false,
                                        triggerAction: 'all',
                                        allowBlank: false,
                                        labelWidth: 80
                                },
                                {
                                xtype: 'combobox',
                                        width: '33%',
                                        allowBlank: false,
                                        fieldLabel: '* Parroquia',
                                        disabled    : true,
                                        margins: '2 0 8 5',
                                        name: 'cmbparroquia',
                                        displayField: 'nombre',
                                        editable: false,
                                        valueField: 'id',
                                        store: Ext.create('myapp.store.registrar.Parroquia'),
                                        queryMode: 'local',
                                        emptyText: 'Seleccionar',
                                        triggerAction: 'all',
                                        allowBlank: false,
                                        labelWidth: 80
                                }

                                ]
                        }, {
                        xtype: 'container',
                                layout: 'hbox',
                                items: [
                                {
                                xtype: 'combobox',
                                        width: '33%',
                                        allowBlank: false,
                                        fieldLabel: '* Comunidad',
                                        disabled    : true,
                                        margins: '2 0 8 5',
                                        name: 'cmbcomunidad',
                                        displayField: 'nombre',
                                        editable: false,
                                        valueField: 'id',
                                        store: Ext.create('myapp.store.registrar.Comunidad'),
                                        queryMode: 'local',
                                        emptyText: 'Seleccionar',
                                        triggerAction: 'all',
                                        labelWidth: 80,
                                        allowBlank: false
                                }, {
                                xtype: 'container',
                                        layout: 'hbox',
                                        width: '70%',
                                        items: [{
                                        xtype: 'textareafield',
                                                name: 'direccion',
                                                width: '94%',
                                                height: 40,
                                                margins: '0 0 8 7',
                                                fieldLabel: 'Dirección',
                                                labelWidth: 80

                                        }],
                                }],
                        }, {
                        xtype: 'fieldcontainer',
                                layout: 'hbox',
                                items: [{
                                xtype: 'combobox',
                                        width: '13%',
                                        fieldLabel: '* Tlf.Movil',
                                        labelWidth: 80,
                                        margins: '2 10 5 0',
                                        name: 'codmovilemp',
                                        store: Ext.create('myapp.store.registrar.TelefonoCelular'),
                                        displayField: 'codigo',
                                        valueField: 'codigo',
                                        editable: false,
                                        allowBlank: false,
                                          listeners: {
                                                select: function (comp, record, index) {
                                                        if (comp.getValue() == "" || comp.getValue() == "&nbsp;") 
                                                        comp.setValue(null);
                                                }
                                        },
                                        editable: false
                                }, {
                                xtype: 'textfield',
                                        //flex        : 1,
                                        //allowBlank:false,
                                        width: '21%',
                                        margins: '2 5 8 0',
                                        name: 'movilemp',
                                        minLength: 7,
                                        maxLength: 7,
                                        maskRe: /[0-9]/,
                                      
                                }, {
                                xtype: 'combobox',
                                        width: '13%',
                                        fieldLabel: ' Tlf.Local',
                                        margins: '2 10 5 0',
                                        labelWidth: 80,
                                        name: 'codfijoemp',
                                        store: Ext.create('myapp.store.registrar.TelefonoFijo'),
                                        displayField: 'codigo',
                                        valueField: 'codigo',
                                        editable: false,
                                        listeners: {

                                                select: function (comp, record, index) {
                                                        if (comp.getValue() == "" || comp.getValue() == "&nbsp;") 
                                                        comp.setValue(null);
                                                }
                                        }
                                }, {
                                xtype: 'textfield',
                                        //flex        : 1,
                                        width: '21%',
                                        margins: '2 5 2 0',
                                        name: 'fijoemp',
                                        minLength: 7,
                                        maxLength: 7,
                                        vtype: 'numero'
                                }, {
                                xtype: 'combobox',
                                        width: '10%',
                                        fieldLabel: ' Fax ',
                                        margins: '2 2 5 5',
                                        labelWidth: 40,
                                        name: 'codfaxemp',
                                        store: Ext.create('myapp.store.registrar.TelefonoFijo'),
                                        displayField: 'codigo',
                                        valueField: 'codigo',
                                        editable: false,
                                        listeners: {

                                                select: function (comp, record, index) {
                                                        if (comp.getValue() == "" || comp.getValue() == "&nbsp;") 
                                                        comp.setValue(null);
                                                }
                                        }
                                }, {
                                xtype: 'textfield',
                                        //flex        : 1,
                                        width: '21%',
                                        margins: '2 5 2 0',
                                        name: 'faxemp',
                                        minLength: 7,
                                        maxLength: 7,
                                        vtype: 'numero'
                                }]
                        }]
                }, , {
                xtype: 'fieldset',
                        flex: 2,
                        type: 'hbox',
                        margin: '10 10 10 10',
                        style: 'padding:10px',
                        width: '100%',
                        title: 'Sitio Web/Redes Sociales',
                        items: [{
                        xtype: 'container',
                                width: '100%',
                                layout: 'hbox',
                                items: [{
                                xtype: 'textfield',
                                        fieldLabel: 'E-mail',
                                        width: '49%',
                                        margins: '5 0 5 7',
                                        labelWidth: 80,
                                        name: 'correoemp',
                                        vtype: 'correo',
                                        allowBlank: false,
                                }, {
                                xtype: 'textfield',
                                        fieldLabel: 'Página Web',
                                        width: '49%',
                                        margins: '5 0 5 7',
                                        labelWidth: 80,
                                        name: 'pagwebemp',
                                        allowBlank: false,
                                }],
                        }, {
                        xtype: 'container',
                                width: '100%',
                                layout: 'hbox',
                                items: [{
                                xtype: 'textfield',
                                        fieldLabel: 'Facebook',
                                        width: '49%',
                                        margins: '5 0 5 7',
                                        labelWidth: 80,
                                        name: 'facebookemp',
                                        allowBlank: false,
                                }, {
                                xtype: 'textfield',
                                        fieldLabel: 'Twitter',
                                        width: '49%',
                                        margins: '5 0 5 7',
                                        labelWidth: 80,
                                        name: 'twitteremp',
                                        allowBlank: false,
                                }],
                        }]

                }]
        }]
        }

});