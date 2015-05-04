Ext.define('myapp.controller.reportes.Seleccionreppersonal', {
	extend: 'Ext.app.Controller',
	
	 views: [
      'vacaciones.reportesvac.ReportePersonalVacaciones',
      'vacaciones.reportesvac.Gridempleadolista',
      'vacaciones.reportesvac.Gridbuscarempleado',
      'vacaciones.reportesvac.PersonalvacacionesLista'
    ],
 
  requires: [
      'myapp.util.Util' ,
      'myapp.util.Md5' 
  ],
  refs: [{
    ref: 'ReportePersonalVacaciones',
    selector: 'reportepersonalvacaciones'
  },{
    ref: 'Gridempleadolista',
    selector: 'gridempleadolista'
  },{
    ref: 'Gridbuscarempleado',
    selector: 'gridbuscarempleado'
  },{
    ref: 'PersonalvacacionesLista',
    selector: 'personalvacacioneslista'
  }],
	init: function(application) {
		this.control({
		  "gridempleadolista": {
        itemclick: this.cargaremp2
      },
      "gridempleadolista button[name=adicionar]": {
        click: this.cargaremp2
      },
			"reportepersonalvacaciones button[name=buscar]":  {      
        click: this.onButtonClickBuscar
      },
      "reportepersonalvacaciones button[name=buscargeneral]":  {      
        click: this.onButtonClickBuscargeneral
      },
		}); 
	},
  onButtonClickBuscargeneral:function (button, e, options) {
    form=this.getReportePersonalVacaciones();
    var idemp=form.down("textfield[name=idemp]").getValue();
    var cmbmeses=form.down("combobox[name=cmbmeses]").getValue();
    var grid1=this.getPersonalvacacionesLista();
    gridStore=this.getPersonalvacacionesLista().getStore();
    gridStore.proxy.extraParams.idemp=idemp;
    gridStore.proxy.extraParams.cmbmeses=cmbmeses;
    gridStore.load();
    console.log(gridStore);
    grid1.getView().refresh(true);
  },
	cargaremp2: function(button, e, options) {
    var grid = this.getGridempleadolista();
    var win=this.getGridbuscarempleado();
    gridStore=this.getGridempleadolista().getStore();
    gridStore.load();
    grid.getView().refresh(true);
    record = grid.getSelectionModel().getSelection();
    console.log(gridStore);
    grid.close();
    win.close();
    if(record[0]){ 
      form=this.getReportePersonalVacaciones();
      form.down('form').loadRecord(record[0]);
      form.down("fieldset[itemId=datos] textfield[name=nombres]").setValue(record[0].get('nombres'));form.destroy
    }
  },
  onButtonClickBuscar:function (button, e, options) {
    var win=Ext.create('myapp.view.vacaciones.reportesvac.Gridbuscarempleado');
    win.show();
  },
});
