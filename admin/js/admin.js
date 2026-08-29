(function ($) {
  var berocket_apply_styles_for_button,
    berocket_apply_styles_for_button_free,
    berocket_apply_style_for_button_apply,
    berocket_apply_style_from_list;

  berocket_apply_styles_for_button = function ($parent) {
    var $button = jQuery(
      '<a class="infinite_button" href="#load_next_page"></a>'
    );

    $button = berocket_apply_style_for_button_apply($button, $parent);

    $parent
      .find(".infinite_loader_btn_load .infinite_button")
      .replaceWith($button);
    $parent
      .find(".infinite_loader_btn_load .infinite_button")
      .trigger("infinite_loader_button_changed");
  };
  berocket_apply_style_for_button_apply = function ($button, $parent) {
    return berocket_apply_styles_for_button_free($button, $parent);
  };
  berocket_apply_styles_for_button_free = function ($button, $parent) {
    var $settings = $parent.find(".infinite_loader_btn_settings");

    $button = berocket_apply_style_from_list($button, $settings);
    $button.css("background-color", $parent.find(".bg_btn_color").val());
    $button.css("color", $parent.find(".txt_btn_color").val());
    return $button;
  };
  berocket_apply_style_from_list = function ($button, $settings) {
    $settings.each(function () {
      var $field = $(this).data("field");
      var $style = $(this).data("style");
      var $type = $(this).data("type");

      if ($style != "custom_css") {
        if ($field == "border") {
          if ($(this).val() == "" || $(this).val() == " ") {
            var value = 0;
          } else {
            var value = $(this).val();
          }
          $button.css(
            $style,
            value +
              "px solid " +
              $(this).closest("form").find(".btn_border_color").val()
          );
        } else {
          if ($style == "text") {
            $button.text($(this).val());
          } else {
            if ($(this).val() == "") {
              $button.css($style, $(this).val());
            } else {
              $button.css($style, $(this).val() + $type);
            }
          }
        }
      }
    });
    return $button;
  };
  $(document).ready(function () {
    setTimeout(function () {
      $(".infinite_loader_btn_load .infinite_button").each(function () {
        berocket_apply_styles_for_button($(this).closest("form"));
      });
    }, 10);

    // Reset a single native colour input to its data-default, then repaint the
    // preview. One delegated handler scoped to the field replaces the old set of
    // id-specific handlers, so it works on both button forms without caring
    // which one it is or that their ids are now distinct.
    $(document).on("click", ".infinite-loader-color-reset", function (event) {
      event.preventDefault();
      var $color = $(this)
        .closest(".wbcom-field-control")
        .find('input[type="color"]');
      $color.val($color.data("default") || "#000000").trigger("change");
    });

    $(document).on(
      "change",
      ".infinite_loader_btn_settings, .bg_btn_color, .txt_btn_color, .btn_border_color",
      function () {
        berocket_apply_styles_for_button($(this).closest("form"));
      }
    );
    $(document).on(
      "mouseenter",
      ".infinite_loader_btn_load .infinite_button",
      function () {
        var $form = $(this).closest("form");
        $button = $form.find(".infinite_loader_btn_load .infinite_button");
        $button.css("background-color", $form.find(".bg_btn_color_hover").val());
        $button.css("color", $form.find(".txt_btn_color_hover").val());
        $button.trigger("infinite_loader_button_changed");
      }
    );
    $(document).on(
      "mouseleave",
      ".infinite_loader_btn_load .infinite_button",
      function () {
        var $form = $(this).closest("form");
        $button = $form.find(".infinite_loader_btn_load .infinite_button");
        $button.css("background-color", $form.find(".bg_btn_color").val());
        $button.css("color", $form.find(".txt_btn_color").val());
        $button.trigger("infinite_loader_button_changed");
      }
    );
    $(document).on(
      "click",
      ".infinite-loader-set-load-more-options",
      function (event) {
        event.preventDefault();
        var $form = $(this).closest("form");
        $form.find(".infinite_loader_btn_settings").each(function (i, o) {
          $(o).val($(o).data("default")).trigger("change");
        });
        // Reset the native colour inputs too, so "Set all to default" really
        // does reset every field the form holds.
        $form.find(".infinite-loader-color-reset").trigger("click");
      }
    );
  });
})(jQuery);
