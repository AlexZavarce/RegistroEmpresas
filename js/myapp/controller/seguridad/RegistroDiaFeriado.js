Ext.define('myapp.controller.seguridad.RegistroDiaFeriado', {
    extend: 'Ext.app.Controller',
    views: [
    'seguridad.RegistroDiaFeriado',
    'seguridad.Griddiaferiado'
    ],
    refs: [{
        ref: 'Griddiaferiado',
        selector: 'griddiaferiado'
    },{
        ref: 'RegistroDiaFeriado',
        selector: 'registrodiaferiado'
    }],
    init: function(application) {
        this.control({
          
            "registrodiaferiado button#add": {
                click: this.onButtonClickAdd
            },
            "griddiaferiado actioncolumn[id=eliminar]": {
                click: this.eliminar
            },
            "griddiaferiado button[name=guardar]": {
                click: this.guardar
            },
        }); 
    },
    onButtonClickAdd: function (button, e, options) {
        var me=this;
        var grid = button.up('registrodiaferiado');
        grid1= this.getGriddiaferiado();
        store = grid1.getStore();
        modelName = store.getProxy().getModel().modelName;
        cellEditing = grid1.getPlugin('cellplugin'); 
        store.add( Ext.create(modelName, {}));
    },
    guardar: function(button, e, options) {
        console.log('Holaaaa');
        var formPanel1 = button.up('form');
        var form = this.getRegistroDiaFeriado();
        me=this;
        grid = this.getGriddiaferiado(),
        formPanel = this.getGriddiaferiado();
        modified = grid.getSelectionModel().getSelection();
        if(!Ext.isEmpty(modified)){
            Ext.get(grid.getEl()).mask("Guardando ... Por favor espere...",'loading');
            var recordsToSend = [];
            Ext.each(modified, function(record) { 
                recordsToSend.push(Ext.apply(record.data));
            });
            url= BASE_URL + 'seguridad/diasferiados/guardar_diasferiados'
            recordsToSend = Ext.encode(recordsToSend);
            Ext.Ajax.request({
                method:'POST',
                url:url,
                params :{
                     records : recordsToSend
                },
                success : function(form,action) {
                    Ext.get(grid.getEl()).unmask();
                    info = Ext.JSON.decode(form.responseText);
                    if(info.success==true){
                        Ext.Msg.alert("Aviso","Guardado satisfactoriamente");
                        grid.getView().refresh(true);
                        grid.getSelectionModel().clearSelections();   
                    }
                }
            });
        }
        else{
            Ext.MessageBox.show({ title: 'Informaci&oacute;n', 
            msg: 'Debe seleccionar por lo menos un empleado', 
            buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO });
        }
    },
    /*selecttiponomina:function(button, combobox, e, options){
        var formPanel = button.up('form');
        var form = this.getRegistroPeriodo();
        me=this;
        var tiponomina = form.down("combobox[name=nomina]").getValue();
        grid1=this.getGridregperiodo();
        gridStore=this.getGridregperiodo().getStore();
        gridStore.proxy.extraParams.tiponomina=tiponomina;
        gridStore.load();
        grid1.getView().refresh(true);
    },
    eliminar: function(grid, record,rowIndex){
        grid =  this.getGridregperiodo();
        store= grid.getStore();
        rec = store.getAt(rowIndex);
        store.remove(rec);
        Ext.Msg.alert('Delete', 'Save the changes to persist theremoved record.');
    },
    onEdit: function(editor, context, options) {
       context.record.set('last_update', new Date());
    },
    onButtonClickAdd: function (button, e, options) {
        var me=this;
        var grid = button.up('registroperiodo');
        grid1= this.getGridregperiodo();
        store = grid1.getStore();
        modelName = store.getProxy().getModel().modelName; // #3
        cellEditing = grid1.getPlugin('cellplugin'); // #4
        console.log(cellEditing);
        store.add( Ext.create(modelName, {
        last_update: new Date()
        }));
        cellEditing.startEditByPosition({row: 0, column: 1}); // #7
    },
    onRender: function(component, options) { 
    }*/
});
