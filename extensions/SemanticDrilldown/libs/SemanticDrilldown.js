/**
 * SemanticDrilldown.js
 *
 * Javascript code for use by the Semantic Drilldown extension.
 *
 * @author Sanyam Goyal
 */
(function(jQuery) {
	jQuery.widget("ui.combobox", {
		_create: function() {
			var self = this;
			var select = this.element.hide();
			var inp_id = select[0].options[0].value;
			var curval = select[0].name;
			var input = jQuery("<input id = \""+inp_id+"\" type=\"text\" name=\""+inp_id+"\"  value=\""+curval+"\">")
				.insertAfter(select)
				.autocomplete({
					source: function(request, response) {
						var matcher = new RegExp("\\b" + request.term, "i" );
						response(select.children("option").map(function() {
							var text = jQuery(this).text();
							if (this.value && (!request.term || matcher.test(text)))
								return {
									id: this.value,
									label: text.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + jQuery.ui.autocomplete.escapeRegex(request.term) + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<strong>$1</strong>"),
									value: text
								};
						}));
					},
					delay: 0,
					change: function(event, ui) {
						if (!ui.item) {
							// if it didn't match anything,
							// just leave it as it is
							return false;
						}
						select.val(ui.item.id);
						self._trigger("selected", event, {
							item: select.find("[value='" + ui.item.id + "']")
						});

					},
					minLength: 0
				})
				.addClass("ui-widget ui-widget-content ui-corner-left");
			jQuery("<button type=\"button\">&nbsp;</button>")
			.attr("tabIndex", -1)
			.attr("title", "Show All Items")
			.insertAfter(input)
			.button({
				icons: {
					primary: "ui-icon-triangle-1-s"
				},
				text: false
			}).removeClass("ui-corner-all")
			.addClass("ui-corner-right ui-button-icon")
			.click(function() {
				// close if already visible
				if (input.autocomplete("widget").is(":visible")) {
					input.autocomplete("close");
					return;
				}
				// pass empty string as value to search for, displaying all results
				input.autocomplete("search", "");
				input.focus();
			});
		}
	});

})(jQuery);
