(function() {
  var BLOCK_ACTION, BLOCK_SELECTORS, CONTROLS_HIDDEN, Gallery, MOUSE_TIMEOUT, TIMEOUT, TOGGLE_CLASS, document_url, gallery_view_defaults, hide_gallery_controls, mouse_check_movement, mouse_throttling_timeout, setup_gallery, show_gallery_controls, throttle_mouse_check;

  if (!App.config.gallery.enable) {
    return;
  }

  /*
      Track the document URL
      To figure out if we're going history or pronto back
  */


  document_url = null;

  $$(window).on("pronto.request", function() {
    document_url = window.location.href;
  });

  Gallery = false;

  gallery_view_defaults = {
    thumbs: true,
    sidebar: true
  };

  setup_gallery = function() {
    var gallery_data, gallery_exists;
    $$('#gallery__stage', true);
    $$('#gallery__sidebar', true);
    $$('#gallery', true);
    gallery_exists = $$('#gallery', true).length > 0;
    if (!gallery_exists) {
      App.Header.reset();
    } else {
      gallery_data = $$('#gallery-data', true).data('gallery');
      if (gallery_data != null) {
        App.Header.set_to('responsive', true);
        App.Header.hide();
        Gallery = new Gallery_Handle(gallery_view_defaults, gallery_data);
        App.Gallery = Gallery;
      }
    }
  };

  $$(window).one('themeresized', setup_gallery);

  $$(window).on('stage/complete', function() {
    if (Gallery !== false) {
      Gallery.destroy();
      Gallery = false;
    }
    setup_gallery();
  });

  $$(document).on('click', '#gallery__close', function(e) {
    e.preventDefault();
    e.stopPropagation();
    if (!document_url) {
      document_url = App.config.gallery.root_url;
    }
    return Gallery.close(null, document_url);
  });

  $$(document).on('click', '#gallery__thumbs__toggle', function(e) {
    return Gallery.toggle_thumbnails();
  });

  $$(document).on('click', '#gallery__sidebar__close', function(e) {
    return Gallery.hide_sidebar(!App.is.responsive);
  });

  $$(document).on('click', '#gallery__sidebar__open', function(e) {
    return Gallery.show_sidebar(!App.is.responsive);
  });

  $$(window).on('theme:sizes_setup', function() {
    if (App.Gallery && App.Gallery.fotorama) {
      return Gallery.fotorama.resize();
    }
  });

  App.config.gallery.mouse_timeout = false;

  if (App.config.gallery.mouse_timeout) {
    TIMEOUT = null;
    BLOCK_ACTION = false;
    CONTROLS_HIDDEN = false;
    MOUSE_TIMEOUT = App.config.gallery.mouse_timeout_ms;
    TOGGLE_CLASS = "js__mouse-not-moving fotorama__wrap--no-controls";
    BLOCK_SELECTORS = '#gallery__sidebar, .fotorama__caption, #gallery__share, .fotorama__wrap--video';
    if (Modernizr.touch) {
      MOUSE_TIMEOUT *= 2;
    }
    hide_gallery_controls = function() {
      if (BLOCK_ACTION) {
        return;
      }
      if (CONTROLS_HIDDEN) {
        return;
      }
      $$('#gallery').addClass(TOGGLE_CLASS);
      CONTROLS_HIDDEN = true;
    };
    show_gallery_controls = function() {
      if (BLOCK_ACTION) {
        return;
      }
      if (!CONTROLS_HIDDEN) {
        return;
      }
      $$('#gallery').removeClass(TOGGLE_CLASS);
      CONTROLS_HIDDEN = false;
    };
    mouse_check_movement = function() {
      clearTimeout(TIMEOUT);
      if (!Gallery) {
        return;
      }
      show_gallery_controls();
      TIMEOUT = setTimeout(hide_gallery_controls, MOUSE_TIMEOUT);
    };
    mouse_throttling_timeout = Math.round(MOUSE_TIMEOUT / 2);
    throttle_mouse_check = _.throttle(mouse_check_movement, mouse_throttling_timeout, {
      trailing: false
    });
    $$(document).on('mousemove touchend', throttle_mouse_check);
    $$(document).on('mouseenter', BLOCK_SELECTORS, function() {
      if (!Gallery) {
        return;
      }
      if (Gallery.disabled === true) {
        return;
      }
      BLOCK_ACTION = true;
    });
    $$(document).on('mouseleave', BLOCK_SELECTORS, function() {
      if (!Gallery) {
        return;
      }
      if (Gallery.disabled === true) {
        return;
      }
      BLOCK_ACTION = false;
    });
    $$(document).on('fotorama:loadvideo', function() {
      hide_gallery_controls();
      BLOCK_ACTION = true;
    });
    $$(document).on('fotorama:unloadvideo', function() {
      BLOCK_ACTION = false;
      show_gallery_controls();
    });
  }

}).call(this);
