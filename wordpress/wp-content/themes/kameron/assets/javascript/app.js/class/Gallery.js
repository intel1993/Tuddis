var Gallery_Handle,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

Gallery_Handle = (function() {
  var CONF, HISTORY_SUPPORT;

  HISTORY_SUPPORT = window.history && window.history.pushState && window.history.replaceState;

  CONF = App.config.gallery;

  /* 
      Initialize
  */


  function Gallery_Handle(external_view_defaults, data) {
    var cookie_view, descriptions, view_defaults;
    this.data = data;
    this.set_fotorama_image = __bind(this.set_fotorama_image, this);
    this.hide_thumbnails = __bind(this.hide_thumbnails, this);
    this.show_thumbnails = __bind(this.show_thumbnails, this);
    this.show_sidebar = __bind(this.show_sidebar, this);
    this.hide_sidebar = __bind(this.hide_sidebar, this);
    this.enable_addons = __bind(this.enable_addons, this);
    this.disable_addons = __bind(this.disable_addons, this);
    this.images = _.map(this.data, function(i) {
      return {
        img: i.image,
        thumb: i.thumb,
        caption: i.caption,
        thumbratio: i.thumbwidth / i.thumbheight,
        video: i.video
      };
    });
    this.currentID = 0;
    this.fotorama = false;
    this.disabled = false;
    view_defaults = {
      thumbs: false,
      sidebar: false
    };
    cookie_view = $.cookie('village_gallery');
    this.view = $.extend(true, {}, view_defaults, external_view_defaults, cookie_view);
    this.back_url = CONF.root_url;
    descriptions = _.filter(this.data, function(obj) {
      return (obj.desc != null) && obj.desc !== "";
    });
    if (CONF.thumbnails_overlay) {
      $$('#gallery').addClass('overlay-thumbs');
    }
    if (descriptions.length === 0) {
      this.destroy_sidebar();
    } else if (this.view.sidebar === false) {
      this.hide_sidebar();
    }
    this.attach_events();
    this.setup(this.images);
  }

  Gallery_Handle.prototype.detach_events = function() {
    $$('#gallery__stage').off('fotorama:showend', this.set_fotorama_image);
    $$('#gallery__stage').off('fotorama:loadvideo', this.disable_addons);
    $$('#gallery__stage').off('fotorama:unloadvideo', this.enable_addons);
  };

  Gallery_Handle.prototype.attach_events = function() {
    $$('#gallery__stage').on('fotorama:showend', this.set_fotorama_image);
    $$('#gallery__stage').on('fotorama:loadvideo', this.disable_addons);
    $$('#gallery__stage').on('fotorama:unloadvideo', this.enable_addons);
  };

  Gallery_Handle.prototype.setup = function(images) {
    var fotorama_settings;
    fotorama_settings = {
      fit: CONF.fit,
      transition: CONF.transition,
      width: App.win.width,
      height: CONF.thumbnails_overlay ? App.win.height : "100%",
      thumbheight: CONF.thumbnails_height,
      nav: CONF.thumbnails && this.view.thumbs === true ? "thumbs" : false,
      autoplay: CONF.autoplay ? CONF.autoplay_duration : false,
      stopautoplaytouch: CONF.autoplay_stop,
      loop: CONF.loop,
      data: images
    };
    $$('#gallery__stage').fotorama(fotorama_settings);
    this.fotorama = $$('#gallery__stage').data('fotorama');
    $$('#gallery').removeClass('init');
    if (!this.fotorama) {
      return;
    }
    if (this.view.thumbs === true) {
      this.show_thumbnails();
    }
    if (this.view.sidebar === true) {
      this.show_sidebar();
    }
    return this;
  };

  Gallery_Handle.prototype.close = function(try_force_back, previous_url) {
    var _this = this;
    if (try_force_back == null) {
      try_force_back = false;
    }
    if (previous_url == null) {
      previous_url = false;
    }
    if (previous_url === false || previous_url === window.location.href) {
      previous_url = this.back_url;
    }
    if (HISTORY_SUPPORT && (try_force_back || document.referrer.indexOf(window.location.host) >= 0)) {
      window.history.back();
    } else {
      $.pronto('load', previous_url);
    }
    return $$(window).one("stage/complete", function() {
      return _this.destroy();
    });
  };

  Gallery_Handle.prototype.disable_addons = function() {
    this.disabled = true;
    $$('#gallery').addClass('disable-addons');
  };

  Gallery_Handle.prototype.enable_addons = function() {
    this.disabled = false;
    $$('#gallery').removeClass('disable-addons');
  };

  Gallery_Handle.prototype.destroy = function() {
    this.detach_events();
    if (this.fotorama) {
      this.fotorama.destroy();
    }
    $$('#gallery').remove();
    $$('#gallery__stage', true);
    $$('#gallery__sidebar', true);
    return $$('#gallery', true);
  };

  /*
      Sidebar Functions
  */


  Gallery_Handle.prototype.destroy_sidebar = function() {
    $$('#gallery').addClass('is-full no-sidebar');
    this.view.sidebar = false;
    return this.detach_events();
  };

  Gallery_Handle.prototype.update_sidebar = function(data) {
    var $desc, $sidebar, $title, D;
    if (this.view.sidebar === false) {
      return;
    }
    D = [];
    $sidebar = $$('#gallery__sidebar');
    $title = $sidebar.find('.title');
    $desc = $sidebar.find(".desc");
    D.push($title.animate({
      opacity: 0
    }, 150));
    D.push($desc.animate({
      opacity: 0
    }, 150));
    return $.when.apply(null, D).done(function() {
      $title.text(data.caption).animate({
        opacity: 1
      }, 300);
      $desc.html(data.desc).animate({
        opacity: 1
      }, 300);
      D = [];
    });
  };

  Gallery_Handle.prototype.hide_sidebar = function(resize) {
    if (resize == null) {
      resize = true;
    }
    $$('#gallery').addClass('is-full').removeClass('show-sidebar');
    if (resize && this.fotorama) {
      this.fotorama.resize();
    }
    this.view.sidebar = false;
    $.cookie('village_gallery', this.view, {
      path: '/'
    });
  };

  Gallery_Handle.prototype.show_sidebar = function(resize) {
    if (resize == null) {
      resize = true;
    }
    $$('#gallery').addClass('show-sidebar').removeClass('is-full');
    if (resize && this.fotorama) {
      this.fotorama.resize();
    }
    this.view.sidebar = true;
    $.cookie('village_gallery', this.view, {
      path: '/'
    });
    this.set_image('current');
  };

  /*
      Thumbnails Toggle
  */


  Gallery_Handle.prototype.toggle_thumbnails = function() {
    if (this.view.thumbs === true) {
      return this.hide_thumbnails();
    } else {
      return this.show_thumbnails();
    }
  };

  Gallery_Handle.prototype.show_thumbnails = function() {
    var _this = this;
    this.fotorama.setOptions({
      nav: "thumbs"
    });
    return $$('#gallery').find('.fotorama__nav').animo({
      animation: 'do-fadeInUp',
      duration: 0.2,
      timing: "ease-out",
      keep: false
    }, function() {
      _this.view.thumbs = true;
      $.cookie('village_gallery', _this.view, {
        path: '/'
      });
      return $$('#gallery').addClass('show-thumbnails');
    });
  };

  Gallery_Handle.prototype.hide_thumbnails = function() {
    var _this = this;
    return $$('#gallery').find('.fotorama__nav').animo({
      animation: 'do-fadeOutDown',
      duration: 0.2,
      timing: "ease-in",
      keep: false
    }, function() {
      _this.view.thumbs = false;
      $.cookie('village_gallery', _this.view, {
        path: '/'
      });
      $$('#gallery').removeClass('show-thumbnails');
      return _this.fotorama.setOptions({
        nav: false
      });
    });
  };

  /* 
      Slider Navigation
  */


  Gallery_Handle.prototype.set_fotorama_image = function(e, fotorama) {
    return this.set_image(fotorama.activeIndex);
  };

  Gallery_Handle.prototype.set_image = function(index) {
    var data;
    if (index == null) {
      index = 'current';
    }
    if (index === 'current') {
      index = this.currentID;
    } else {
      if (index === this.currentID) {
        return;
      }
      this.currentID = index;
    }
    if (this.view.sidebar) {
      data = this.data[this.currentID];
      return this.update_sidebar(data);
    }
  };

  return Gallery_Handle;

})();
