Ext.define('myapp.view.reportes.Reportegen', {
    extend: 'Ext.panel.Panel',
    alias: 'widget.reportegen',
    autoShow: true,
    title: 'Cambio de password',
    layout: {
        align: 'center',
        pack: 'center',
        type: 'vbox'
    },
    bodyCls:'degradado',
    bodyStyle: {
        background: '#F0F8FF',
        padding: '10px',
         color: '#000',
    },
    initComponent: function() {
    var me = this;
    me.items = me.buildItem();
    me.callParent();
    },
    buildItem : function(){
        return [{ 
            xtype: 'checkboxgroup',
            hideLabel: true,
            align: 'center',
            id:'reportes',
            width:1035,
            height:1035, 
            name:'reportes',
            pack: 'center',
            columns:2,
            margins:'100 100 100 200',
            items: [{
                xtype: 'checkboxfield',
                name:'reportegen',
                boxLabel: 'Empresas Registradas',
                style: 'margin-bottom: 20px',
                value:'infpersonal',
                inputValue: '5',
                id:'5',
                labelWidth:1000,
                labelheight:300,
                margins:'20 30 40 30',
                cheked:false
            }],
        }]
    }
});

  