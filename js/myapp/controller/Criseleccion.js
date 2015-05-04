Ext.define('myapp.view.reportes.Criseleccion', {
	extend: 'Ext.window.Window',
	alias: 'widget.criseleccion',
	modal:true,
	autoShow: true,
	height: 290,
	width: 850,
	title: 'Criterios de Selección',
	layout: {
		type: 'fit'
	},
	requires:[
        'myapp.vtypes.Validadores'
    ],
	initComponent: function() {
	var me = this;
	me.items = me.buildItem();
	me.callParent();
	},
	buildItem : function(){
		return [{   
			xtype: 'form',
			bodyPadding: 30,
			items:[{
				xtype: 'fieldset',
				flex: 2,
				width:'60%',
				title: '',
				items: [{
					xtype: 'container',
					layout: 'hbox',
					items: [{
                        xtype: 'combobox',
                        editable: false,  
                        name: 'rif',
                        editable: false, 
                        fieldLabel: 'R.I.F', 
                        labelWidth: 60,
                        width: 130,
                        value:'V',
                        //margins:'10 5 5 0',
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
                        //margins:'10 5 5 0',
                        maskRe: /[0-9]/,
                        name: 'rif1',
                        width:100,
                        minLength:6,
                        maxLength:8,
                        allowBlank: false
                    },{
                        xtype: 'textfield',
                        labelWidth: 50,
                        //margins:'10 5 5 0',
                        maskRe: /[0-9]/,
                        name: 'rif2',
                        width:40,
                        minLength:1,
                        maxLength:1,
                        allowBlank: false
                    },{
                         xtype: 'textfield',
                        name: 'nombrecomer',
                        margins:'0 0 0 5',
                        width:380,
                        fieldLabel: 'Nombre Comercial',
                        labelWidth: 115,
                    },{
                        xtype: 'textfield',
                        name: 'anoact',
                        width:110,
                        //margins:'0 0 0 1',
                        fieldLabel: 'Años en Actividad',
                        labelWidth: 60,
                    },]
				},{
					xtype: 'fieldcontainer',
					layout: {type: 'hbox'},
					items: [{
						xtype: 'combobox',
						width: 290,
						fieldLabel: 'Cedula',
						name:'cmbcedula',
						editable:true,
						margins:'0 2 20 0',
						emptyText:' ',
						store :Ext.create('myapp.store.reportes.Cedula'),
						valueField: 'cedula',
						displayField: 'cedula',
						queryMode: 'remote',
						labelWidth: 50,
						typeAhead:true,
						typeAheadDelay: 100,
					},{
						xtype : 'datefield',
						width     : 250,
				        margins   : '0 0 0 0',
				        labelWidth: 50,
				        fieldLabel: 'Desde',
				        name      : 'cmbfechades',
				        id        : 'cmbfechades',
				        vtype: 'daterange',
                		endDateField: 'cmbfechahas', // id of the end date field
					},{
						xtype : 'datefield',
						width     : 200,
				        margins   : '0 0 0 0',
				        labelWidth: 55,
				        fieldLabel: 'Hasta',
				        name      : 'cmbfechahas',
				        id        : 'cmbfechahas',
				        vtype: 'daterange',
                		startDateField: 'cmbfechades',
					}]
				},{
	               	xtype: 'fieldcontainer',
					layout: {type: 'hbox'},
					items: [{
		                xtype: 'checkboxfield',
		                name:'observa',
		                value:'observa',
		                boxLabel: 'Observación',
		                inputValue: '9',
		                id:'9',
		                Widthlabel:300,
		                heightlabel:300,
		                hidden: true,
		                style: 'margin-bottom: 20px',
		                cheked:false
		            },{
		            	xtype: 'fieldcontainer',
						layout: {type: 'hbox'},
						boxLabel:'Tipo-Nomina',
						items: [{
	                        xtype: 'textareafield',
	                        minLength:1,
	                        labelWidth:85,
	                        maxLength:1000,
	                        name:'txtobservacion',
	                       	hidden: true,
	                        width:470
	               		},{
							xtype: 'combobox',
							width: 160,
							fieldLabel: 'Nomina',
							name:'cmbtipo',
							hidden: true,
							allowBlank:true,
							forceSelection:true,
							store :Ext.create('myapp.store.reportes.Tiponomina'),
							valueField: 'id',
							displayField: 'nombre',
							queryMode: 'remote',
							labelWidth: 50,
							typeAhead:true,
						},{ 
				            xtype: 'button',
				            itemId: 'saverepasi',
				           	name:'saverepasi',
				           	margins:'3 0 0 0',
				            iconCls: 'save',
				            hidden: true,
						},],
			        }]
				}]
			}],
			dockedItems: [{
				xtype: 'toolbar',
				dock: 'bottom',
				ui: 'footer',
				items: [{
					xtype: 'tbfill'
					},{
						xtype: 'button', 
						itemId: 'generar',
						iconCls: 'generar',
						name: 'generar',
						text: "Generar reporte"
					},{
						xtype: 'button',
						text: 'Generar asistencia',
						iconCls:'generar',
						itemId: 'asistencia',
						name: 'asistencia',
					},{
		                xtype: 'combobox',
		               	width: 160,
						fieldLabel: 'Formato',
						name:'cmbformato',
						hidden: true,
						allowBlank:true,
						forceSelection:true,
						store :Ext.create('myapp.store.reportes.Formatorep'),
						valueField: 'nombre',
						displayField: 'nombre',
						queryMode: 'local',
						labelWidth: 55,
						typeAhead:true,
					},{
						xtype: 'button',
						text: 'Generar permisos',
						iconCls:'generar',
						itemId: 'permisos',
						name: 'permisos',
					},{
						xtype: 'button',
						text: 'Asistencia semanal',
						iconCls:'generar',
						itemId: 'semanal',
						name: 'semanal',
					},{
						xtype: 'button',
						text: 'Limpiar',
						iconCls:'limpiar',
						tooltip: 'Limpiar',
						itemId: 'limpiar',
					}
				]
			}]
		}]
	}
}); 