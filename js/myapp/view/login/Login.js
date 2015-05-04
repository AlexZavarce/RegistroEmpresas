var ventana = null;
var ventana2 = null;
Ext.define('myapp.view.login.Login', {
    extend: 'Ext.window.Window',
    alias: 'widget.login',
    resizable: false,
    draggable: false,
    itemId: 'loginWindow',
    autoShow: true,
    height: 270,
    width: 440,
    layout: {
        type: 'fit'
    },
    iconCls: 'key',
    title: "Registro de Empresas por Actividad Economica Lara",
    closeAction: 'hide',
    closable: false,
    items: [{
            xtype: 'form',
            frame: false,
            bodyPadding: 15,
            itemId: 'loginForm',
            layout: {
                type: 'vbox',
                align: 'center',
                anchor: '100%'
            },
            defaults: {
                xtype: 'textfield',
                anchor: '100%',
                labelWidth: 80,
                allowBlank: false,
                vtype: 'alphanum',
                minLength: 6,
                msgTarget: 'under'
            },
            dockedItems: [{
                    xtype: 'toolbar',
                    dock: 'bottom',
                    items: [{
                            xtype: 'tbfill'
                        }, {
                            xtype: 'box',
                            name: 'accepRegistrarme',
                            autoEl: {tag: 'a', href: '#', html: 'Registrarme'},
                            listeners: {
                                click: {
                                    element: 'el', //bind to the underlying el property on the panel
                                    fn: function () {
                                        if (ventana == null)
                                            ventana = Ext.create('myapp.view.login.Registrarme');
                                        //Ext.ComponentQuery.query('login')[0].hide();
                                        ventana.show();
                                    }
                                }
                            }
                        }, 
                        {
                            xtype: 'box',
                            name: 'accepOlvido',
                            autoEl: {tag: 'a', href: '#', html: 'Olvido su Contraseña'},
                            listeners: {
                                click: {
                                    element: 'el', //bind to the underlying el property on the panel
                                    fn: function () {
                                        if (ventana2 == null)
                                        ventana2 = Ext.create('myapp.view.login.OlvidoClave');
                                        //Ext.ComponentQuery.query('login')[0].hide();
                                        ventana2.show();
                                    }
                                }
                            }
                        }, 
                        {
                            xtype: 'button',
                            itemId: 'cancel',
                            iconCls: 'cancel',
                            text: 'Cancelar'
                        }, {
                            xtype: 'button',
                            itemId: 'submit',
                            iconCls: 'go',
                            formBind: true,
                            text: "Aceptar",
                        }]
                }],
            items: [{
                    xtype: 'image',
                    src: BASE_PATH + './imagen/logo/laraprogresista1.png',
                    height: 80,
                    width: 250,
                },
                {
                    name: 'user',
                    fieldLabel: "RIF",
                    emptyText: 'Introduzca el RIF sin espacios',
                    maxLength: 25,
                    width: 285,
                    labelWidth: 85,
                }, {
                    inputType: 'password',
                    name: 'password',
                    maxLength: 300,
                    labelWidth: 85,
                    name: 'password',
                            fieldLabel: "Contraseña",
                    enableKeyEvents: true,
                    width: 285,
                    id: 'password'
                }, {
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
                    }]
        }]
});
