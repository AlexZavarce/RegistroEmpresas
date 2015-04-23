Ext.define('myapp.controller.reportes.Criseleccionnivaca', {
  extend: 'Ext.app.Controller',
  views: ['reportes.Criseleccionnivaca'],
  init: function(application) {
    this.control({
      "criseleccionnivaca combobox[name=cmbmunicipio]": {
        select: this.seleccionMunicipio
      },
      "criseleccionnivaca button#generar": {
        click: this.onButtonClickGenerar
      },
      "criseleccionnivaca button#limpiar": {
        click: this.onButtonClickLimpiar
      },
    }); 
  },
  seleccionMunicipio: function(button, combobox, e, options){
    var formPanel = button.up('form');
    parroquiaStore = formPanel.down("combobox[name=cmbparroquia]").getStore();
    formPanel.down("combobox[name=cmbparroquia]").clearValue();
    formPanel.down("combobox[name=cmbparroquia]").setDisabled(0);
    parroquiaStore.proxy.extraParams.municipio=formPanel.down("combobox[name=cmbmunicipio]").getValue();
    parroquiaStore.load();
  },
  onButtonClickGenerar: function(button, e, options) {
    var formPanel1 = button.up('window')
    var formPanel = button.up('form'), 
    nombre= formPanel.down("textfield[name='textnombre']").getValue();
    apellido= formPanel.down("textfield[name='textapellido']").getValue();
    edocivil= formPanel.down("combobox[name='cmbedocivil]").getValue();
    edad= formPanel.down("combobox[name=cmbedad]").getValue();
    municipio= formPanel.down("combobox[name=cmbmunicipio]").getValue();
    parroquia= formPanel.down("combobox[name=cmbparroquia]").getValue();
    sexo= formPanel.down("combobox[name=cmbsexo]").getValue();
    institucion= formPanel.down("combobox[name=cmbinstitucion]").getValue();
    gradoins= formPanel.down("combobox[name=cmbgradoins]").getValue();
    limitaciones = formPanel.down("combobox[name=cmblimitaciones]").getValue();
    condiciones= formPanel.down("combobox[name=cmbcondiciones]").getValue();
    deseoestudiar= formPanel.down("combobox[name=cmbdeseoestudiar]").getValue();
    window.open(BASE_URL +'pdfs/repnivelaca/generarListadogennivaca?nombre='+nombre+'&apellido='+apellido+'&edocivil='+edocivil+'&edad='+edad+'&municipio='+municipio+'&parroquia='+parroquia+'&sexo='+sexo+'&institucion='+institucion+'&gradoins='+gradoins+'&limitaciones='+limitaciones+'&condiciones='+condiciones+'&deseoestudiar='+deseoestudiar);
    formPanel1.hide();
  },
  onButtonClickLimpiar: function(button, e, options) {
    var formPanel = button.up('form'); 
    formPanel.getForm().reset();
    nombre= formPanel.down("textfield[name=textnombre]").setValue('');
    apellido= formPanel.down("textfield[name=textapellido]").setValue('');
    edocivil= formPanel.down("combobox[name=cmbedocivil]").clearValue();
    edad= formPanel.down("combobox[name=cmbedad]").clearValue();
    municipio= formPanel.down("combobox[name=cmbmunicipio]").clearValue();
    parroquia= formPanel.down("combobox[name=cmbparroquia]").clearValue();
    sexo= formPanel.down("combobox[name=cmbsexo]").clearValue();
    institucion= formPanel.down("combobox[name=cmbinstitucion]").clearValue();
    gradoins= formPanel.down("combobox[name=cmbgradoins]").clearValue();
    limitaciones = formPanel.down("combobox[name=cmblimitaciones]").clearValue();
    condiciones= formPanel.down("combobox[name=cmbcondiciones]").clearValue();
    cmbdeseoestudiar= formPanel.down("combobox[name=cmbdeseoestudiar]").clearValue();
  },
});
