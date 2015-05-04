Ext.define('myapp.view.login.OlvidoClave', {
    extend: 'Ext.window.Window',
    alias: 'widget.olvidoclave',
    layout: 'fit',
    closable: false,
    title: "Olvido Contraseña ",
    requires: ['myapp.util.Util', 'myapp.vtypes.Validadores'],
    // autoShow: true,
    // autoRender: true,
    height: "37%",
    width: "35%",
    initComponent: function () {
        var me = this;
        me.items = me.buildItems();
        me.callParent(arguments);
    },
    buildItems: function () {
        return [{
                xtype: 'container',
                border: 1,
                margin: '0 0 0 0',
                layout: {
                    align: 'center',
                    pack: 'center',
                    type: 'vbox'
                },
                items: [{
                        xtype: 'container',
                        layout: 'vbox',
                        margin: '10 10 0 10',
                        width: '85%',
                        flex: 2,
                        title: '',
                        items: [{
                                margin: '10 10 0 40',
                                xtype: 'image',
                                src: BASE_PATH + './imagen/logo/laraprogresista1.png',
                                height: 80,
                                width: 250,
                            }, {
                                xtype: 'textfield',
                                fieldLabel: 'RIF',
                                labelWidth: 55,
                                name: 'rif',
                                margins: '10 5 5 30',
                                hiddenLabel: true,
                                emptyText: 'Introduzca el RIF sin espacios',
                                maxLength: 25,
                                width: 285,
                                //labelWidth: 85,
                                allowBlank: false
                            }]
                    },
                    {
                        xtype: 'fieldset',
                        id: 'contenedorNotificacionEscribir',
                        layout: 'vbox',
                        margin: '10 10 10 10',
                        width: '85%',
                        flex: 1,
                        title: '',
                        items: [{
                                xtype: 'label',
                                width: '100%',
                                name: 'Notificacion',
                                id: 'notificacionEscribir',
                                margins: '10 5 5 0',
                                hiddenLabel: true,
                                text: 'Si presenta inconvenientes con el servicio por favor escribir al correo (correo) o Numero: (Numero)'

                            }]
                    }



                ]

            }];
    },
     dockedItems: [{
            xtype: 'toolbar',
            dock: 'bottom',
            height: 40,
            width: '100%',
            items: [{
                    xtype: 'tbfill'
                }, {
                    xtype: 'button',
                    itemId: 'cancel',
                    iconCls: 'cancel',
                    name: 'salir',
                    text: 'Cancelar'
                }, {
                    xtype: 'button',
                    name: 'enviar',
                    iconCls: 'go',
                    text: "Aceptar",
                }]
    }]
});