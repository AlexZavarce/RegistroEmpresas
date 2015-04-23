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
            }
        });
    },
    salir: function (button, e, options) {
        me = this;
        var formulario2 = button.up('olvidoclave');
        formulario2.hide();
    }
});