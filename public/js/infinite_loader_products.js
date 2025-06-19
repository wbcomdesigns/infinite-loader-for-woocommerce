var infinite_loader_update_state, infinite_loader_product_data, infinite_loader_load_next_page, infinite_loader_ajax_instance = false, infinite_loader_update_lazyload, infinite_loader_init, infinite_loader_init_buttons;

(function ($) {
    'use strict';
    
    // Check if jQuery is available
    if (typeof $ === 'undefined') {
        console.error('Infinite Loader: jQuery is required');
        return;
    }
    
    // Check if data is available
    if (typeof infinite_loader_product_data === 'undefined') {
        console.error('Infinite Loader: Configuration data is missing');
        return;
    }
    
    // Create preload element with proper escaping
    var preloadHtml = $('<div>').addClass('infinite_loader_preload');
    if (infinite_loader_product_data.load_image) {
        preloadHtml.html(infinite_loader_product_data.load_image);
    }
    $('body').append(preloadHtml);

    // Create a cache object for better performance
    var domCache = {
        products: null,
        pagination: null,
        resultCount: null,
        body: $('body'),
        window: $(window),
        
        init: function() {
            this.products = $(infinite_loader_product_data.products);
            this.pagination = $(infinite_loader_product_data.pagination);
            this.resultCount = $('.woocommerce-result-count');
            
            // Validate elements exist
            if (!this.products.length && infinite_loader_product_data.debug_mode) {
                console.warn('Infinite Loader: Products container not found');
            }
        },
        
        refresh: function() {
            this.init();
        }
    };
    
    // Main initialization
    $(document).ready(function () {
        var infinite_loader_loading = false,
            infinite_loader_type,
            infinite_count_start = 0,
            infinite_count_end = 0,
            infinite_count_laststart = 0,
            infinite_count_lastend = 0,
            infinite_count_text = '';
            
        // Initialize cache
        domCache.init();
        
        // Initialize plugin
        infinite_loader_init = function () {
            infinite_loader_loading = false;
            infinite_loader_type = undefined;
            infinite_count_start = 0;
            infinite_count_end = 0;
            infinite_count_laststart = 0;
            infinite_count_lastend = 0;
            infinite_count_text = '';
            
            $('.infinite_loader_preload').remove();
            
            // Set up first item marker
            if (domCache.products.find(infinite_loader_product_data.item).first().length) {
                domCache.products.find(infinite_loader_product_data.item).first()
                    .addClass('infinite_loader_btn')
                    .attr('data-url', encodeURI(decodeURIComponent(location.href)));
            }
            
            // Handle extra data elements
            if (domCache.products.find('.infinite_loader_extra_data').first().length) {
                domCache.products.find('.infinite_loader_extra_data').first()
                    .addClass('infinite_loader_btn')
                    .attr('data-url', encodeURI(decodeURIComponent(location.href)));
            }
            
            // Initialize count tracking
            var $count_element = $('.infinite_loader_product_count');
            if ($count_element.length) {
                infinite_count_start = parseInt($count_element.data('start')) || 0;
                infinite_count_end = parseInt($count_element.data('end')) || 0;
                infinite_count_text = $count_element.data('text') || '';
                infinite_count_laststart = infinite_count_start;
                infinite_count_lastend = infinite_count_end;
            }
        };
        
        infinite_loader_init();
        
        // Only proceed if products container exists
        if (domCache.products.length > 0) {
            // Initialize buttons
            infinite_loader_init_buttons = function () {
                if (infinite_loader_product_data.load_more) {
                    var loadMoreEl = $(infinite_loader_product_data.load_more);
                    domCache.products.after(loadMoreEl);
                }
                
                if (infinite_loader_product_data.use_prev_btn && infinite_loader_product_data.load_prev) {
                    var loadPrevEl = $(infinite_loader_product_data.load_prev);
                    domCache.products.before(loadPrevEl);
                }
            };
            
            infinite_loader_init_buttons();
            current_style();
            
            if (infinite_loader_type !== 'none') {
                // Window resize handler
                var resizeTimer;
                domCache.window.on('resize', function () {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(function() {
                        current_style();
                    }, 250);
                });
                
                // Handle browser history
                if (infinite_loader_product_data.update_url === true) {
                    window.onpopstate = function (event) {
                        var state = event.state;
                        if (state && state.blmp === 'br_lmp_popstate') {
                            handle_popstate(state);
                        }
                    };
                }
                
                // Scroll handler
                var scrollTimer;
                domCache.window.on('scroll', function () {
                    if (!infinite_loader_loading) {
                        clearTimeout(scrollTimer);
                        scrollTimer = setTimeout(function() {
                            br_load_more_html5();
                            
                            if (infinite_loader_type === 'infinity-scroll') {
                                infinite_loader_update_state();
                                infinite_loader_load_next_page();
                            }
                        }, 100);
                    }
                });
                
                // Event handlers
                $(document).on('click', '.infinite_loader_btn_setting .infinite_button', function (event) {
                    event.preventDefault();
                    infinite_loader_load_next_page();
                });
                
                $(document).on('click', '.infinite_loader_prev_btn_setting .infinite_button', function (event) {
                    event.preventDefault();
                    var href = $(this).attr('href');
                    if (is_valid_url(href)) {
                        infinite_loader_load_next_page(2, href);
                    }
                });
                
                // Pagination click handler
                if (!infinite_loader_product_data.is_AAPF || typeof the_ajax_script === 'undefined') {
                    $(document).on('click', infinite_loader_product_data.pagination + ' a', function (event) {
                        event.preventDefault();
                        var next_page = $(this).attr('href');
                        
                        if (!is_valid_url(next_page)) {
                            return;
                        }
                        
                        if (infinite_loader_product_data.update_url === true) {
                            update_browser_history(next_page);
                        }
                        
                        infinite_loader_load_next_page(true, next_page);
                    });
                }
                
                // Integration events
                $(document).on('infinite_loader_ajax_filter_start', function () {
                    infinite_loader_loading = true;
                });
                
                $(document).on('infinite_loader_ajax_filter_end', function () {
                    infinite_loader_loading = false;
                });
            }
        }
        
        // Main load function
        infinite_loader_load_next_page = function (replace, user_next_page) {
            if (infinite_loader_loading) {
                return;
            }
            
            replace = replace || false;
            user_next_page = user_next_page || false;
            
            var $next_page = jquery_get_next_page();
            
            if ($next_page.length > 0 || user_next_page !== false) {
                start_ajax_loading(replace);
                
                var next_page = user_next_page !== false ? user_next_page : $next_page.attr('href');
                
                // Security check
                if (!is_valid_url(next_page)) {
                    console.error('Infinite Loader: Invalid URL');
                    end_ajax_loading();
                    return;
                }
                
                infinite_loader_ajax_instance = $.ajax({
                    method: "GET",
                    url: next_page,
                    data: {
                        'infinite_loader_ajax': 1,
                        'nonce': infinite_loader_product_data.ajax_nonce
                    },
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-Braapfdisable', '1');
                        xhr.setRequestHeader('X-WP-Nonce', infinite_loader_product_data.ajax_nonce);
                    },
                    success: function (data) {
                        processAjaxResponse(data, next_page, replace);
                    },
                    error: function(xhr, status, error) {
                        handle_ajax_error(xhr, status, error);
                    },
                    complete: function() {
                        infinite_loader_ajax_instance = false;
                    },
                    timeout: 30000 // 30 second timeout
                });
            }
        };
        
        // Helper functions
        function handle_popstate(state) {
            if (infinite_loader_type !== 'pagination') {
                if (!infinite_loader_loading) {
                    infinite_loader_loading = true;
                    
                    var targetUrl = encodeURI(decodeURIComponent(location.href));
                    var $target = $('.infinite_loader_btn[data-url="' + targetUrl + '"]');
                    if ($target.length) {
                        $('html, body').stop().animate({
                            scrollTop: $target.offset().top - 100
                        }, 500, function () {
                            infinite_loader_loading = false;
                        });
                    } else {
                        location.reload();
                    }
                }
            } else {
                if (infinite_loader_ajax_instance !== false) {
                    infinite_loader_ajax_instance.abort();
                    end_ajax_loading();
                }
                var currentUrl = decodeURIComponent(location.href);
                if (is_valid_url(currentUrl)) {
                    infinite_loader_load_next_page(true, currentUrl);
                }
            }
        }
        
        function update_browser_history(next_page) {
            if (!is_valid_url(next_page)) {
                return;
            }
            
            var history_data = { blmp: 'br_lmp_popstate' };
            history.replaceState(history_data, "");
            
            history_data.link = next_page;
            history.pushState(history_data, "", next_page);
            history.pathname = next_page;
        }
        
        function is_valid_url(url) {
            if (!url) return false;
            
            // Check if it's a relative URL or from the same origin
            try {
                var parsedUrl = new URL(url, window.location.origin);
                return parsedUrl.origin === window.location.origin;
            } catch (e) {
                // For older browsers, do a basic check
                return url.indexOf('http') !== 0 || url.indexOf(window.location.hostname) !== -1;
            }
        }
        
        function handle_ajax_error(xhr, status, error) {
            console.error('Infinite Loader Error:', error);
            
            var errorMessage = infinite_loader_product_data.error_message || 'Unable to load more products.';
            var retryText = infinite_loader_product_data.retry_text || 'Retry';
            
            var errorDiv = $('<div>').addClass('infinite-loader-error');
            var errorP = $('<p>').text(errorMessage);
            var retryBtn = $('<button>').addClass('infinite-loader-retry button').text(retryText);
            
            errorDiv.append(errorP).append(retryBtn);
            
            $('.infinite-loader-error').remove();
            domCache.products.after(errorDiv);
            
            end_ajax_loading();
        }
        
        function start_ajax_loading(replace) {
            infinite_loader_loading = true;
            domCache.body.addClass('infinite_loader_ajax_loading');
            
            // Execute before update callback
            infinite_loader_exc_js(infinite_loader_product_data.javascript.before_update);
            
            $(document).trigger('infinite_loader_product_start');
            
            if (replace === 2) {
                if (infinite_loader_product_data.load_image) {
                    domCache.products.before($(infinite_loader_product_data.load_image));
                }
                $(document).trigger('infinite_loader_product_start_prev');
            } else {
                if (infinite_loader_product_data.load_image) {
                    domCache.products.after($(infinite_loader_product_data.load_image));
                }
                $(document).trigger('infinite_loader_product_start_next');
            }
        }
        
        function end_ajax_loading() {
            // Handle Isotope if present
            if (typeof domCache.products.isotope === 'function' && domCache.products.data('isotope')) {
                domCache.products.isotope('reloadItems').isotope();
            }
            
            // Remove loading indicators
            $(infinite_loader_product_data.load_img_class).remove();
            
            // Trigger events
            $(document).trigger('infinite_loader_ajax_load_products');
            $(document).trigger('infinite_loader_ajax_btn_end');
            
            // Execute after update callback
            infinite_loader_exc_js(infinite_loader_product_data.javascript.after_update);
            
            domCache.body.removeClass('infinite_loader_ajax_loading');
            infinite_loader_loading = false;
            
            // Check if there are more pages
            var $next_page = jquery_get_next_page();
            if ((infinite_loader_type === 'infinity-scroll' || infinite_loader_type === 'load-more-button') && $next_page.length <= 0) {
                var noMoreText = infinite_loader_product_data.no_more_text || 'No more products';
                var noMoreDiv = $('<div>').addClass('infinite-loader-no-more').text(noMoreText);
                domCache.products.after(noMoreDiv);
            }
            
            // Update URL if needed
            br_load_more_html5();
            
            // Trigger lazy load plugins
            trigger_lazy_load();
        }
        
        function trigger_lazy_load() {
            // Trigger common lazy load events
            domCache.window.trigger('scroll').trigger('resize');
            $(document).trigger('lazyload');
            
            // Specific plugin support
            if (typeof $.fn.lazyload === 'function') {
                $('img.lazy').lazyload();
            }
            
            if (typeof LazyLoad !== 'undefined') {
                new LazyLoad();
            }
            
            // WooCommerce specific
            $(document.body).trigger('init_image_gallery_lightbox');
        }
        
        function processAjaxResponse(data, next_page, replace) {
            try {
                var $data = $('<div>').html(data);
                
                // Check for WooCommerce content
                if (!$data.find(infinite_loader_product_data.products).length) {
                    console.error('Infinite Loader: Products container not found in response');
                    end_ajax_loading();
                    return;
                }
                
                // Process lazy loading attributes
                if (should_lazy_load()) {
                    prepare_lazy_load_content($data);
                }
                
                // Mark first item with URL
                mark_first_item($data, next_page);
                
                // Get products HTML
                var $products = $data.find(infinite_loader_product_data.products).html();
                
                // Update products based on replace type
                if (replace === 1) {
                    domCache.products.html($products);
                } else if (replace === 2) {
                    handle_prepend_products($data);
                } else {
                    domCache.products.append($products);
                }
                
                // Update lazy loading
                infinite_loader_update_lazyload();
                
                // Update result count
                update_result_count($data, replace);
                
                // Update pagination
                update_pagination($data, replace);
                
                // Refresh cache
                domCache.refresh();
                
                // Update current style
                current_style();
                
                // Reinitialize WooCommerce features
                reinit_woocommerce();
                
                if (replace !== 2) {
                    end_ajax_loading();
                }
                
            } catch (e) {
                console.error('Infinite Loader: Error processing response', e);
                end_ajax_loading();
            }
        }
        
        function should_lazy_load() {
            var is_mobile = domCache.window.width() <= (infinite_loader_product_data.mobile_width || 768);
            return (infinite_loader_product_data.lazy_load_m && is_mobile) || 
                   (infinite_loader_product_data.lazy_load && !is_mobile);
        }
        
        function prepare_lazy_load_content($data) {
            $data.find(infinite_loader_product_data.products + ' .lazy,' + infinite_loader_product_data.item + ', .infinite_loader_extra_data')
                .find('img').each(function () {
                    var $img = $(this);
                    $img.attr('data-src', $img.attr('src')).removeAttr('src');
                    $img.attr('data-srcset', $img.attr('srcset')).removeAttr('srcset');
                });
            
            $data.find(infinite_loader_product_data.item + ', .infinite_loader_extra_data').addClass('lazy');
        }
        
        function mark_first_item($data, next_page) {
            var validUrl = encodeURI(decodeURIComponent(next_page));
            
            var $first_item = $data.find(infinite_loader_product_data.products).find(infinite_loader_product_data.item).first();
            if ($first_item.length) {
                $first_item.addClass('infinite_loader_btn').attr('data-url', validUrl);
            }
            
            var $first_extra = $data.find(infinite_loader_product_data.products).find('.infinite_loader_extra_data').first();
            if ($first_extra.length) {
                $first_extra.addClass('infinite_loader_btn').attr('data-url', validUrl);
            }
        }
        
        function handle_prepend_products($data) {
            var $products = $data.find(infinite_loader_product_data.products);
            $products.find(infinite_loader_product_data.item).addClass('infnite_loader_hidden');
            
            var count_images = $products.find('img').length;
            var products_html = $products.html();
            
            domCache.products.prepend(products_html);
            
            var display_hidden_executed = false;
            
            function display_hidden() {
                if (!display_hidden_executed) {
                    display_hidden_executed = true;
                    
                    var $first_visible = domCache.products.find(infinite_loader_product_data.item + ':not(".infnite_loader_hidden")').first();
                    var positionOld = $first_visible.offset().top;
                    var scrollTop = domCache.window.scrollTop();
                    
                    $('.infnite_loader_hidden').removeClass('infnite_loader_hidden');
                    end_ajax_loading();
                    
                    var positionNew = $first_visible.offset().top;
                    domCache.window.scrollTop(positionNew - (positionOld - scrollTop));
                }
            }
            
            if (count_images > 0) {
                var loaded_images = 0;
                domCache.products.find('.infnite_loader_hidden img').on('load error', function () {
                    loaded_images++;
                    if (loaded_images >= count_images - 1) {
                        display_hidden();
                    }
                });
            }
            
            setTimeout(display_hidden, 2500);
        }
        
        function update_result_count($data, replace) {
            if (infinite_loader_type === 'pagination') {
                var newCountText = $data.find('.woocommerce-result-count:first').text();
                domCache.resultCount.text(newCountText);
                return;
            }
            
            var $count_element = $data.find('.infinite_loader_product_count');
            if ($count_element.length && (infinite_count_start || infinite_count_end)) {
                infinite_count_text = $count_element.data('text') || '';
                
                if (replace === 2) {
                    infinite_count_start = parseInt($count_element.data('start')) || 0;
                } else {
                    infinite_count_end = parseInt($count_element.data('end')) || 0;
                }
                
                infinite_count_lastend = parseInt($count_element.data('end')) || 0;
                infinite_count_laststart = parseInt($count_element.data('start')) || 0;
                
                var text_count = infinite_count_text
                    .replace('-1', infinite_count_start)
                    .replace('-2', infinite_count_end);
                
                domCache.resultCount.text(text_count);
            } else {
                var newCountText = $data.find('.woocommerce-result-count:first').text();
                domCache.resultCount.text(newCountText);
            }
        }
        
        function update_pagination($data, replace) {
            var $new_pagination = $data.find(infinite_loader_product_data.pagination);
            
            if (replace === 1) {
                domCache.pagination.html($new_pagination.html());
            } else if (replace === 2) {
                var $prev_page = jquery_get_prev_page();
                var $new_prev_page = jquery_get_prev_page($data);
                
                if ($new_prev_page.length) {
                    $prev_page.replaceWith($new_prev_page);
                } else {
                    $prev_page.remove();
                }
            } else {
                var $next_page = jquery_get_next_page();
                var $new_next_page = jquery_get_next_page($data);
                
                if ($new_next_page.length) {
                    $next_page.replaceWith($new_next_page);
                } else {
                    $next_page.remove();
                }
            }
        }
        
        function reinit_woocommerce() {
            // Trigger WooCommerce init events
            $(document.body).trigger('wc-init-gallery');
            $(document.body).trigger('init_variation_swatches');
            
            // Reinitialize any tooltips
            if (typeof $.fn.tooltip === 'function') {
                $('.woocommerce-tooltip').tooltip();
            }
            
            // Trigger custom event for third-party plugins
            $(document).trigger('infinite_loader_products_loaded');
        }
        
        function current_style() {
            var $next_page = jquery_get_next_page();
            if ($next_page.length > 0) {
                var href = $next_page.attr('href');
                if (is_valid_url(href)) {
                    $('.infinite_loader_btn_setting .infinite_button').attr('href', href);
                }
            }
            
            var $prev_page = jquery_get_prev_page();
            if ($prev_page.length > 0) {
                var href = $prev_page.attr('href');
                if (is_valid_url(href)) {
                    $('.infinite_loader_prev_btn_setting .infinite_button').attr('href', href);
                }
            }
            
            var is_mobile = domCache.window.width() <= (infinite_loader_product_data.mobile_width || 768);
            
            if (infinite_loader_product_data.use_mobile && is_mobile) {
                set_style(infinite_loader_product_data.mobile_type);
            } else {
                set_style(infinite_loader_product_data.type);
            }
        }
        
        var test_prev_page_timeout = false;
        
        function set_style(style) {
            $('.infinite_loader_btn_load').hide();
            
            if (style !== 'none') {
                var $next_page = jquery_get_next_page();
                domCache.pagination.hide();
                
                if (style === 'load-more-button') {
                    if ($next_page.length > 0) {
                        $('.infinite_loader_btn_load.infinite_loader_btn_setting').show();
                    } else {
                        setTimeout(test_next_page, 4000);
                    }
                } else if (style === 'pagination') {
                    domCache.pagination.show();
                }
                
                var $prev_page = jquery_get_prev_page();
                if ($prev_page.length > 0) {
                    $('.infinite_loader_btn_load.infinite_loader_prev_btn_setting').show();
                } else {
                    clearTimeout(test_prev_page_timeout);
                    test_prev_page_timeout = setTimeout(test_prev_page, 4000);
                }
            }
            
            infinite_loader_type = style;
        }
        
        function test_next_page() {
            var $next_page = jquery_get_next_page();
            if ($next_page.length > 0) {
                current_style();
            } else {
                setTimeout(test_next_page, 4000);
            }
        }
        
        function test_prev_page() {
            var $prev_page = jquery_get_prev_page();
            if ($prev_page.length > 0) {
                current_style();
            } else {
                clearTimeout(test_prev_page_timeout);
                test_prev_page_timeout = setTimeout(test_prev_page, 4000);
            }
        }
        
        function jquery_get_next_page($parent) {
            $parent = $parent || $(document);
            var $pagination = $parent.find(infinite_loader_product_data.pagination);
            
            return $pagination.find(infinite_loader_product_data.next_page).length > 0 
                ? $pagination.find(infinite_loader_product_data.next_page)
                : $parent.find(infinite_loader_product_data.next_page);
        }
        
        function jquery_get_prev_page($parent) {
            $parent = $parent || $(document);
            var $pagination = $parent.find(infinite_loader_product_data.pagination);
            
            return $pagination.find(infinite_loader_product_data.prev_page).length > 0 
                ? $pagination.find(infinite_loader_product_data.prev_page)
                : $parent.find(infinite_loader_product_data.prev_page);
        }
        
        var br_load_more_html5_wait;
        
        function br_load_more_html5() {
            clearTimeout(br_load_more_html5_wait);
            
            br_load_more_html5_wait = setTimeout(function () {
                if (infinite_loader_product_data.update_url === true && !infinite_loader_loading && infinite_loader_type !== 'pagination') {
                    var next_page = '';
                    
                    $('.infinite_loader_btn').each(function () {
                        if (!$(this).is(':visible')) {
                            return true;
                        }
                        
                        if ($(this).offset().top > domCache.window.scrollTop() + (domCache.window.height() / 2)) {
                            return false;
                        }
                        
                        next_page = $(this).attr('data-url');
                    });
                    
                    if (!next_page) {
                        next_page = $('.infinite_loader_btn').first().attr('data-url');
                    }
                    
                    var current_state = history.state;
                    if (next_page && decodeURIComponent(location.href) !== decodeURIComponent(next_page) && 
                        (!current_state || current_state.link !== next_page)) {
                        update_browser_history(next_page);
                    }
                }
            }, 50);
        }
        
        // Update state function
        infinite_loader_update_state = function (reset_count) {
            reset_count = reset_count || false;
            
            if (!domCache.products.find(infinite_loader_product_data.item).first().is('.infinite_loader_btn')) {
                domCache.products.find(infinite_loader_product_data.item).first()
                    .addClass('infinite_loader_btn')
                    .attr('data-url', encodeURI(decodeURIComponent(location.href)));
            }
            
            current_style();
            
            if (reset_count) {
                update_woocommerce_count();
            }
        };
        
        function update_woocommerce_count() {
            if (infinite_loader_type !== 'pagination' && $('.infinite_loader_product_count').length) {
                infinite_count_start = parseInt($('.infinite_loader_product_count').data('start')) || 0;
                infinite_count_end = parseInt($('.infinite_loader_product_count').data('end')) || 0;
                infinite_count_text = $('.infinite_loader_product_count').data('text') || '';
                infinite_count_lastend = infinite_count_end;
                infinite_count_laststart = infinite_count_start;
                
                var text_count = infinite_count_text
                    .replace('-1', infinite_count_start)
                    .replace('-2', infinite_count_end);
                
                domCache.resultCount.text(text_count);
            }
        }
        
        // Update lazy load function
        infinite_loader_update_lazyload = function () {
            if (typeof domCache.window.lazyLoadXT !== 'undefined' && should_lazy_load()) {
                $(infinite_loader_product_data.products + ' .lazy').find('img').lazyLoadXT();
                
                domCache.products.find('.lazy').on('lazyshow', function () {
                    var $this = $(this);
                    $this.removeClass('lazy')
                        .addClass('animated')
                        .addClass(infinite_loader_product_data.LLanimation || 'fadeIn');
                    
                    if ($this.is('img')) {
                        $this.attr('srcset', $this.data('srcset'));
                    } else {
                        $this.find('img').each(function () {
                            $(this).attr('srcset', $(this).data('srcset'));
                        });
                    }
                    
                    if (!$this.is('.infinite_loader_extra_data')) {
                        $this.next('.infinite_loader_extra_data')
                            .removeClass('lazy')
                            .addClass('animated')
                            .addClass(infinite_loader_product_data.LLanimation || 'fadeIn');
                    }
                });
            }
        };
        
        // Events
        $(document).on('infinite_loader_ajax_loader', function () {
            infinite_loader_update_state(true);
            
            if (typeof domCache.window.lazyLoadXT !== 'undefined' && should_lazy_load()) {
                $(infinite_loader_product_data.item + ', .infinite_loader_extra_data')
                    .addClass('lazy')
                    .find('img')
                    .each(function () {
                        var $img = $(this);
                        $img.attr('data-src', $img.attr('src')).removeAttr('src')
                            .attr('data-srcset', $img.attr('srcset')).removeAttr('srcset');
                    })
                    .lazyLoadXT();
            }
            
            infinite_loader_update_lazyload();
        });
        
        $(document).on('infinite_loader_after_style_set', function () {
            domCache.window.scrollTop(domCache.window.scrollTop() + 1)
                .scrollTop(domCache.window.scrollTop() - 1);
            
            $(infinite_loader_product_data.item + '.animated').trigger('lazyshow');
        });
        
        // Retry handler
        $(document).on('click', '.infinite-loader-retry', function () {
            $('.infinite-loader-error').remove();
            infinite_loader_load_next_page();
        });
    });

    // Scroll to top button
    var scroll_offset = 100;
    var scroll_duration = 500;
    
    $(window).on('scroll', function () {
        if ($(this).scrollTop() < scroll_offset) {
            $('.infinity_loader_topbutton').fadeOut(scroll_duration);
        } else {
            $('.infinity_loader_topbutton').fadeIn(scroll_duration);
        }
    });
    
    $(document).on('click', '.infinity_loader_topbutton', function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, 250);
        return false;
    });

})(jQuery);

// Safe JavaScript execution function
function infinite_loader_exc_js(func) {
    if (typeof func !== 'undefined' && func && func.length > 0) {
        try {
            // Create a sandboxed function with limited scope
            var sandboxed = new Function('jQuery', '$', 'document', 'window', func);
            sandboxed(jQuery, jQuery, document, window);
        } catch (err) {
            if (infinite_loader_product_data && infinite_loader_product_data.debug_mode) {
                console.error('Infinite Loader: JavaScript execution error', err);
            }
        }
    }
}