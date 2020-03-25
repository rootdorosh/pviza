$(function() {

// device
if (isMobile()) {
	$('html').addClass('is-mobile');
} else {
	$('html').addClass('is-desktop');
}

// update browser
if (bowser.chrome && bowser.version <= 44) {
	$('.update-browser').show();
} else if (bowser.firefox && bowser.version <= 42) {
	$('.update-browser').show();
} else if (bowser.msie && bowser.version <= 9) {
	$('.update-browser').show();
} else if (bowser.safari && bowser.version <= 8) {
	$('.update-browser').show();
} else if (bowser.opera && bowser.version <= 33) {
	$('.update-browser').show();
}

// header menu
$(document).on('click', '.js-menu-btn-open', function() {
	$('body').addClass('body-scroll-hidden').css('padding-right', getScrollbarWidth() + 'px');
	$('.header').addClass('active').css('padding-right', getScrollbarWidth() + 'px');
});

$(document).on('click', '.js-menu-btn-close', function() {
	$('body').removeClass('body-scroll-hidden').css('padding-right', '');
	$('.header').removeClass('active').css('padding-right', '');
});

// header scroll
function headerScroll(position) {
	var header = $('.header');

	if (position > 1) {
		header.addClass('scroll');
	} else {
		header.removeClass('scroll');
	}
}

headerScroll($(window).scrollTop());

$(window).on('scroll', function() {
	headerScroll($(this).scrollTop());
});

// about
if ($('.about').length > 0) {
	var aboutMain = $('.about__affirmation-main');
	var aboutNumber = $('.about__affirmation-number');
	var aboutLabel = $('.about__affirmation-label');
	var aboutCaption = $('.about__affirmation-caption');
	var aboutTyped = [];

	$.each(aboutData, function() {
		aboutTyped.push(this.caption)
	});

	$(document).on('animation.start.done', function() {
		$(this).off('animation.start.done');

		aboutCaption.typed({
			strings: aboutTyped,
			backDelay: 5000,
			loop: true,
			fadeOut: true,
			fadeOutDelay: 1000,
			preStringTyped: function(i) {
				aboutMain.addClass('active');
				aboutNumber.text(i + 1);
				aboutLabel.text(aboutData[i].label);
			},
			onStringTyped: function() {
				aboutMain.removeClass('active');
			}
		});
	});
}

// quote
if ($('.quote').length > 0) {
	$('.quote').each(function() {
		var wrap = $(this);
		var wrapH = wrap.height();
		var content = wrap.find('.quote__content');
		var strings = [content.text()];
		var animationName = 'animation.active';

		wrap.css('height', wrapH).off(animationName).on(animationName, function() {
			$(this).off(animationName);

			content.text('').typed({
				strings: strings,
				preStringTyped: function() {
					wrap.addClass('active');
				},
				callback: function() {
					wrap.css('height', '').addClass('done');
				},
			});
		});
	});
}

// mask
var maskPhone = '+38 (999) 999 99 99';

$('.js-mask-phone').mask(maskPhone);

// field
var fieldElements = '.field input, .field textarea';
var maskPhoneVal = maskPhone.replace(/9/g, '_');

function fieldInit() {
	$(fieldElements).each(function() {
		fieldChange($(this));
	});
}

function fieldChange(element) {
	var value = element.val();

	if (value && value != maskPhoneVal) {
		element.addClass('active');
	} else {
		element.removeClass('active');
	}
}

fieldInit(fieldElements);

$(document).on('focusout', fieldElements, function() {
	fieldChange($(this));
});

$(document).ajaxComplete(function() {
	fieldInit(fieldElements);
});

// add file
function addFile() {
	$('.add-file').each(function() {
		var wrap = $(this);

		if(wrap.data('addFile')) return;

		wrap.data('addFile', true);

		var itemDefault = wrap.find('.add-file__item').clone();
		var list = wrap.find('.add-file__list');
		var maxSize = wrap.data('max-size');

		$(document).on('change', '.js-add-file', function(event) {
			var element = $(this);
			var item = element.closest('.add-file__item');
			var items = list.find('.add-file__item');
			var data = '';

			data += '<div class="add-file__name">'+ event.target.files[0].name +'</div>';
			data += '<div class="add-file__remove">';
			data += '<svg class="add-file__remove-icon"><use xlink:href="'+ url +'img/sprite.svg#close"></use></svg>';
			data += '</div>';

			item.addClass('active').append(data);

			if (items.length < maxSize) {
				list.append(itemDefault.clone());
			}
		});

		$(document).on('click', '.add-file__remove', function() {
			var element = $(this);
			var item = element.closest('.add-file__item');

			item.remove();

			var items = list.find('.add-file__item');

			if (items.length == 0) {
				list.append(itemDefault.clone());
			}
		});
	});
}

addFile();
$(document).ajaxComplete(addFile);

// waypoints
var waypointAnimation = function() {
	Waypoint.destroyAll();

	$('.js-animation:not(.animation-active)').waypoint({
		handler: function() {
			var element = $(this.element);

			if (!element.data('state')) {
				element.data('state', 'active');

				var animation = {
					type: element.data('animation'),
					duration: element.data('duration'),
					delay: element.data('delay')
				};

				if (animation.duration) {
					element.css({
						'-webkit-animation-duration': animation.duration,
						'-moz-animation-duration': animation.duration,
						'-o-animation-duration': animation.duration,
						'animation-duration': animation.duration
					});
				}

				if (animation.delay) {
					element.css({
						'-webkit-animation-delay': animation.delay,
						'-moz-animation-delay': animation.delay,
						'-o-animation-delay': animation.delay,
						'animation-delay': animation.delay
					});
				}

				if (animation.type) {
					element.addClass(animation.type);
				}

				element
					.addClass('animation-active')
					.trigger('animation.active');
			}
		},
		offset: '80%'
	});
};

waypointAnimation();
$(document).ajaxComplete(waypointAnimation);

// sunbee field
var feedbackSunbee = $('.feedback__sunbee');

$(document).on('focusin', '.js-feedback-field', function() {
	feedbackSunbee.addClass('sunbee-paused');
});

$(document).on('focusout', '.js-feedback-field', function() {
	feedbackSunbee.removeClass('sunbee-paused');
});

});

