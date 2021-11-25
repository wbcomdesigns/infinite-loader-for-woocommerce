var infinite_loader_update_state, infinite_loader_product_data, infinite_loader_load_next_page, infinite_loader_ajax_instance = false, infinite_loader_update_lazyload, infinite_loader_init, infinite_loader_init_buttons;
(function ($) {
    $('body').append($('<div class="infinite_loader_preload">'
        + infinite_loader_product_data.load_image
        + infinite_loader_product_data.infinite_loader_btn_setting_load_image
        + infinite_loader_product_data.infinite_loader_btn_setting_use_image
        + infinite_loader_product_data.infinite_loader_prev_btn_setting_load_image
        + infinite_loader_product_data.infinite_loader_prev_btn_setting_use_image
        + '</div>'));
    $(document).ready(function () {
        var infinite_loader_loading = false, infinite_loader_type;
        var infinite_count_start = 0, infinite_count_end = 0, infinite_count_laststart = 0, infinite_count_lastend = 0, infinite_count_text = '';
        infinite_loader_init = function () {
            infinite_loader_loading = false, infinite_loader_type, infinite_count_start = 0, infinite_count_end = 0, infinite_count_laststart = 0, infinite_count_lastend = 0, infinite_count_text = '';
            $('.infinite_loader_preload').remove();
            if ($(infinite_loader_product_data.products).find(infinite_loader_product_data.item).first().length) {
                $(infinite_loader_product_data.products).find(infinite_loader_product_data.item).first().addClass('infinite_loader_btn').attr('data-url', decodeURIComponent(location.href));
            }
            if ($(infinite_loader_product_data.products).find('.infinite_loader_extra_data').first().length) {
                $(infinite_loader_product_data.products).find('.infinite_loader_extra_data').first().addClass('infinite_loader_btn').attr('data-url', decodeURIComponent(location.href));
            }
            if ($('.infinite_loader_product_count').length) {
                infinite_count_start = $('.infinite_loader_product_count').data('start');
                infinite_count_end = $('.infinite_loader_product_count').data('end');
                infinite_count_text = $('.infinite_loader_product_count').data('text');
                infinite_count_laststart = infinite_count_start;
                infinite_count_lastend = infinite_count_end;
            }
        }
        infinite_loader_init();
        if ($(infinite_loader_product_data.products).length > 0) {
            infinite_loader_init_buttons = function () {
                $(infinite_loader_product_data.products).after($(infinite_loader_product_data.load_more));
                if (infinite_loader_product_data.use_prev_btn) {
                    $(infinite_loader_product_data.products).before($(infinite_loader_product_data.load_prev));
                }
            }
            infinite_loader_init_buttons();
            current_style();
            if (infinite_loader_type != 'none') {
                $(window).resize(function () {
                    current_style();
                });
                if (typeof infinite_loader_product_data.update_url != "undefined" && infinite_loader_product_data.update_url == 1) {
                    window.onpopstate = function (event) {
                        var state = event.state;
                        if (typeof (state) != 'undefined' && state != null && typeof (state.blmp) != 'undefined' && state.blmp == 'br_lmp_popstate') {
                            if (infinite_loader_type !== 'pagination') {
                                if (!infinite_loader_loading) {
                                    infinite_loader_loading = true;
                                    if ($('.infinite_loader_btn[data-url="' + decodeURIComponent(location.href) + '"]').length) {
                                        $('html, body').stop().animate({
                                            scrollTop: $('.infinite_loader_btn[data-url="' + decodeURIComponent(location.href) + '"]').offset().top
                                        }, 500, function () { infinite_loader_loading = false; });
                                    } else {
                                        location.reload();
                                    }
                                }
                            } else {
                                if (infinite_loader_ajax_instance != false) {
                                    infinite_loader_ajax_instance.abort();
                                    end_ajax_loading();
                                }
                                infinite_loader_load_next_page(true, decodeURIComponent(location.href));
                            }
                        }
                    }
                }
                var br_load_more_html5_wait;
                function br_load_more_html5() {
                    clearTimeout(br_load_more_html5_wait);
                    br_load_more_html5_wait = setTimeout(function () {
                        if (typeof infinite_loader_product_data.update_url != "undefined" && infinite_loader_product_data.update_url == 1) {
                            if (!infinite_loader_loading) {
                                if (infinite_loader_type !== 'pagination') {
                                    var next_page = '';
                                    $('.infinite_loader_btn').each(function (i, o) {
                                        if (!$(o).is(':visible')) {
                                            return true;
                                        }
                                        if ($(o).offset().top > $(window).scrollTop() + ($(window).height() / 2)) {
                                            return false;
                                        }
                                        next_page = $(o).attr('data-url');
                                    });
                                    if (!next_page) {
                                        next_page = $('.infinite_loader_btn').first().attr('data-url');
                                    }
                                    var current_state = history.state;
                                    if (next_page && decodeURIComponent(location.href) != next_page && (current_state == null || typeof (current_state.link) == 'undefined' || current_state.link != next_page)) {
                                        var history_data = { blmp: 'br_lmp_popstate' };
                                        history.replaceState(history_data, "");
                                        var history_data = { blmp: 'br_lmp_popstate', link: next_page };
                                        history.pushState(history_data, "", next_page);
                                        history.pathname = next_page;
                                    }
                                }
                            }
                        }
                    }, 50);
                }
                $(document).on('infinite_loader_ajax_filter_start', function () {
                    infinite_loader_loading = true;
                });
                $(document).on('infinite_loader_ajax_filter_end', function () {
                    infinite_loader_loading = false;
                });
                $(window).scroll(function () {

                    if (!infinite_loader_loading) {
                        br_load_more_html5();
                        if (infinite_loader_type == 'infinity-scroll') {
                            var products_bottom = $(infinite_loader_product_data.products).offset().top + $(infinite_loader_product_data.products).height() - infinite_loader_product_data.buffer;
                            var bottom_position = $(window).scrollTop() + $(window).height();
                            if (products_bottom < bottom_position && !infinite_loader_loading) {
                                infinite_loader_update_state();
                                infinite_loader_load_next_page();
                            }
                        }
                    }
                });
                $(document).on('click', '.infinite_loader_btn_setting .infinite_button', function (event) {
                    event.preventDefault();
                    infinite_loader_load_next_page();
                });
                $(document).on('click', '.infinite_loader_prev_btn_setting .infinite_button', function (event) {
                    event.preventDefault();
                    infinite_loader_load_next_page(2, $(this).attr('href'));
                });
                if (!infinite_loader_product_data.is_AAPF || typeof the_ajax_script == 'undefined') {
                    $(document).on('click', infinite_loader_product_data.pagination + ' a', function (event) {
                        event.preventDefault();
                        var next_page = $(this).attr('href');
                        if (typeof infinite_loader_product_data.update_url != "undefined" && infinite_loader_product_data.update_url == 1) {
                            var history_data = { blmp: 'br_lmp_popstate' };
                            history.replaceState(history_data, "");
                            var history_data = { blmp: 'br_lmp_popstate', link: next_page };
                            history.pushState(history_data, "", next_page);
                            history.pathname = next_page;
                        }
                        infinite_loader_load_next_page(true, next_page);
                    });
                }
            }
        }

        infinite_loader_load_next_page = function (replace, user_next_page) {
            if (!infinite_loader_loading) {
                if (typeof (replace) == 'undefined') {
                    user_next_page = false;
                }
                if (typeof (user_next_page) == 'undefined') {
                    user_next_page = false;
                }
                var $next_page = jquery_get_next_page();
                if ($next_page.length > 0 || user_next_page !== false) {
                    start_ajax_loading(replace);
                    var next_page;
                    if (user_next_page !== false) {
                        next_page = user_next_page;
                    } else {
                        next_page = $next_page.attr('href');
                    }
                    infinite_loader_ajax_instance = $.ajax({
                        method: "GET", url: next_page, beforeSend: function (xhr) {
                            xhr.setRequestHeader('X-Braapfdisable', '1');
                        }, success: function (data) {
                            infinite_loader_ajax_instance = false;
                            var $data = $('<div>' + data + '</div>');
                            if (infinite_loader_product_data.lazy_load_m && $(window).width() <= infinite_loader_product_data.mobile_width || infinite_loader_product_data.lazy_load && $(window).width() > infinite_loader_product_data.mobile_width) {
                                $data.find(infinite_loader_product_data.products + ' .lazy,' + infinite_loader_product_data.item + ', .infinite_loader_extra_data').find('img').each(function (i, o) {
                                    $(o).attr('data-src', $(o).attr('src')).removeAttr('src');
                                    $(o).attr('data-srcset', $(o).attr('srcset')).removeAttr('srcset');
                                });
                                $data.find(infinite_loader_product_data.item + ', .infinite_loader_extra_data').addClass('lazy');
                            }
                            if ($data.find(infinite_loader_product_data.products).find(infinite_loader_product_data.item).first().length) {
                                $data.find(infinite_loader_product_data.products).find(infinite_loader_product_data.item).first().addClass('infinite_loader_btn').attr('data-url', decodeURIComponent(next_page));
                            }
                            if ($data.find(infinite_loader_product_data.products).find('.infinite_loader_extra_data').first().length) {
                                $data.find(infinite_loader_product_data.products).find('.infinite_loader_extra_data').first().addClass('infinite_loader_btn').attr('data-url', decodeURIComponent(next_page));
                            }
                            var $products = $data.find(infinite_loader_product_data.products).html();
                            if (replace == 1) {
                                $(infinite_loader_product_data.products).html($products);
                            } else if (replace == 2) {
                                $products = $data.find(infinite_loader_product_data.products);
                                $products.find(infinite_loader_product_data.item).addClass('infnite_loader_hidden');
                                var count_images = $products.find(infinite_loader_product_data.item).find('img').length;
                                $products = $products.html();
                                $(infinite_loader_product_data.products).prepend($products);
                                infinite_loader_display_hidden_executed = false;
                                function infinite_loader_display_hidden() {
                                    if (!infinite_loader_display_hidden_executed) {
                                        infinite_loader_display_hidden_executed = true;
                                        var object = $(infinite_loader_product_data.products).find(infinite_loader_product_data.item + ':not(".infnite_loader_hidden")').first();
                                        var positionOld = object.offset().top;
                                        var scrollTop = $(window).scrollTop();
                                        $('.infnite_loader_hidden').removeClass('infnite_loader_hidden');
                                        end_ajax_loading();
                                        var positionNew = object.offset().top;
                                        $(window).scrollTop(positionNew - (positionOld - scrollTop));
                                    }
                                }
                                $(infinite_loader_product_data.products).find('.infnite_loader_hidden').find('img').on('load error', function () {
                                    count_images--;
                                    if (count_images <= 1) {
                                        infinite_loader_display_hidden();
                                    }
                                });
                                setTimeout(infinite_loader_display_hidden, 2500);
                            } else {
                                $(infinite_loader_product_data.products).append($products);
                            }
                            infinite_loader_update_lazyload();
                            if (infinite_loader_type !== 'pagination') {
                                if ($data.find('.infinite_loader_product_count').length && (infinite_count_start || infinite_count_end)) {
                                    infinite_count_text = $data.find('.infinite_loader_product_count').data('text');
                                    if (replace == 2) {
                                        infinite_count_start = $data.find('.infinite_loader_product_count').data('start');
                                    } else {
                                        infinite_count_end = $data.find('.infinite_loader_product_count').data('end');
                                    }
                                    infinite_count_lastend = $data.find('.infinite_loader_product_count').data('end');
                                    infinite_count_laststart = $data.find('.infinite_loader_product_count').data('start');
                                    text_count = infinite_count_text;
                                    text_count = text_count.replace('-1', infinite_count_start);
                                    text_count = text_count.replace('-2', infinite_count_end);
                                    $('.woocommerce-result-count').text(text_count);
                                } else {
                                    $('.woocommerce-result-count').text($data.find('.woocommerce-result-count:first').text());
                                }
                            }
                            else {
                                $('.woocommerce-result-count').text($data.find('.woocommerce-result-count:first').text());
                            }

                            var $pagination = $data.find(infinite_loader_product_data.pagination);
                            if (replace == 1) {
                                $(infinite_loader_product_data.pagination).html($pagination.html());
                            } else if (infinite_loader_product_data.type == 'load-more-button-and-ajax-pagination') {
                                $(infinite_loader_product_data.pagination).html($pagination.html());
                                //pagination_replace_partial($data, replace);
                            } else if (replace == 2) {
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
                            current_style();
                            infinite_loader_load_products();
                            if (replace != 2) {
                                end_ajax_loading();
                            }
                        }
                    });
                }
            }
        }
        function pagination_replace_partial($data, replace) {
            var $pagination = $(infinite_loader_product_data.pagination);
            var $new_pagination = $data.find(infinite_loader_product_data.pagination);
            var $prev_page = jquery_get_prev_page();
            var $new_prev_page = jquery_get_prev_page($data);
            var $next_page = jquery_get_next_page();
            var $new_next_page = jquery_get_next_page($data);
            var easy_way = true;
            if (($pagination.find(infinite_loader_product_data.next_page).length || $pagination.find(infinite_loader_product_data.prev_page).length) && $pagination.find('.current').length) {
                if (replace == 2) {
                    var $current = $pagination.find('.current').last();
                    var $new_current = $new_pagination.find('.current').last();
                } else {
                    var $current = $pagination.find('.current').first();
                    var $new_current = $new_pagination.find('.current').first();
                }
                var $current_block = get_current_page_last_block($current);
                var $new_current_block = get_current_page_last_block($new_current);
                var html_between_current = '';
                if (infinite_loader_product_data.html_between_current) {
                    html_between_current = infinite_loader_product_data.html_between_current;
                }
                if ($current_block !== false && $new_current_block !== false) {
                    easy_way = false;
                    if (replace == 2) {
                        $current_block.prevAll().remove();
                        while ($new_current_block.prevAll().length) {
                            $current_block.before($new_current_block.prevAll().last());
                        }
                        $current_block.before($new_current_block);
                        if (html_between_current) {
                            $current_block.before($(html_between_current));
                        }
                    } else {
                        $current_block.nextAll().remove();
                        $current_block.after($new_current_block.nextAll());
                        $current_block.after($new_current_block);
                        if (html_between_current) {
                            $current_block.after($(html_between_current));
                        }
                    }
                }
            }
            if (easy_way) {
                if (replace == 2) {
                    if ($next_page.length) {
                        $new_next_page.replaceWith($next_page);
                    } else {
                        $new_next_page.remove();
                    }
                } else {
                    if ($prev_page.length) {
                        $new_prev_page.replaceWith($prev_page);
                    } else {
                        $new_prev_page.remove();
                    }
                }
                $pagination.html($new_pagination.html());
            }
        }
        function get_current_page_last_block($current) {
            var $i = 10;
            var $needed_block
            do {
                $i--;
                $needed_block = $current;
                $current = $current.parent();
            } while ($i > 0 && !(($current.find(infinite_loader_product_data.next_page).length || $current.find(infinite_loader_product_data.prev_page).length) && $current.find('.current').length));
            if ($i <= 0) {
                return false;
            } else {
                return $needed_block;
            }
        }
        function woocommerce_result_count_update() {
            if (infinite_loader_type !== 'pagination') {
                if ($('.infinite_loader_product_count').length) {
                    infinite_count_start = $('.infinite_loader_product_count').data('start');
                    infinite_count_end = $('.infinite_loader_product_count').data('end');
                    infinite_count_text = $('.infinite_loader_product_count').data('text');
                    infinite_count_lastend = infinite_count_end;
                    infinite_count_laststart = infinite_count_start;
                    text_count = infinite_count_text;
                    text_count = text_count.replace('-1', infinite_count_start);
                    text_count = text_count.replace('-2', infinite_count_end);
                    $('.woocommerce-result-count').text(text_count);
                }
            }
        }
        function start_ajax_loading(replace) {
            infinite_loader_loading = true;
            jQuery('body').addClass('infinite_loader_ajax_loading');
            infinite_loader_exc_js(infinite_loader_product_data.javascript.before_update);
            $(document).trigger('infinite_loader_product_start');
            if (replace == 2) {
                $(infinite_loader_product_data.products).before($(infinite_loader_product_data.load_image));
                $(document).trigger('infinite_loader_product_start_prev');
            } else {
                $(infinite_loader_product_data.products).after($(infinite_loader_product_data.load_image));
                $(document).trigger('infinite_loader_product_start_next');
            }
        }
        function end_ajax_loading() {
            if (typeof ($(infinite_loader_product_data.products).isotope) == 'function' && $(infinite_loader_product_data.products).data('isotope')) {
                $(infinite_loader_product_data.products).isotope('reloadItems');
                $(infinite_loader_product_data.products).isotope();
            }
            $(infinite_loader_product_data.load_img_class).remove();
            $(document).trigger('infinite_loader_ajax_load_products');
            $(document).trigger('infinite_loader_ajax_btn_end');
            infinite_loader_exc_js(infinite_loader_product_data.javascript.after_update);
            jQuery('body').removeClass('infinite_loader_ajax_loading');
            infinite_loader_loading = false;
            var $next_page = jquery_get_next_page();
            if ((infinite_loader_type == 'infinity-scroll' || infinite_loader_type == 'load-more-button') && $next_page.length <= 0) {
                $(infinite_loader_product_data.products).append($(infinite_loader_product_data.end_text));
            }
            br_load_more_html5();
        }
        function current_style() {
            var $next_page = jquery_get_next_page();
            if ($next_page.length > 0) {
                $('.infinite_loader_btn_setting .infinite_button').attr('href', $next_page.attr('href'));
            }
            var $prev_page = jquery_get_prev_page();
            if ($prev_page.length > 0) {
                $('.infinite_loader_prev_btn_setting .infinite_button').attr('href', $prev_page.attr('href'));
            }
            if (infinite_loader_product_data.use_mobile && $(window).width() <= infinite_loader_product_data.mobile_width) {
                set_style(infinite_loader_product_data.mobile_type);
            } else {
                set_style(infinite_loader_product_data.type);
            }
        }
        var Timeout_test_prev_page = false;
        function set_style(style) {
            $('.infinite_loader_btn_load').hide();
            if (style != 'none') {
                var $next_page = jquery_get_next_page();
                $(infinite_loader_product_data.pagination).hide();
                if (style == 'load-more-button') {
                    if ($next_page.length > 0) {
                        $('.infinite_loader_btn_load.infinite_loader_btn_setting').show();
                    } else {
                        setTimeout(test_next_page, 4000);
                    }
                } else if (style == 'pagination') {
                    $(infinite_loader_product_data.pagination).show();
                } else if (style == 'load-more-button-and-ajax-pagination') {
                    $(infinite_loader_product_data.pagination).show();
                    if ($next_page.length > 0) {
                        $('.infinite_loader_btn_load.infinite_loader_btn_setting').show();
                    } else {
                        setTimeout(test_next_page, 4000);
                    }
                }
                var $prev_page = jquery_get_prev_page();
                if ($prev_page.length > 0) {
                    $('.infinite_loader_btn_load.infinite_loader_prev_btn_setting').show();
                } else {
                    if (Timeout_test_prev_page != false) {
                        clearTimeout(Timeout_test_prev_page);
                    }
                    Timeout_test_prev_page = setTimeout(test_prev_page, 4000);
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
                if (Timeout_test_prev_page != false) {
                    clearTimeout(Timeout_test_prev_page);
                }
                Timeout_test_prev_page = setTimeout(test_prev_page, 4000);
            }
        }
        function jquery_get_next_page($parent) {
            if (typeof ($parent) == 'undefined') {
                $parent = $(document);
            }
            var $pagination = $parent.find(infinite_loader_product_data.pagination);
            if ($pagination.find(infinite_loader_product_data.next_page).length > 0) {
                $next_page = $pagination.find(infinite_loader_product_data.next_page);
            } else {
                $next_page = $parent.find(infinite_loader_product_data.next_page);
            }
            return $next_page;
        }
        function jquery_get_prev_page($parent) {
            if (typeof ($parent) == 'undefined') {
                $parent = $(document);
            }
            var $pagination = $parent.find(infinite_loader_product_data.pagination);
            if ($pagination.find(infinite_loader_product_data.prev_page).length > 0) {
                $prev_page = $pagination.find(infinite_loader_product_data.prev_page);
            } else {
                $prev_page = $parent.find(infinite_loader_product_data.prev_page);
            }
            return $prev_page;
        }
        infinite_loader_update_state = function (reset_count) {
            if (typeof reset_count == 'undefined') {
                reset_count = false;
            }
            if (!$(infinite_loader_product_data.products).find(infinite_loader_product_data.item).first().is('.infinite_loader_btn')) {
                $(infinite_loader_product_data.products).find(infinite_loader_product_data.item).first().addClass('infinite_loader_btn').attr('data-url', decodeURIComponent(location.href));
            }
            current_style();
            if (reset_count) {
                woocommerce_result_count_update();
            }
        }
        $(document).on('infinite_loader_ajax_loader', function () {
            infinite_loader_update_state(true);
            if (typeof $(window).lazyLoadXT != 'undefined') {
                if (infinite_loader_product_data.lazy_load_m && $(window).width() <= infinite_loader_product_data.mobile_width || infinite_loader_product_data.lazy_load && $(window).width() > infinite_loader_product_data.mobile_width) {
                    jQuery(infinite_loader_product_data.item + ', .infinite_loader_extra_data').addClass('lazy').find('img').each(
                        function (i, o) {
                            jQuery(o)
                                .attr('data-src', jQuery(o).attr('src')).removeAttr('src')
                                .attr('data-srcset', jQuery(o).attr('srcset')).removeAttr('srcset');
                        }
                    ).lazyLoadXT();
                }
            }
            infinite_loader_update_lazyload();
        });
        $(document).on('infinite_loader_after_style_set', function () {
            jQuery(window).scrollTop(jQuery(window).scrollTop() + 1).scrollTop(jQuery(window).scrollTop() - 1);
            jQuery(infinite_loader_product_data.item + '.animated').trigger('lazyshow');
        });
        infinite_loader_update_lazyload = function () {
            if (typeof $(window).lazyLoadXT != 'undefined') {
                if (infinite_loader_product_data.lazy_load_m && $(window).width() <= infinite_loader_product_data.mobile_width || infinite_loader_product_data.lazy_load && $(window).width() > infinite_loader_product_data.mobile_width) {
                    $(infinite_loader_product_data.products + ' .lazy').find('img').lazyLoadXT();
                    $(infinite_loader_product_data.products).find('.lazy').on('lazyshow', function () {
                        $(this).removeClass('lazy').addClass('animated').addClass(infinite_loader_product_data.LLanimation);
                        if ($(this).is('img')) {
                            $(this).attr('srcset', $(this).data('srcset'));
                        } else {
                            $(this).find('img').each(function (i, o) {
                                $(o).attr('srcset', $(o).data('srcset'));
                            });
                        }
                        if (!$(this).is('.infinite_loader_extra_data')) {
                            $(this).next('.infinite_loader_extra_data').removeClass('lazy').addClass('animated').addClass(infinite_loader_product_data.LLanimation);
                        }
                    });
                }
            }
        }
        infinite_loader_load_products = function () {
            $(window).trigger('resize');
            try {
                if (typeof (InfiniteScroll) == 'function') {
                    var infScroll = InfiniteScroll.data('.shop-container .products');
                    if (typeof (infScroll) == 'object' && infScroll.options) {
                        var infOptionsStore = infScroll.options;
                        infScroll.destroy();
                        jQuery('.shop-container .products').data('infiniteScroll', '').infiniteScroll(infOptionsStore);
                    }
                }
            } catch (e) { }
        }
    });
})(jQuery);
function infinite_loader_exc_js(func) {
    if (infinite_loader_product_data.javascript != 'undefined'
        && infinite_loader_product_data.javascript != null
        && typeof func != 'undefined'
        && func.length > 0) {
        try {
            eval(func);
        } catch (err) {
            alert('You have some incorrect JavaScript code (Load More Products)');
        }
    }
}

