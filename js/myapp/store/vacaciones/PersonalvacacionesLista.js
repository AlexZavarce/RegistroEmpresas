var itemsPerPage = 10;
Ext.define('myapp.store.vacaciones.PersonalvacacionesLista', {
    extend: 'Ext.data.Store',
    groupField: 'division',
    storeId: 'id',
    pageSize: itemsPerPage,
    model: 'myapp.model.vacaciones.PersonalvacacionesLista',
    proxy: { 
        type:'ajax', 
        url: BASE_URL + 'vacaciones/Historicovac/obtenerpersonalvacaciones',
        reader: {
            type:'json', 
            root: 'data'
        }
    },
   autoLoad: true
});