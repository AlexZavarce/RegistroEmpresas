Ext.define('myapp.controller.seguridad.Jornadaext', { 
    extend: 'Ext.app.Controller',
    views: [
        'seguridad.Jornadaext',
        'seguridad.Gridbuscarempext',
        'seguridad.Gridempext'    
    ],

    refs: [{
        ref: 'Jornadaext',
        selector: 'jornadaext'
    },{
        ref: 'Gridbuscarempext',
        selector: 'gridbuscarempext'
    },{
        ref: 'Gridempext',
        selector: 'gridempext'
    }],
    init: function(application) {
        this.control({ 
            "jornadaext button[name=buscaremp]": {
                click: this.onButtonClickbuscar
            },
            "jornadaext button[name=save]": {
                click: this.onButtonClicksave
            },
              "gridbuscarempext": { 
                itemclick: this.click
            },
             "gridbuscarempext button#agregar": {
                click: this.onButtonClickagregar
            },
            "jornadaext  button[name=cancel]": {
                click: this.onButtonClickCancel 
            } ,
        }); 
    },
    onButtonClickCancel: function(button, e, options) {
        var form=this.getJornadaext();
        form.close();
    },
    onButtonClickbuscar:function (button, e, options) {
        var win=Ext.create('myapp.view.seguridad.Gridempext');
        win.show();
    },
    onButtonClicksave:function (button, e, options) {
        var form = this.getJornadaext();
        me=this;
        var id=form.down("textfield[name=id]").getValue();
        var idemp=form.down("textfield[name=idemp]").getValue();
        var descripcion=form.down("fieldset[itemId=motivo] textareafield[name=txtdescripcion]").getValue();
        var fechades= form.down("datefield[name=fechadesde]").getValue();
        var fechahas= form.down("datefield[name=fechahasta]").getValue();
        Ext.Ajax.request({ 
            url: BASE_URL + 'seguridad/jornadaext/guardarjorext',
            method:'POST',
            params: {
                id:id,
                idemp:idemp,
                descripcion:descripcion,
                fechades:fechades,
                fechahas:fechahas,
            },
            failure: function(conn, response, options, eOpts) {
                Ext.Msg.show({
                title:'Fallo!',
                msg: result.msg, 
                icon: Ext.Msg.ERROR,
                buttons: Ext.Msg.OK
                });
            },
            success: function(conn, response, options, eOpts) {
                var result = Ext.JSON.decode(conn.responseText, true);
                if (result.success) {
                  Ext.Msg.alert( 'Exito',result.msg);
                  form.close();
                } else {
                    Ext.Msg.alert( 'Error','Falta seleccionar algún campo');
                }
            }
        });
    },
    click:function(dv, record, item, index, e) {
        console.log('holaaa');
        var grid = this.getGridbuscarempext();
        var win=this.getGridempext();
        gridStore=this.getGridbuscarempext().getStore();
        gridStore.load();
        grid.getView().refresh(true);
        record = grid.getSelectionModel().getSelection();
        grid.close();
        win.close();
        if(record[0]){ 
          formJornada=this.getJornadaext();
          extraordina=formJornada.down("form[name=extra]");
          extraordina.getForm().loadRecord(record[0]);
        }
    },
}); 