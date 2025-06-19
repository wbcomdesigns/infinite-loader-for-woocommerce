# Infinite Loader for WooCommerce - User Guide

## Table of Contents
1. [Introduction](#introduction)
2. [Installation](#installation)
3. [Getting Started](#getting-started)
4. [Configuration](#configuration)
   - [General Settings](#general-settings)
   - [Button Style Settings](#button-style-settings)
   - [Previous Button Style](#previous-button-style)
   - [JavaScript/CSS Settings](#javascriptcss-settings)
5. [Usage Examples](#usage-examples)
6. [Troubleshooting](#troubleshooting)
7. [Best Practices](#best-practices)

## Introduction

Infinite Loader for WooCommerce enhances your online store's browsing experience by replacing traditional pagination with modern loading methods. Choose between infinite scroll, load more button, or enhanced pagination to keep customers engaged and reduce page loads.

### Key Features
- 🔄 **Infinite Scroll** - Products load automatically as users scroll
- 🔘 **Load More Button** - Users control when to load more products
- 📄 **Enhanced Pagination** - AJAX-powered page navigation
- 🎨 **Fully Customizable** - Style buttons to match your theme
- 📱 **Mobile Optimized** - Responsive design for all devices
- ⚡ **Performance Focused** - Lazy loading and optimized queries

## Installation

### Requirements
- WordPress 5.0 or higher
- WooCommerce 3.0 or higher
- PHP 7.2 or higher

### Installation Steps

1. **Upload Plugin**
   - Download the plugin ZIP file
   - Go to WordPress Admin → Plugins → Add New
   - Click "Upload Plugin" and select the ZIP file
   - Click "Install Now"

2. **Activate Plugin**
   - After installation, click "Activate"
   - You'll be redirected to the plugin settings

3. **Verify Installation**
   - Check that "WB Plugins" appears in your admin menu
   - Navigate to WB Plugins → Infinite Loader for WooCommerce

## Getting Started

### Quick Setup

1. **Choose Loading Type**
   - Go to WB Plugins → Infinite Loader for WooCommerce
   - Select the "General" tab
   - Choose your preferred loading type:
     - **Infinite Scroll** - Best for mobile and modern designs
     - **Load More Button** - Gives users control
     - **Pagination** - Traditional with AJAX enhancement

2. **Set Products Per Page**
   - Enter the number of products to load at once
   - Recommended: 12-24 products

3. **Save Changes**
   - Click "Save Changes"
   - Visit your shop page to see it in action!

## Configuration

### General Settings

#### Products Loading Type
Choose how products are loaded on your shop pages:

- **Infinite Scroll**
  - Products load automatically when users reach the bottom
  - Best for: Mobile users, long product catalogs
  - Pros: Seamless browsing, no clicks required
  - Cons: Can be disorienting for some users

- **Load More Button**
  - Users click a button to load more products
  - Best for: Desktop users, controlled browsing
  - Pros: User control, clear loading points
  - Cons: Requires user action

- **Pagination**
  - Traditional pagination enhanced with AJAX
  - Best for: Users who prefer classic navigation
  - Pros: Familiar interface, precise navigation
  - Cons: More clicks required

#### Products Per Page
- Set between 1-100 products
- Consider your product image sizes
- Balance between performance and user experience

#### Font Awesome Icons
- Enable to use icon library for loading animations
- Provides 400+ icon options
- Required for custom loading icons

#### Loading Animation
- Choose from various loading icons
- Enable rotation for dynamic effect
- Upload custom loading images

#### URL Management
- **Prevent URL Update**: Keeps the same URL while browsing
- Useful for analytics and sharing

### Button Style Settings

Customize the Load More button appearance:

#### Text Options
- **Button Text**: Default "Load More" (translatable)
- **Custom CSS Class**: Add your own styling classes

#### Color Settings
- **Background Color**: Button fill color
- **Hover Background**: Color on mouse hover
- **Text Color**: Button text color
- **Hover Text Color**: Text color on hover
- **Border Color**: Button border color

#### Dimensions
- **Font Size**: Text size in pixels
- **Padding**: Internal spacing (top, right, bottom, left)
- **Margin**: External spacing
- **Border Width**: Border thickness for each side
- **Border Radius**: Corner roundness

### Previous Button Style

Similar options to Load More button for loading previous products:
- Appears when users have scrolled past initial products
- Allows backward navigation without page refresh
- Fully customizable like the Load More button

### JavaScript/CSS Settings

#### Custom CSS
Add your own styles:
```css
/* Example: Custom button animation */
.infinite_loader_btn_setting .infinite_button {
    transition: all 0.3s ease;
}

.infinite_loader_btn_setting .infinite_button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}
```

#### JavaScript Callbacks

**Before Update**
```javascript
// Hide elements before loading
jQuery('.my-filters').fadeOut();
console.log('Loading products...');
```

**After Update**
```javascript
// Reinitialize features after loading
jQuery('.my-filters').fadeIn();
// Initialize tooltips
jQuery('[data-toggle="tooltip"]').tooltip();
```

## Usage Examples

### Example 1: Modern Infinite Scroll Setup
```
Loading Type: Infinite Scroll
Products Per Page: 20
Font Awesome: Enabled
Loading Icon: fa-spinner (with rotation)
URL Update: Disabled
```

### Example 2: Classic Load More Button
```
Loading Type: Load More Button
Products Per Page: 12
Button Text: "Show More Products"
Background Color: #000000
Text Color: #FFFFFF
Border Radius: 5px
```

### Example 3: Mobile-Optimized Configuration
```
Loading Type: Infinite Scroll
Products Per Page: 10
Loading Icon: fa-circle-notch (with rotation)
Custom CSS:
.infinite_loader_products_loading {
    padding: 20px;
    text-align: center;
}
```

## Troubleshooting

### Products Not Loading

1. **Check Console Errors**
   - Open browser developer tools (F12)
   - Look for JavaScript errors
   - Common issue: jQuery conflicts

2. **Verify Selectors**
   - Ensure your theme uses standard WooCommerce classes
   - Check if `.products` and `.product` classes exist

3. **Plugin Conflicts**
   - Deactivate other plugins one by one
   - Common conflicts: Other AJAX plugins, minification plugins

### Styling Issues

1. **Button Not Visible**
   - Check z-index conflicts
   - Verify color contrast
   - Inspect element for CSS overrides

2. **Layout Problems**
   - Clear browser cache
   - Check responsive settings
   - Test in different browsers

### Performance Issues

1. **Slow Loading**
   - Reduce products per page
   - Optimize product images
   - Enable lazy loading

2. **Memory Issues**
   - Limit total products loaded
   - Use pagination for large catalogs
   - Clear browser cache regularly

## Best Practices

### Performance Optimization

1. **Image Optimization**
   - Use appropriate image sizes
   - Enable lazy loading for images
   - Compress images before upload

2. **Products Per Page**
   - Mobile: 8-12 products
   - Desktop: 12-24 products
   - Consider connection speeds

3. **Loading Indicators**
   - Use clear, visible loading animations
   - Provide feedback to users
   - Consider accessibility

### User Experience

1. **Mobile Considerations**
   - Test on various devices
   - Ensure touch-friendly buttons
   - Consider data usage

2. **Accessibility**
   - Provide keyboard navigation
   - Use descriptive button text
   - Ensure color contrast

3. **SEO Considerations**
   - Enable URL updates for better tracking
   - Ensure products are crawlable
   - Test with Google Search Console

### Maintenance

1. **Regular Updates**
   - Keep plugin updated
   - Test after WooCommerce updates
   - Backup before major changes

2. **Performance Monitoring**
   - Track page load times
   - Monitor server resources
   - Check error logs regularly

3. **User Feedback**
   - Monitor bounce rates
   - Collect user feedback
   - A/B test different configurations

## Advanced Tips

### Custom Integration
- Use WordPress hooks for customization
- Trigger custom events on load
- Integrate with analytics tools

### Theme Compatibility
- Test with your theme
- Adjust selectors if needed
- Contact support for help

### Multi-language Support
- Plugin is translation-ready
- Use WPML or Polylang
- Translate button text in settings