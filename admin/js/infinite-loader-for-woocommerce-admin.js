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
		var $button = jQuery('<a class="infinite_button" href="#load_next_page"></a>');
		
		$(document).on('mouseenter', '.infinite_loader_btn_load .infinite_button', function () {
			$button = $(this).parents('.form-table').first().find('.infinite_loader_btn_load .infinite_button');
			$button.css('background_color', $(this).parents('.form-table').first().find('.bg_btn_color_hover').val());
			$button.css('color', $(this).parents('.form-table').first().find('.txt_btn_color_hover').val());
			$button.trigger('infinite_loader_button_changed');
		});

		$(document).on('mouseleave', '.infinite_loader_btn_load .infinite_button', function () {
			$button = $(this).parents('.form-table').first().find('.infinite_loader_btn_load .infinite_button');
			$button.css('background_color', $(this).parents('.form-table').first().find('.bg_btn_color').val());
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
		var infinite_select_icon_for = $('.infinite_display_icon_popup');
		$(document).on('click', '.infinite_loader_select_fontawesome .infinite_select_icon',function(event) {
            event.preventDefault();
			infinite_select_icon_for = $(this);
			var $html = $('<div class="infinite_loader_select_fontawesome"></div>');
			$html.append($('.infinite_display_icon_popup'));
            var $html2 = $('<div class="infinite_loader_icons_display icons_popup_body_area"></div>');
            $html2.append($html);
			$('body').children('.icons_popup_body_area').remove();
            $('body').append($html2);
			$('.infinite_display_icon_popup').show();
        });
		$(document).on('mouseenter', '.infinite_loader_select_fontawesome .infinite_icon_hover', function() {
            var window_width = $(window).width();
            window_width = window_width / 2;
			var $this = $(this).parents('.infinite_fa_fa_icon');
            if( $this.offset().left < window_width ) {
				$this.find('.infinite_icon_preview').css({left: '0', right: 'initial'});
				$this.find('.infinite_icon_preview span').appendTo($this.find('.infinite_icon_preview'));
            } else {
				$this.find('.infinite_icon_preview').css({left: 'initial', right: '0'});
				$this.find('.infinite_icon_preview .fa').appendTo($this.find('.infinite_icon_preview'));
            }
        });
		$(document).on('click', '.infinite_loader_select_fontawesome .infinite_icon_hover',function(event) {
            event.preventDefault();
			var value = $(this).parents('.infinite_fa_fa_icon').first().find('.infinite_icon_preview span').text();
			$(infinite_select_icon_for).parents('.infinite_loader_select_fontawesome').find('.infinite_icon_value').val(value).trigger('change');
			$('.infinite_display_icon_popup').hide();
			if ( value ) {
				$(infinite_select_icon_for).parents('.infinite_loader_select_fontawesome').find('.infinite_selected_icon').html('<i class="fa '+value+'"></i>').show();
				$(infinite_select_icon_for).parents('.infinite_loader_select_fontawesome').find(".infinite_remove_icons").show();
			} else {
				$(infinite_select_icon_for).parents('.infinite_loader_select_fontawesome').find('.infinite_selected_icon').html('').hide();
				$(infinite_select_icon_for).parents('.infinite_loader_select_fontawesome').find(".infinite_remove_icons").hide();
			}
        });
		$(document).on('click', '.infinite_loader_select_fontawesome .infinite_remove_icon',function(event) {
            event.preventDefault();
			$(this).parents('.infinite_loader_select_fontawesome').find('.infinite_selected_icon').html('');
			$(this).parents('.infinite_loader_select_fontawesome').find('.infinite_icon_value').val('').trigger('change');
        });
		$(document).on('keyup', '.infinite_loader_select_fontawesome .infinite_icons_search', function() {
			var $parent = $(this).parents('.infinite_loader_select_fontawesome').first();
            var value = $(this).val();
            value = value.replace(/\s+/g, '');
            value = value.toLowerCase();
            if( value.length >=1 ) {
				$parent.find('.infinite_fa_fa_icon').hide();
				$parent.find('.infinite_icon_preview span:contains("' + value + '")').parents('.infinite_fa_fa_icon').show();
            } else {
				$parent.find('.infinite_fa_fa_icon').show();
            }
        });
		$(document).on('click', '.infinite_loader_select_fontawesome .infinite_display_icon_popup',function(event) {
            event.preventDefault();
            $(this).hide();
        });
		$(document).on('click', '.infinite_loader_select_fontawesome .infinite_display_icon_popup .infinite_close_popup',function(event) {
            event.preventDefault();
			$(this).parents('.infinite_display_icon_popup').hide();
        });
		$(document).on('click', '.infinite_loader_select_fontawesome .infinite_icons_popup',function(event) {
            event.preventDefault();
            event.stopPropagation();
        });
	});
})( jQuery );
