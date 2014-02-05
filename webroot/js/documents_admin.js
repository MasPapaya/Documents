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
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull",
		theme_advanced_buttons2 : "bullist,numlist,separator,outdent,indent,separator,undo,redo,separator,link,unlink,jbimages",
		theme_advanced_buttons3 : "",
		//		theme_advanced_buttons4 : "jbimages",
		relative_urls : false
	});
	
	$(".select_chosen").chosen({
		max_selected_options: 2,
		no_results_text: "No se encontro"
	
	});
		
		
	$('#DocumentUserId').typeahead({
		source: function (query, process) {
			return $.post(baseurl+'documents/Documents/get_users/'+query, {
				type:'POST',
				dataType: "json",
				query: query
			}, function (data) {				
				var new_search=new Array();
				$.each(JSON.parse(data), function(i, item) {					
					new_search.push(item);
				});		
				return process(new_search);
			});

		}

	});
	
	

	
}
