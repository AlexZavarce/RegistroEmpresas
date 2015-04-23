Ext.define('myapp.view.Header', { 
  extend: 'Ext.toolbar.Toolbar',
  alias: 'widget.appheader',
  height: 200,
  ui: 'footer',
  items: [{
        xtype: 'image', 
        src:BASE_PATH+'./imagen/logo/logoborde1.png',                          
        //src: 'http://localhost/Ceapdis/Imagen/logo/logoborde1.png' ,
        height:80,
        width:250,
    },{    
        xtype: 'tbseparator'
    },{
        xtype: 'image',  
        //src: 'http://localhost/Ceapdis/Imagen/logo/banner3.png',                         
        height:110,
        width:530,
        margins:'0 0 0 70'
    },{    
        xtype: 'tbseparator'
    },{ 
        xtype: 'tbfill'
    },{
        xtype: 'image',                           
        //src: 'http://localhost/Ceapdis/Imagen/logo/logoceapdis.png' ,
        height:80,
        width:140,
        margins:'0 50 0 0'
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