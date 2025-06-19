(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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
	 
	// Ensure jQuery is available
	if ( typeof $ === 'undefined' ) {
		return;
	}
	
	// Document ready
	$(function() {
		// Initialize any public-facing functionality here
		
		// Example: Handle product hover effects
		$(document).on('mouseenter', '.products .product', function() {
			$(this).addClass('hover');
		}).on('mouseleave', '.products .product', function() {
			$(this).removeClass('hover');
		});
		
		// Example: Track product clicks
		$(document).on('click', '.products .product a', function() {
			// You can add analytics tracking here
			var productId = $(this).closest('.product').data('product-id');
			if ( productId ) {
				// Track the click
				$(document).trigger('infinite_loader_product_clicked', [productId]);
			}
		});
	});
	
	// Window load
	$(window).on('load', function() {
		// Any functionality that needs to run after all assets are loaded
	});

})( jQuery );