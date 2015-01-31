var Header,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

Header = (function() {
  function Header() {
    this.hide = __bind(this.hide, this);
    this.show = __bind(this.show, this);
    this.mode = null;
    this.saved_mode = null;
    this.is_setup = $.Deferred();
    this.is_setup.promise();
  }

  Header.prototype.setup = function(responsive) {
    var mode;
    if (responsive == null) {
      responsive = false;
    }
    if (!responsive) {
      mode = 'regular';
    } else {
      mode = 'responsive';
    }
    this._set(mode);
    this.mode = mode;
    return this.is_setup.resolve();
  };

  Header.prototype.is_tmp = function() {
    return this.saved_mode !== null;
  };

  Header.prototype.is_visible = function() {
    return !this.is_tmp() && this.mode === 'regular';
  };

  Header.prototype.show = function() {
    if (this.mode === 'regular') {
      return;
    }
    return $$('#header').addClass("is-visible");
  };

  Header.prototype.hide = function() {
    if (this.mode === 'regular') {
      return;
    }
    return $$('#header').removeClass("is-visible");
  };

  Header.prototype.reset = function() {
    if (this.mode === null) {
      return;
    }
    if (!this.is_tmp()) {
      return;
    }
    if (this.mode === this.saved_mode) {
      return;
    }
    this.mode = this.saved_mode;
    this.saved_mode = null;
    return this._set(this.mode);
  };

  Header.prototype._set = function(mode) {
    if (this.is_tmp()) {
      return false;
    }
    if (mode === 'regular') {
      $$("html").addClass('header--regular').removeClass('header--toggleable');
    }
    if (mode === 'responsive') {
      $$("html").removeClass('header--regular').addClass('header--toggleable');
    }
    return this;
  };

  Header.prototype.set_to = function(mode, temporary) {
    var _this = this;
    if (mode == null) {
      mode = 'regular';
    }
    if (temporary == null) {
      temporary = false;
    }
    if (mode === this.mode) {
      return;
    }
    if (this.is_tmp()) {
      return false;
    }
    $.when(this.is_setup).then(function() {
      _this._set(mode);
      if (temporary) {
        _this.saved_mode = _this.mode;
      }
      _this.mode = mode;
    });
    return this;
  };

  return Header;

})();
