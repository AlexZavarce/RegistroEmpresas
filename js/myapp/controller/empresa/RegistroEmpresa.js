Ext.define('myapp.controller.empresa.RegistroEmpresa', {
    extend: 'Ext.app.Controller',
    views: [
        'empresa.RegistroEmpresa',
        'empresa.TabRegistro1',
        'empresa.TabRegistro2',
        'empresa.TabRegistro3',
        'empresa.Verempresa',
        'empresa.Verempresagrid'
    ],
    refs: [{
            ref: 'RegistroEmpresa',
            selector: 'registroempresa'
        }, {
            ref: 'TabRegistro1',
            selector: 'tabregistro1',
        }, {
            ref: 'TabRegistro2',
            selector: 'tabregistro2',
        }, {
            ref: 'TabRegistro3',
            selector: 'tabregistro3',
        },{
            ref: 'Verempresa',
            selector: 'verempresa',
        },{
            ref: 'Verempresagrid',
            selector: 'verempresagrid',
        }],
    init: function (application) {
        this.control({
            "tabregistro1 combobox[name=cmbmunicipio]": {
                select: this.seleccionMunicipio
            },
            "registroempresa": {
                render: this.renderPanelempresa
            },
            "tabregistro1 combobox[name=cmbparroquia]": {
                select: this.seleccionParroquia
            },
            "tabregistro2 combobox[name=cmbseccion]": {
                select: this.seleccionSeccion
            },
            "tabregistro2 combobox[name=cmbdivisionact]": {
                select: this.seleccionDivision
            },
            "tabregistro2 combobox[name=cmbgrupo]": {
                select: this.seleccionGrupo
            },
             "tabregistro2 combobox[name=cmbclase]": {
                select: this.seleccionClase
            },
            "registroempresa button[name=guardar]": {
                click: this.onButtonClickSave
            },
             "registroempresa button[name=btncatalogo]": {
                click: this.onButtonClickcatalogo
            },
             "verempresagrid button#agregar": {
                click: this.onButtonClickagregar
            },
            "verempresagrid itemclick": { // #2
                click: this.onclick   
            },
             "registroempresa button[name=limpiar]": {
                click: this.onButtonClicklimpiar
            },
            "tabregistro2 button[name=pdfClasificador]":{
                click: this.pdfClasificador
            },


        });
    },
     pdfClasificador: function(){
        window.open(BASE_URL +'pdfs/pdf/planilla?file=Clasificador.pdf');  
    },   
    
    onButtonClicklimpiar: function (button, e, options) {
        //form = this.getRegistroEmpresa();
        //form.getForm().reset();
    },
    onclick:function(dv, record, item, index, e) {
         var grid = this.getVerempresagrid();
        var win=this.getVerempresa();
        record = grid.getSelectionModel().getSelection();
        if(record[0]){
            this.getRegistroEmpresa().getForm().reset();
            formulario = this.getRegistroEmpresa();
            empresaStore = Ext.create('myapp.store.empresa.VerempresaStore');
            rif = record[0].get('rif');
            console.log(rif);
            empresaStore.proxy.extraParams.rif = rif;
            empresaStore.load(function (records, operation, success) {
                empresaStore.each(function (record) {
                    formulario.down("combobox[name=rif]").setReadOnly(true);
                    formulario.down("textfield[name=rif1]").setReadOnly(true);
                    formulario.down("textfield[name=rif2]").setReadOnly(true);
                    formulario.down("textarea[name=razonsoc]").setReadOnly(true);

                    formulario.getForm().loadRecord(record);
                    grid.close();
                    win.close();
                          
                })
            })
        } 
    },
    onButtonClickagregar: function () {
        var grid = this.getVerempresagrid();
        var win=this.getVerempresa();
        record = grid.getSelectionModel().getSelection();
        if(record[0]){
            this.getRegistroEmpresa().getForm().reset();
            formulario = this.getRegistroEmpresa();
            empresaStore = Ext.create('myapp.store.empresa.VerempresaStore');
            rif = record[0].get('rif');
            console.log(rif);
            empresaStore.proxy.extraParams.rif = rif;
            empresaStore.load(function (records, operation, success) {
                empresaStore.each(function (record) {
                    formulario.down("combobox[name=rif]").setReadOnly(true);
                    formulario.down("textfield[name=rif1]").setReadOnly(true);
                    formulario.down("textfield[name=rif2]").setReadOnly(true);
                    formulario.down("textarea[name=razonsoc]").setReadOnly(true);
                    formulario.getForm().loadRecord(record);
                    grid.close();
                    win.close();
                          
                })
            })
        } 
    } ,   
    onButtonClickcatalogo: function () {
        var editWindow = Ext.create('myapp.view.empresa.Verempresa');
        editWindow.show();
    },
    renderPanelempresa: function () {
        this.getRegistroEmpresa().getForm().reset();

        formulario = this.getRegistroEmpresa();
        empresaStore = Ext.create('myapp.store.empresa.EmpresaStore');
        empresaStore.load(function (records, operation, success) {
            empresaStore.each(function (record) {
                if (record.get('total') == 1) {
                    formulario.down("combobox[name=rif]").setReadOnly(true);
                    formulario.down("textfield[name=rif1]").setReadOnly(true);
                    formulario.down("textfield[name=rif2]").setReadOnly(true);
                    formulario.down("textarea[name=razonsoc]").setReadOnly(true);
                    formulario.down("combobox[name=nacionalidadrep]").setReadOnly(true);
                    formulario.down("textfield[name=cedularep]").setReadOnly(true);
                    formulario.down("button[name=btncatalogo]").setVisible(false);
                    formulario.getForm().loadRecord(record);
                  
                }
            })
        })
    },
    onButtonClickSave: function (button, e, options) {
        var formPanel = button.up('form');
        var form = this.getRegistroEmpresa();
        var tab1 = this.getTabRegistro1();
        var tab2 = this.getTabRegistro2();
        var tab3 = this.getTabRegistro3();
        me = this;
        console.log(form.down("textfield[name=rif1]").getValue().length);
        if (form.down("textfield[name=rif1]").getValue().length == 8) 
        {    if (form.down("textfield[name=cedularep]").getValue().length == 8) 
            {
                if( form.down("textfield[name=registromer]").getValue()!="" &&
                    form.down("textfield[name=anoact]").getValue()!="" &&
                    form.down("textarea[name=razonsoc]").getValue()!="" &&
                    form.down("textfield[name=anoact]").getValue()!="" &&
                    tab1.down("combobox[name=cmbestado]").getValue()!="" &&
                    tab1.down("combobox[name=cmbmunicipio]").getValue()!="" &&
                    tab1.down("combobox[name=cmbparroquia]").getValue()!="" &&
                    tab1.down("combobox[name=cmbcomunidad]").getValue()!="" &&
                    tab2.down("combobox[name=cmbseccion]").getValue()!="" &&
                    tab2.down("combobox[name=cmbdivisionact]").getValue()!="" &&
                    tab2.down("combobox[name=cmbgrupo]").getValue()!="" &&
                    tab2.down("combobox[name=cmbclase]").getValue()!="" &&
                    tab2.down("combobox[name=cmbrama]").getValue()!="" &&
                    tab1.down("combobox[name=cmbestado]").getRawValue()!=0 &&
                    tab1.down("combobox[name=cmbmunicipio]").getRawValue()!=0 &&
                    tab1.down("combobox[name=cmbparroquia]").getRawValue()!=0 &&
                    tab1.down("combobox[name=cmbcomunidad]").getRawValue()!=0 &&
                    tab2.down("combobox[name=cmbseccion]").getRawValue()!=0 &&
                    tab2.down("combobox[name=cmbdivisionact]").getRawValue()!=0 &&
                    tab2.down("combobox[name=cmbgrupo]").getRawValue()!=0 &&
                    tab2.down("combobox[name=cmbclase]").getRawValue()!=0 &&
                    tab2.down("combobox[name=cmbrama]").getRawValue()!=0 &&
                    form.down("textfield[name=rif2]").getValue().length == 1)
                {
                    if( ((tab3.down("combobox[name=nacionalidadcont]").getRawValue()!="" && tab3.down("combobox[name=nacionalidadcont]").getRawValue()!=0 && tab3.down("textfield[name=cedulacont]").getValue()!="") && tab3.down("textfield[name=nombrecont]").getValue()=="") ||
                    ((tab3.down("combobox[name=nacionalidadcont]").getRawValue()=="" && tab3.down("combobox[name=nacionalidadcont]").getRawValue()==0 && tab3.down("textfield[name=cedulacont]").getValue()=="") && tab3.down("textfield[name=nombrecont]").getValue()!="") )
                    {
                          Ext.Msg.show({
                                    title: 'Fallo!',
                                    msg: "Debe Introducir los Datos de la persona de contacto (Cedula y Nombre) ",
                                    icon: Ext.Msg.ERROR,
                                    buttons: Ext.Msg.OK
                                });
                   }
                    else 
                    {
                            var myMask = new Ext.LoadMask(Ext.getBody(), {msg:"Por favor espere..."});
                            myMask.show();
                            var id = form.down("textfield[name=id]").getValue();
                            var rif = form.down("combobox[name=rif]").getValue();
                            var rif1 = form.down("textfield[name=rif1]").getValue();
                            var rif2 = form.down("textfield[name=rif2]").getValue();
                            var nombrecomer = form.down("textfield[name=nombrecomer]").getValue();
                            var anoact = form.down("textfield[name=anoact]").getValue();
                            var registromer = form.down("textfield[name=registromer]").getValue();
                            var razonsoc = form.down("textfield[name=razonsoc]").getValue();
                            var tipo = form.down("combobox[name=tipo]").getValue();
                            var nacionalidadrep = tab3.down("textfield[name=nacionalidadrep]").getRawValue();
                            var cedularep = tab3.down("textfield[name=cedularep]").getValue();
                            var representante = tab3.down("textfield[name=representante]").getValue();
                            var codmovilrep = tab3.down("combobox[name=codmovilrep]").getValue();
                            var movilrep = tab3.down("textfield[name=movilrep]").getValue();
                            var nombrecont = tab3.down("textfield[name=nombrecont]").getValue();

                            var codmovilcont =tab3.down("combobox[name=codmovilcont]").getValue();
                            var movilcont = tab3.down("textfield[name=movilcont]").getValue();
                            var cedulacont = tab3.down("textfield[name=cedulacont]").getValue();
                            var nacionalidadcont = tab3.down("textfield[name=nacionalidadcont]").getRawValue();
                            var cmbestado = tab1.down("combobox[name=cmbestado]").getValue();
                            var cmbmunicipio = tab1.down("combobox[name=cmbmunicipio]").getValue();
                            var cmbparroquia = tab1.down("combobox[name=cmbparroquia]").getValue();
                            var cmbcomunidad = tab1.down("combobox[name=cmbcomunidad]").getValue();
                            var direccion = tab1.down("textareafield[name=direccion]").getValue();
                            var codmovilemp = tab1.down("combobox[name=codmovilemp]").getValue();
                            var movilemp = tab1.down("textfield[name=movilemp]").getValue();
                            var codfijoemp = tab1.down("combobox[name=codfijoemp]").getValue();
                            var fijoemp = tab1.down("textfield[name=fijoemp]").getValue();
                            var codfaxemp = tab1.down("textfield[name=codfaxemp]").getValue();
                            var faxemp = tab1.down("textfield[name=faxemp]").getValue();
                            var correoemp = tab1.down("textfield[name=correoemp]").getValue();
                            var pagwebemp = tab1.down("textfield[name=pagwebemp]").getValue();
                            var facebookemp = tab1.down("textfield[name=facebookemp]").getValue();
                            var twitteremp = tab1.down("textfield[name=twitteremp]").getValue();
                            var seleccioncamara1 = tab2.down("checkboxfield[name=seleccioncamara1]").getValue();
                            var seleccioncamara2 = tab2.down("checkboxfield[name=seleccioncamara2]").getValue();
                            var seleccioncamara3 = tab2.down("checkboxfield[name=seleccioncamara3]").getValue();
                            var seleccioncamara4 = tab2.down("checkboxfield[name=seleccioncamara4]").getValue();
                            var seleccioncamara5 = tab2.down("checkboxfield[name=seleccioncamara5]").getValue();
                            var cmbseccion = tab2.down("combobox[name=cmbseccion]").getValue();
                            var cmbdivision = tab2.down("combobox[name=cmbdivisionact]").getValue();
                            var cmbgrupo = tab2.down("combobox[name=cmbgrupo]").getValue();
                            var cmbclase = tab2.down("combobox[name=cmbclase]").getValue();
                            var cmbrama = tab2.down("combobox[name=cmbrama]").getValue();
                            Ext.Ajax.request({
                                url: BASE_URL + 'empresa/empresa/guardarempresa',
                                method: 'POST',
                                params: {
                                    id: id,
                                    rif: rif,
                                    rif1: rif1,
                                    rif2: rif2,
                                    nombrecomer: nombrecomer,
                                    anoact: anoact,
                                    registromer: registromer,
                                    razonsoc: razonsoc,
                                    nacionalidadrep: nacionalidadrep,
                                    cedularep: cedularep,
                                    representante: representante,
                                    codmovilrep: codmovilrep,
                                    movilrep: movilrep,
                                    tipo: tipo,
                                    nombrecont: nombrecont,
                                    codmovilcont:codmovilcont,
                                    movilcont:movilcont,
                                    nacionalidadcont: nacionalidadcont,
                                    cedulacont: cedulacont,
                                    
                                    cmbestado: cmbestado,
                                    cmbmunicipio: cmbmunicipio,
                                    cmbparroquia: cmbparroquia,
                                    cmbcomunidad: cmbcomunidad,
                                    direccion: direccion,
                                    codmovilemp: codmovilemp,
                                    movilemp: movilemp,
                                    codfijoemp: codfijoemp,
                                    fijoemp: fijoemp,
                                    codfaxemp: codfaxemp,
                                    faxemp: faxemp,
                                    correoemp: correoemp,
                                    pagwebemp: pagwebemp,
                                    facebookemp: facebookemp,
                                    twitteremp: twitteremp,
                                    seleccioncamara1: seleccioncamara1,
                                    seleccioncamara2: seleccioncamara2,
                                    seleccioncamara3: seleccioncamara3,
                                    seleccioncamara4: seleccioncamara4,
                                    seleccioncamara5: seleccioncamara5,
                                    cmbseccion: cmbseccion,
                                    cmbdivision: cmbdivision,
                                    cmbgrupo: cmbgrupo,
                                    cmbclase: cmbclase,
                                    cmbrama: cmbrama
                                },
                                failure: function (conn, response, options, eOpts) {
                                    Ext.Msg.show({
                                        title: 'Fallo!',
                                        msg: result.msg,
                                        icon: Ext.Msg.ERROR,
                                        buttons: Ext.Msg.OK
                                    });
                                },
                                success: function (conn, response, options, eOpts) {
                                    var result = Ext.JSON.decode(conn.responseText, true);
                                    if (result.success) {
                                        Ext.Msg.alert('Exito', result.msg);
                                        myMask.hide();
                                        //form.close();
                                        //win.close();
                                        grid.getView().refresh(true);
                                        grid.getStore().load();
                                    } else {
                                        Ext.Msg.alert('Error', 'Falta seleccionar algún campo');
                                    }
                                }
                            });
                    }
                }
                else
                {
                     Ext.Msg.show({
                                    title: 'Fallo!',
                                    msg: "Debe llenar todos los campos obligatorios (*) ",
                                    icon: Ext.Msg.ERROR,
                                    buttons: Ext.Msg.OK
                                });
                }
            }else
            {
                Ext.Msg.show({
                    title: 'Fallo!',
                    msg: "La Cedula debe tener 8 Caracteres ",
                    icon: Ext.Msg.ERROR,
                    buttons: Ext.Msg.OK
                });
            }
        }  
       
        else{
             Ext.Msg.show({
                                title: 'Fallo!',
                                msg: "El Rif debe tener 8 Caracteres",
                                icon: Ext.Msg.ERROR,
                                buttons: Ext.Msg.OK
                            });
        }
    },
    seleccionMunicipio: function (button, combobox, e, options) {
        console.log('Hola');
        var formPanel = this.getTabRegistro1();
        parroquiaStore = formPanel.down("combobox[name=cmbparroquia]").getStore();
        parroquiaStore = formPanel.down("combobox[name=cmbparroquia]").getStore();
        formPanel.down("combobox[name=cmbparroquia]").clearValue();
        formPanel.down("combobox[name=cmbparroquia]").setDisabled(false);
  
        municipio = formPanel.down("combobox[name=cmbmunicipio]").getValue(                            )
        parroquiaStore.proxy.extraParams.municipio = municipio;
        parroquiaStore.load();
    },
    seleccionSeccion: function (button, combobox, e, options) {

        var formPanel = this.getTabRegistro2();
        divisionStore = formPanel.down("combobox[name=cmbdivisionact]").getStore();
        divisionStore = formPanel.down("combobox[name=cmbdivisionact]").getStore();
        formPanel.down("combobox[name=cmbdivisionact]").clearValue();
        formPanel.down("combobox[name=cmbdivisionact]").setDisabled(0);
        seccion = formPanel.down("combobox[name=cmbseccion]").getValue();
        seccion = formPanel.down("combobox[name=cmbseccion]").getValue(                            )
        divisionStore.proxy.extraParams.seccion = seccion;
        divisionStore.load();
    },
    seleccionDivision: function (button, combobox, e, options) {
        console.log('Hola');
        var formPanel = this.getTabRegistro2();
        grupoStore = formPanel.down("combobox[name=cmbgrupo]").getStore();
        grupoStore = formPanel.down("combobox[name=cmbgrupo]").getStore();
        formPanel.down("combobox[name=cmbgrupo]").clearValue();
        formPanel.down("combobox[name=cmbgrupo]").setDisabled(0);
        division = formPanel.down("combobox[name=cmbdivisionact]").getValue();
        division = formPanel.down("combobox[name=cmbdivisionact]").getValue(                            )
        grupoStore.proxy.extraParams.division = division;
        grupoStore.load();
    },
    seleccionGrupo: function (button, combobox, e, options) {
        console.log('Hola');
        var formPanel = this.getTabRegistro2();
        claseStore = formPanel.down("combobox[name=cmbclase]").getStore();
        claseStore = formPanel.down("combobox[name=cmbclase]").getStore();
        formPanel.down("combobox[name=cmbclase]").clearValue();
        formPanel.down("combobox[name=cmbclase]").setDisabled(0);
        grupo = formPanel.down("combobox[name=cmbgrupo]").getValue(                            )
        claseStore.proxy.extraParams.grupo = grupo;
        claseStore.load();
    },
    seleccionClase: function (button, combobox, e, options) {
        console.log('Hola');
        var formPanel = this.getTabRegistro2();
        ramaStore = formPanel.down("combobox[name=cmbrama]").getStore();
        claseStore = formPanel.down("combobox[name=cmbrama]").getStore();
        formPanel.down("combobox[name=cmbrama]").clearValue();
        formPanel.down("combobox[name=cmbrama]").setDisabled(0);
        clase = formPanel.down("combobox[name=cmbclase]").getValue(                            )
        claseStore.proxy.extraParams.clase = clase;
        claseStore.load();
    },
    seleccionParroquia: function (button, combobox, e, options) {
        console.log('Hola');
        var formPanel = this.getTabRegistro1();
        comunidadStore = formPanel.down("combobox[name=cmbcomunidad]").getStore();
        comunidadStore = formPanel.down("combobox[name=cmbcomunidad]").getStore();
        formPanel.down("combobox[name=cmbcomunidad]").clearValue();
        formPanel.down("combobox[name=cmbcomunidad]").setDisabled(0);
        parroquia = formPanel.down("combobox[name=cmbparroquia]").getValue(                            )
        comunidadStore.proxy.extraParams.parroquia = parroquia;
        comunidadStore.load();
    },
});