$(function() {

// $('body').removeClass('body-start');
// $('.wrap').addClass('animation-wrap-step1').css({'transition-delay': '0s'});
// return;

if ($('.body-start').length > 0) {

/****************************************************
* animation wrap
*****************************************************/

var animationWrapConfig = {
	wrap: $('.wrap')
}

function animationWrapStep1() {
	$('body').removeClass('body-start');
	$('body, .header').css('padding-right', '');
	animationWrapConfig.wrap.addClass('animation-wrap-step1');

	animationWrapConfig.wrap.off(transitionEnd).on(transitionEnd, function() {
		$(this).off(transitionEnd);

		$(document).trigger('animation.start.done');
	});
}

function animationWrapInit() {
	$(document).on('animation.wrap.step1', animationWrapStep1);

	$(document).trigger('animation.wrap.step1');
}


/****************************************************
* animation welcome
*****************************************************/

var animationWelcomeConfig = {
	welcome: $('.welcome'),
	list: $('.welcome__list'),
	listWidth: $('.welcome__list').width(),
	listHeight: $('.welcome__list').height(),
	itemSize: 270,
	itemsLength: 0,
	itemsCounter: 0,
	timerEnd: null,
	scopeTm: []
}

function random(min, max) {
	if (max == null) { max = min; min = 0; }

	return Math.random() * (max - min) + min;
}

function randomMovement(element, duration, x, y, opacity, scale, delay, step) {
	var tm = new TweenMax.to(element, duration, {
		x: x,
		y: y,
		opacity: opacity,
		scale: scale,
		delay: delay,
		ease: Power2.easeInOut,
		rotation: 0.001,
		force3D: true﻿,
		onComplete: function() {
			if (step) {
				animationWelcomeConfig.itemsCounter++;

				if (step == 2) {
					if (animationWelcomeConfig.itemsLength == animationWelcomeConfig.itemsCounter) {
						$(document).trigger('animation.welcome.step2');

						animationWelcomeConfig.itemsCounter = 0;
					}
				} else if (step == 3) {
					if (Math.ceil(animationWelcomeConfig.itemsLength / 6) == animationWelcomeConfig.itemsCounter) {
						$(document).trigger('animation.welcome.step3');

						animationWelcomeConfig.itemsCounter = 0;
					}
				} else {
					if (animationWelcomeConfig.itemsLength == animationWelcomeConfig.itemsCounter) {
						$(document).trigger('animation.welcome.step' + step);

						animationWelcomeConfig.itemsCounter = 0;
					}
				}
			}
		}
	}, 0);

	animationWelcomeConfig.scopeTm.push(tm);
}

function animationWelcomeStep1() {
	animationWelcomeConfig.welcome.addClass('animation-welcome-step1').data('currentStep', 1);

	var fillH = Math.ceil(animationWelcomeConfig.listWidth / animationWelcomeConfig.itemSize) * 2.1;
	var fillV = Math.ceil(animationWelcomeConfig.listHeight / animationWelcomeConfig.itemSize) * 1.2;

	for(var x = 0; x < fillH; x++) {
	  for(var y = 0; y < fillV / 2; y++) {
			var item = $('<div/>');
			var figure = $('<svg><use xlink:href="'+ url +'img/sprite.svg#hexagon"></use></svg>');
			var posY = (y * (animationWelcomeConfig.itemSize - 35) * 2) + animationWelcomeConfig.itemSize - 65;
	    var posX = (x * animationWelcomeConfig.itemSize / 2) - animationWelcomeConfig.itemSize / 2;

	    if(x % 2 == 0) {
	      posY = posY - (animationWelcomeConfig.itemSize - 35);
	    }

			figure
				.addClass('welcome__figure')
				.data('transform', {
					duration: random(1, 5),
					x: posX,
					y: posY
				})
				.css({
					'transform': 'translate3d('+ random(-animationWelcomeConfig.itemSize, animationWelcomeConfig.listWidth) +'px, '+ random(animationWelcomeConfig.listHeight, -animationWelcomeConfig.itemSize) +'px, 0px) scale('+ random(0.3, 1) +')',
					'opacity': 0
				});

			item
				.addClass('welcome__item')
				.append(figure)
				.appendTo(animationWelcomeConfig.list);

			animationWelcomeConfig.itemsLength++;
		}
	}

	$('.welcome__figure').each(function() {
		var element = $(this);
		var x = element.data('transform').x;
		var y = element.data('transform').y;
	  var duration = random(1, 5);
		var opacity = 1;
		var scale = 1;
		var delay = 0;
		var step = 2;

		randomMovement(element, duration, x, y, opacity, scale, delay, step);
	});
}

function animationWelcomeStep2() {
	animationWelcomeConfig.welcome.addClass('animation-welcome-step2').data('currentStep', 2);

	$('.welcome__figure').each(function() {
		var element = $(this);
		var x = random(-animationWelcomeConfig.itemSize, animationWelcomeConfig.listWidth + animationWelcomeConfig.itemSize);
		var y = random(animationWelcomeConfig.listHeight + animationWelcomeConfig.itemSize, -animationWelcomeConfig.itemSize);
		var duration = random(1, 5);
		var opacity = 0;
		var scale = random(0.2, 0.5);
		var delay = 0;
		var step = 3;

		randomMovement(element, duration, x, y, opacity, scale, delay, step);
	});
}

function animationWelcomeStep3() {
	animationWelcomeConfig.welcome.addClass('animation-welcome-step3').data('currentStep', 3);
}

function animationWelcomeStep4() {
	animationWelcomeConfig.welcome.addClass('animation-welcome-step4').data('currentStep', 4);

	clearTimeout(animationWelcomeConfig.timerEnd);
	animationWelcomeConfig.timerEnd = setTimeout(function() {
		$(document).trigger('animation.welcome.step5');
	}, 3000);
}

function animationWelcomeStep5() {
	animationWelcomeConfig.welcome.addClass('animation-welcome-step5').data('currentStep', 5);

	animationWelcomeConfig.welcome.off(transitionEnd).on(transitionEnd, function() {
		$(this).off(transitionEnd);

		animationWelcomeDestroy();

		animationWelcomeConfig.welcome.addClass('hidden');
	});

	animationWrapInit();
}

function animationWelcomeFefresh(init) {
	animationWelcomeConfig.listWidth = animationWelcomeConfig.list.width();
	animationWelcomeConfig.listHeight = animationWelcomeConfig.list.height();
	animationWelcomeConfig.itemsLength = 0;
	animationWelcomeConfig.itemsCounter = 0;

	for (var i = 1; i <= 5; i++) {
		animationWelcomeConfig.welcome.removeClass('animation-welcome-step' + i);

		$(document).off('animation.welcome.step' + i);
	}

	for (var i = 1; i < animationWelcomeConfig.scopeTm.length; i++) {
		animationWelcomeConfig.scopeTm[i].kill();
	}

	animationWelcomeConfig.scopeTm = [];

	$('.welcome__decor').eq(0).off(transitionEnd);
	$('.welcome__item').remove();

	if (init) {
		animationWelcomeInit();
	}
}

function animationWelcomeDestroy() {
	$(window).off('.animation.welcome');

	animationWelcomeFefresh(false);
}

function animationWelcomeInit() {
	$('body, .header').css('padding-right', getScrollbarWidth() + 'px');
	animationWelcomeConfig.welcome.removeClass('hidden');

	$('.welcome__decor').eq(0).off(transitionEnd).on(transitionEnd, function() {
		$(this).off(transitionEnd);

		$(document).trigger('animation.welcome.step4');
	});

	$(document).on('animation.welcome.step1', animationWelcomeStep1);
	$(document).on('animation.welcome.step2', animationWelcomeStep2);
	$(document).on('animation.welcome.step3', animationWelcomeStep3);
	$(document).on('animation.welcome.step4', animationWelcomeStep4);
	$(document).on('animation.welcome.step5', animationWelcomeStep5);

	$(document).trigger('animation.welcome.step1');
}

animationWelcomeInit();

$(window).on('resizeend.animation.welcome', function() {
	if (animationWelcomeConfig.welcome.data('currentStep') < 3) {
		animationWelcomeFefresh(true);
	}
});

}

});

