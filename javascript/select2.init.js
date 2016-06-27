jQuery.entwine("select2", function($) {

	$("select.select2").entwine({
		onmatch: function() {
			var self = this,
			    limit = self.attr('limit');
			if(limit > 0){
			    self.select2({maximumSelectionSize: limit});
			} else {
			    self.select2();
			}
		},
	});
});

