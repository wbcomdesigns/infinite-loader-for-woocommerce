# Infinite Loader for WooCommerce - Frequently Asked Questions

## Table of Contents
1. [General Questions](#general-questions)
2. [Installation & Setup](#installation--setup)
3. [Configuration & Settings](#configuration--settings)
4. [Troubleshooting](#troubleshooting)
5. [Compatibility](#compatibility)
6. [Performance](#performance)
7. [Customization](#customization)
8. [Technical Questions](#technical-questions)

## General Questions

### What is Infinite Loader for WooCommerce?
Infinite Loader for WooCommerce is a plugin that replaces traditional pagination on your WooCommerce shop pages with modern loading methods like infinite scroll or load more buttons. It uses AJAX to load products without page refreshes, creating a smoother shopping experience.

### What are the main features?
- **Three loading modes**: Infinite scroll, Load more button, and AJAX pagination
- **Fully customizable**: Style buttons to match your theme
- **Performance optimized**: Lazy loading and efficient queries
- **Mobile friendly**: Responsive design and touch support
- **SEO friendly**: Optional URL updates for better tracking
- **Developer friendly**: Hooks and filters for customization

### Is it free to use?
Yes, the plugin is free to use. We also offer a Pro version with additional features like:
- Advanced filtering integration
- Multiple button styles
- Custom animations
- Priority support

### How does it improve user experience?
- **Faster browsing**: No page reloads mean faster product discovery
- **Seamless navigation**: Users stay engaged without interruption
- **Mobile optimization**: Better experience on touch devices
- **Reduced bounce rate**: Users are more likely to view more products

## Installation & Setup

### What are the requirements?
- WordPress 5.0 or higher
- WooCommerce 3.0 or higher
- PHP 7.2 or higher
- Modern browser with JavaScript enabled

### Why isn't the plugin working after activation?
1. **Check WooCommerce is active**: The plugin requires WooCommerce to function
2. **Clear cache**: Clear your browser and any caching plugin cache
3. **Check for JavaScript errors**: Open browser console (F12) and look for errors
4. **Verify theme compatibility**: Some themes may need custom selectors

### How do I set it up quickly?
1. Install and activate the plugin
2. Go to WB Plugins → Infinite Loader for WooCommerce
3. Choose your loading type in General settings
4. Save changes and visit your shop page

### Do I need to configure anything else?
Basic setup works out of the box. You may want to:
- Adjust products per page (default is 8)
- Customize button styling to match your theme
- Add custom CSS for unique designs

## Configuration & Settings

### What's the difference between loading types?

**Infinite Scroll**
- Products load automatically as you scroll
- Best for: Mobile users, image-heavy stores
- Pros: Hands-free browsing
- Cons: Can disorient some users

**Load More Button**
- Users click to load more products
- Best for: Desktop users, controlled browsing
- Pros: User has control, clear loading points
- Cons: Requires user action

**AJAX Pagination**
- Traditional page numbers with AJAX loading
- Best for: Users who prefer classic navigation
- Pros: Familiar interface, precise navigation
- Cons: More clicks required

### How many products should I load per page?
- **Mobile**: 8-12 products recommended
- **Desktop**: 12-24 products recommended
- **Large catalogs**: Start with fewer, increase if performance is good
- **Image-heavy stores**: Fewer products to maintain speed

### Can I have different settings for mobile and desktop?
Currently, the plugin uses the same settings for all devices. You can use custom CSS media queries to adjust styling for different screen sizes.

### What do the Font Awesome settings do?
- **Enable Font Awesome**: Loads the icon library for loading animations
- **Loading Image**: Choose from 400+ icons for your loading animation
- **Rotate Image**: Adds a spinning animation to the loading icon

### Should I prevent URL updates?
- **Enable URL updates**: Better for SEO and analytics tracking
- **Disable URL updates**: Cleaner for single-page experience
- Choose based on your tracking and SEO needs

## Troubleshooting

### Products aren't loading - what should I check?

1. **JavaScript Console**
   ```javascript
   // Open browser console (F12) and look for:
   // - Red error messages
   // - Failed network requests
   // - 404 errors on AJAX calls
   ```

2. **Theme Compatibility**
   - Check if your theme uses standard WooCommerce classes
   - Verify `.products` and `.product` selectors exist
   - Try with a default theme like Storefront

3. **Plugin Conflicts**
   - Deactivate other plugins one by one
   - Common conflicts: Caching plugins, minification plugins, other AJAX plugins

4. **Server Issues**
   - Check PHP error logs
   - Verify AJAX endpoint is accessible
   - Ensure sufficient PHP memory limit

### The button isn't showing up

1. **Check Loading Type**
   - Ensure "Load More Button" is selected
   - Verify there are more products to load

2. **CSS Issues**
   ```css
   /* Add to custom CSS to force visibility */
   .infinite_loader_btn_load {
       display: block !important;
       z-index: 9999;
   }
   ```

3. **Theme Overrides**
   - Inspect element to check for conflicting styles
   - Look for `display: none` on parent elements

### Loading is very slow

1. **Optimize Images**
   - Use appropriate image sizes
   - Compress images before upload
   - Consider lazy loading plugin

2. **Reduce Products Per Page**
   - Start with 8-12 products
   - Increase gradually if performance is good

3. **Server Performance**
   - Check hosting resources
   - Enable caching plugins
   - Consider CDN for images

### Duplicate products are showing

This usually happens with:
- Caching conflicts
- Custom query modifications
- Theme compatibility issues

Solutions:
1. Clear all caches
2. Check for query modification plugins
3. Disable other filtering plugins temporarily

## Compatibility

### Which themes are compatible?
The plugin works with any properly coded WooCommerce theme. Tested with:
- Storefront (100% compatible)
- Astra
- OceanWP
- Flatsome
- Divi
- Avada
- Most ThemeForest themes

### Which plugins might conflict?
Potential conflicts with:
- Other infinite scroll plugins
- AJAX filter plugins (may need configuration)
- Heavy JavaScript plugins
- Some page builders (in rare cases)

### Does it work with WooCommerce Blocks?
Yes, the plugin detects and supports WooCommerce Blocks with appropriate selectors.

### Is it compatible with WPML/Polylang?
Yes, the plugin is translation-ready and works with multilingual plugins. Button text can be translated through the settings.

### Does it work with product filter plugins?
Most filter plugins work fine. Some may need additional configuration:
```javascript
// Trigger plugin after filters update
$(document).on('filter_ajax_complete', function() {
    infinite_loader_update_state(true);
});
```

## Performance

### How does it affect page load time?
- **Initial load**: Slightly faster (fewer products loaded)
- **Subsequent loads**: No page refresh = faster browsing
- **Overall**: Better perceived performance

### Does it impact SEO?
- **With URL updates**: Minimal impact, pages remain crawlable
- **Without URL updates**: May affect deep page indexing
- **Recommendation**: Keep URL updates enabled for better SEO

### How can I optimize performance?

1. **Image Optimization**
   ```bash
   # Recommended image sizes
   Thumbnail: 300x300
   Catalog: 600x600
   Single: 1024x1024
   ```

2. **Caching Configuration**
   - Enable browser caching
   - Use object caching
   - Configure CDN for static assets

3. **Server Optimization**
   - PHP 7.4+ recommended
   - Adequate memory limit (256MB+)
   - Enable OPcache

### What about mobile data usage?
- Products load on-demand, potentially saving data
- Users only load what they view
- Consider fewer products per page on mobile

## Customization

### How do I style the button to match my theme?

1. **Using Plugin Settings**
   - Adjust colors, padding, borders in Button Style tab
   - Add custom CSS class for advanced styling

2. **Custom CSS Examples**
   ```css
   /* Gradient button */
   .infinite_button {
       background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
       border: none;
       box-shadow: 0 4px 15px rgba(0,0,0,0.2);
   }
   
   /* Outline style */
   .infinite_button {
       background: transparent;
       border: 2px solid #333;
       color: #333;
   }
   
   /* Hover animation */
   .infinite_button:hover {
       transform: translateY(-2px);
       box-shadow: 0 7px 20px rgba(0,0,0,0.3);
   }
   ```

### Can I add custom loading animations?

Yes! Use custom CSS:
```css
/* Pulse animation */
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.infinite_loader_products_loading {
    animation: pulse 1.5s infinite;
}

/* Custom spinner */
.infinite_loader_products_loading:after {
    content: '';
    width: 40px;
    height: 40px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #333;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
```

### How do I integrate with my custom theme?

1. **Custom Selectors**
   ```php
   add_filter('infinite_loader_products_selector', function() {
       return '.my-custom-products-container';
   });
   ```

2. **Custom Events**
   ```javascript
   $(document).on('infinite_loader_products_loaded', function() {
       // Reinitialize your theme features
       myTheme.initProductCards();
   });
   ```

### Can I modify the AJAX behavior?

Yes, use JavaScript callbacks:
```javascript
// Before products load
infinite_loader_product_data.javascript.before_update = `
    jQuery('.shop-filters').addClass('loading');
    console.log('Starting to load products...');
`;

// After products load
infinite_loader_product_data.javascript.after_update = `
    jQuery('.shop-filters').removeClass('loading');
    initializeProductQuickView();
`;
```

## Technical Questions

### How does the AJAX loading work?
1. User triggers load (scroll/click)
2. JavaScript sends AJAX request with nonce
3. WordPress processes request normally
4. Plugin extracts product HTML from response
5. JavaScript updates DOM with new products

### Is the plugin secure?
Yes, security measures include:
- Nonce verification on all AJAX requests
- Input sanitization and validation
- Output escaping
- Rate limiting to prevent abuse
- No direct database queries

### Can I use it with a headless setup?
The plugin is designed for traditional WordPress setups. For headless applications, you'd need to:
- Implement your own API endpoints
- Handle the frontend logic separately
- Use the plugin's PHP functions for product queries

### How do I debug issues?

1. **Enable Debug Mode**
   ```php
   // In wp-config.php
   define('WP_DEBUG', true);
   define('WP_DEBUG_LOG', true);
   define('SCRIPT_DEBUG', true);
   ```

2. **Check Browser Console**
   ```javascript
   // Look for errors
   console.log(infinite_loader_product_data);
   ```

3. **Monitor Network Tab**
   - Check AJAX requests
   - Verify response format
   - Look for 404 or 500 errors

### Where are settings stored?
Settings are stored in WordPress options table:
- `infinite_loader_admin_general_option`
- `infinite_loader_admin_button_option`
- `infinite_loader_admin_previous_button_option`
- `infinite_loader_admin_css_js_option`

### Can I programmatically change settings?
```php
// Example: Change loading type
$options = get_option('infinite_loader_admin_general_option');
$options['product_loading_type'] = 'infinity-scroll';
update_option('infinite_loader_admin_general_option', $options);
```

### How do I contribute or report bugs?
- **GitHub**: Submit issues and pull requests
- **WordPress.org**: Use the support forum
- **Email**: Contact support for urgent issues

### Is the plugin actively maintained?
Yes! We regularly update the plugin for:
- WordPress core updates
- WooCommerce compatibility
- Security patches
- New features based on user feedback