$(function() {

/****************************************************
* honeycomb top
*****************************************************/

if ($('.honeycomb-top').length > 0) {
	var aboutController = new ScrollMagic.Controller({
		globalSceneOptions: {
			triggerHook: 'onLeave'
		}
	});

	new ScrollMagic
		.Scene({
			triggerElement: '.honeycomb-top__trigger',
			duration: '100%'
		})
		.setTween('.honeycomb-top__bg', {
			x: 100,
			y: 500,
			scale: 0.8,
			rotation: 25
		})
		// .addIndicators()
		.addTo(aboutController);
}


/****************************************************
* honeycomb bottom
*****************************************************/

if ($('.honeycomb-bottom').length > 0) {
	var footerController = new ScrollMagic.Controller();

	new ScrollMagic
		.Scene({
			triggerElement: '.honeycomb-bottom__trigger',
			duration: '100%'
		})
		.setTween('.honeycomb-bottom__bg', {
			x: 0,
			y: 0,
			scale: 1,
			rotation: 0
		})
		// .addIndicators()
		.addTo(footerController);
}


/****************************************************
* portfolio item
*****************************************************/

if ($('.body-portfolio-item').length > 0) {

	function itemInit() {
		var itemController = new ScrollMagic.Controller();
		var itemAnimation = new TimelineMax();
		var itemSectionLen = $('.section').length;

		function itemAddAnimation(element, delay, isFirst) {
			var id = $(element).attr('id');
			var prefix = '#'+ id +' ';

			if (!isFirst) {
				itemAnimation.fromTo(element, 1, {y: '0'}, {y: '-100%'});
			}

			if (id == 'data') {
				itemAnimation
					.fromTo(prefix + '.data__backdrop', itemGetDuration(id, 2), {opacity: '1'}, {opacity: '0'}, delay)
					.fromTo(prefix + '.data__column:eq(0)', 1, {y: '0'}, {y: '-200'}, delay)
					.fromTo(prefix + '.data__column:eq(1)', 1, {y: '0'}, {y: '200'}, delay)
					.fromTo(prefix + '.data__panel', 1, {x: '0'}, {x: '200'}, delay)
			} else if (id == 'color-spectrum') {
				itemAnimation
					.fromTo(prefix + '.color-spectrum__backdrop', itemGetDuration(id, 2), {opacity: '1'}, {opacity: '0'}, delay)
					.fromTo(prefix + '.color-spectrum__info', 1, {x: '-200'}, {x: '0'}, delay)
					.fromTo(prefix + '.color-spectrum__list', 1, {x: '200'}, {x: '0'}, delay);
			} else if (id == 'fonts') {
				itemAnimation
					.fromTo(prefix + '.fonts__backdrop', itemGetDuration(id, 2), {opacity: '1'}, {opacity: '0'}, delay)
					.fromTo(prefix + '.fonts__info', 1, {x: '-50', rotation: '-10'}, {x: '0', rotation: '0'}, delay)
					.fromTo(prefix + '.fonts__scope', 1, {scale: '0.8'}, {scale: '1'}, delay);
			} else if (id == 'preview') {
				itemAnimation
					.fromTo(prefix + '.preview__backdrop', itemGetDuration(id, 2), {opacity: '1'}, {opacity: '0'}, delay)
					.fromTo(prefix + '.preview__left', 1, {scale: '0.4'}, {scale: '1'}, delay)
					.fromTo(prefix + '.preview__right', 1, {scale: '1.3'}, {scale: '1'}, delay);
			} else if (id == 'view') {
				itemAnimation
					.fromTo(prefix + '.view__backdrop', itemGetDuration(id, 2), {opacity: '1'}, {opacity: '0'}, delay)
				// .fromTo(prefix + '.view__head', 1, {opacity: '0'}, {opacity: '1'}, delay)
				// 	.fromTo(prefix + '.view__body', 1, {y: '50'}, {y: '0'}, delay);
			} else if (id == 'layouts') {
				itemAnimation
					.fromTo(prefix + '.layouts__backdrop', itemGetDuration(id, 2), {opacity: '1'}, {opacity: '0'}, delay)
				// 	.fromTo(prefix + '.layouts__col:eq(1)', 1, {y: '200'}, {y: '0'}, delay)
				// 	.fromTo(prefix + '.layouts__col:eq(3)', 1, {y: '200'}, {y: '0'}, delay)
				// 	.fromTo(prefix + '.layouts__col:eq(2)', 1, {y: '-200'}, {y: '0'}, delay)
				// 	.fromTo(prefix + '.layouts__col:eq(4)', 1, {y: '-200'}, {y: '0'}, delay);
			}
		}

		function itemGetDuration(id, part) {
			return ((viewport().height - 92) / part) / $('#' + id).height();
		}

		$('.section').not(':first').each(function(i) {
			itemAddAnimation(this, i, false);
		});

		itemAddAnimation($('.section').eq(0)[0], 0, true);

		new ScrollMagic.Scene({
			triggerElement: '.sections',
			triggerHook: 'onLeave',
			duration: itemSectionLen * 100 + '%'
		})
		.setPin('.sections')
		.setTween(itemAnimation)
		.addTo(itemController);
	}

	var itemImg = $('.section img');
	var itemImgLen = itemImg.length;
	var itemImgLoad = 0;

	function itemReady() {
		if (itemImgLen == itemImgLoad) {
			itemInit();
		}
	}

	$(document).on('image.complete', function() {
		itemImgLoad++;

		itemReady();
	});

	imagesComplete($('.section img').not('.view__img'));

	$('.view__img').lazySize({
		classLoading: '',
		onLoadAfter: function() {
			itemImgLoad++;

			itemReady();
		}
	});
}

});
