Ext.define('myapp.controller.empresa.RifLista', { 
    extend: 'Ext.app.Controller',
    views: [
        'empresa.Riflista',
    ],
    refs: [{
        ref: 'riflista',
        selector: 'riflista'
    }],
    init: function(application) {
        this.control({ 
           "riflista actioncolumn[id=procesar]": {
                click: this.guardarIndividual
            },
        });
    },
  
     guardarIndividual: function(grid, record,rowIndex){
        grid = this.getRiflista(),
        store = this.getRiflista().getStore(),
        modified =store.getAt(rowIndex);
        if (modified){
            if(!Ext.isEmpty(modified)){
                Ext.get(grid.getEl()).mask("Guardando ... Por favor espere",'loading');
                var recordsToSend = [];
                Ext.each(modified, function(record) {
                    recordsToSend.push(Ext.apply(record.data));
                });
                url= BASE_URL + 'seguridad/usuario/registrarusuario'
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
                            grid.getStore().load();
                       }
                    }
                });
            }
            else{
                Ext.MessageBox.show({ title: 'Informaci&oacute;n', 
                msg: 'Debe seleccionar por lo menos un empleado', 
                buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO });
            }
        }   
    },
});