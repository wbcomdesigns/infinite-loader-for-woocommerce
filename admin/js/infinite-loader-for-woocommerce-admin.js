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
		$('#infinity-loader-loading-type').select2({
			placeholder: "Select Button Action",
			allowClear: true // If you want a remove (clear) button
		});

		$(document).on('click',"#infinite-loader-default-color", function () {
			document.getElementById("infinite_loader_default_bg_color").value = "#1d76da";
		});

		$(document).on('click',"#infinite-loader-default-bg-color-mouse-hover", function () {
			document.getElementById("infinite_loader_default_bg_color_mouse_hover").value = "#0e4da0";
		});

		$(document).on('click',"#infinite-loader-default-border-color", function () {
			document.getElementById("infinite_loader_default_border_color").value = "#1d76da";
		});

		$(document).on('click',"#infinite-loader-default-text-color", function () {
			document.getElementById("infinite_loader_default_text_color").value = "#ffffff";
		});

		$(document).on('click',"#infinite-loader-default-text-color-mouse-hover", function () {
			document.getElementById("infinite_loader_default_text_color_mouse_hover").value = "#ffffff";
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
		$(document).on('click', '.infinite_loader_select_fontawesome .infinite_default_icon',function(event) {
            event.preventDefault();
			$(this).parents('.infinite_loader_select_fontawesome').find('.infinite_selected_icon').html('<i class="fa fa-spinner"></i>');
			$(this).parents('.infinite_loader_select_fontawesome').find('.infinite_icon_value').val('fa-spinner').trigger('change');
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
