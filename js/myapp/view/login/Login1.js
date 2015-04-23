Ext.define('myapp.view.login.Login', {
  extend    : "Ext.window.Window",
  alias     : 'widget.registroLoginWin',
  requires  : ["MyApp.modules.login.LoginForm"],
  //modal   : false, //Fondo GRis
  draggable   : false,
  resizable : false,
  bodyPadding : 0,
  layout    : "auto",
  width   : 400,
  autoHeight  : true,
  closable  : false,
  forward   : true,
  //cls     : "bleext-window",
  //autoHeight  : true,
  itemId  : 'registroLoginWin',

  initComponent: function() {
    var me = this;
    this.store = Ext.create('MyApp.store.Captcha');
    this.items = this.buildItems();

    this.callParent();
  },
  buildItems  : function(){
    var me = this;
    this.store.load(function(records, operation, success) {
        var codigocaptcha = records[0].raw.image,
          captcha = Ext.ComponentQuery.query('component[itemId=captcha]')[0];
      captcha.update('<div align="center" ><img align="middle" src="'+BASE_PATH+'captcha/'+codigocaptcha+'.jpg"/></div>');
    });
    //
    //me.setCaptcha(125);
    //console.log(a.data.getItems);
    return [{
      xtype :'form',
      title   :'Registro de Usuario',
      bodyPadding: 5,
      border  : false,
      height  : 300,
      anchor : '100%',
      url   :BASE_PATH+'index.php/login/insertUsuario',
      items   : [{
        xtype   : 'textfield',
        name    : 'correo',
        labelWidth  : '12%',
        fieldLabel  : 'Correo',
        allowBlank  : false,
        vtype     : 'email',
        anchor    : '100%'
      },{
        xtype :'component',
        itemId  : 'captcha',
        padding : '10 0 5 0'
        },{
        xtype   : 'numberfield',
        name    : 'captcha',
        labelWidth  : '90%',
        fieldLabel  : 'Introduzca el numero de la Imagen',
        maxValue  : 99999,
        allowBlank  : false,
        minValue  : 10000,
        padding   : '0 0 30 0',
        },{
        xtype:'component',
        html:'<p>Envíe su correo Electrónico para obtener una clave, luego estará listo para ingresar al Portal de registro WEB.</p>'
      }/*,{
        xtype: 'box',
        autoEl: {tag: 'a', href: '', html: 'Registrarme'}
      }*/],
      buttons:[{
        text: 'Limpiar',
        handler: function() {
              this.up('form').getForm().reset();
          }
      }, {
        text: 'Enviar',
        formBind: true, //only enabled once the form is valid
        disabled: true,
        handler: function() {
          var form = this.up('form').getForm();
          if (form.isValid()) {
            form.submit({
              waitMsg: 'Espere por favor',
              waitTitle: 'Enviando datos',
              success: function(form, action) {
                Ext.Msg.alert('Informaci&oacute;n',action.result.msg,function(btn){ //Step 2
                  if(btn === 'ok' || btn === 'cancel'){
                    location.href =BASE_PATH;
                  }
                });
              },
              failure: function(form, action) {
                if(action.result.existe){ //Si el error es que no existe registrado, entonces se equivoco en el captcha
                  Ext.Msg.show({
                    title     :'¿Desea que le reenviemos la clave?',
                    msg       : action.result.msg,
                    buttons     : Ext.Msg.YESNO,
                    scope       : this,
                    icon      : Ext.Msg.QUESTION,
                    fn        : function(btn){
                      if(btn === 'no' || btn === 'cancel'){
                        location.href = BASE_PATH;
                      }else{
                        form.submit({
                          waitMsg   : 'Espere por favor',
                          waitTitle : 'Enviando datos',
                          url     : 'index.php/login/insertUsuario',
                          params    : {
                              reenvio : 1,
                            },
                            success: function(form, action) {
                            Ext.Msg.alert('Informaci&oacute;n',action.result.msg,function(btn){ //Step 2
                              if(btn === 'ok' || btn === 'cancel'){
                                location.href =BASE_PATH;
                              }
                            });
                            },
                            failure: function(form, action) {
                              Ext.Msg.alert('Falló', action.result.msg);
                            }
                        });
                      }
                    }
                  });
                }else{
                  Ext.Msg.alert('Error', action.result.msg);
                }
              }
            });
          }
        }
      }]
    }]
  }
});