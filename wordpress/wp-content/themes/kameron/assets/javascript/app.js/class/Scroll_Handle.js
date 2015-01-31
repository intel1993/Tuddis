var Scroll_Handle;

Scroll_Handle = (function() {
  function Scroll_Handle(settings) {
    var defaults;
    this.init = false;
    this.active = {
      x: [],
      y: []
    };
    defaults = {
      force_parallax: false,
      callbacks: {
        x: null,
        y: null
      },
      x: {
        interactiveScrollbars: true,
        mouseWheel: true,
        disableMouse: true,
        mouseWheelSpeed: App.config.scroll.speedX,
        scrollX: true,
        scrollY: false,
        tap: Modernizr.touch ? "click" : void 0,
        keyBindings: App.config.scroll.keyboard_scroll,
        snap: App.config.scroll.keyboard_scroll ? '.hscol' : false,
        hasHorizontalScroll: true,
        hasVerticalScroll: false,
        scrollbars: App.config.scroll.hs_scrollbar && !Modernizr.touch ? 'custom' : false,
        shrinkScrollbars: Modernizr.touch ? 'clip' : 'scale',
        bounce: !Modernizr.touch
      },
      y: {
        interactiveScrollbars: true,
        mouseWheel: true,
        disableMouse: true,
        mouseWheelSpeed: App.config.scroll.speedY,
        scrollbars: 'custom',
        scrollX: false,
        tap: Modernizr.touch ? "click" : void 0,
        keyBindings: App.config.scroll.keyboard_scroll ? {
          up: 40,
          down: 38
        } : false,
        snap: App.config.scroll.keyboard_scroll ? true : false
      }
    };
    this.settings = $.extend(true, {}, defaults, settings);
  }

  Scroll_Handle.prototype.setup = function($page) {
    this.destroy();
    if (this.settings.x) {
      this.setup_horizontal($page);
    }
    if (this.settings.y) {
      this.setup_vertical($page);
    }
    this.maybe_hide_active_scrollbars();
    this.init = true;
  };

  Scroll_Handle.prototype.setup_vertical = function($page) {
    var $scroll, $scroller, enable_parallax, is_nested, key, scroller, _i, _len, _results;
    $scroll = $page.find(".js__scroll");
    if ($scroll.length === 0) {
      return;
    }
    enable_parallax = this.settings.enable_parallax && ((this.settings.callbacks.y && !Modernizr.touch) || this.settings.force_parallax);
    _results = [];
    for (key = _i = 0, _len = $scroll.length; _i < _len; key = ++_i) {
      scroller = $scroll[key];
      $scroller = $(scroller);
      $scroller.children().wrapAll('<div class="js__scroll__canvas"/>');
      is_nested = $scroller.closest(".js__scroll--horizontal").length > 0;
      if (enable_parallax || is_nested === true) {
        this.settings.y.probeType = 3;
      }
      this.active.y[key] = new IScroll(scroller, this.settings.y);
      if (is_nested) {
        _results.push(this.active.y[key].on("scroll", this.maybe_stop_propagation));
      } else if (enable_parallax) {
        _results.push(this.active.y[key].on("scroll", this.settings.callbacks.y));
      } else {
        _results.push(void 0);
      }
    }
    return _results;
  };

  Scroll_Handle.prototype.setup_horizontal = function($page) {
    var $scroller, enable_parallax, key, scroller, total_width, _i, _len, _ref, _results;
    if ($page.find(".js__scroll--horizontal").length > 0) {
      enable_parallax = this.settings.enable_parallax && ((this.settings.callbacks.y && !Modernizr.touch) || this.settings.force_parallax);
      _ref = $page.find(".js__scroll--horizontal");
      _results = [];
      for (key = _i = 0, _len = _ref.length; _i < _len; key = ++_i) {
        scroller = _ref[key];
        $scroller = $(scroller);
        $scroller.removeClass("scroll--horizontal");
        total_width = this.get_total_width($scroller.find(".hscol"));
        $scroller.children().wrapAll("<div class=\"js__scroll__canvas\" style=\"width: " + total_width + "px;\"/>");
        if (key === 0 && enable_parallax) {
          this.settings.x.probeType = 3;
        } else {
          this.settings.x.probeType = 0;
        }
        this.active.x[key] = new IScroll(scroller, this.settings.x);
        if (key === 0 && enable_parallax) {
          _results.push(this.active.x[key].on("scroll", this.settings.callbacks.x));
        } else {
          _results.push(void 0);
        }
      }
      return _results;
    }
  };

  Scroll_Handle.prototype.maybe_stop_propagation = function() {
    if (this.y <= this.maxScrollY || this.y === 0) {
      this.options.stopPropagation = false;
    } else {
      this.options.stopPropagation = true;
    }
  };

  Scroll_Handle.prototype.destroy = function($page) {
    var iS, _i, _j, _len, _len1, _ref, _ref1;
    if (this.active.x.length === 0 && this.active.y.length === 0) {
      return;
    }
    _ref = this.active.x;
    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
      iS = _ref[_i];
      iS.destroy();
    }
    _ref1 = this.active.y;
    for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
      iS = _ref1[_j];
      iS.destroy();
    }
    this.active = {
      x: [],
      y: []
    };
    if ($('.js__scroll__canvas').length > 0) {
      return $$('#stage').find(".js__scroll__canvas").children().unwrap();
    }
  };

  Scroll_Handle.prototype.refresh = function() {
    var $scroller, scroller, total_width, _i, _j, _len, _len1, _ref, _ref1;
    if (this.init === false) {
      return false;
    }
    _ref = this.active.x;
    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
      scroller = _ref[_i];
      $scroller = $(scroller.scroller);
      $(scroller.wrapper).removeClass("hide-scrollbar");
      total_width = this.get_total_width($scroller.find(".hscol"));
      $scroller.width(total_width);
      scroller.refresh();
    }
    _ref1 = this.active.y;
    for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
      scroller = _ref1[_j];
      $(scroller.wrapper).removeClass("hide-scrollbar");
      scroller.refresh();
    }
    this.maybe_hide_active_scrollbars();
  };

  Scroll_Handle.prototype.maybe_hide_active_scrollbars = function() {
    var key, scrollbar, _i, _len, _ref, _results;
    _ref = this.active.x.concat(this.active.y);
    _results = [];
    for (key = _i = 0, _len = _ref.length; _i < _len; key = ++_i) {
      scrollbar = _ref[key];
      _results.push(this.maybe_hide_scrollbar(scrollbar));
    }
    return _results;
  };

  Scroll_Handle.prototype.maybe_hide_scrollbar = function(IS) {
    var indicator, scrollbar_is_visible;
    if (!IS.indicators) {
      return;
    }
    indicator = IS.indicators[0];
    scrollbar_is_visible = indicator.wrapperHeight ? indicator.wrapperHeight > indicator.indicatorHeight : indicator.wrapperWidth > indicator.indicatorWidth;
    if (scrollbar_is_visible) {
      return $(IS.wrapper).removeClass("hide-scrollbar");
    } else {
      return $(IS.wrapper).addClass("hide-scrollbar");
    }
  };

  Scroll_Handle.prototype.get_total_width = function($elements) {
    var width;
    width = 0;
    $elements.each(function() {
      return width += $(this).outerWidth(true);
    });
    width += 80;
    return width;
  };

  return Scroll_Handle;

})();
