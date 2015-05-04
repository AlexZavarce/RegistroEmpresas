Ext.define('myapp.controller.reportes.Criselecciondis', {
  extend: 'Ext.app.Controller',
  views: ['reportes.Criselecciondis'],
  init: function(application) {
    this.control({
      "criselecciondis combobox[name=cmbmunicipio]": {
        select: this.seleccionMunicipio
      },
      "criselecciondis button#generar": {
        click: this.onButtonClickGenerar
      },
      "criselecciondis button#limpiar": {
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
    nombre= formPanel.down("textfield[name=textnombre]").getValue();
    apellido= formPanel.down("textfield[name=textapellido]").getValue();
    edocivil= formPanel.down("combobox[name=cmbedocivil]").getValue();
    edad= formPanel.down("combobox[name=cmbedad]").getValue();
    municipio= formPanel.down("combobox[name=cmbmunicipio]").getValue();
    parroquia= formPanel.down("combobox[name=cmbparroquia]").getValue();
    sexo= formPanel.down("combobox[name=cmbsexo]").getValue();
    institucion= formPanel.down("combobox[name=cmbinstitucion]").getValue();
    tipodiscapacidad= formPanel.down("combobox[name=cmbtipodiscapacidad]").getValue();
    requiereayuda = formPanel.down("combobox[name=cmbrequiereayuda]").getValue();
    poseeinforme = formPanel.down("combobox[name=cmbposeeinforme]").getValue();
    condiciondis = formPanel.down("combobox[name=cmbcondiciondis]").getValue();
    medicamentos = formPanel.down("combobox[name=cmbmedicamentos]").getValue();
    ayuda = formPanel.down("combobox[name=cmbayuda]").getValue();
    window.open(BASE_URL +'pdfs/repdiscaapcitado/generarListadogendis?nombre='+nombre+'&apellido='+apellido+'&edad='+edad+'&edocivil='+edocivil+'&municipio='+municipio+'&parroquia='+parroquia+'&sexo='+sexo+'&institucion='+institucion+'&tipodiscapacidad='+tipodiscapacidad+'&ayuda='+ayuda+'&requiereayuda='+requiereayuda+'&poseeinforme='+poseeinforme+'&condiciondis='+condiciondis+'&medicamentos='+medicamentos) ;
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
    tipodiscapacidad= formPanel.down("combobox[name=cmbtipodiscapacidad]").clearValue();
    requiereayuda = formPanel.down("combobox[name=cmbrequiereayuda]").clearValue();
    poseeinforme = formPanel.down("combobox[name=cmbposeeinforme]").clearValue();
    condiciondis = formPanel.down("combobox[name=cmbcondiciondis]").clearValue();
    medicamentos = formPanel.down("combobox[name=cmbmedicamentos]").clearValue();
    cmbayuda = formPanel.down("combobox[name=cmbayuda]").clearValue();
  },
});
