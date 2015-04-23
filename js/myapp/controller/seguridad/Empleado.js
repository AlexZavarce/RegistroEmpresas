Ext.define('myapp.controller.seguridad.Empleado', { 
    extend: 'Ext.app.Controller',
    views: [
        'seguridad.Empleado',
        'seguridad.Empleadolista',
        'seguridad.Registroempleado'
        
    ],
   
    
    refs: [{
        ref: 'Empleadolista',
        selector: 'empleadolista'
    },{
        ref: 'Empleado',
        selector: 'empleado'
    },{
        ref: 'Registroempleado',
        selector: 'registroempleado'
    },{
        ref: 'userPicture',
        selector: 'registroempleado image'
    }],
    init: function(application) {
        this.control({ 
             "empleado button[name=agregar]": {
                click: this.onButtonClickAgregar
            },
             "registroempleado filefield": {
                change: this.onFilefieldChange
            },
            "registroempleado radiogroup[name=rdselfoto]": {
                change: this.changeFoto
            },
            "registroempleado button[name=guardar]": {
                click: this.onButtonClickGuardar
            },
             "empleado button[name=editar]": {
                click: this.onButtonClickEditar
            },
          
            "registroempleado combobox[name=codTlf1]": {
                select: this.selecttelefonocelular
            },
            "registroempleado combobox[name=hijos]":{
                select : this.changeHijo
            },
            "registroempleado textfield[name=cedula]": {
                specialkey: this.onTextfieldSpecialKey
            },
             "registroempleado button[name=cancelar]": {
                click: this.onButtonClickCancel
            },
             "empleadolista actioncolumn[id=modificar]": {
                click: this.onButtonClickEditar
            },
        }); 
    },
    onButtonClickCancel: function(button, e, options) {
        var win = button.up('window');
        win.close();
    },
    onTextfieldSpecialKey: function(field, e, options) {
        if (e.getKey() == e.ENTER || e.getKey() == e.TAB){
            var win = field.up('window'),
            formPanel = win.down('form'),
            nac = formPanel.down('combobox[name=nacionalidad]').getValue(),  
            ced = formPanel.down('textfield[name=cedula]').getValue();
            Ext.Ajax.request({
                url: BASE_URL + 'seguridad/empleado/existeempleado',
                method:'POST',
                params: { 
                  ced: ced,
                  nac: nac
                } ,
                success: function(conn, response, options, eOpts) {
                    var result = Ext.JSON.decode(conn.responseText, true); 
                    if (result.success) {
                      Ext.Msg.alert( 'Alerta','Usuario ya esta registrado');
                      formPanel.down('textfield[name=cedula]').reset() ;
                    } 
                } 
            });
        }
    },
     changeFoto:function(grupo,cmp){
        var form = this.getRegistroempleado();
        if(cmp.seleccionfoto==2){     
            Ext.ComponentQuery.query('filefield[name=foto]')[0].allowBlank = false;
            Ext.ComponentQuery.query('filefield[name=foto]')[0].validateValue(Ext.ComponentQuery.query('filefield[name=foto]')[0].getValue());
            Ext.ComponentQuery.query('form [itemId=fotografia1]')[0].setDisabled(false);
            Ext.ComponentQuery.query('form [itemId=fotografia1]')[0].setVisible(true);
            Ext.ComponentQuery.query('filefield[name=foto]')[0].reset();
            Ext.ComponentQuery.query('filefield[name=foto]')[0].setVisible(true);
            Ext.ComponentQuery.query('filefield[name=foto]')[0].setDisabled(false);
            form.down('image[name=fotoFrontal1]').setSrc(BASE_PATH+'imagen/foto/silueta.png');
        }
        if(cmp.seleccionfoto==3){
            Ext.ComponentQuery.query('form [itemId=fotografia1]')[0].setDisabled(true);
            Ext.ComponentQuery.query('filefield[name=foto]')[0].setVisible(false);
            Ext.ComponentQuery.query('form [itemId=fotografia1]')[0].setVisible(false);
            Ext.ComponentQuery.query('filefield[name=foto]')[0].allowBlank = true;
            Ext.ComponentQuery.query('filefield[name=foto]')[0].validateValue(Ext.ComponentQuery.query('filefield[name=foto]')[0].getValue());   
            //Ext.ComponentQuery.query('button[name=guardar]')[0].setDisabled(false);
            Ext.ComponentQuery.query('filefield[name=foto]')[0].reset();
            Ext.ComponentQuery.query('filefield[name=foto]')[0].setDisabled(false);
        }
    },
    changeHijo:function(grupo,cmp){
    var formPanel = this.getRegistroempleado();
        hijos = formPanel.down("combobox[name=hijos]").getValue();
        if(hijos==1){
            formPanel.down("textfield[name=canthijos]").setDisabled(false);
            formPanel.down("textfield[name=canthijos]").setVisible(true);
        }else{
            formPanel.down("textfield[name=canthijos]").setValue(0);
            formPanel.down("textfield[name=canthijos]").setDisabled(true);
        }
    },
    onButtonClickAgregar: function (button, e, options) {
        var editWindow = Ext.create('myapp.view.seguridad.Registroempleado');
        editWindow.show();
    },
    onButtonClickCancel: function(button, e, options) {
        var win = button.up('window');
        win.close();
    },
    onButtonClickEditar: function (button, e, options) {
        var grid = this.getEmpleadolista(),
        record = grid.getSelectionModel().getSelection();
        if(record[0]){
            var editWindow = Ext.create('myapp.view.seguridad.Registroempleado');
            editWindow.down('form').getForm().reset();
            editWindow.down('form').loadRecord(record[0]);
            editWindow.down('textfield[name=cedula]').setReadOnly(true);
            editWindow.down('textfield[name=nacionalidad]').setReadOnly(true);
            if (record[0].get('foto')){
                var img = editWindow.down('image');
                 img.setSrc(BASE_PATH+'./empleados/_DSC' + record[0].get('foto'));
            }
            editWindow.setTitle(record[0].get('name'));
            editWindow.show();
            editWindow.down('combobox[name=division]').setValue(record[0].get('division'));
            console.log(record[0].get('profesion'));
            editWindow.down('combobox[name=profesion]').setValue(record[0].get('profesion'));
            if (record[0].get('status')==0) {
                Ext.Msg.alert( 'Error','Usuario esta inactivo, verifique su status');
                editWindow.down('toolbar').down('button[name=guardar]').disable(true);
            }else{
                editWindow.down('toolbar').down('button[name=guardar]').enable(true);
            }
        }
    },
    onButtonClickGuardar: function(button, e, options) {
        var win = button.up('window'),
        formPanel = win.down('form'),
        grid=this.getEmpleadolista(),
        sele=formPanel.down("radiofield[name=seleccionfoto]").getValue();
        console.log(sele);
        store = this.getEmpleadolista().getStore();
        if (formPanel.getForm().isValid()) {
            formPanel.getForm().submit({
                clientValidation: true,
                url: BASE_URL + 'seguridad/empleado/guardarempleado',
                method:'POST',
                params:formPanel.getForm().getValues(),

                success: function(form, action) {
                    var result = action.result;
                    if (result.success) {
                        Ext.Msg.alert( 'Exito',result.msg);
                        store.load();
                        grid.getSelectionModel().clearSelections();
                        formPanel.getForm().reset();
                        win.close();
                    } else {
                        Ext.Msg.alert( 'Error','Usuario esta inactivo, verifique su status');
                    }
                },
                failure: function(form, action) {
                    switch (action.failureType) {
                        case Ext.form.action.Action.CLIENT_INVALID:
                            Ext.Msg.alert('Fallo', 'Los campos no pueden ser guardados con un valor invalido');
                            break;
                        case Ext.form.action.Action.CONNECT_FAILURE:
                            Ext.Msg.alert('Failure', 'Ajax communication failed');
                            break;
                        case Ext.form.action.Action.SERVER_INVALID:
                            Ext.Msg.alert('Error', action.result.msg);
                    }
                }
            });
        } 
    },
    onFilefieldChange: function(filefield, value, options) {

        var file = filefield.fileInputEl.dom.files[0];
        var picture = this.getUserPicture();
        if (typeof FileReader !== "undefined" && (/image/i).test(file.type)) {
            var reader = new FileReader();
            reader.onload = function(e){
                picture.setSrc(e.target.result);
            };
            reader.readAsDataURL(file); 
        } else if (!(/image/i).test(file.type)){
            Ext.Msg.alert('Warning', 'You can only upload image files!');
            filefield.reset();
        }   
    }    
}); 