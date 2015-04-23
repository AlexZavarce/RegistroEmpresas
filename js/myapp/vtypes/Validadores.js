Ext.define('myapp.vtypes.Validadores', {
  init: function () {
    var me = this;
    this.correoFn();
    this.numeroFn();
    this.passwordFn();
    this.letraFn(),
    this.showcolorFn()
    this.daterangeFn() 
  },
  correoFn:function () {
    var me = this;
    Ext.apply(Ext.form.field.VTypes, {
      correo : function(value, field) {
        return /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/.test(value);
      },
      correoText : 'No es un correo Valido,debe tener el formato eje',
    }); 
  },
  numeroFn:function () {
    var me = this;
    Ext.apply(Ext.form.field.VTypes, {
      numero : function(value, field) {
        return /[0-9]/.test(value);
      },
      numeroText : 'Los datos ingresado no son válidos. Solo números',
      numeroMask : /[0-9]/,
	  }); 
  },
  passwordFn: function(){
    var me = this;
    Ext.apply(Ext.form.field.VTypes, {
      password: function(val, field) {
        var win = field.up('window');
        formPanel = win.down('form');
        formPanel1= win.down('toolbar');
        if (field.initialPassField) {
          var pwd = field.up('form').down('#' + field.initialPassField);
          return (val == pwd.getValue());
          formPanel1.down('button[name=guardar]').enable(true);
        }
        return true.test(val);
        formPanel1.down('button[name=guardar]').enable(true);
      },
      passwordText: 'No coincide con la Nueva Contraseña,por favor verificar',
    }); 
  },
  daterangeFn:function () {
    var me = this;
    Ext.apply(Ext.form.field.VTypes, {
      daterange: function(val, field) {
          var date = field.parseDate(val);

          if (!date) {
              return false;
          }
          if (field.startDateField && (!this.dateRangeMax || (date.getTime() != this.dateRangeMax.getTime()))) {
              var start = field.up('form').down('#' + field.startDateField);
              start.setMaxValue(date);
              start.validate();
              this.dateRangeMax = date;
          }
          else if (field.endDateField && (!this.dateRangeMin || (date.getTime() != this.dateRangeMin.getTime()))) {
              var end = field.up('form').down('#' + field.endDateField);
              end.setMinValue(date);
              end.validate();
              this.dateRangeMin = date;
          }
          /*
           * Always return true since we're only using this vtype to set the
           * min/max allowed values (these are tested for after the vtype test)
           */
          return true;
      },
      daterangeText: 'Start date must be less than end date',
    });
  },
  letraFn:function () {
    var me = this;
    Ext.apply(Ext.form.field.VTypes, {
      letra : function(value, field) {
        return /[A-Za-z]/.test(value);
		  },
  		letraText : 'Los datos ingresado no son válidos. Solo letras',
  		letraMask : /[A-Za-z]/,
  	}); 
  },
  showcolorFn:function () {
    var me = this;
    Ext.apply(Ext.form.field.VTypes, {
      showcolor: function(value,metaData){
        metaData.attr = value?'style="color:#f00"':'style="color:#0a0"';
        return value?'Activo':'Inactivo';
      },
    }); 
  }
});

