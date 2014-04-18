(function($) {
	$.entwine("select2", function($) {
		$("input.ajaxselect2").entwine({
			onmatch: function() {
				var self = this;
				self.select2({
				    placeholder: self.data('placeholder'),
				    minimumInputLength: self.data('minimuminputlength'),
				    page_limit: self.data('resultslimit'),
				    quietMillis: 100,
				    ajax: {
				        url: self.data('searchurl'),
				        dataType: 'json',
				        data: function (term, page) {
				            return {
				                q: term,
				                page: page
				            };
				        },
				        results: function (data, page) {
				        	var more = (page * self.data('resultslimit')) < data.total
				            return {
				            	results: data.list, 
				            	more: more
				           	};
				        }
				    },
				    initSelection: function(element, callback) {
				        var id=$(element).val();
				        if (id!=='') {
				            $.ajax($(element).data('searchurl'), {
				                data: {
				                    id: id
				                },
				                dataType: "json"
				            }).done(function(data) { callback(data.list[0]); });
				        }
				    },
				    formatResult: function(item) {
				        return item.resultsContent;
				    },
    				formatSelection: function(item) {
				        return item.selectionContent;
				    },
				    dropdownCssClass: "bigdrop", 
				    escapeMarkup: function (m) { return m; }
				});
			}
		});
	});
}(jQuery));