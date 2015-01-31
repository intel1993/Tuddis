(function() {
  var $ajax, $render, R, Stage, clicked_url, on_render;

  if (!window.history.pushState) {
    return;
  }

  Stage = new Stage_Handler();

  $ajax = new $.Deferred();

  $render = new $.Deferred();

  clicked_url = false;

  R = false;

  $$(window).on("pronto.request", function() {
    if (R === true) {
      return;
    }
    R = true;
    $ajax = Stage.add_promise();
    Stage.close();
  });

  $$(window).on("pronto.load", function() {
    $ajax.resolve();
    R = false;
  });

  $$(window).on("pronto.error", function() {
    window.location.href = clicked_url;
  });

  $$(window).on("pronto.render", function() {
    $render.resolve();
    $ajax.resolve();
    clicked_url = false;
  });

  on_render = function(data) {
    var $new_stage;
    $render = Stage.add_promise();
    $new_stage = Stage.add(data);
    $$('#content').prepend($new_stage);
    return $.when($new_stage).done(function() {
      data.body_classes.push("loaded");
      $$('body').attr('class', data.body_classes.join(" "));
      return $$('head title').text(data.title);
    });
  };

  $$(window).on('stage/complete', function() {
    if (!App.is.responsive) {
      return App.Scroll.setup($$('#stage'));
    }
  });

  $$('body').on('click', 'a', function() {
    var href;
    href = $(this).attr('href');
    if ((href != null) && href !== "") {
      clicked_url = href;
    }
  });

  $$(document).ready(function() {
    return $.pronto({
      selector: 'a:not(.no-pjax)',
      requestKey: "pjax",
      force: true,
      target: {
        title: 'title',
        content: '#content'
      },
      render: on_render
    });
  });

}).call(this);
