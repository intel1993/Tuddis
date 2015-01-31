(function() {
  $$('#main-menu').on("click", "a", function() {
    var $el, href;
    $el = $(this);
    href = $el.attr('href');
    if (!href || href === '#') {
      return;
    }
    $$('#main-menu .menu-item').removeClass('current-menu-item');
    return $(this).closest('.menu-item').addClass('current-menu-item');
  });

  $$(window).on("stage/complete", function() {
    var flat_href, href, rpat;
    href = window.location.href;
    if ($('#main-menu .current-menu-item a').attr('href') !== href) {
      rpat = /[^a-zA-Z0-9]/g;
      flat_href = href.replace(rpat, '');
      return $$('#main-menu .menu-item').removeClass('current-menu-item').find('a').filter(function() {
        return this.href.replace(rpat, '') === flat_href;
      }).closest('.menu-item').addClass('current-menu-item');
    }
  });

}).call(this);
