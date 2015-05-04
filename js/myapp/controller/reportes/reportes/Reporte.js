Ext.define('myapp.controller.reportes.Reporte', {
  extend: 'Ext.app.Controller',
  views: [
    'reportes.Reporte'
  ],
  requires: [
    'myapp.util.Util' ,
    'myapp.util.Md5' 
  ],
  init: function() {
    this.control({
     "reporte button#generar": {
      click: this.onButtonClickGenerar
    },
    "reporte button#limpiar": {
      click: this.onButtonClickLimpiar
    },
              
    });
  },
  onButtonClickGenerar: function(button, e, options) {
    var formPanel1 = button.up('window')
    var formPanel = button.up('form'), 
    nombre= formPanel.down("textfield[name='textnombre']").getValue();
    apellido= formPanel.down("textfield[name='textapellido']").getValue();
    edocivil= formPanel.down("combobox[name='cmbedocivil]").getValue();
    window.open(BASE_URL +'pdfs/repsocioFami/generarListado?nombre='+nombre+'&apellido='+apellido+'&edocivil='+edocivil);
    formPanel1.hide();
  },
  onButtonClickLimpiar: function(button, e, options) {
    var formPanel = button.up('form'); 
    formPanel.getForm().reset();
    nombre= formPanel.down("textfield[name=textnombre]").setValue('');
    apellido= formPanel.down("textfield[name=textapellido]").setValue('');
    edocivil= formPanel.down("combobox[name=cmbedocivil]").clearValue();
  },
});