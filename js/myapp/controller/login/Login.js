 
        

Ext.define('myapp.controller.login.Login', { // #1 
  extend: 'Ext.app.Controller',      // #2
  views: [
    'login.Login',
    'Header',
    'autenticar.Capslocktooltip'
  ] ,
  requires: [
    'myapp.util.Util' ,
    'myapp.util.Md5' 
  ],
  refs: [{
    ref: 'login',
    selector: '#loginWindow #loginForm'
  }],
  refs: [{
      ref: 'capslockTooltip',
      selector: 'capslocktooltip'
  }],
    
  init: function(application) { 
    this.control({
      "#loginWindow #loginForm textfiel[name=user]": {
        chame: this. cambio
      },
      "login form textfield": {
        specialkey: this. onTextfieldSpecialKey
      },   
      "login form button#submit":  {       // #1  
        click: this.onButtonClickSubmit // #2 
      },   
      "login form button#cancel": {       // #3  
        click: this.onButtonClickCancel // #4     
      } ,
      "appheader button#logout": {  
        click: this.onButtonClickLogout
      } ,
      "appheader button#perfil": {  
        click: this.onButtonClickPerfil
      } ,
        "login form textfield[name=password]": {
        keypress: this.onTextfieldKeyPress
      },
       "login form box[name=accepRegistrarme]": {
        click: this.onClickRegistrar // #2 
      }, 
      "login form box[name=accepOlvido]": {
        click: this.onClickOlvidoClave // #2 
      }, 
    }); 
  },

   onClickRegistrar: function(e) {
      console.log('Registrarme');
              var target = e.getTarget('.terms'),
              win;
              if (target) {
                var ventana = Ext.create('myapp.view.login.Registrarme');
                ventana.show();
              }
        

  },
  onClickOlvidoClave: function(e) {
      console.log('Olvido');
              var target = e.getTarget('.terms'),
              win;
              if (target) {
                var ventana2 = Ext.create('myapp.view.login.OlvidoClave');
                ventana2.show();
              }
        

  },
  onTextfieldSpecialKey: function(field, e, options) {
    if (e.getKey() == e.ENTER){
      var submitBtn = field.up('form').down('button#submit');
      submitBtn.fireEvent('click', submitBtn, e, options);
    }
  },
  onButtonClickSubmit: function(button, e, options){ 
    var formPanel = button.up('form'), 
    login = button.up('login'),  
    url= BASE_URL + 'login/login/auth' 
    user = formPanel.down('textfield[name=user]').getValue(),  
    pass = formPanel.down('textfield[name=password]').getValue().toUpperCase();         // #5
    if (formPanel.getForm().isValid()) { 
      pass = myapp.util.Md5.encode(pass);
      Ext.get(login.getEl()).mask("Autentificando... Por favor espere...",'loading');
      Ext.Ajax.request({ 
        url: BASE_URL + 'login/login/auth',
        method:'POST',
        params: { 
          user: user,
          pass: pass
        } ,
        failure: function(conn, response, options, eOpts) {
          Ext.get(login.getEl()).unmask();
          Ext.Msg.show({
            title:'Fallo!',
            msg: result.msg, 
            icon: Ext.Msg.ERROR,
            buttons: Ext.Msg.OK
        });
      },
        success: function(conn, response, options, eOpts) {
          Ext.get(login.getEl()).unmask();
          var result = Ext.JSON.decode(conn.responseText, true); 
          if (result.success) {
            console.log('paso'); 
            login.close();
            if (result.tipousuario=='4'){
              document.location = BASE_URL+'appi/home';
              myapp.util.SessionMonitor.start();
            }else{
              document.location = BASE_URL+'app/home';
              myapp.util.SessionMonitor.start();
            }
          }else {
            console.log(result);
            Ext.Msg.show({
              title:'Fallo!',
              msg: result.msg, 
              icon: Ext.Msg.ERROR,
              buttons: Ext.Msg.OK
            });
          }
        },
      });
    }
  },    
  onButtonClickCancel: function(button, e, options){ 
    button.up('form').getForm().reset();
  },
  onButtonClickLogout: function(button, e, options) {
    document.location= BASE_URL+'login/login/logout';
  },
  onButtonClickPerfil: function(button, e, options) {
    var win=Ext.create('myapp.view.seguridad.Contrasena');
    win.show();
  },
  onTextfieldKeyPress: function(field, e, options) {
    var charCode = e.getCharCode(); // #1
    if((e.shiftKey && charCode >= 97 && charCode <= 122) || 
    (!e.shiftKey && charCode >= 65 && charCode <= 90)){
      if(this.getCapslockTooltip() === undefined){ 
        Ext.widget('capslocktooltip');
      }
        this.getCapslockTooltip().show(); 
      } else {
        if(this.getCapslockTooltip() !== undefined){
          this.getCapslockTooltip().hide();
      }
    }
  }
});