Ext.define('myapp.view.login.Registrarme', {
    extend: 'Ext.window.Window',
    alias: 'widget.registrarme',
    // resizable:false,        
    // draggable:false,
    // autoShow: true,
    // height: 550,
    // width: 450, 
    layout: 'fit',
    closable: false,
    requires: ['myapp.util.Util', 'myapp.vtypes.Validadores', ],
    title: "Registro de Usuario ",
    // autoShow: true,
    // autoRender: true,
    height: 550,
    width: 450,
    initComponent: function () {
        var me = this;
        me.items = me.buildItems();
        me.callParent(arguments);
    },
    buildItems: function () {
        return [{
                xtype: 'container',
                border: 1,
                layout: {
                    align: 'center',
                    pack: 'center',
                    type: 'vbox'
                },
                margin: '20 0 0 0',
                items: [{
                        xtype: 'fieldset',
                        layout: 'vbox',
                        margin: '10 10 0 10',
                        width: '85%',
                        flex: 2,
                        title: 'Datos Empresariales',
                        items: [
                            {
                                xtype: 'container',
                                items: [{
                                        xtype: 'fieldcontainer',
                                        fieldLabel: 'RIF',
                                        layout: 'hbox',
                                        items: [{
                                                xtype: 'combobox',
                                                width: 55,
                                                hiddenLabel: true,
                                                name: 'rif',
                                                displayField: 'nombre',
                                                store: Ext.create('myapp.store.seguridad.Rif'),
                                                valueField: 'id',
                                                editable: false
                                            }, {
                                                xtype: 'label',
                                                text: '-',
                                            }, {
                                                xtype: 'textfield',
                                                maskRe: /[0-9]/,
                                                name: 'rif1',
                                                width: 110,
                                                minLength: 8,
                                                maxLength: 8,
                                                allowBlank: false
                                            }, {
                                                xtype: 'label',
                                                text: '-',
                                            }, {
                                                xtype: 'textfield',
                                                name: 'rif2',
                                                hiddenLabel: true,
                                                width: 20,
                                                maskRe: /[0-9]/,
                                                maxLength: 1,
                                                minLength: 1,
                                                allowBlank: false
                                            }]
                                    }]},
                            {
                                xtype: 'textarea',
                                name: 'razonsocial',
                                fieldLabel: 'Razon Social',
                                width: 300,
                                margins: '10 0 0 0',
                                labelWidth: 100,
                                allowBlank: false

                            }]
                    }, {
                        xtype: 'fieldset',
                        layout: 'vbox',
                        margin: '10 10 10 10',
                        width: '85%',
                        flex: 3,
                        title: 'Datos del Representante',
                        items: [{
                                xtype: 'fieldcontainer',
                                fieldLabel: 'Cédula',
                                layout: 'hbox',
                                items: [{
                                        xtype: 'combobox',
                                        margins: '10 5 5 0',
                                        width: 55,
                                        hiddenLabel: true,
                                        name: 'nacionalidad',
                                        displayField: 'nombre',
                                        valueField: 'id',
                                        store: Ext.create('myapp.store.seguridad.Nacionalidad'),
                                        editable: false
                                    }, {
                                        xtype: 'textfield',
                                        name: 'cedula',
                                        margins: '10 5 5 0',
                                        hiddenLabel: true,
                                        width: 135,
                                        maskRe: /[0-9]/,
                                        maxLength: 8,
                                        minLength: 4,
                                        allowBlank: false
                                    }]
                            }, {
                                xtype: 'textfield',
                                fieldLabel: 'Email',
                                maxLength: 70,
                                width: 300,
                                margins: '10 5 5 0',
                                name: 'correo',
                                blankText: 'Campo obligatorio.. '
                            }, {
                                xtype: 'panel',
                                border: false,
                                height: 150,
                                margins: '10 15 15 0',
                                width: 350,
                                itemId: 'reCaptcha',
                                items: [recaptcha]
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
                }, {
                    xtype: 'button',
                    itemId: 'cancel',
                    iconCls: 'cancel',
                    name: 'salir',
                    text: 'Cancelar'
                }, {
                    xtype: 'button',
                    name: 'save',
                    iconCls: 'go',
                    text: "Aceptar",
                }]
    }]
});
var recaptcha = Ext.create('myapp.util.ReCaptcha', {
    name: 'recaptcha',
    recaptchaId: 'recaptcha',
    publickey: '6LcJAPUSAAAAACZ_vvBx46SqeL0eSQTh5JhkKcLC',
    theme: 'white',
    lang: 'es'
});