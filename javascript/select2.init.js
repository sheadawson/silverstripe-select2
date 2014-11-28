jQuery.entwine("select2", function($) {

	$("select.select2").entwine({
		onmatch: function() {
			var self = this;
			self.select2();
		},
	});
});

