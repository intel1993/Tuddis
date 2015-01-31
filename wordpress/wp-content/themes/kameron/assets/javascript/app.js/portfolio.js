(function() {
  var ENABLE_HOVER, info_box;

  $$('#content').on('click', '.pfentry__image', function() {
    var url;
    url = $(this).closest('.js__hscol').find('.js__link').attr('href');
    if (url != null) {
      return $.pronto('load', url);
    }
  });

  if (!App.config.portfolio.has_desc) {
    return;
  }

  ENABLE_HOVER = !Modernizr.touch && App.config.portfolio.detect_hover;

  info_box = {
    open: function($container) {
      if (App.is.responsive) {
        return;
      }
      $container.addClass('display--desc').removeClass('display--image');
      return $container.find('.js__open').stop().fadeOut();
    },
    close: function($container) {
      if (App.is.responsive) {
        return;
      }
      $container.removeClass('display--desc').addClass('display--image');
      return $container.find('.js__open').stop().fadeIn();
    }
  };

  $$('#content').on('click', '.js__hscol .js__open, .js__hscol .js__close', function() {
    var $container, $el;
    if (App.is.responsive) {
      return;
    }
    $el = $(this);
    $container = $el.closest('.js__hscol');
    if ($el.hasClass('js__open')) {
      if (ENABLE_HOVER) {
        $container.addClass("js__clicklock");
      }
      info_box.open($container);
    }
    if ($el.hasClass('js__close')) {
      if (ENABLE_HOVER) {
        $container.removeClass("js__clicklock");
      }
      info_box.close($container);
    }
  });

  if (ENABLE_HOVER) {
    $$('#page').hoverIntent({
      selector: '.js__pfentry',
      timeout: 175,
      interval: 50,
      sensitivity: 6,
      over: function() {
        var $container;
        $container = $(this);
        return info_box.open($container);
      },
      out: function() {
        var $container;
        $container = $(this);
        if ($container.hasClass("js__clicklock")) {
          return;
        }
        return info_box.close($container);
      }
    });
  }

}).call(this);
