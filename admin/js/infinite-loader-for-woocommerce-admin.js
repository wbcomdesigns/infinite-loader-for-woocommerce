(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	jQuery(document).ready(function ($) {
		$('#infinity-loader-loading-type').selectize({
		placeholder: "Select Button Action",
		plugins: ['remove_button'],
	});
		var $button = jQuery('<a class="infinite_loader_button" href="#load_next_page"></a>');
		$(document).on('mouseenter', '.infinite_load_more_button .infinite_loader_button', function () {
			$button = $(this).parents('.form-table').first().find('.infinite_load_more_button .infinite_loader_button');
			$button.css('background-color', $(this).parents('.form-table').first().find('.bg_btn_color_hover').val());
			$button.css('color', $(this).parents('.form-table').first().find('.txt_btn_color_hover').val());
			$button.trigger('infinite_loader_button_changed');
		});

		$(document).on('mouseleave', '.infinite_load_more_button .infinite_loader_button', function () {
			$button = $(this).parents('.form-table').first().find('.infinite_load_more_button .infinite_loader_button');
			$button.css('background-color', $(this).parents('.form-table').first().find('.bg_btn_color').val());
			$button.css('color', $(this).parents('.form-table').first().find('.txt_btn_color').val());
			$button.trigger('infinite_loader_button_changed');
		});

		$("#infinite-loader-default-color").click(function () {
			document.getElementById("infinite_loader_default_bg_color").value = "#1d76da";
		});

		$("#infinite-loader-default-bg-color-mouse-hover").click(function () {
			document.getElementById("infinite_loader_default_bg_color_mouse_hover").value = "#1d76da";
		});

		$("#infinite-loader-default-border-color").click(function () {
			document.getElementById("infinite_loader_default_border_color").value = "#1d76da";
		});

		$("#infinite-loader-default-text-color").click(function () {
			document.getElementById("infinite_loader_default_text_color").value = "#d6cccc";
		});

		$("#infinite-loader-default-text-color-mouse-hover").click(function () {
			document.getElementById("infinite_loader_default_text_color_mouse_hover").value = "#d6cccc";
		});

		$(document).on('click', '.infinite-loader-set-load-more-options', function (event) {
			event.preventDefault();
			$('.form-table .infinite_loader_button_settings, .form-table .infinite_loader_button_settings_hover').each(function (i, o) {
				$(o).val($(o).data('default')).trigger('change');
			});
			$('.form-table .button-settings').trigger('change');
			$('#infinite-loader-default-bg-color-mouse-hover').click();
			$('#infinite-loader-default-border-color').click();
			$('#infinite-loader-default-text-color').click();
			$('#infinite-loader-default-text-color-mouse-hover').click();
			$('#infinite-loader-default-color').click();
			$('#infinite-loader-default-border-color').click();
			$('#infinite-loader-default-border-color').click();
			document.getElementById("infinite_loader_default_custom_class").value = "";
			document.getElementById("infinite_loader_default_load_more_botton_text").value = "Load More";
			document.getElementById("infinite-loader_set-default-font-size").value = "22";
			document.getElementById("infinite-loader_set-default-padding-top").value = "18";
			document.getElementById("infinite-loader_set-default-padding-right").value = "25";
			document.getElementById("infinite-loader_set-default-padding-bottom").value = "18";
			document.getElementById("infinite-loader_set-default-padding-left").value = "25";
			document.getElementById("infinite-loader_set-default-margin-top").value = "";
			document.getElementById("infinite-loader_set-default-margin-right").value = "";
			document.getElementById("infinite-loader_set-default-margin-bottom").value = "";
			document.getElementById("infinite-loader_set-default-margin-left").value = "";
			document.getElementById("infinite-loader_set-default-border-top").value = "";
			document.getElementById("infinite-loader_set-default-border-right").value = "";
			document.getElementById("infinite-loader_set-default-border-bottom").value = "";
			document.getElementById("infinite-loader_set-default-border-left").value = "";
			document.getElementById("infinite-loader_set-default-border-radius-top").value = "";
			document.getElementById("infinite-loader_set-default-border-radius-right").value = "";
			document.getElementById("infinite-loader_set-default-border-radius-bottom").value = "";
			document.getElementById("infinite-loader_set-default-border-radius-left").value = "";
		});

		$(document).on('click', '.infinite-loader-set-load-previous-options', function (event) {
			event.preventDefault();
			$('.form-table .infinite_loader_button_settings, .form-table .infinite_loader_button_settings_hover').each(function (i, o) {
				$(o).val($(o).data('default')).trigger('change');
			});
			$('.form-table .button-settings').trigger('change');
			$('#infinite-loader-default-bg-color-mouse-hover').click();
			$('#infinite-loader-default-border-color').click();
			$('#infinite-loader-default-text-color').click();
			$('#infinite-loader-default-text-color-mouse-hover').click();
			$('#infinite-loader-default-color').click();
			$('#infinite-loader-default-border-color').click();
			$('#infinite-loader-default-border-color').click();
			document.getElementById("infinite_loader_default_custom_class").value = "";
			document.getElementById("infinite_loader_default_previous_botton_text").value = "Load Previous";
			document.getElementById("infinite-loader_set-default-font-size").value = "22";
			document.getElementById("infinite-loader_set-default-padding-top").value = "18";
			document.getElementById("infinite-loader_set-default-padding-right").value = "25";
			document.getElementById("infinite-loader_set-default-padding-bottom").value = "18";
			document.getElementById("infinite-loader_set-default-padding-left").value = "25";
			document.getElementById("infinite-loader_set-default-margin-top").value = "";
			document.getElementById("infinite-loader_set-default-margin-right").value = "";
			document.getElementById("infinite-loader_set-default-margin-bottom").value = "";
			document.getElementById("infinite-loader_set-default-margin-left").value = "";
			document.getElementById("infinite-loader_set-default-border-top").value = "";
			document.getElementById("infinite-loader_set-default-border-right").value = "";
			document.getElementById("infinite-loader_set-default-border-bottom").value = "";
			document.getElementById("infinite-loader_set-default-border-left").value = "";
			document.getElementById("infinite-loader_set-default-border-radius-top").value = "";
			document.getElementById("infinite-loader_set-default-border-radius-right").value = "";
			document.getElementById("infinite-loader_set-default-border-radius-bottom").value = "";
			document.getElementById("infinite-loader_set-default-border-radius-left").value = "";
		});
		
		

	});
})( jQuery );
