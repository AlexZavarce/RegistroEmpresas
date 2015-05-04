Ext.define('myapp.view.empresa.Verempresagrid', {
	extend: 'Ext.grid.Panel',
	alias: 'widget.verempresagrid',
	itemId: 'verempresagrid',

	requires: [
        'Ext.selection.CellModel', 
        'Ext.selection.CheckboxModel',
        'Ext.ux.ajax.SimManager',
        'Ext.ux.grid.FiltersFeature',
    ],
    features:[{
        ftype: 'filters',
        local: true
	},{
    	id: 'group',
    	ftype: 'groupingsummary',
    	
    	groupHeaderTpl:'<font size=2><font size=2>{name}</font>',
    	hideGroupedHeader: true,
    	enableGroupingMenu: false
    }], 
    viewConfig: {
    },
	store: Ext.create('myapp.store.empresa.Verempresagrid'),
	selType: 'checkboxmodel',
	//selModel: selModel,
	columnLines: true,
	initComponent : function(){
	    var me = this;
	    me.columns= me.buildColumns();
	    me.dockedItems = me.buildDockedItems();
	    me.callParent();
	 },
	 
	buildColumns: function(){
		return [{ 
			dataIndex: 'rif',
			flex: 0.2,
			text: 'Rif',
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
		                        property     : 'rif',
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
			dataIndex: 'razonsoc',
			flex: 0.5,
			text: 'Razón Social',
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
		                        property     : 'razonsoc',
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
			dataIndex: 'cedularep',
			text: 'Cédula Representante Legal',
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
		                        property     : 'cedularep',
		                        value         : this.value,
		                        anyMatch      : true,
		                        caseSensitive : false
		                    });
			            }
				    },
				    buffer: 500
				}
			}
		}]
	},
	buildDockedItems : function(){
		return [{
			xtype:'pagingtoolbar',
			dock:'bottom',
			store:this.store,
			displayInfo:true,
			items: [{ 
					xtype: 'button',
                    id      :'agregar',
        			text    : 'Agregar',
        			iconCls:'aceptar'
                 }]
		}];
	}
});