Ext.define('myapp.store.reportes.Fechades', {
    extend: 'Ext.data.Store',
    autoLoad: true,
	fields: ['fecha'],
    data: [
		{fecha:'2014/05/21'},{fecha:'2014/06/21'},{fecha:'2014/07/21'},
		{fecha:'2014/08/21'},{fecha:'2014/09/21'},{fecha:'2014/10/21'},{fecha:'2014/11/21'},
		{fecha:'2014/12/21'}
	]
});