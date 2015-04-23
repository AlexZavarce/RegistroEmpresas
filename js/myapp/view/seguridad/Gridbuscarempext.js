var showSummary = true;
var encode = false;
var local = true;
var filters = {
    ftype: 'filters',        
    encode: encode, // json encode the filter query
    local: local,   // defaults to false (remote filtering)
    filters: [{
        type: 'string',
        dataIndex: 'name',
        value: 'foo',
        active: true, // default is false
        iconCls: 'ux-gridfilter-text-icon' // default
    }],
    features:[{
		ftype:'grouping',
	},{
        ftype: 'filters',
        local: true,
	}] 
};
Ext.define('myapp.view.seguridad.Gridbuscarempext', {
	extend: 'Ext.grid.Panel',
	alias: 'widget.gridbuscarempext',
	itemId: 'gridbuscarempext',

	requires: [
        'Ext.selection.CellModel', 
        'Ext.selection.CheckboxModel',
        'Ext.ux.ajax.SimManager',
        'Ext.ux.grid.FiltersFeature',
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
    },
	store: Ext.create('myapp.store.permisos.EmpleadosGrid'),
	columnLines: true,
	initComponent : function(){
	    var me = this;
	    me.columns= me.buildColumns();
	    me.dockedItems = me.buildDockedItems();
	    me.callParent();
	},
	buildColumns: function(){
		return [{ 
			dataIndex: 'nacionalidad',
			flex: 0.2,
			text: 'Nac.',
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
		                        property     : 'nacionalidad',
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
				flex: 1,
				dataIndex: 'idemp',
				hidden:true,
				text: 'id',
				filter: {
	            	type: 'string'
	            }
	        },{
				flex: 1,
				dataIndex: 'tiponomina',
				text: 'tiponomina',
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
				dataIndex: 'fechaingreso',
				flex: 0.5,
				text: 'Fecha de ingreso',
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
				dataIndex: 'cedula',
				flex: 0.5,
				text: 'Cédula',
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
				dataIndex: 'division',
				flex: 0.5,
				text: 'division',
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
			                        property     : 'division',
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
				flex: 1,
				dataIndex: 'nombres',
				text: 'Nombres',
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
				flex: 1,
				dataIndex: 'foto',
				hidden:true,
				text: 'Fotos',
				filter: {
	            	type: 'string'
	            }
			}]
	},
	buildDockedItems : function(){
		return [{
			xtype:'pagingtoolbar',
			dock:'bottom',
			store:this.store,
			displayInfo:true,
			items: [{ xtype: 'button',
                name      :'agregar',
    			text    : 'Agregar',
    			iconCls:'aceptar'
            }]
		}];
	}
});