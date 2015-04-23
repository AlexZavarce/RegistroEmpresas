Ext.define('myapp.view.seguridad.Empleadolista', {
	extend: 'Ext.grid.Panel', 
	alias: 'widget.empleadolista',
	itemId: 'empleadolista',
	requires: [
        'Ext.selection.CellModel', 
        'Ext.selection.CheckboxModel',
        'Ext.ux.ajax.SimManager',
        'Ext.ux.grid.FiltersFeature',
        'Ext.grid.column.Action'
    ],
    features    : [{
        ftype: 'filters',
        local: true,
	},{
    	id: 'group',
    	ftype: 'groupingsummary',
    	groupHeaderTpl:'<font size=2><font size=2>{name}</font>',
    	hideGroupedHeader: true,
    	enableGroupingMenu: false
    }],
    viewConfig: {   
    	getRowClass: function(record, index) {
			var c = record.get('estatus');
			if (c == 'Inactivo') {
				return 'price-fall';
			} else if (c == 'Activo') {
				return 'price-rise';
			}
		}, 
    },
	store: Ext.create('myapp.store.seguridad.Empleado'),
	selType: 'checkboxmodel',
	emptyText   : 'No hay datos registrados',
	columnLines: true,
	initComponent : function(){
	    var me = this;
	    me.columns= me.buildColumns();
	    me.callParent();
	},
	buildColumns: function(){
		return [{ 
			dataIndex: 'id',
			flex: 0.2,
			text: 'ID',
			//hidden: true,
			items    : {
				xtype: 'textfield',
				flex : 1,
				margin: 2,
				enableKeyEvents: true,
				listeners: {
				    keyup: function() {
			           	var store = this.up('grid').store;
			           	store.clearFilter();
			            if (this.value) {
		                   	store.filter({
		                        property     : 'id',
		                        value         : this.value,
		                        anyMatch      : true,
		                        caseSensitive : false
		                    });
			            }
				    },
				    buffer: 500
				}
			}
		},{ 

			dataIndex: 'nombres',
			flex: 0.4,
			text: 'Nombre y Apellido',
			//hidden: true,
			items    : {
				xtype: 'textfield',
				flex : 1,
				margin: 2,
				enableKeyEvents: true,
				listeners: {
				    keyup: function() {
			           	var store = this.up('grid').store;
			           	store.clearFilter();
			            if (this.value) {
		                   	store.filter({
		                        property     : 'nombres',
		                        value         : this.value,
		                        anyMatch      : true,
		                        caseSensitive : false
		                    });
			            }
				    },
				buffer: 500
				}
			}
		},{ 

			dataIndex: 'apellido',
			flex: 0.4,
			text: 'Apellidos',
			hidden:true
		},{ 
			dataIndex: 'sexo',
			flex: 0.4,
			text: 'Sexo',
			hidden:true
		},{ 
			dataIndex: 'correo',
			flex: 0.4,
			text: 'correo',
			hidden:true
		},{ 
			dataIndex: 'edocivil',
			flex: 0.4,
			text: 'Edo-civil',
			hidden:true
		},{ 
			dataIndex: 'fechanac',
			flex: 0.4,
			text: 'Fecha-Nacimiento',
			hidden:true
		},{ 
			width: 250,
			dataIndex: 'nacionalidad',
			text: 'Nacionalidad',
			hidden:true
		},{ 
			width: 250,
			dataIndex: 'direccion',
			text: 'direccion',
			hidden:true
		},{ 
			width: 250,
			dataIndex: 'movil',
			text: 'movil',
			hidden:true
		},{ 
			width: 250,
			dataIndex: 'fijo',
			text: 'fijo',
			hidden:true
		},{ 
			width: 250,
			dataIndex: 'codfijo',
			text: 'Codigo fijo',
			hidden:true
		},{ 
			width: 250,
			dataIndex: 'codmovil',
			text: 'codigo movil',
			hidden:true
		},{ 
			width: 250,
			dataIndex: 'hijos',
			text: 'Hijos',
			hidden:true
		},{ 
			width: 250,
			dataIndex: 'canthijos',
			text: 'Cantidad de Hijos',
			hidden:true
		},{ 
			width: 250,
			dataIndex: 'profesion',
			text: 'Profesion',
			hidden:true
		},{ 
			dataIndex: 'cedula',
			flex: 0.2,
			text: 'Cedula',
			hidden:true,
			items    : {
				xtype: 'textfield',
				flex : 1,
				margin: 2,
				enableKeyEvents: true,
				listeners: {
				    keyup: function() {
			           	var store = this.up('grid').store;
			           	store.clearFilter();
			            if (this.value) {
		                   	store.filter({
		                        property     : 'cedula',
		                        value         : this.value,
		                        anyMatch      : true,
		                        caseSensitive : false
		                    });
			            }
				    },
				buffer: 500
				}
			}
		},{ 
			dataIndex: 'divisionnombre',
			flex: 0.3,
			text: 'divisionnombre',
		},{ 
			dataIndex:'division',
			flex: 0.3,
			text: 'division',
			hidden:true,
		},{
			width: 250,
			text: 'horario',
			dataIndex: 'horario',
			hidden:true,
			       
		},{
			flex: 0.50,
			dataIndex: 'tiponomina',
			text: 'Tipo Nomina',
			items    : {
				xtype: 'textfield',
				flex : 1,
				margin: 2,
				enableKeyEvents: true,
				listeners: {
				    keyup: function() {
			           	var store = this.up('grid').store;
			           	store.clearFilter();
			            if (this.value) {
		                   	store.filter({
		                        property     : 'tiponomina',
		                        value         : this.value,
		                        anyMatch      : true,
		                        caseSensitive : false
		                    });
			            }
				    },
				    buffer: 500
				}
			}
		},{
			width: 250,
			text: 'cargo',
			dataIndex: 'cargo',
			hidden:true,
			       
		},{
			width: 250,
			text: 'foto',
			dataIndex: 'foto',
			//hidden: true
		},{
			flex: 0.7,
			dataIndex: 'fechaingreso',
			text: 'Fecha de Ingreso',
			items    : {
				xtype: 'textfield',
				flex : 1,
				margin: 2,
				enableKeyEvents: true,
				listeners: {
				    keyup: function() {
			           	var store = this.up('grid').store;
			           	store.clearFilter();
			            if (this.value) {
		                   	store.filter({
		                        property     : 'fechaingreso',
		                        value         : this.value,
		                        anyMatch      : true,
		                        caseSensitive : false
		                    });
			            }
				    },
				buffer: 500
				}
			}
		},{ 
			dataIndex: 'estatus',
			flex: 0.2,
			text: 'Estatus',
			tdCls: 'x-change-cell',
			queryMode: 'local',      
			items    : {
				xtype: 'textfield',
				flex : 1,
				margin: 2,
				enableKeyEvents: true,

				listeners: {
				    keyup: function() {
			           	var store = this.up('grid').store;
			           	store.clearFilter();
			            if (this.value) {
		                   	store.filter({
		                        property     : 'estatus',
		                        value         : this.value,
		                        anyMatch      : true,
		                        caseSensitive : false
		                    });
			            }
				    },
				   
				buffer: 500
				}
			}
		},{
	        xtype: 'actioncolumn',
	        flex: 0.1,
	        id: 'modificar',
	        name:'modificar',
	        sortable: false,
	        menuDisabled: true,
	        items: [{
	            icon: '../../imagen/btn/edit.png',
	            tooltip: 'Modificar',
	            scope: this,
	            /*getClass: function(value,metadata,record) {
		            var c = record.get('status');
		            if (c == 'Procesada' || c=='Anulado') {
		                return 'x-hide-display';
		            } else if (c == 'Sin procesar') {
		                return 'x-grid-center-icon';
		            }
		        }*/
	        }]
	    }]
	},
	
});
 