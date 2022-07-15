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
    var $settings = $parent
      .find("div.wbcom-settings-section-wrap")
      .not(".br_trbtn_for_use_image");
    $settings = $settings.find(".infinite_loader_btn_settings");

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
              $(this)
                .parents(".form-table")
                .first()
                .find(".btn_border_color")
                .val()
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
        berocket_apply_styles_for_button(
          $(this).parents(".form-table").first()
        );
      });
    }, 10);
    $(document).on("change", ".lmp_hide_element", function () {
      var value = $(this).val();
      var hide = $(this).data("hide");
      if ($(this).attr("type") == "checkbox") {
        if (!$(this).prop("checked")) {
          value = "false";
        }
      }
      var $hide = $(hide);
      $hide.each(function () {
        $(this).parents("div.wbcom-settings-section-wrap").first().hide();
      });
      var $hide = $(hide + value);
      $hide.each(function () {
        $(this).parents("div.wbcom-settings-section-wrap").first().show();
      });
    });

    $(document).on(
      "change",
      ".form-table .infinite_loader_btn_settings, .bg_btn_color, .txt_btn_color, .btn_border_color",
      function () {
        berocket_apply_styles_for_button(
          $(this).parents(".form-table").first()
        );
      }
    );
    $(document).on(
      "mouseenter",
      ".infinite_loader_btn_load .infinite_button",
      function () {
        $button = $(this)
          .parents(".form-table")
          .first()
          .find(".infinite_loader_btn_load .infinite_button");
        $button.css(
          "background-color",
          $(this)
            .parents(".form-table")
            .first()
            .find(".bg_btn_color_hover")
            .val()
        );
        $button.css(
          "color",
          $(this)
            .parents(".form-table")
            .first()
            .find(".txt_btn_color_hover")
            .val()
        );
        $button.trigger("infinite_loader_button_changed");
      }
    );
    $(document).on(
      "mouseleave",
      ".infinite_loader_btn_load .infinite_button",
      function () {
        $button = $(this)
          .parents(".form-table")
          .first()
          .find(".infinite_loader_btn_load .infinite_button");
        $button.css(
          "background-color",
          $(this).parents(".form-table").first().find(".bg_btn_color").val()
        );
        $button.css(
          "color",
          $(this).parents(".form-table").first().find(".txt_btn_color").val()
        );
        $button.trigger("infinite_loader_button_changed");
      }
    );
    $(document).on(
      "click",
      ".infinite-loader-set-load-more-options",
      function (event) {
        alert();
        event.preventDefault();
        $(
          ".form-table .infinite_loader_btn_settings, .form-table .lmp_button_settings_hover"
        ).each(function (i, o) {
          $(o).val($(o).data("default")).trigger("change");
        });
        $(".form-table .button-settings").trigger("change");
        $(".br_colorpicker_default").click();
      }
    );
  });
})(jQuery);
