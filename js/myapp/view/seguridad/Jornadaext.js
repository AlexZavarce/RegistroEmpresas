Ext.define('myapp.view.seguridad.Jornadaext', {
	extend: 'Ext.form.Panel',
	alias: 'widget.jornadaext',
	itemId: 'jornadaext',
	modal:true,
	autoShow: true,
	height: 400,
	width: 670,
	title: 'Micro-memo',
	layout: {
		type: 'fit'
	},
	initComponent: function() {
	var me = this;
	me.items = me.buildItem();
	me.callParent();
	},
	buildItem : function(){
		return [{   
			xtype: 'form',
			name:'extra',
			bodyPadding: 30,
			items:[{
				xtype: 'fieldset',
				flex: 2,
				title: 'Datos Empleado',
				items: [{
                    xtype: 'textfield',
                    name: 'id',
                    width:300,
                    fieldLabel: 'Id',
                    labelWidth: 70,
                    editable:false,
                    minLength:6,
                    maxLength:8,
                    hidden: true
                },{
					xtype: 'container',
					layout: 'hbox',
					items: [{
                    xtype: 'textfield',
                    name: 'nombres',
                    width:400,
                    margins:'0 2 20 80',
                    fieldLabel: 'Empleado',
                    labelWidth: 100,
                    minLength:6,
                    maxLength:100,
                },{
                    xtype: 'textfield',
                    name: 'cedula',
                    width:300,
                    fieldLabel: 'cedula',
                    labelWidth: 70,
                    editable:false,
                    minLength:6,
                    maxLength:8,
                    hidden: true
                },{
                    xtype: 'textfield',
                    name: 'idemp',
                    width:300,
                    fieldLabel: 'Id',
                    labelWidth: 70,
                    editable:false,
                    minLength:6,
                    maxLength:8,
                    hidden: true
                },{
                    xtype: 'button',
                    name:'buscaremp',
                    width: 23,
                    margins:'0 0 0 6',
                    height:23,
                    iconCls:'icon-responsable',
                    iconAlign: 'right',
                    tooltip  : 'Buscar Empleado',
                },]
			}]
				},{
	            
			},{
				xtype: 'fieldset',
				flex: 3,
				title: 'Días de Jornada Extraordinaria',
				itemId:'jornada',
				items: [{
					xtype: 'container',
					layout: 'hbox',
					items: [{
	                    xtype:'datefield', 
	                    fieldLabel:'Desde',
	                    format:'Y-m-d',
	                    name:'fechadesde',
	                    margin:'0 0 0 20',
	                    labelWidth:40,
	                    editable:true,
	                    width: 160,
	                    value:new Date(),
                	},{
	                    xtype:'datefield', 
	                    fieldLabel:'Hasta',
	                    format:'Y-m-d',
	                    name:'fechahasta',
	                    margin:'0 0 0 50',
	                    labelWidth:50,
	                    editable:true,
	                    width: 160,
	                    value:new Date(), 
                	},
				]
			},]
			
			},{
				xtype: 'fieldset',
				flex: 2,
				title: 'Motivo',
				itemId:'motivo',
				hidden:true,
				items: [{
					xtype: 'container',
					layout: 'vbox',
					items: [{
                        xtype: 'textareafield',
                        fieldLabel:'Descripción',
                        minLength:1,
                        labelWidth:100,
                        maxLength:1000,
                        name:'txtdescripcion',
                        margins:'0 30 5 15',
                        width:920
               		}]
				}]
			},{

				xtype: 'fieldset',
				flex: 2,
				title: 'Observación',
				itemId:'motivo',
				items: [{
					xtype: 'container',
					layout: 'vbox',
					items: [{
                        xtype: 'textareafield',
                        fieldLabel:'Descripción',
                        minLength:1,
                        labelWidth:100,
                        maxLength:1000,
                        name:'txtdescripcion',
                        margins:'0 30 5 15',
                        width:920
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
		            text: 'Cancelar',
		            name: 'cancel',
		            iconCls: 'cancel'
		        },{
		            xtype: 'button',
		            text: 'Guardar',
		           	name:'save',
		            iconCls: 'save'
		        },]
			}]
		}]
	}
}); 