// (function($) {
// 	$('.chosenfield').livequery(function() {		
// 		alert('here');
// 		$(this).chosen({
// 	      	disable_search_threshold: $(this).attr('data-search-threshold')
// 	    });
// 	});
// }(jQuery));

jQuery.entwine("select2", function($) {
	
	$("select.select2").entwine({
		onmatch: function() {
			var self = this;
			self.select2();
		},
	});

});


//jQuery(document).ready(function($) { $("select.select2").select2(); });

