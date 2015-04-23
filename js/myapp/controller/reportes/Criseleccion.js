Ext.define('myapp.controller.reportes.Criseleccion', {
	extend: 'Ext.app.Controller',
	views: ['reportes.Criseleccion'],
	init: function(application) {
		this.control({
		 
			"criseleccion button#generar": {
				click: this.onButtonClickGenerar
			},
			"criseleccion button#asistencia": {
				click: this.onButtonClickAsistencia
			},
			"criseleccion button#permisos": {
				click: this.onButtonClickPermisos
			},
			"criseleccion button#limpiar": {
				click: this.onButtonClickLimpiar
			},
			"criseleccion button#semanal": {
				click: this.onButtonClickSemanal
			},
			"criseleccion button#saverepasi": {
				click: this.onButtonguardarobser
			},
			"criseleccion checkboxfield[name=observa]": {
      			change: this.changeReporte
      		},
		}); 
	},
	changeReporte:function(grupo,cmp){
		var formPanel1 = grupo.up('form')
	    var observa = formPanel1.down("checkboxfield[name=observa]").getValue();
	    if (observa){
	      formPanel1.down("textareafield[name=txtobservacion]").setVisible(true);
	      formPanel1.down("checkboxfield[name=observa]").setVisible(true);
	      formPanel1.down("combobox[name=cmbtipo]").setVisible(true);
	      formPanel1.down("button[name=saverepasi]").setVisible(true);
	    }
  	},
	onButtonguardarobser: function(button, e, options) {
		var formPanel1 = button.up('window');
		var formPanel = button.up('form');
		criseleccion = button.up('criseleccion') ;
		division=formPanel.down("combobox[name=cmbunidad]").getValue();
		observacion= formPanel.down("textareafield[name=txtobservacion]").getValue();
		fechades1= formPanel.down("datefield[name=cmbfechades]").getValue();
		fechades=Ext.Date.format(fechades1, 'Y-m-d');
		fechahas1= formPanel.down("datefield[name=cmbfechahas]").getValue()
		fechahas=Ext.Date.format(fechahas1, 'Y-m-d');
		tiponomina=formPanel.down("combobox[name=cmbtipo]").getValue();
		if(formPanel.down("textareafield[name=txtobservacion]").isVisible()){
            Ext.Ajax.request({
                method:'POST',
                url:BASE_URL + 'permisos/permisos/guardarrepperasistencia',
                params :{
                    fechadesde:fechades,
                    fechahasta:fechahas,
                    tiponomina:tiponomina,
                    division:division,
                    observacion:observacion
                },
                failure: function(conn, response, options, eOpts) {
			        Ext.Msg.show({
			        title:'Fallo!',
			        icon: Ext.Msg.ERROR,
			        buttons: Ext.Msg.OK
			        });
			    },
			    success : function(form,action) {
                    info = Ext.JSON.decode(form.responseText);
                    if(info.success==true){
			            Ext.Msg.alert( 'Exito',info.msg);
			        } else {
			            Ext.Msg.alert( 'Error',info.msg);
			        }
			    }
            });
        }
        formPanel.down("textareafield[name=txtobservacion]").setValue(" ");
        formPanel.down("combobox[name=cmbtipo]").setValue(" ");
  	},
  	onButtonClickSemanal: function(button, e, options) {
		var formPanel1 = button.up('window')
		var formPanel = button.up('form'), 
		division= formPanel.down("combobox[name='cmbunidad]").getValue();
		nombres= formPanel.down("textfield[name='nombres]").getValue();
		cedula= formPanel.down("combobox[name=cmbcedula]").getValue();
		fechades1= formPanel.down("datefield[name=cmbfechades]").getValue();
		fechades=Ext.Date.format(fechades1, 'Y-m-d');
		fechahas1= formPanel.down("datefield[name=cmbfechahas]").getValue();
		fechahas=Ext.Date.format(fechahas1, 'Y-m-d');
		window.open(BASE_URL +'pdfs/repasisemanal/generarlistadosemanal?division='+division+'&nombres='+nombres+'&cedula='+cedula+'&fechades='+fechades+'&fechahas='+fechahas);
		formPanel.close();
		formPanel1.hide();
  	},
	onButtonClickPermisos: function(button, e, options) {
		var formPanel1 = button.up('window')
		var formPanel = button.up('form'), 
		division= formPanel.down("combobox[name='cmbunidad]").getValue();
		tiponomina= formPanel.down("combobox[name=cmbtiponomina]").getValue();
		retardos= formPanel.down("combobox[name=cmbretardos]").getValue();
		cedula= formPanel.down("combobox[name=cmbcedula]").getValue();
		observacion=formPanel.down("textareafield[name=txtobservacion]").getValue();
		fechades1= formPanel.down("datefield[name=cmbfechades]").getValue();
		formato=formPanel.down("combobox[name=cmbformato]").getValue();
		fechades=Ext.Date.format(fechades1, 'Y-m-d');
		fechahas1= formPanel.down("datefield[name=cmbfechahas]").getValue();
		fechahas=Ext.Date.format(fechahas1, 'Y-m-d');
		window.open(BASE_URL +'pdfs/reppermisos/generarlistadopermisos?division='+division+'&tiponomina='+tiponomina+'&retardos='+retardos+'&cedula='+cedula+'&fechades='+fechades+'&fechahas='+fechahas+'&observacion='+observacion+'&formato='+formato);
		formPanel.close();
		formPanel1.hide();
  	},
	onButtonClickGenerar: function(button, e, options) {
		var formPanel1 = button.up('window')
		var formPanel = button.up('form'), 
		division= formPanel.down("combobox[name=cmbunidad]").getValue();
		tiponomina= formPanel.down("combobox[name=cmbtiponomina]").getValue();
		retardos= formPanel.down("combobox[name=cmbretardos]").getValue();
		cedula= formPanel.down("combobox[name=cmbcedula]").getValue();
		fechades1= formPanel.down("datefield[name=cmbfechades]").getValue();
		fechades=Ext.Date.format(fechades1, 'Y-m-d');
		fechahas1= formPanel.down("datefield[name=cmbfechahas]").getValue();
		fechahas=Ext.Date.format(fechahas1, 'Y-m-d');
		window.open(BASE_URL +'pdfs/inasistencia/generarlistadoinasistencia?division='+division+'&tiponomina='+tiponomina+'&cedula='+cedula+'&fechades='+fechades+'&fechahas='+fechahas);
		formPanel.close();
		formPanel1.hide();
	},
	onButtonClickAsistencia: function(button, e, options) {
		var formPanel1 = button.up('window')
		var formPanel = button.up('form'), 
		division= formPanel.down("combobox[name='cmbunidad]").getValue();
		tiponomina= formPanel.down("combobox[name=cmbtiponomina]").getValue();
		retardos= formPanel.down("combobox[name=cmbretardos]").getValue();
		cedula= formPanel.down("combobox[name=cmbcedula]").getValue();
		fechades1= formPanel.down("datefield[name=cmbfechades]").getValue();
		fechades=Ext.Date.format(fechades1, 'Y-m-d');
		fechahas1= formPanel.down("datefield[name=cmbfechahas]").getValue();
		fechahas=Ext.Date.format(fechahas1, 'Y-m-d');
		window.open(BASE_URL +'pdfs/repasistencia/generarasistencia?division='+division+'&tiponomina='+tiponomina+'&retardos='+retardos+'&cedula='+cedula+'&fechades='+fechades+'&fechahas='+fechahas);
		formPanel.close();
		formPanel1.hide();
  	},
	onButtonClickLimpiar: function(button, e, options) {
		var formPanel = button.up('form'); 
		formPanel.getForm().reset();
		division= formPanel.down("textfield[name=cmbunidad]").setValue(" ");
		tiponomina= formPanel.down("combobox[name=cmbtiponomina]").clearValue();
		retardos= formPanel.down("combobox[name=cmbretardos]").clearValue();
		cedula= formPanel.down("combobox[name=cmbcedula]").clearValue();
		fechades= formPanel.down("combobox[name=cmbfechades]").clearValue();
		fechahas= formPanel.down("combobox[name=cmbfechahas]").clearValue();
	},
});
