(function() {
  var SHARRRE, Sharrre_Config, item, key, network_data, network_exists, network_toggle, setup_social_sharing, value, _ref;

  if (!App.config.gallery.enable) {
    return;
  }

  if (App.config.gallery.networks.length === 0) {
    return;
  }

  network_data = {
    googleplus: {
      item_class: "googleplus",
      item_data: "googlePlus"
    },
    facebook: {
      item_class: "facebook",
      item_data: "facebook"
    },
    twitter: {
      item_class: "twitter",
      item_data: "twitter"
    },
    pinterest: {
      item_class: "pinterest",
      item_data: "pinterest"
    }
  };

  Sharrre_Config = {
    template: "",
    share: {}
  };

  _ref = App.config.gallery.networks;
  for (key in _ref) {
    value = _ref[key];
    item = network_data[key];
    network_exists = value !== "";
    Sharrre_Config.share[item.item_data] = network_exists;
    if (network_exists) {
      Sharrre_Config.template += "<a class=\"network " + item.item_class + "\" data-social-network=\"" + item.item_data + "\">\n		        <i class=\"icon ion-social-" + item.item_class + "\"></i>		 \n </a>";
    }
  }

  if (Sharrre_Config.template === "") {
    return;
  }

  SHARRRE = false;

  setup_social_sharing = function(e, fotorama) {
    var $sharrre, gallery_cover_image;
    gallery_cover_image = fotorama.data[0].img;
    $sharrre = $$('#gallery__share', true).find('.sharrre');
    $sharrre.sharrre({
      share: Sharrre_Config.share,
      urlCurl: '',
      buttons: {
        pinterest: {
          media: gallery_cover_image
        }
      },
      enableHover: false,
      template: Sharrre_Config.template
    });
    SHARRRE = $sharrre.data('plugin_sharrre');
    $$('#gallery__share .share__networks', true);
  };

  $$('#content').on('fotorama:ready', _.debounce(setup_social_sharing, 200));

  $$('#content').on('click', '.network', function() {
    var $el, network;
    if (!SHARRRE) {
      return;
    }
    $el = $(this);
    network = $el.data('socialNetwork');
    if (network == null) {
      return;
    }
    SHARRRE.update(window.location.href, '');
    return SHARRRE.openPopup(network);
  });

  /*
  	Hover Intent
  */


  network_toggle = {
    show: function() {
      if (!App.Gallery) {
        return;
      }
      return $$('#gallery__share .share__networks').show().animo({
        animation: 'do-fadeInUp',
        duration: 0.2,
        keep: true,
        timing: 'ease-out'
      });
    },
    hide: function() {
      if (!App.Gallery) {
        return;
      }
      $$('#gallery__share .share__networks').animo({
        animation: 'do-fadeOut',
        duration: 0.2,
        timing: 'ease-out',
        keep: false
      }, function() {
        $$('#gallery__share .share__networks').hide();
      });
    }
  };

  if (!Modernizr.touch) {
    $$('#page').hoverIntent({
      selector: '#gallery__share',
      timeout: 350,
      interval: 50,
      over: network_toggle.show,
      out: network_toggle.hide
    });
  }

  $$('#page').on("click", '#gallery__share', function() {
    var $el;
    $el = $(this);
    if ($el.hasClass('is-open')) {
      $el.removeClass('is-open');
      return network_toggle.hide();
    } else {
      $el.addClass('is-open');
      return network_toggle.show();
    }
  });

}).call(this);
