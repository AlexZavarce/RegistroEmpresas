Ext.define('myapp.controller.seguridad.Contrasena', {
  extend: 'Ext.app.Controller',
  views: [
    'seguridad.Contrasena',
    'seguridad.Contrasenaprin'
  ],
  refs:[{
     ref: 'contrasena',
     selector: 'contrasena'
  }],
  requires: [
    'myapp.util.Util' ,
    'myapp.util.Md5' 
  ],
  init: function() {
    this.control({
      "contrasena textfield[name=contrasenact]": {
        specialkey: this.onTextfieldSpecialKey
      },
      "contrasena  textfield[name=pass]": {
        specialkey: this.onTextfieldSpecialKey1
      },
      "contrasena  textfield": {
        change: this.onActivarBoton
      }, 
      "contrasena toolbar button#guardar":  {       // #1  
        click: this.onButtonClickSubmit // #2 
      },
     
    });
  },
  onActivarBoton : function(button, e, options){
    var win = button.up('window'),
    formPanel = button.up('form');
      //console.log(formPanel);
    if (formPanel.getForm().isValid()) {
      Ext.ComponentQuery.query('contrasena toolbar button[name=guardar]')[0].setDisabled(false);
    }else{
      Ext.ComponentQuery.query('contrasena toolbar button[name=guardar]')[0].setDisabled(true);
    }
  },
   onButtonClickSubmit: function(button, e, options){ 
    var win = button.up('window'),
    formPanel = win.down('form'),
    formPanel1= win.down('toolbar'),
    contrasena = button.up('contrasena'), 
    confcontrasena = formPanel.down('textfield[name=confcontrasena]').getValue();         // #5
    if (formPanel.getForm().isValid()) { 
      console.log('valor');
      confcontrasena = myapp.util.Md5.encode(confcontrasena);
      console.log(confcontrasena);
      Ext.Ajax.request({ 
        url: BASE_URL + 'seguridad/usuario/updatecontrasena',
        method:'POST',
        params: { 
          confcontrasena:confcontrasena,
        },
        failure: function(conn, response, options, eOpts) {
          Ext.Msg.show({
            title:'Error!',
            msg: conn.responseText,
            icon: Ext.Msg.ERROR,
            buttons: Ext.Msg.OK
          });
        },
        success: function(conn, response, options, eOpts) {
          var result = Ext.JSON.decode(conn.responseText, true); 
          if (!result){ 
            result = {};
            result.success = false;
            result.msg = conn.responseText;
          }
          if (result.success) {
            console.log('paso');
            Ext.Msg.alert( ' ','Actualizado correctamente'); 
            contrasena.close();
          } 
        }
      });
    } 
  },     
  onTextfieldSpecialKey1: function(field, e, options) {
    var win = field.up('window'),
    formPanel = win.down('form'),
    formPanel1= win.down('toolbar');
    formPanel1.down('button[name=guardar]').enable(true);
  },
  onTextfieldSpecialKey: function(field, e, options) {
    console.log('hola');
    if (e.getKey() ==e.ENTER || e.getKey() ==e.TAB){
      var win = field.up('window'),
      formPanel = win.down('form'),
      formPanel1= win.down('toolbar'),
      formPanel = win.down('form'),
      contrasena = formPanel.down('textfield[name=contrasenact]').getValue();
      contrasena = myapp.util.Md5.encode(contrasena),
      Ext.Ajax.request({
        url: BASE_URL + 'seguridad/usuario/existecontrasena',
        method:'POST',
        params: { 
          contrasena:contrasena
        } ,
        success: function(conn, response, options, eOpts) {
          var result = Ext.JSON.decode(conn.responseText, true); 
          if (!result.success) {
            Ext.Msg.alert( 'Error','Contraseña invalida');; 
            formPanel.down('textfield[name=pass]').disable(true);
            formPanel.down('textfield[name=confcontrasena]').disable(true);
            formPanel1.down('button[name=guardar]').disable(true);
            document.location= BASE_URL+'login/login/logout';
          } else{
            formPanel.down('textfield[name=pass]').enable(true);
            formPanel.down('textfield[name=confcontrasena]').enable(true);
          }
        } 
      });
    }
  },
});