// variables
var isDev = location.href.split("/").slice(-2, -1)[0] === 'dist' ? true : false;
var url = !isDev ? '/markup/' : '';

// animation end
var animationEnd = (function(el) {
  var animations = {
    animation: 'animationend',
    OAnimation: 'oAnimationEnd',
    MozAnimation: 'mozAnimationEnd',
    WebkitAnimation: 'webkitAnimationEnd',
  };

  for (var t in animations) {
    if (el.style[t] !== undefined) {
      return animations[t];
    }
  }
})(document.createElement('div'));

// transition end
var transitionEnd = (function(el) {
  var transitions = {
    transition: 'transitionend',
    OTransition: 'oTransitionEnd',
    MozTransition: 'mozTransitionEnd',
    WebkitTransition: 'webkitTransitionEnd',
  };

  for (var t in transitions) {
    if (el.style[t] !== undefined) {
      return transitions[t];
    }
  }
})(document.createElement('div'));

// isMobile
function isMobile() {
	if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
		return true;
	} else {
		return false;
	}
}

// viewport
function viewport() {
  return {
    width: $(window).width(),
    height: $(window).height()
  }
}

// calculate proportions
function calculateAspectRatioFit(srcWidth, srcHeight, maxWidth, maxHeight) {
	var ratio = Math.min(maxWidth / srcWidth, maxHeight / srcHeight);

	return { width: Math.ceil(srcWidth*ratio), height: Math.ceil(srcHeight*ratio) };
}

// get scrollbar width
function getScrollbarWidth() {
  var outer = document.createElement('div');
  outer.style.visibility = 'hidden';
  outer.style.overflow = 'scroll';
  outer.style.msOverflowStyle = 'scrollbar';
  document.body.appendChild(outer);

  var inner = document.createElement('div');
  outer.appendChild(inner);

  var scrollbarWidth = (outer.offsetWidth - inner.offsetWidth);
  outer.parentNode.removeChild(outer);

  return scrollbarWidth;
}

// images complete
function imagesComplete(images) {
  images.each(function() {
    var image = $(this);

    if(!image.data('is-loading')) {
      if (!image.prop('complete')) {
        image.on('load', function() {
          image.data('is-loading', true);

          $(document).trigger('image.complete');
        });
      } else {
        image.data('is-loading', true);

        $(document).trigger('image.complete');
      }
    }
  });
}
