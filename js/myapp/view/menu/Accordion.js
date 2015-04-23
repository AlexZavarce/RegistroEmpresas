Ext.define('myapp.view.menu.Accordion', {
    extend: 'Ext.panel.Panel',
    alias: 'widget.mainmenu',
    width: 300,
    layout: {
        type: 'accordion'
        },
    collapsible: false,
    hideCollapseTool: false,
    conCls: 'sitemap',
    title: 'Menu'
});