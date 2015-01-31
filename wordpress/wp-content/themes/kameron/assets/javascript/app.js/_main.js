(function() {
  var check_if_responsive, setup_fitvids;

  $$(window).one("theme:sizes_setup", function() {
    return $$(document.body).addClass('loaded');
  });

  App.Util = new Village_Utilities();

  check_if_responsive = function() {
    var is_responsive, was_responsive;
    is_responsive = App.sniff.isMoile === true || App.win.width < 768 ? true : false;
    was_responsive = App.is.responsive === null ? is_responsive : App.is.responsive;
    if (was_responsive && !is_responsive) {
      App.is.responsive = false;
      $$(document).triggerHandler("theme/responsive", false);
      return;
    }
    if (!was_responsive && is_responsive) {
      $$(window).scrollTop(0);
      $$(window).scrollLeft(0);
      App.is.responsive = true;
      $$(document).triggerHandler("theme/responsive", true);
      return;
    }
    App.is.responsive = is_responsive;
  };

  $$(window).on('themeresized', check_if_responsive);

  setup_fitvids = function() {
    $$('#stage').fitVids();
  };

  $$(window).load(function() {
    setup_fitvids();
    return $$('#main-menu').find('a').filter(function() {
      return !this.href || this.href === "#";
    }).addClass('no-link');
  });

}).call(this);
