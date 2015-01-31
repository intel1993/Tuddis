(function() {
  var defaults, load_site, setup_slides;

  if ($$('#fullscreen-gallery').length === 0) {
    return;
  }

  if ($$('#enter-site').length === 0) {
    return;
  }

  defaults = {
    play: App.config.slider.duration,
    animation: App.config.slider.animation,
    animation_speed: App.config.slider.animation_speed,
    animation_easing: App.config.slider.animation_easing,
    key_navigation: false,
    pagination: false
  };

  setup_slides = function(refresh) {
    var $slider, slide_config;
    if (refresh == null) {
      refresh = false;
    }
    $slider = $$('#fullscreen-gallery');
    slide_config = $.extend({}, defaults, $slider.data("slidesConfig"));
    $slider.superslides(slide_config);
    if ($slider.find('img').length === 1) {
      return $slider.superslides('stop');
    }
  };

  load_site = _.once(function() {
    if (!Modernizr.cssanimations) {
      window.location.href = $$('#enter-site').attr('href');
      return;
    }
    return $$('html').animo({
      animation: 'do-fadeOutUp',
      duration: 0.6,
      keep: true
    }, function() {
      window.location.href = $$('#enter-site').attr('href');
    });
  });

  $$(document).ready(setup_slides);

  if ($$('#enter-site').length > 0) {
    $$(document).one('click mousewheel scroll', function(e) {
      e.preventDefault();
      return load_site();
    });
  }

}).call(this);
