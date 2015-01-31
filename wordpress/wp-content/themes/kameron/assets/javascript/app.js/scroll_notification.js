(function() {
  var Notify;

  if (!App.config.scroll_notification.enable) {
    return;
  }

  Notify = (function() {
    var CONF, COOKIE_KEY, COUNT;

    CONF = App.config.scroll_notification;

    COOKIE_KEY = 'icanhaz-scroll';

    COUNT = 0;

    function Notify() {
      var user_knows;
      user_knows = $.cookie(COOKIE_KEY, Number);
      if (!_.isUndefined(user_knows)) {
        COUNT = user_knows;
      }
    }

    Notify.prototype.should_attach_event = function() {
      if (COUNT < CONF.times || CONF.enable_cookies === false) {
        return true;
      } else {
        return false;
      }
    };

    Notify.prototype.maybe_show = function() {
      if (CONF.enable_cookies === false) {
        $$('#scroll-note').fadeIn();
        return;
      }
      if (COUNT < CONF.times) {
        if ($$('body').hasClass('is-horizontal')) {
          return $$('#scroll-note').fadeIn();
        }
      }
    };

    Notify.prototype.hide = function() {
      var _this = this;
      return $$('#scroll-note').fadeOut(500, function() {
        if (CONF.enable_cookies) {
          ++COUNT;
          return $.cookie(COOKIE_KEY, COUNT, {
            expires: CONF.expires,
            path: '/'
          });
        }
      });
    };

    return Notify;

  })();

  $$(window).one("theme:sizes_setup", function() {
    var Notification;
    Notification = new Notify();
    if (Notification.should_attach_event()) {
      $$(window).on("load stage/complete", _.debounce(Notification.maybe_show, 400));
      return $$('#scroll-i-get-it').on("click", Notification.hide);
    }
  });

}).call(this);
