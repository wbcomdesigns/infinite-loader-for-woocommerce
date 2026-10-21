# Custom CSS and JavaScript

The **JavaScript/CSS** tab lets you add custom CSS and small JavaScript snippets without editing theme files. All three fields are stored in the `infinite_loader_admin_css_js_option` option.

## Custom CSS

CSS entered here is printed in the page head on shop archives. Use it to restyle the buttons, the loading icon, or anything else the plugin outputs.

```css
.infinite_loader_btn_setting .infinite_button {
    transition: all 0.3s ease;
}

.infinite_loader_btn_setting .infinite_button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}
```

Combinator selectors such as `ul.products > li.product` are supported.

### How custom CSS is sanitised

On save, the CSS is stripped of HTML tags, and `@import` statements, `javascript:` URLs, and `expression()` are removed. This means you cannot load external stylesheets with `@import` from this field; link them from your theme instead.

## Before-update and after-update JavaScript

Two JavaScript fields run around each load:

- **Before Update** runs just before a new page of products is requested.
- **After Update** runs just after the new products are in the DOM.

Use them to hide and restore your own UI, or to re-initialise features on the newly loaded products.

```javascript
// Before Update
jQuery( '.my-filters' ).fadeOut();

// After Update
jQuery( '.my-filters' ).fadeIn();
jQuery( '[data-toggle="tooltip"]' ).tooltip();
```

### How the JavaScript is sanitised

On save, these fields are scrubbed: PHP tags and `<script>` tags are removed, and a set of dangerous patterns (for example `eval(`, `new Function(`, `document.write`, `innerHTML =`, `document.cookie`, `localStorage`, `setTimeout`/`setInterval` with a string argument, and assignments to `window.location`) are stripped out and replaced with a comment. Keep these snippets to simple, safe DOM work. For anything more involved, enqueue your own script and listen for the plugin's jQuery events instead (see [JavaScript Events and API](../developer-guide/javascript-events.md)).
