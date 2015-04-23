Ext.define('myapp.store.reportes.Fechahas', {
    extend: 'Ext.data.Store',
    autoLoad: true,
    fields: ['fecha'],
    data: [
		{fecha:'2014/06/20'},{fecha:'2014/07/20'},{fecha:'2014/08/20'},
		{fecha:'2014/09/20'},{fecha:'2014/10/20'},{fecha:'2014/11/20'},
		{fecha:'2014/12/20'}
	]
});