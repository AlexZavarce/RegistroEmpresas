Ext.define('myapp.model.empresa.Verempresagrid', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id'},
        {name: 'nombre'},
        {name: 'rif'},
        {name: 'rif1'},
        {name: 'rif2'},
        {name: 'nombrecomer'},
        {name: 'anoact'},
        {name: 'registromer'},
        {name: 'razonsoc'},
        {name: 'nacionalidarep', type: 'int'},
        {name: 'cedularep'},
        {name: 'representante'},
        {name: 'codmovilrep'},
        {name: 'movilrep'},
        {name: 'tipo'},
        {name: 'nombrecont'},
        {name: 'codmovilcont'},
        {name: 'movilcont'},
        {name: 'nacionalidadcont'},
        {name: 'cedulacont'},
        {name: 'cmbestado'},
        {name: 'cmbmunicipio', type: 'int'},
        {name: 'cmbparroquia', type: 'int'},
        {name: 'cmbcomunidad', type: 'int'},
        {name: 'direccion'},
        {name: 'codmovilemp'},
        {name: 'movilemp'},
        {name: 'codfijoemp'},
        {name: 'fijoemp'},
        {name: 'codfaxemp'},
        {name: 'faxemp'},
        {name: 'correoemp'},
        {name: 'pagwebemp'},
        {name: 'facebookemp'},
        {name: 'twitteremp'},
        {name: 'seleccioncamara1'},
        {name: 'seleccioncamara2'},
        {name: 'seleccioncamara3'},
        {name: 'seleccioncamara4'},
         {name: 'seleccioncamara5'},
        {name: 'cmbseccion'},
        {name: 'cmbdivisionact', type: 'int'},
        {name: 'cmbgrupo', type: 'int'},
        {name: 'cmbclase', type: 'int'},
        {name: 'cmbrama', type: 'int'},
        {name: 'total'}
    ]
});