(function() {
    tinymce.PluginManager.requireLangPack('jbimages');
    tinymce.create('tinymce.plugins.jbImagesPlugin', {
        init: function(ed, url) {
            
            ed.addCommand('jbImages', function() {
                ed.windowManager.open({
                file: resources_tiny,
                width: 430 + parseInt(ed.getLang('jbimages.delta_width', 0)),
                height: 275 + parseInt(ed.getLang('jbimages.delta_height', 0)), inline: 1},
                {plugin_url: url});
                
            });
            ed.addButton('jbimages', {title: 'jbimages.desc', cmd: 'jbImages', image: url + '/img/jbimages.gif'});
            ed.onNodeChange.add(function(ed, cm, n) {
                cm.setActive('jbimages', n.nodeName == 'IMG');
            });
        }, createControl: function(n, cm) {
            return null;
        }, getInfo: function() {
            return{longname: 'JustBoil.me Images Plugin', author: 'Viktor Kuzhelny', authorurl: 'http://justboil.me', infourl: 'http://justboil.me/tinymce-images-plugin/', version: "2.1"};
        }});
    tinymce.PluginManager.add('jbimages', tinymce.plugins.jbImagesPlugin);
})();