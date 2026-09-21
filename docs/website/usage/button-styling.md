# Button Styling

The **Button Style** tab controls the Load More button, and the **Previous Button Style** tab controls the Previous button. Both tabs offer the same fields, so the two buttons can be styled independently.

## Fields

| Field | What it controls | Default (Load More) |
|---|---|---|
| Button Text | The label on the button. Translatable. | Load More (Previous: Load Previous) |
| Custom CSS Class | An extra CSS class added to the button, for advanced styling. | (empty) |
| Background Color | Button fill colour. | `#1d76da` |
| Hover Background | Fill colour on mouse hover. | `#0e4da0` |
| Text Color | Label colour. | `#ffffff` |
| Hover Text Color | Label colour on hover. | `#ffffff` |
| Border Color | Border colour. | `#1d76da` |
| Font Size | Label size, in pixels. | 16 |
| Padding | Inner spacing, per side (top, right, bottom, left). | 13 / 30 / 13 / 30 |
| Margin | Outer spacing, per side. | 0 (Previous button: 20 bottom) |
| Border Width | Border thickness, per side. | 1 on every side |
| Border Radius | Corner roundness, per corner. | 50 on every corner |

## How values are validated

- Colours are stored as sanitised hex values.
- Font size, padding, margin, border width, and border radius are whole numbers clamped to a maximum of 999 pixels.
- The custom class is sanitised as a single HTML class name.

## Hover colours

The base and hover background/text colours are combined into a hover style block that the plugin prints in the page head on shop archives, so hover state matches your chosen colours without extra CSS.

## Going further with code

The generated inline style and hover CSS can both be extended with filters. See `infinite_loader_for_woocommerce_load_more_button_style`, `infinite_loader_for_woocommerce_load_previous_button_style`, `infinite_loader_lm_btn_hover_css`, and `infinite_loader_previous_btn_hover_css` in [Hooks and Filters](../developer-guide/hooks-and-filters.md).
