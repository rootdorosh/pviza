;(function($, window, document, undefined) {

  var plugin = {
    name: 'lazySize',
    version: '2.1.4',
    license: 'MIT',
    author: 'Andrey Proskurin',
    imageSetFormats: ['any']
  };

  var defaults = {
    attrSrc: 'data-src',
  	attrBreakpoints: 'data-image-breakpoints',
    classLoading: 'loading',
		classLoaded: 'loaded',
		classError: 'error',
		classWrapLoading: 'wrap-loading',
    placeholder: 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==',
    inViewport: false,
    slick: false,
    resizeTimer: 250,
    imageSet: true,
		onInitBefore: function() {},
		onInitAfter: function() {},
		onLoadBefore: function() {},
		onLoadAfter: function() {}
  };

  var Plugin = function(element, options) {
    this.element = element;
    this.config = $.extend({}, defaults, options);
    this.data = {};
    this.init();
  };

  Plugin.prototype.init = function() {
    var scope = this;
    var element = scope.element;
    var attrSrc = scope.config.attrSrc;
    var attrBreakpoints = scope.config.attrBreakpoints;
    var source = element.attr(attrSrc);
    var breakpoints = element.attr(attrBreakpoints);

    scope.data.tagName = element.get(0).tagName;
    scope.data.load = false;

    if (typeof breakpoints !== typeof undefined && breakpoints !== false) {
      if ($.trim(breakpoints)) {
        scope.data.breakpoints = {};
        scope.data.type = 'breakpoints';
        scope.data.breakpoints.default = breakpoints;
        scope.data.breakpoints.parse = $.parseJSON(breakpoints);
        scope.data.breakpoints.range = Object.keys(scope.data.breakpoints.parse);
        scope.data.breakpoints.current = scope.getBreakpoint();
      }

      element
        .removeAttr(attrBreakpoints)
        .removeAttr(attrSrc)
        .removeAttr('src');
    } else if (typeof source !== typeof undefined && source !== false) {
      if ($.trim(source)) {
        scope.data.source = {};
        scope.data.type = 'source';

        if (source.replace(/[^{}]/g, '') == '{}') {
          scope.data.source.default = $.parseJSON(source);
        } else {
          scope.data.source.default = source;
        }
      }

      element
        .removeAttr(attrSrc)
        .removeAttr('src');
    } else {
      return;
    }

    if (scope.config.slick) {
      var slickSlider = element.closest('.slick-slider');

      if (slickSlider.length > 0) {
        scope.data.slick = {};
        scope.data.slick.slider = slickSlider;
      }
    }

    scope.events();
  };

  Plugin.prototype.getViewport = function() {
    return {
      width: $(window).width(),
      height: $(window).height()
    }
  };

  Plugin.prototype.getBreakpoint = function() {
    var scope = this;

    return scope.data.breakpoints.range.reduce(function(prev, current) {
      return current <= scope.getViewport().width ? current : prev;
    });
  };

  Plugin.prototype.inViewport = function() {
    var scope = this;
    var element = scope.element;

    if (scope.data.load) return;

    var elementTop = element.offset().top;
    var elementBottom = elementTop + element.outerHeight();
    var viewportTop = $(window).scrollTop();
    var viewportBottom = Math.floor(viewportTop + scope.getViewport().height);

    if((viewportBottom > elementTop) && (viewportTop < elementBottom)) {
      scope.data.load = true;

      scope.load();
    }
  };

  Plugin.prototype.slickRefresh = function() {
    var scope = this;
    var slider = scope.data.slick.slider;

    if (!slider.data('refresh')) {
      slider.data('refresh', true);

      setTimeout(function() {
        slider
          .slick('refresh')
          .removeData('refresh');
      }, 500);
    }
  };

  Plugin.prototype.getUrl = function(array) {
    var scope = this;
    var formats = plugin.imageSetFormats;
    var url = undefined;
    var urlLength = Object.keys(array).length;
    var formatsLength = 0;

    $.each(array, function(key, val) {
      formatsLength++;

      if (formats.indexOf(key) > -1 && key != 'any') {
        url = array[key];
      }

      if (!url && urlLength == formatsLength) {
        if (typeof array == 'object' && formats.indexOf('any') > -1) {
          url = array['any'];
        }
      }
    });

    return url;
  };

  Plugin.prototype.load = function() {
    var scope = this;
    var element = scope.element;
    var url = undefined;

    if (scope.data.type === 'breakpoints') {
      url = scope.data.breakpoints.parse[scope.data.breakpoints.current][0];

      if (scope.config.imageSet && typeof url == 'object') {
        url = scope.getUrl(url);
      }
    } else if (scope.data.type === 'source') {
      url = scope.data.source.default;

      if (scope.config.imageSet && typeof url == 'object') {
        url = scope.getUrl(url);
      }
    }

    if (!$.trim(url) || typeof url == 'object') return;

    scope.config.onLoadBefore(element);

    element
      .parent()
      .removeClass(scope.config.classLoaded)
      .removeClass(scope.config.classError);

    if (scope.data.tagName === 'IMG') {
      element
        .attr('src', scope.config.placeholder)
        .css('visibility', 'hidden')
        .wrap('<div class="'+ scope.config.classWrapLoading +' '+ scope.config.classLoading +'" style="display: '+ element.css('display') +'" />');
    }

    element.addClass(scope.config.classLoading);

    $('<img/>')
      .off('load.' + plugin.name + ' error.' + plugin.name)
      .attr('src', url)
      .on('load.' + plugin.name, function() {
        $(this).remove();

        if (scope.data.tagName === 'IMG') {
          element
            .attr('src', url)
            .unwrap()
            .css('visibility', '');
        } else {
          element.css('background-image', 'url("'+ url +'")');

          if (scope.data.type === 'breakpoints') {
            var backgroundPosition = $.trim(scope.data.breakpoints.parse[scope.data.breakpoints.current][1]);
            var backgroundSize = $.trim(scope.data.breakpoints.parse[scope.data.breakpoints.current][2]);

            element
              .css({
                'background-position': backgroundPosition ? backgroundPosition : '',
                'background-size': backgroundSize ? backgroundSize : ''
              });
          }
        }

        element
          .off('load.' + plugin.name + ' error.' + plugin.name)
          .removeClass(scope.config.classLoading)
          .addClass(scope.config.classLoaded)
          .trigger(plugin.name + '.loaded')
          .parent()
          .addClass(scope.config.classLoaded);

        if (scope.data.slick) {
          scope.slickRefresh();
        }

        scope.config.onLoadAfter(element);
      })
      .on('error.' + plugin.name, function() {
        element
          .off('load.' + plugin.name + ' error.' + plugin.name)
          .removeClass(scope.config.classLoading)
          .addClass(scope.config.classError)
          .parent()
          .addClass(scope.config.classError);

        if (scope.data.slick) {
          scope.slickRefresh();
        }

        scope.config.onLoadAfter(element);
      });
  };

  Plugin.prototype.events = function() {
    var scope = this;
    var element = scope.element;
    var resizeTimeout = null;

    // in viewport
    if (scope.config.inViewport) {
      scope.inViewport();

      $(window).on('scroll.' + plugin.name, function() {
        scope.inViewport();
      });
    } else {
      scope.load();
    };

    $(window).on('resize.' + plugin.name, function() {
      clearTimeout(resizeTimeout);

      // get breakpoint
      if (scope.data.type === 'breakpoints') {
        var breakpoint = scope.getBreakpoint();
      };

      resizeTimeout = setTimeout(function() {
        // get breakpoint
        if (scope.data.type === 'breakpoints') {
          if (scope.data.breakpoints.current !== breakpoint) {
            scope.data.breakpoints.current = breakpoint;

            scope.load();
          }
        };

        // in viewport
        if (scope.config.inViewport) {
          scope.inViewport();
        };
      }, scope.config.resizeTimer);
    });
  };

  Plugin.prototype.refresh = function(elements) {
    var scope = this;
    var options = scope.config;

    scope.destroy(elements);

    elements.each(function() {
      var element = $(this);

      if (!element.data(plugin.name)) {
        element.data(plugin.name, new Plugin(element, options));
      }
    });
  };

  Plugin.prototype.destroy = function(elements) {
    $(window).off('.' + plugin.name);

    elements.each(function() {
      var element = $(this);
      var scope = element.data(plugin.name);

      if (scope) {
        element.removeData(plugin.name);
        element.off('.' + plugin.name);

        element
          .removeClass(scope.config.classLoading)
          .removeClass(scope.config.classLoaded)
          .removeClass(scope.config.classError);

        if (scope.data.tagName === 'IMG') {
          element.attr('src', scope.config.placeholder);
        } else {
          element.css({
            'background-image': '',
            'background-position': '',
            'background-size': ''
          });
        }

        if (scope.data.type === 'breakpoints') {
          element.attr(scope.config.attrBreakpoints, scope.data.breakpoints.default);
        } else if (scope.data.type === 'source') {
          element.attr(scope.config.attrSrc, scope.data.source.default);
        }
      }
    });
  };

  $.fn[plugin.name] = function(options) {
    var elements = $(this);

    if (typeof options === 'undefined' || typeof options === 'object') {
      function init() {
        if (options && options.onInitBefore && typeof options.onInitBefore === 'function') {
          options.onInitBefore.call(elements);
        }

        elements.each(function(index) {
          var element = $(this);

          if (!element.data(plugin.name)) {
            element.data(plugin.name, new Plugin(element, options));
          }
        })
        .promise()
        .done(function() {
          if (options && options.onInitAfter && typeof options.onInitAfter === 'function') {
            options.onInitAfter.call(elements);
          }
        });
      }

      if ((typeof options === 'undefined' && defaults.imageSet) || (typeof options === 'object' && options.imageSet)) {
        var imageSetFormats = plugin.imageSetFormats;
        var imageSetCounter = 0;

        function imageSetState() {
          if (imageSetCounter == 1) {
            init();
          }
        }

        var WebP = new Image();
        WebP.onload = WebP.onerror = function() {
          imageSetCounter++;

          if (WebP.height == 2) {
            plugin.imageSetFormats.push('webp');
          }

          imageSetState();
        };
        WebP.src = 'data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA';

      } else {
        init();
      }
    } else if (typeof options === 'string') {
      elements.each(function() {
        var element = $(this);

        if (element.data(plugin.name) && typeof element.data(plugin.name)[options] === 'function') {
          element.data(plugin.name)[options].apply(element.data(plugin.name), [elements]);

          return false;
        }
      });
    } else {
      $.error('Method ' + options + ' does not exist on jQuery ' + plugin.name);
    }

    return elements;
  }

})(jQuery, window, document);
