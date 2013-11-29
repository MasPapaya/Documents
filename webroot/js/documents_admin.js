function documents_init() {		
		
	tinyMCE.init({
		theme : "advanced",
		language : "es",
		selector : "textarea.tinymce-editor",
		skin : "o2k7",
		skin_variant : "silver",
		width : "720px",
		height: '300px',
		setup : function(ed) {
			ed.onChange.add(function(ed, e) {
				$("#DocumentContent").text(tinyMCE.activeEditor.getContent()+'');				

			});
		},
		plugins:"jbimages",
		relative_urls : false,
		theme_advanced_buttons4 : "jbimages"
	});
	
	
}