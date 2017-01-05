(function($) {
	$.entwine("select2", function($) {
		$("select.select2").entwine({
			onmatch: function() {
				this._super();
				this.select2();
			}
		});
	});
})(jQuery);