Ext.define('myapp.controller.empresa.RegistroEmpresa', { 
    extend: 'Ext.app.Controller',
    views: [
        'empresa.RegistroEmpresa',
        'empresa.TabRegistro1',
        'empresa.TabRegistro2',
        'empresa.TabRegistro3'
    ],
    refs: [{
        ref: 'RegistroEmpresa',
        selector: 'registroempresa'
    },{
        ref: 'TabRegistro1',
        selector:'tabregistro1',
    },{
        ref: 'TabRegistro2',
        selector:'tabregistro2',
    },{
        ref: 'TabRegistro3',
        selector:'tabregistro3',
    }],
    init: function(application) {
        this.control({ 
            "tabregistro1 combobox[name=cmbmunicipio]": {
            select: this.seleccionMunicipio
            },
            "tabregistro1 combobox[name=cmbparroquia]": {
            select: this.seleccionParroquia
            },
             "tabregistro2 combobox[name=cmbseccion]": {
            select: this.seleccionSeccion
            },
             "tabregistro2 combobox[name=cmbdivision]": {
            select: this.seleccionDivision
            },
            "tabregistro2 combobox[name=cmbgrupo]": {
            select: this.seleccionGrupo
            },
            "registroempresa button[name=guardar]": {
            click: this.onButtonClickSave
            },
        });
    },
    onButtonClickSave: function(button, e, options) {
    var formPanel = button.up('form'); 
    var form = this.getRegistroEmpresa();
    var tab1 = this.getTabRegistro1();
    var tab2 = this.getTabRegistro2();
    var tab3= this.getTabRegistro3();
    me=this;
    var id=form.down("textfield[name=id]").getValue();
    var rif = form.down("combobox[name=rif]").getValue();
    var rif1 = form.down("textfield[name=rif1]").getValue();
    var rif2 = form.down("textfield[name=rif2]").getValue();
    var nombrecomer= form.down("textfield[name=nombrecomer]").getValue();
    var anoact = form.down("textfield[name=anoact]").getValue();
    var registromer = form.down("textfield[name=registromer]").getValue();
    var razonsoc = form.down("textfield[name=razonsoc]").getValue();
    var tipo = form.down("combobox[name=tipo]").getValue();
    var cedula = tab3.down("textfield[name=cedula]").getValue();
    var representante =tab3.down("textfield[name=representante]").getValue();
    var codmovilrep =tab3.down("combobox[name=codmovilrep]").getValue();
    var movilrep = tab3.down("textfield[name=movilrep]").getValue();
    var nombrecont=tab3.down("textfield[name=nombrecont]").getValue();
    var codmovil =tab3.down("combobox[name=codmovil]").getValue();
    var movil = tab3.down("textfield[name=movil]").getValue();
    var cedulacont = tab3.down("textfield[name=cedulacont]").getValue();
    var cmbestado = tab1.down("combobox[name=cmbestado]").getValue();
    var cmbmunicipio = tab1.down("combobox[name=cmbmunicipio]").getValue();
    var cmbparroquia = tab1.down("combobox[name=cmbparroquia]").getValue();
    var cmbcomunidad = tab1.down("combobox[name=cmbcomunidad]").getValue();
    var direccion = tab1.down("textareafield[name=direccion]").getValue();
    var codmovilemp = tab1.down("combobox[name=codmovilemp]").getValue();
    var movilemp = tab1.down("textfield[name=movilemp]").getValue();
    var codfijoemp=tab1.down("combobox[name=codfijoemp]").getValue();
    var fijoemp = tab1.down("textfield[name=fijoemp]").getValue();
    var codfaxemp = tab1.down("textfield[name=codfaxemp]").getValue();
    var faxemp = tab1.down("textfield[name=faxemp]").getValue();
    var correoemp=tab1.down("textfield[name=correoemp]").getValue();
    var pagwebemp=tab1.down("textfield[name=pagwebemp]").getValue();
    var facebookemp=tab1.down("textfield[name=facebookemp]").getValue();
    var twitteremp=tab1.down("textfield[name=twitteremp]").getValue();
    var seleccioncamara1=tab2.down("checkboxfield[name=seleccioncamara1]").getValue();
    var seleccioncamara2=tab2.down("checkboxfield[name=seleccioncamara2]").getValue();
    var seleccioncamara3=tab2.down("checkboxfield[name=seleccioncamara3]").getValue();
    var seleccioncamara4=tab2.down("checkboxfield[name=seleccioncamara4]").getValue();
    var cmbseccion=tab2.down("combobox[name=cmbseccion]").getValue();
    var cmbdivision=tab2.down("combobox[name=cmbdivision]").getValue();
    var cmbgrupo=tab2.down("combobox[name=cmbgrupo]").getValue();
    var cmbclase=tab2.down("combobox[name=cmbclase]").getValue();
    Ext.Ajax.request({ 
      url: BASE_URL + 'empresa/empresa/guardarempresa',
      method:'POST',
      params: {
        id:id,
        rif:rif,
        rif1:rif1,
        rif2:rif2,
        nombrecomer:nombrecomer,
        anoact:anoact,
        registromer:registromer,
        razonsoc:razonsoc,
        cedula:cedula,
        representante:representante,
        codmovilrep:codmovilrep,
        movilrep:movilrep,
        tipo:tipo,
        nombrecon:nombrecont,
        codmovil:codmovil,
        movil:movil,
        correocont:correocont,
        cmbestado:cmbestado,
        cmbmunicipio:cmbmunicipio,
        cmbparroquia:cmbparroquia,
        cmbcomunidad:cmbcomunidad,
        direccion:direccion,
        codmovilemp:codmovilemp,
        movilemp:movilemp,
        codfijoemp:codfijoemp,
        codfaxemp:codfaxemp,
        faxemp:faxemp,
        correoemp:correoemp,
        pagwebemp:pagwebemp,
        facebookemp:facebookemp,
        twitteremp:twitteremp,
        seleccioncamara1:seleccioncamara1,
        seleccioncamara2:seleccioncamara2,
        seleccioncamara3:seleccioncamara3,
        seleccioncamara4:seleccioncamara4,
        cmbseccion:cmbseccion,
        cmbdivision:cmbdivision,
        cmbgrupo:cmbgrupo,
        cmbclase:cmbclase
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
          win.close();
          grid.getView().refresh(true);
          grid.getStore().load();
        } else {
            Ext.Msg.alert( 'Error','Falta seleccionar algún campo');
        }
      }
    });
  },
    seleccionMunicipio: function(button, combobox, e, options){
        console.log('Hola');
        var formPanel =  this.getTabRegistro1();
        parroquiaStore = formPanel.down("combobox[name=cmbparroquia]").getStore();
        parroquiaStore = formPanel.down("combobox[name=cmbparroquia]").getStore();
        formPanel.down("combobox[name=cmbparroquia]").clearValue();
        formPanel.down("combobox[name=cmbparroquia]").setDisabled(0);
        municipio=formPanel.down("combobox[name=cmbmunicipio]").getValue(                            )
        parroquiaStore.proxy.extraParams.municipio=municipio;
        parroquiaStore.load();
    },
    seleccionSeccion: function(button, combobox, e, options){

        var formPanel =  this.getTabRegistro2();
        divisionStore = formPanel.down("combobox[name=cmbdivision]").getStore();
        divisionStore = formPanel.down("combobox[name=cmbdivision]").getStore();
        formPanel.down("combobox[name=cmbdivision]").clearValue();
        formPanel.down("combobox[name=cmbdivision]").setDisabled(0);
        secc=formPanel.down("combobox[name=cmbseccion]").getValue();
        seccion=formPanel.down("combobox[name=cmbseccion]").getValue(                            )
        divisionStore.proxy.extraParams.seccion=seccion;
        divisionStore.load();
    },
    seleccionDivision: function(button, combobox, e, options){
        console.log('Hola');
        var formPanel =  this.getTabRegistro2();
        grupoStore = formPanel.down("combobox[name=cmbgrupo]").getStore();
        grupoStore = formPanel.down("combobox[name=cmbgrupo]").getStore();
        formPanel.down("combobox[name=cmbgrupo]").clearValue();
        formPanel.down("combobox[name=cmbgrupo]").setDisabled(0);
        division=formPanel.down("combobox[name=cmbdivision]").getValue(                            )
        grupoStore.proxy.extraParams.division=division;
        grupoStore.load();
    },
    seleccionGrupo: function(button, combobox, e, options){
        console.log('Hola');
        var formPanel =  this.getTabRegistro2();
        claseStore = formPanel.down("combobox[name=cmbclase]").getStore();
        claseStore = formPanel.down("combobox[name=cmbclase]").getStore();
        formPanel.down("combobox[name=cmbclase]").clearValue();
        formPanel.down("combobox[name=cmbclase]").setDisabled(0);
        grupo=formPanel.down("combobox[name=cmbgrupo]").getValue(                            )
        claseStore.proxy.extraParams.grupo=grupo;
        claseStore.load();
    },
     seleccionParroquia: function(button, combobox, e, options){
        console.log('Hola');
        var formPanel =  this.getTabRegistro1();
        comunidadStore = formPanel.down("combobox[name=cmbcomunidad]").getStore();
        comunidadStore = formPanel.down("combobox[name=cmbcomunidad]").getStore();
        formPanel.down("combobox[name=cmbcomunidad]").clearValue();
        formPanel.down("combobox[name=cmbcomunidad]").setDisabled(0);
        parroquia=formPanel.down("combobox[name=cmbparroquia]").getValue(                            )
        comunidadStore.proxy.extraParams.parroquia=parroquia;
        comunidadStore.load();
    },
   
});