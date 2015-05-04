Ext.define('myapp.controller.reportes.Criseleccionnivocu', {
  extend: 'Ext.app.Controller',
  views: ['reportes.Criseleccionnivocu'],
  init: function(application) {
    this.control({
      "criseleccionnivocu combobox[name=cmbmunicipio]": {
        select: this.seleccionMunicipio
      },
      "criseleccionnivocu button#generar": {
        click: this.onButtonClickGenerar
      },
      "criseleccionnivocu button#limpiar": {
        click: this.onButtonClickLimpiar
      },
     "criseleccionnivocu combobox[name=cmbactproductiva]": {
        select: this.seleccionctproductiva
      },
      "criseleccionnivocu combobox[name=cmbaprenderofi]": {
        select: this.seleccionaprenderofi
      }
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
  seleccionctproductiva: function(button, combobox, e, options){
    var formPanel = button.up('form');
    actividad = formPanel.down("combobox[name=cmbactproductiva]").getValue();
    if (actividad==1){
        formPanel.down("combobox[name=cmbactiproddesarrollando]").setDisabled(0);
    }
  },
  seleccionaprenderofi: function(button, combobox, e, options){
    var formPanel = button.up('form');
    oficio = formPanel.down("combobox[name=cmbaprenderofi]").getValue();
    if (oficio==1){
      formPanel.down("combobox[name=cmboficio]").setDisabled(0);
    }
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
    habilidad= formPanel.down("combobox[name=cmbhabilidad]").getValue();
    actividaddesem = formPanel.down("combobox[name=cmbactividaddesem]").getValue();
    actiproddesarrollando = formPanel.down("combobox[name=cmbactiproddesarrollando]").getValue();
    actproductiva = formPanel.down("combobox[name=cmbactproductiva]").getValue();
    condiciones= formPanel.down("combobox[name=cmbcondiciones]").getValue();
    aprenderofi= formPanel.down("combobox[name=cmbaprenderofi]").getValue();
    oficio=formPanel.down("combobox[name=cmboficio]").getValue();
    window.open(BASE_URL +'pdfs/repnivocupa/generarListadogennivocu?nombre='+nombre+'&apellido='+apellido+'&edocivil='+edocivil+'&edad='+edad+'&municipio='+municipio+'&parroquia='+parroquia+'&sexo='+sexo+'&institucion='+institucion+'&habilidad='+habilidad+'&actividaddesem='+actividaddesem+'&actiproddesarrollando='+actiproddesarrollando+'&actproductiva='+actproductiva+'&condiciones='+condiciones+'&aprenderofi='+aprenderofi+'&oficio='+oficio);
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
    habilidad= formPanel.down("combobox[name=cmbhabilidad]").clearValue();
    actividaddesem = formPanel.down("combobox[name=actividaddesem]").clearValue();
    actiproddesarrollando = formPanel.down("combobox[name=cmbactiproddesarrollando]").clearValue();
    actproductiva = formPanel.down("combobox[name=cmbactproductiva]").clearValue();
    condiciones= formPanel.down("combobox[name=cmbcondiciones]").clearValue();
    aprenderofi= formPanel.down("combobox[name=cmbaprenderofi]").clearValue();
    oficio=formPanel.down("combobox[name=cmboficio]").clearValue();
  },
});
