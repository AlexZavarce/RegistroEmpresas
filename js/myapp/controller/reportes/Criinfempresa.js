Ext.define('myapp.controller.reportes.Criinfempresa', {
  extend: 'Ext.app.Controller',
  views: ['reportes.Repempresa'],
  init: function(application) {
    this.control({
     
      "repempresa button#ejecutar": {
        click: this.onButtonClickejecutar
      },
    }); 
  },


  onButtonClickejecutar: function(button, e, options) {
    console.log
    var formPanel1 = button.up('window')
    var formPanel = button.up('form'), 
    rif= formPanel.down("combobox[name=rif]").getValue();
    rif1= formPanel.down("textfield[name=rif1]").getValue();
    rif2= formPanel.down("textfield[name=rif2]").getValue();
    nombrecomer= formPanel.down("textfield[name=nombrecomer]").getValue();
    anoact= formPanel.down("textfield[name=anoact]").getValue();
    cmbmunicipio= formPanel.down("combobox[name=cmbmunicipio]").getValue();
    cmbparroquia= formPanel.down("combobox[name=cmbparroquia]").getValue();
    cmbcomunidad= formPanel.down("combobox[name=cmbcomunidad]").getValue();
    cmbtipo= formPanel.down("combobox[name=cmbtipo]").getValue();
    cmbdivision= formPanel.down("combobox[name=cmbdivision]").getValue();
    cmbseccion= formPanel.down("combobox[name=cmbseccion]").getValue();
    cmbgrupo= formPanel.down("combobox[name=cmbgrupo]").getValue();
    cmbclase = formPanel.down("combobox[name=cmbclase]").getValue();
    window.open(BASE_URL +'pdfs/infpersonal/listadopersonal?rif='+rif+'&rif1='+rif1+'&rif2='+rif2+'&nombrecomer='+nombrecomer+'&anoact='+anoact+'&cmbmunicipio='+cmbmunicipio+'&cmbparroquia='+cmbparroquia+'&cmbcomunidad='+cmbcomunidad+'&cmbtipo='+cmbtipo+'&cmbdivision='+cmbdivision+'&cmbseccion='+cmbseccion+'&cmbgrupo='+cmbgrupo+'&cmbclase='+cmbclase);
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
