Ext.define('myapp.view.seguridad.Registroempleado', {
	extend: 'Ext.window.Window',
	alias: 'widget.registroempleado',
	height: 600,
	width: 800,
	modal:true,
	draggable:false,
	requires: ['myapp.util.Util'],
	resizable:false,
	layout: {
		type: 'fit'
	},
	title: 'Registro del Empleado',
	initComponent: function() {
    var me = this;
    me.items = me.buildItem();
    me.dockedItems = me.buildDockedItems();
    me.callParent();
  	},
	buildItem : function(){
        return [{   
			xtype: 'form',
			bodyPadding: 10,
			layout: {
				type: 'hbox', 
				align: 'stretch'
				},
			items:
			[{
				xtype: 'fieldset',
				itemId:'personal' ,
				title: 'Datos-Personales',
				flex: 2,
				defaults: {
					anchor: '90%',
					xtype: 'textfield',
					//allowBlank: false,
					labelWidth: 70
					},
				items: [{
			         xtype: 'container',
	                layout: 'hbox',
			    	items: [{
	                    xtype: 'combobox',
	                    editable: false,  
	                    name: 'nacionalidad',
	                    editable: false, 
	                    fieldLabel: 'Cedula', 
	                    labelWidth: 80,
	                    width: 130,
	                    value:'V',
	                    margins:'10 5 5 0',
	                    selecOnFocus: true,
	                   	store: Ext.create('myapp.store.Nacionalidad'),
	                    valueField: 'nombre',
	                    displayField: 'nombre', 
	                    queryMode: 'local',
	                    allowBlank: false, 
	                    forceSelection: true,
	                    triggerAction: 'all',           
	                    editable:false
	                },{
	                    xtype: 'textfield',
	                    labelWidth: 100,
	                    margins:'10 5 5 0',
	                    maskRe: /[0-9]/,
	                    name: 'cedula',
	                    width:210,
	                    minLength:6,
	                    maxLength:8,
	                    allowBlank: false
	                }]}, {
				        fieldLabel: 'Nombres',
				        labelWidth: 80,
				        name: 'nombres',
				        blankText:'Campo obligatorio.. '
				    },{
				    	labelWidth: 80,
				        fieldLabel: 'Apellidos',
				        maxLength: 70,
				        name: 'apellido',
				        blankText:'Campo obligatorio.. ',
				    },{
                    xtype: 'textareafield',
                    width: 450,
                    minLength:3,
                    maxLength:200,
                    //margins:'0 30 0 15',
                    allowBlank: false,
                    name:'direccion',
                    fieldLabel: 'Direccion',
                    labelWidth: 80    
                },{
                    xtype: 'datefield',
                    width: 460,
                    fieldLabel: 'Fecha de <br>Nacimiento',
                    format: "Y/m/d",
                    name:'fechanac',
                    editable: false,
                    maxValue: new Date(),
                    labelWidth: 80,
                    hidden:false
                },{
                    xtype       : 'textfield',
                    fieldLabel  : 'E-mail',
                    width       : 655,
                    margins     : '0 0 0 10',
                    labelWidth  : 80,
                    name        :'correo',
                    vtype       :'correo',
                    allowBlank  : false,
                },{
                    xtype       : 'combobox',
                    fieldLabel  : 'Sexo:',
                    name        : 'sexo',
                    emptyText   :'Seleccionar',
                    editable    : false,
                    labelWidth: 80,
                    margins     : '0 0 0 10',
                    store       : Ext.create('myapp.store.registrar.Sexo'),
                    width       : 655,
                    valueField: 'id',
                    displayField: 'nombre',

                },{
                    xtype: 'combobox',
                    width: 490,
                    fieldLabel: 'Edo. Civil',
                    name:'edocivil',
                    editable:false,
                    margins:'0 6 3 5',
                    forceSelection: true,
                    emptyText:'Seleccione',
                    store :Ext.create('myapp.store.registrar.Edocivil'),// cargar lo que esta en la clase store
                    valueField: 'id',
                    displayField: 'nombre',
                    queryMode: 'local',//revisar
                    allowBlank: false,
                    triggerAction: 'all',
                    labelWidth: 80
                },{
                    xtype       : 'fieldcontainer',
                    layout      : 'hbox',
                    margins     : '0 0 0 10',
                    labelWidth: 80,
                    fieldLabel  : 'Tlf Celular',
                    items:[{
                        xtype       : 'combobox',
                        width       : 80,
                        hiddenLabel : true,
                        name        : 'codmovil',
                        store       : Ext.create('myapp.store.registrar.TelefonoCelular'),
                        displayField:'codigo',
                        valueField  :'codigo',
                        editable    : false
                    },{
                      xtype       : 'textfield',
                      flex        : 1,
                      //allowBlank:false,
                      width       : 420,
                      name        : 'movil',
                      minLength   : 7,
                      maxLength   : 7,
                      maskRe: /[0-9]/,
                  	}]
                },{
                    xtype       : 'fieldcontainer',
                    layout      : 'hbox',
                    margins     : '0 0 0 10',
                    labelWidth: 80,
                    fieldLabel  : 'Tlf Local',
                    items:[{
                        xtype       : 'combobox',
                        width       : 80,
                        hiddenLabel : true,
                        name        : 'codfijo',
                        store       : Ext.create('myapp.store.registrar.TelefonoFijo'),
                        displayField:'codigo',
                        valueField  :'codigo',
                        editable    : false,
                     },{
                        xtype       : 'textfield',
                        flex        : 1,
                        width       : 420,
                        name        : 'fijo',
                        minLength   : 7,
                        maxLength   : 7,
                        
                        vtype       : 'numero'
                    }]
                },{
                    xtype       : 'fieldcontainer',
                    layout      : 'hbox',
                    margins     : '0 0 0 10',
                    labelWidth: 80,
                    fieldLabel  : 'Hijos/Cant.',
                    items:[{
                        xtype       : 'combobox',
                        width       : 80,
                        hiddenLabel : true,
                        name        : 'hijos',
                        store       : Ext.create('myapp.store.seguridad.Hijos'),
                        displayField:'nombre',
                        valueField  :'id',
                        queryMode: 'local',
                        editable    : false
                    },{
                      	xtype       : 'textfield',
                      	flex        : 1,
                      	allowBlank:false,
                      	width       : 420,
                      	name        : 'canthijos',
                      	minLength   : 1,
                      	maxLength   : 2,
                      	maskRe: /[0-9]/,
                      	disabled    : true
                  	}]
                },{
                  xtype: 'combobox',
                  fieldLabel: 'Status',
                  labelWidth: 80,
                  name: 'estatus',
                  displayField: 'nombre',
                  valueField: 'nombre',
                  queryMode: 'local',
                  store: Ext.create('myapp.store.seguridad.Status'),
               }]	
			     },{
	            xtype: 'fieldset',
	            title: 'Datos-Laborales',
	            width: 250,
                items: [{
                      xtype: 'filefield',
                      fieldLabel: 'Foto Empleado',
                      name: 'foto',
                      labelWidth: 80,
                      fileUpload: true,
                      hidden:true,
                      allowBlank:true,
                      disabled:true,
                      itemId:'foto',
                      
                    },{
                      xtype:'form',
                      itemId:'fotografia1',
                      frame: true,
                      disabled:true,
                      hidden:false,
                      border: false,
                      width:150,
                      layout: 'fit',
                      height: 150,
                      autoShow: true,
                      items : [{
                        xtype: 'image',
                        height: 50,
                        width: 50,
                        name:'fotoFrontal1',
                        src: BASE_PATH+'imagen/foto/silueta.png'
                      }]
                    },{ 
                        xtype: 'radiogroup',
                        //hideLabel: true,
                        align: 'center',
                        name:'rdselfoto',
                        //allowBlank:false,
                        
                        width:'100%',
                        pack: 'center',
                        columns:2,
                        items: [{
                          xtype: 'radiofield',
                          name:'seleccionfoto',
                          boxLabel: 'Buscar Foto',
                          style: 'margin-bottom: 20px',
                          inputValue: '2',
                        },{
                          xtype: 'radiofield',
                          name:'seleccionfoto',
                          boxLabel: 'Sin Foto',
                          style: 'margin-bottom: 20px',
                          inputValue: '3',
                          //checked:false
                        }],
                    },{
                        xtype       : 'combobox',
                        fieldLabel: 'Profesión',
                        labelWidth: 70,
                        hiddenLabel : true,
                        name        : 'profesion',
                        store       : Ext.create('myapp.store.seguridad.Profesion'),
                        queryMode: 'local',
                        displayField:'nombre',
                        valueField  :'id',
                        emptyText:'Ninguno',
                        //editable    : false,
                    },{
    			        xtype: 'combobox',
    			        labelWidth: 70,
    			        fieldLabel: 'División',
    			        name:'division',
    			        displayField: 'nombre',
    			        valueField: 'id',
    			        queryMode: 'local',
    			        store: Ext.create('myapp.store.vacaciones.Unidad'),
    				},{
    			        xtype: 'hiddenfield',
    			        fieldLabel: 'Label',
    			        name: 'id'
    			    },{
    			        xtype: 'combobox',
    			        labelWidth: 70,
    			        fieldLabel: 'Horario',
    			        name: 'horario',
    			        displayField: 'hora',
    			        valueField: 'id',
    			        queryMode: 'local',
    			        store: Ext.create('myapp.store.seguridad.Horario'),

    			    },{
    			        xtype: 'combobox',
    			        labelWidth: 70,
    			        fieldLabel: 'Tipo-Nomina',
    			        name: 'tiponomina',
    			        displayField: 'nombre',
    			        valueField: 'id',
    			        queryMode: 'local',
    			        store: Ext.create('myapp.store.reportes.Tiponomina'),

    			    },{
    			        xtype: 'combobox',
    			        labelWidth: 70,
    			        fieldLabel: 'Cargo',
    			        name: 'cargo',
    			        displayField: 'nombre',
    			        valueField: 'id',
    			        queryMode: 'local',
                  allowBlank: false,
    			        store: Ext.create('myapp.store.seguridad.Cargos'),
    			    },{
                  xtype:'datefield', 
                  fieldLabel:'Fecha Ingreso',
                  format:'Y-m-d',
                  name:'fechaingreso',
                  labelWidth:70,
                  editable:true,
                        
              }]
	        }]
		}]
	},
	buildDockedItems : function(){
    	return [{
	        xtype: 'toolbar',
	        flex: 1,
	        dock: 'bottom',
	        ui: 'footer',
	        layout: {
	            pack: 'end',
	            type: 'hbox'
	        },
	        items: [{
	            xtype: 'button',
	            text: 'Cancelar',
	            name: 'cancelar',
	            iconCls: 'cancel'
	        },{
	            xtype: 'button',
	            text: 'Guardar',
	           	name:'guardar',
	            iconCls: 'save'
	        }]
	    }]
	},  
});