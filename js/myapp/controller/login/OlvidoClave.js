Ext.define('myapp.controller.login.OlvidoClave', {// #1 
    extend: 'Ext.app.Controller', // #2
    views: [
        'login.OlvidoClave'

    ],
    requires: [
        'myapp.util.Util',
        'myapp.util.ReCaptcha',
        'myapp.vtypes.Validadores'
    ],
    refs: [{
            ref: 'OlvidoClave',
            selector: 'olvidoclave'
        }],
    init: function (application) {
        this.control({
            "olvidoclave button[name=salir]": {
                click: this.salir
            },
             "olvidoclave button[name=enviar]": {
                click: this.enviar
            }
        });
    },
    salir: function (button, e, options) {
        me = this;
        var formulario2 = button.up('olvidoclave');
        formulario2.hide();
    },
    
    enviar: function (button, e, options) {
        me = this;
        olvidoclave = button.up('olvidoclave');
        rif = olvidoclave.down('textfield[name=rif]').getValue();
        Ext.Ajax.request({
                url: BASE_URL + 'login/olvidoclave/recuperarclave',
                method: 'POST',
                params: {
                    rif: rif
                    
                },
                failure: function (conn, response, options, eOpts) {
                    Ext.get(olvidoclave.getEl()).unmask();
                    Ext.Msg.show({
                        title: 'Fallo!',
                        msg: result.msg,
                        icon: Ext.Msg.ERROR,
                        buttons: Ext.Msg.OK
                    });
                },
                success: function (conn, response, options, eOpts) {
                    var datos = Ext.JSON.decode(conn.responseText, true);
                    console.log(datos);
                    if (datos.success) {
                        Ext.Msg.alert('Informaci&oacute;n', datos.msg, function (btn) { //Step 2
                            if (btn === 'ok' || btn === 'cancel') {
                                formulario.getForm().reset();
                                formulario.close();
                                formulario.destroy();
                                document.location = BASE_URL + '../';
                            }
                        });
                    }
                    else {
                        Ext.Msg.show({
                            title: 'Error!',
                            msg: 'Los datos suministrados no son correctos',
                            icon: Ext.Msg.ERROR,
                            buttons: Ext.Msg.OK});//Ext.MessageBox.show({ title: 'Informaci&oacute;n', msg: 'Los datos suministrados no son correctos', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO });
                    }
                }
            });
 
    }
});