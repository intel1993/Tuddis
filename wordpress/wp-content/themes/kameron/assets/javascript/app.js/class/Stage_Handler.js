var Stage_Handler,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

Stage_Handler = (function() {
  var DFDs, ON_DONE, PURGERY, STAGES_OPENED, STAGES_OPENED_COMPLETE, UNIQUE_COUNT;

  UNIQUE_COUNT = 0;

  DFDs = [];

  PURGERY = [];

  ON_DONE = new $.Callbacks();

  STAGES_OPENED = 0;

  STAGES_OPENED_COMPLETE = 0;

  function Stage_Handler() {
    this.update_animations = __bind(this.update_animations, this);
    this.update_animations();
    $$(window).on("debouncedresize load", this.update_animations);
  }

  Stage_Handler.prototype.update_animations = function() {
    if (App.is.regular || (App.Gallery && !App.is.responsive)) {
      this.animations = {
        out: App.config.animations.out,
        "in": App.config.animations["in"]
      };
    } else {
      this.animations = {
        out: App.config.animations.responsive_out,
        "in": App.config.animations.responsive_in
      };
    }
  };

  Stage_Handler.prototype.add_promise = function() {
    var $dfd;
    $dfd = new $.Deferred();
    $dfd.promise();
    DFDs.push($dfd);
    return $dfd;
  };

  Stage_Handler.prototype.close = function() {
    var $container, $hide, $stage;
    $stage = $$('#stage', true);
    if ($stage.length === 0) {
      return;
    }
    $stage = $$('#stage').removeAttr('id').addClass('closing-stage');
    $hide = new $.Deferred();
    $hide.promise();
    DFDs.push($hide);
    if ($stage.find('#gallery').length > 0) {
      $container = $stage;
    } else {
      $stage.children().wrapAll('<div class="fade-away-container"/>');
      $container = $stage.find('.fade-away-container');
    }
    return $container.animo({
      animation: this.animations.out,
      duration: 1.5,
      timing: "ease-in",
      keep: true
    }, function() {
      $hide.resolve();
      return PURGERY.push($stage);
    });
  };

  Stage_Handler.prototype.purge = function() {
    var $el, _i, _len;
    for (_i = 0, _len = PURGERY.length; _i < _len; _i++) {
      $el = PURGERY[_i];
      $el.remove();
    }
    if ($$('.closing-stage', true).length > 0) {
      $$('.closing-stage').remove();
    }
    PURGERY = [];
  };

  Stage_Handler.prototype.add = function(data) {
    var $new_stage, $show, ID,
      _this = this;
    ID = ++UNIQUE_COUNT;
    $show = new $.Deferred();
    $show.promise();
    DFDs.push($show);
    $new_stage = $(data.content);
    $new_stage.filter('#stage').first().removeClass('opening-stage closing-stage').attr('id', "stage-tmp-" + ID).addClass('opening-stage').css('z-index', 50 + ID);
    $new_stage.animo({
      animation: this.animations["in"],
      duration: 0.6,
      timing: "ease-out",
      keep: false
    }, function() {
      return $show.resolve();
    });
    this.wait_to_complete(ID, DFDs.length);
    return $new_stage;
  };

  Stage_Handler.prototype.wait_to_complete = function(ID, dfd_length) {
    var _this = this;
    if (ID !== UNIQUE_COUNT) {
      return;
    }
    return $.when.apply(null, DFDs).done(function() {
      if (ID !== UNIQUE_COUNT) {
        return;
      }
      if (DFDs.length !== dfd_length) {
        return;
      }
      $$("#stage-tmp-" + ID, true).attr('id', 'stage').removeClass('opening-stage').css('z-index', '');
      $$('#stage', true);
      $$('.opening-stage', true).remove();
      ON_DONE.fire(ID);
      ON_DONE.empty();
      $$(window).trigger('stage/complete');
      _this.purge();
      UNIQUE_COUNT = 0;
      DFDs = [];
    });
  };

  return Stage_Handler;

})();
