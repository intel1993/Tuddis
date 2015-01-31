(function() {
  App.Header = new Header();

  $$('#header-toggle').hoverIntent({
    over: App.Header.show,
    out: App.Header.hide,
    timeout: 200,
    interval: 50
  });

  $$('#header-toggle .js__toggle').click(function() {
    return $$('#header').toggleClass('is-visible');
  });

  $$(window).on("pronto.request", function() {
    if (Modernizr.touch && !App.Header.is_tmp()) {
      App.Header.hide();
    }
    if (!App.is.responsive) {
      return $$('#header__background').animate({
        'background-position-y': 0,
        'background-position-x': 0
      }, 1200, 'easeInQuad');
    }
  });

}).call(this);
