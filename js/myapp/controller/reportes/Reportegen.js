Ext.define('myapp.controller.reportes.Reportegen', {
    extend: 'Ext.app.Controller',
    views: [
        'reportes.Reportegen',
        'reportes.Criseleccion',
        'reportes.Repempresa'
    ],
    controller: [
        'myapp.controller.reportes.Criseleccion',
        'myapp.controller.reportes.Criinfpersonal'
    ],
    requires: [
        'myapp.util.Util',
        'myapp.util.Md5'
    ],
    refs: [{
            ref: 'Reportegen',
            selector: 'reportegen'
        },
        {
            ref: 'criseleccionForm',
            selector: '#criseleccionWindow #criseleccionForm'
        }, {
            ref: 'Repinfpersonal',
            selector: 'repinfpersonal'
        }],
    init: function () {
        this.control({
            "reportegen radiogroup[name=reportes]": {
                change: this.changeReporte
            }
        });
    },
    changeReporte: function (grupo, cmp) {
        var formPanel1 = grupo.up('panel');
        var reportes = Ext.ComponentQuery.query("reportegen [name=reportegen]");
        var valor = (reportes[0].getGroupValue());
        switch (valor) {
            case '1':
                var win = Ext.create('myapp.view.reportes.Repempresa');
                win.setTitle('Criterios de Selección - Resumen de Empresas Registradas');
                win.down('form').getForm().reset();
                win.show();
                Ext.ComponentQuery.query("reportegen checkboxgroup[name=reportes]")[0].reset();
                break;
            case '2':
                window.open(BASE_URL + 'pdfs/repusuario/generarListadoUsuariosSinEmpresas');


                break;

        }

    }
});