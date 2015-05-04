Ext.define('myapp.controller.login.Registrarme', {// #1 
    extend: 'Ext.app.Controller', // #2
    views: [
        'login.Registrarme'
    ],
    requires: [
        'myapp.util.Util',
        'myapp.util.ReCaptcha',
        'myapp.vtypes.Validadores',
    ],
    refs: [{
            ref: 'Registrarme',
            selector: 'registrarme'
        }],
    refs: [{
            ref: 'capslockTooltip',
            selector: 'capslocktooltip'
        }],
            init: function (application) {
                this.control({
                    "registrarme button[name=save]": {// #3  
                        click: this.onButtonClickSave// #4     
                    },
                    "registrarme button[name=salir]": {
                        click: this.salir
                    }
                });
            },
    onButtonClickSave: function (button, e, options) {
        var formulario = button.up('registrarme');
        if (recaptcha.getResponse() != '') {
            
            login = button.up('registrarme');
            url = BASE_URL + 'login/registrarme/guardarusuariolinea';

            rif = formulario.down('combobox[name=rif]').getRawValue();
            rif1 = formulario.down('textfield[name=rif1]').getValue();
            rif2 = formulario.down('textfield[name=rif2]').getValue();
            razonsocial = formulario.down('textareafield[name=razonsocial]').getValue();
            nacionalidad = formulario.down('combobox[name=nacionalidad]').getRawValue();
            cedula = formulario.down('textfield[name=cedula]').getValue();
            correo = formulario.down('textfield[name=correo]').getValue();

            if (rif.length != 0 && rif1.length != 0 && razonsocial.length != 0 && nacionalidad.length != 0 && cedula.length != 0 && correo.length != 0) {
                if (rif1.length == 8 && rif2.length == 1) {
                    if (cedula.length <= 8 && cedula.length >= 5) {

                        var myMask = new Ext.LoadMask(Ext.getBody(), {msg: "Por favor espere..."});
                        myMask.show();
                        // Ext.get(login.getEl()).mask("Guardando... Se enviara un correo eelctronico...",'loading');
                        Ext.Ajax.request({
                            url: BASE_URL + 'login/registrarme/guardarusuariolinea',
                            method: 'POST',
                            params: {
                                rif: rif,
                                rif1: rif1,
                                rif2: rif2,
                                nacionalidad: nacionalidad,
                                cedula: cedula,
                                correo: correo,
                                razonsocial: razonsocial,
                                recaptcha_challenge_field: recaptcha.getChallenge(),
                                recaptcha_response_field: recaptcha.getResponse()
                            },
                            failure: function (conn, response, options, eOpts) {
                                Ext.get(login.getEl()).unmask();
                                myMask.hide();
                                Ext.Msg.show({
                                    title: 'Fallo!',
                                    msg: result.msg,
                                    icon: Ext.Msg.ERROR,
                                    buttons: Ext.Msg.OK
                                });
                            },
                            success: function (conn, response, options, eOpts) {
                                var datos = Ext.JSON.decode(conn.responseText, true);
                                myMask.hide();
                                if (datos.success) {
                                    myMask.hide();
                                   
                                    
                                    Ext.Msg.alert('Informaci&oacute;n', datos.msg, function (btn) { //Step 2
                                        if (btn === 'ok' || btn === 'cancel') {
                                            formulario.close();
                                            formulario.destroy();
                                            document.location = BASE_URL + '../';
                                        }
                                    });
                                }
                                else {
                                    Ext.Msg.show({
                                        title: 'Error!',
                                        msg: datos.msg,
                                        icon: Ext.Msg.ERROR,
                                        buttons: Ext.Msg.OK});//Ext.MessageBox.show({ title: 'Informaci&oacute;n', msg: 'Los datos suministrados no son correctos', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO });
                                }
                            }
                        });

                    }

                    else {
                        Ext.Msg.show({
                            title: 'Error!',
                            msg: 'La Cedula debe tener entre 5 y 8 Digitos',
                            icon: Ext.Msg.ERROR,
                            buttons: Ext.Msg.OK
                        });//Ext.MessageBox.show({ title: 'Informaci&oacute;n', msg: 'Los datos suministrados no son correctos', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO });
                    }
                }
                else {
                    Ext.Msg.show({
                        title: 'Error!',
                        msg: 'La longitud de su rif no es correcta ',
                        icon: Ext.Msg.ERROR,
                        buttons: Ext.Msg.OK
                    });//Ext.MessageBox.show({ title: 'Informaci&oacute;n', msg: 'Los datos suministrados no son correctos', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO });

                }
            } else {
                Ext.Msg.show({
                    title: 'Error!',
                    msg: 'Debe Ingresar Todos los campos ',
                    icon: Ext.Msg.ERROR,
                    buttons: Ext.Msg.OK
                });//Ext.MessageBox.show({ title: 'Informaci&oacute;n', msg: 'Los datos suministrados no son correctos', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO });

            }
        }
        else {
            Ext.Msg.show({
                title: 'Error!',
                msg: 'Debe Ingresar el Captcha ',
                icon: Ext.Msg.ERROR,
                buttons: Ext.Msg.OK
            });//Ext.MessageBox.show({ title: 'Informaci&oacute;n', msg: 'Los datos suministrados no son correctos', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO });

        }

    },
    onButtonClickCancel: function (button, e, options) {
        button.up('form').getForm().reset();
    },
    onButtonClickLogout: function (button, e, options) {
        document.location = BASE_URL + 'login/login/logout';
    },
    onButtonClickPerfil: function (button, e, options) {
        var win = Ext.create('myapp.view.seguridad.Contrasena');
        win.show();
    },
    onTextfieldKeyPress: function (field, e, options) {
        var charCode = e.getCharCode(); // #1
        if ((e.shiftKey && charCode >= 97 && charCode <= 122) ||
                (!e.shiftKey && charCode >= 65 && charCode <= 90)) {
            if (this.getCapslockTooltip() === undefined) {
                Ext.widget('capslocktooltip');
            }
            this.getCapslockTooltip().show();
        } else {
            if (this.getCapslockTooltip() !== undefined) {
                this.getCapslockTooltip().hide();
            }
        }
    },
    salir: function (button, e, options) {
        me = this;
        var formulario = button.up('registrarme');
        formulario.hide();
    }
});