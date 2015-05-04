Ext.define('myapp.view.Header', { 
  extend: 'Ext.toolbar.Toolbar',
  alias: 'widget.appheader',
  height: 200,
  ui: 'footer',
  baseCls:'price',
  items: [{
        xtype: 'image', 
        src:BASE_PATH+'./imagen/logo/logoborde1.png',                          
        //src: 'http://localhost/Ceapdis/Imagen/logo/logoborde1.png' ,
        height:80,
        width:250,
    },{    
        xtype: 'tbseparator'
    },,{
        xtype: 'label',
        text: 'SISTEMA DE REGISTRO DE EMPRESAS POR ACTIVIDAD ECONÓMICA DEL ESTADO LARA',
        width: 600,
        margins:'0 80 0 120',
        baseCls:'Three-Dee'
    },{    
        xtype: 'tbseparator'
    },{   
        xtype: 'button',
        text: 'Perfil usuario',  
        itemId: 'perfil',
        iconCls: 'userorange'  
    },{    
        xtype: 'tbseparator'
    },{   
        xtype: 'button',
        text: 'Salir',  
        itemId: 'logout',
        iconCls: 'logout'  
    }] 
});