(function() {
  var PARALLAX, get_navalax_pos, scroll_settings;

  PARALLAX = {
    x: App.config.on_scroll.x,
    y: App.config.on_scroll.y,
    speed_x: App.config.on_scroll.speed_x / 100,
    speed_y: App.config.on_scroll.speed_y / 100,
    container_x: App.config.size.header_width + App.config.size.header_toggle_width,
    height: $$('#header__background').data("height"),
    width: $$('#header__background').data("width")
  };

  get_navalax_pos = function(position, max_position, item_size, container_size, speed_modifier) {
    var ratio;
    ratio = (item_size - container_size) / max_position * speed_modifier;
    return position * -ratio;
  };

  scroll_settings = {
    enable_parallax: App.config.on_scroll.enable,
    force_parallax: App.config.on_scroll.force,
    callbacks: {
      y: function() {
        return $$('#header__background').css({
          "background-position-y": get_navalax_pos(this.y, this.maxScrollY, PARALLAX.height, App.win.height, PARALLAX.speed_y)
        });
      },
      x: function() {
        return $$('#header__background').css({
          "background-position-x": get_navalax_pos(this.x, this.maxScrollX, PARALLAX.width, PARALLAX.container_x, PARALLAX.speed_x)
        });
      }
    }
  };

  App.Scroll = new Scroll_Handle(scroll_settings);

  App.Header_Scroll = new Scroll_Handle({
    x: false,
    y: {
      keyBindings: false,
      snap: false
    }
  });

  $$(window).on("load iscroll:refresh debouncedresize", function() {
    return App.Scroll.refresh();
  });

  $$(window).one('theme:sizes_setup', function(e, responsive) {
    if (App.is.responsive) {
      return;
    }
    App.Scroll.setup($$('#stage'));
    $$('.js__scroll').scrollTop(0).scrollLeft(0);
    return $$(window).on("load hashchange", function(e) {
      if (!window.location.hash) {
        return;
      }
      if (App.Scroll.active.y.length === 0) {
        return;
      }
      if ($$(window.location.hash).length) {
        App.Scroll.active.y[0].scrollToElement(window.location.hash, 0);
        return $$('.js__scroll').scrollTop(0).scrollLeft(0);
      }
    });
  });

  $$(document).on("theme/responsive", function(e, responsive) {
    if (responsive === true) {
      App.Scroll.destroy();
    }
    if (responsive === false) {
      return App.Util.delay(100, function() {
        App.Scroll.setup($$('#stage'));
      });
    }
  });

  $$(window).one("load", function() {
    return App.Header_Scroll.setup($$('#header'));
  });

  $$(window).on("theme:sizes_setup", function() {
    App.Scroll.refresh();
    return App.Header_Scroll.refresh();
  });

}).call(this);
