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
Ext.define('myapp.view.seguridad.Griddiaferiado', {
	extend: 'Ext.grid.Panel',
	alias: 'widget.griddiaferiado',
	itemId: 'griddiaferiado',
	requires: [
        'Ext.selection.CellModel', 
        'Ext.selection.CheckboxModel',
        'Ext.ux.ajax.SimManager',
        'Ext.ux.LiveSearchGridPanel',
        'Ext.ux.grid.FiltersFeature',
        'Ext.grid.plugin.CellEditing',
    ],
    plugins     : [Ext.create('Ext.grid.plugin.CellEditing',{pluginId: 'rowediting',clicksToEdit: 1})],
    features    : [{
        ftype: 'filters',
        local: true,
	}],
    viewConfig: {
    },
	store: Ext.create('myapp.store.seguridad.Diasferiados'),
	selType: 'checkboxmodel',
	columnLines: true,
	initComponent : function(){
	    var me = this;
	    me.plugins = [Ext.create('Ext.grid.plugin.CellEditing', { // #5
            clicksToEdit: 1,
            pluginId: 'cellplugin'
         })];
	    me.columns= me.buildColumns();
	    me.dockedItems = me.buildDockedItems();
	    me.callParent();
	},
	buildColumns: function(){
		return [{ 
				dataIndex: 'id',
				flex: 0.6,
				text: 'id',
				hidden:true
			},{ 
				dataIndex: 'fecha',
				flex: 0.4,
				text: 'Fecha',
				renderer :function(fecha) { 
      				return Ext.Date.format(fecha, "Y-m-d"); 
				},
		
				editor:{
					xtype: 'datefield',
	                allowBlank: false,
	                format: 'Y-m-d',
	            }
			},{ 
				dataIndex: 'descripcion',
				flex: 0.5,
				text: 'Descripción',
				editor:{
                    xtype       :'textfield',
                    allowBlank  : false,
                    autoScroll  : true
                }
			}
		]
	},
	buildDockedItems : function(){
		return [{
			xtype:'pagingtoolbar',
			dock:'bottom',
			store:this.store,
			displayInfo:true,
			items: [{ xtype: 'button',
                name    :'guardar',
    			text    : 'guardar',
    			iconCls:'aceptar'
            }]
		}];
	}
});