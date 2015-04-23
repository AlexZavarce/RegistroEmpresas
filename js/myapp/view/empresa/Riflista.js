Ext.define('myapp.view.empresa.Riflista', {
	extend: 'Ext.grid.Panel', 
	alias: 'widget.riflista',
	itemId: 'riflista',
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
	store: Ext.create('myapp.store.empresa.Riflista'),
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
			hidden: true,
			
		},{ 

			dataIndex: 'rif',
			flex: 0.4,
			text: 'Rif de la Empresa',
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

			dataIndex: 'cedula',
			flex: 0.4,
			text: 'Cedula del Contacto',
			//hidden:true
		},{ 
			dataIndex: 'correo',
			flex: 0.4,
			text: 'correo',
			//hidden:true
		},{
			width: 250,
			text: 'status',
			dataIndex: 'status',
			tdCls: 'x-change-cell',
			queryMode: 'local',       
		},{
	        xtype: 'actioncolumn',
	        flex: 0.1,
	        id: 'procesar',
	        sortable: false,
	        //menuDisabled: true,
	        tooltip 	: 'Procesar',
            items: [{
	            icon: '../../imagen/btn/accept.png',
	            tooltip: 'aceptar',
	       }]
	    }]
	},
});
 