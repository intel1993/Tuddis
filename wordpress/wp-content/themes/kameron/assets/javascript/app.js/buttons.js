(function() {
  $$(window).on('load stage/complete', function() {
    return $("button, input[type=submit], .village-button").not('.js__wrapped').addClass('js__wrapped village-button__inner').wrap('<div class="village-button__wrapper"/>');
  });

}).call(this);
