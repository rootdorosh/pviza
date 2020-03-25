var target = 'butterfly';
var element = document.getElementById(target);

var attributes = {
  'version': '1.1',
  'xmlns': 'http://www.w3.org/2000/svg',
  'xmlns:xlink': 'http://www.w3.org/1999/xlink',
  'viewBox': '0 0 1200 380'
}

for (attribute in attributes) {
  element.setAttribute(attribute, attributes[attribute]);
}

var s = Snap('#' + target);

var color = [
  '#391200',
  '#6881B5'
];

var tendrilsDuration = 4000;
var wingsDuration = 500;

var wingLeftTopPath = 'M32.1,46.2c-3.8,2.5-13.3-3.3-17.9-10.4c0,0-7.7-11.6-2.5-27.3c0.2-0.7,0.4-1.2,0.5-1.6c1.9-5.1,2.3-6.6,3.4-6.8c1-0.2,2.7,0.7,7.6,9.1c3.9,6.7,5.8,10,7.4,14.8C31.7,27.6,36.8,43.1,32.1,46.2z';
var wingLeftTopBendPath = 'M32.1,46.2c-3.8,2.5-5.7-3.3-10.4-10.4c0,0-7.7-11.6-2.5-27.3c0.2-0.7,0.4-1.2,0.5-1.6c1.9-5.1,2.3-6.6,3.4-6.8c1-0.2,2.7,0.7,7.6,9.1c3.9,6.7,5.4,9.9,6.7,15C38.1,27.8,36.8,43.1,32.1,46.2z';
var wingLeftBottomPath = 'M32.9,44.9c-0.1-3.7-6.4-4.3-10.8-4.7c-3-0.3-7.5-0.7-13.6,1.6c-2.7,1-5,2.3-6.6,3.3c-0.9,1-2,2.5-2,3.9c-0.2,3.3,4.8,4.4,7.2,4.8c3.2,0.7,6.9,0.1,14.3-1c5.3-0.8,7.6-1.5,9.4-3.5C31.1,49.1,33,46.9,32.9,44.9z';
var wingLeftBottomBendPath = 'M32.9,44.9c-0.1-1.6-0.5-2.8-3.2-4.7c-3-0.3-7.1,0.1-13.6,1.6c-2.7,1-5,2.3-6.6,3.3c-1,0.9-2,2.5-2,3.9c-0.2,3.3,4.8,4.4,7.2,4.8c3.9-0.1,4.8-0.4,9.1-1.2c3.1-0.8,5.6-1.8,7.1-3.3C31.1,49.1,33,46.9,32.9,44.9z';
var wingRightTopPath = 'M30.7,47.6C29.1,52,37.1,59.7,45,62.6c0,0,13.1,4.7,27.1-4.1c0.6-0.4,1.1-0.7,1.4-0.9c4.5-3,5.8-3.8,5.8-4.9c-0.1-1-1.3-2.5-10.7-5.2c-7.4-2.2-11.2-3.2-16.1-3.6C48.8,43.4,32.5,42.3,30.7,47.6z';
var wingRightTopBendPath = 'M30.7,47.6c-1.5,4.3,8.2,6.2,13.8,7.4c0,0,13.1,3.1,27.1-4.1c0.6-0.4,1.1-0.7,1.4-0.9c4.5-3,5.8-3.8,5.8-4.9c-0.1-1-3.5-2.5-10.7-5.2c-6.5-2.1-8.6-3.1-16.6-2.7C44.6,37.8,32.5,42.3,30.7,47.6z';
var wingRightBottomPath = 'M32.5,45.3c3.6-0.9,5.9,5,7.4,9.1c1.1,2.8,2.7,7.1,2.2,13.6c-0.3,2.9-0.9,5.4-1.4,7.2c-0.7,1.1-1.8,2.6-3.2,3c-3.1,1-5.5-3.4-6.6-5.7c-1.6-2.9-2-6.6-2.9-14.1c-0.6-5.4-0.6-7.7,0.9-10C29,48.1,30.5,45.8,32.5,45.3z';
var wingRightBottomBendPath = 'M32.5,45.3c3.6-0.9,6,1.5,7.5,5.6c1.1,2.8,2.6,5.8,2.1,12.3c-0.3,2.9-0.9,5.4-1.4,7.2c-0.7,1.1-1.8,2.6-3.2,3c-3.1,1-5.5-3.4-6.6-5.7c-1.6-2.9-2-6.6-2.9-14.1c-0.2-2.8,0.2-3.9,0.9-5.2C29,48.1,30.5,45.8,32.5,45.3z';
var tendrilLeftPath = 'M37.8,37.9l-0.9-0.7c1.5-1.9,2.6-4,3.4-6.3c1.1-3.3,1.3-6.2,1.2-8.1l1.2-0.1c0.1,1.9,0,5-1.2,8.5C40.6,33.6,39.4,35.9,37.8,37.9z';
var tendrilLeftBendPath = 'M38,39.1l-1.1-0.5c1-2.2,1.5-4.6,1.8-7c0.3-3.5-0.3-6.3-0.9-8.1l1.1-0.4c0.6,1.9,1.2,4.9,0.9,8.6C39.6,34.3,39,36.7,38,39.1z';
var tendrilRightPath = 'M40.7,39.6l-0.9-0.8c1.7-1.8,3.8-3.3,6.1-4.5c2.6-1.3,5.4-2.1,8.3-2.3l0.1,1.2c-2.8,0.2-5.4,1-7.9,2.2C44.3,36.5,42.4,37.9,40.7,39.6z';
var tendrilRightBendPath = 'M40.7,39.7L40,38.8c1.9-1.6,4.2-2.8,6.6-3.7c2.7-1,5.6-1.4,8.5-1.3l0,1.2c-2.8-0.1-5.5,0.3-8.1,1.2C44.7,37,42.5,38.2,40.7,39.7z';
var tailPath = 'M33.6,43.5c-1.5,1.1-3.5,2.9-5.9,5.1c-0.8,0.8-4.5,2.9-10.2,10.6c-3.9,5.2-0.8,6.2,1.2,5.7c1.4-0.4,0.8-0.4,3.2-2.9c3-3.1,6.4-6.6,9.1-12C32.3,47.3,33.1,45.1,33.6,43.5z';
var flightPath = 'M122.9,98.7c26.5-14.4,57.5-20,88-23.1c34.8-3.6,69.8-4.2,104.7-4.9c17.8-0.4,35.8-0.6,53.2,2.5c17.8,3.2,34.6,9.9,51.9,15c42.4,12.7,88,15.8,132.1,10c46.1-6.1,90.1-21.6,135.3-32c45.2-10.5,93.9-15.4,137.7-0.6c23.3,7.9,44.4,21.1,68.1,27.8c33.8,9.4,70,4.9,105.4,5.5c35.3,0.6,74,8.6,94.8,35.1c11.6,14.9,15.9,33.5,18.2,51.7c1,7.3,1.6,15.2-2,21.8c-3,5.5-8.6,9.4-14.4,12.4c-40.7,21.7-94.4,10.9-136,31c-21.3,10.3-37.4,27.6-56.2,41.4c-60.6,43.9-153,45.3-215,3.1c-11.7-8-22.5-17.3-35.6-23.5c-12-5.6-25.4-8.1-38.7-10c-47.9-6.7-96.6-5.4-145.1-4.1c-37.2,1-74.7,2-110.7,10.6c-34.9,8.3-67.5,23.7-102.1,33.2c-34.6,9.4-73.6,12.7-105.5-2.8c-25.6-12.4-43.6-35.3-54.5-60.1c-6.1-13.9-10.2-28.5-13.4-43.2c-2.5-11.5-8.3-24.7-9-36.2C72.9,134.8,102.2,110,122.9,98.7z';

var wingLeftTop = s.path(wingLeftTopPath);
var wingLeftBottom = s.path(wingLeftBottomPath);
var wingRightTop = s.path(wingRightTopPath);
var wingRightBottom = s.path(wingRightBottomPath);
var head = s.circle(38, 39.4, 3.2);
var tendrilLeft = s.path(tendrilLeftPath);
var tendrilRight = s.path(tendrilRightPath);
var body = s.ellipse(32.3, 46.1, 6.9, 3.4);
var tail = s.path(tailPath);
var flight = s.path(flightPath);

var wings = s.group(wingLeftTop, wingLeftBottom, wingRightTop, wingRightBottom);
var core = s.group(head, tendrilLeft, tendrilRight, body, tail);
var butterfly = s.group(core, wings);

body.transform('matrix(0.7047 -0.7095 0.7095 0.7047 -23.177 36.5538)');

wings.attr({
  fill: color[1]
});

core.attr({
  fill: color[0]
});

flight.attr({
  fill: 'none',
  // stroke: color[0],
  // strokeMiterlimit: 10
});

var tendrilLeftAnim = [{
	animation: {
    d: tendrilLeftBendPath,
	},
	duration: tendrilsDuration
}, {
	animation: {
    d: tendrilLeftPath,
	},
	duration: tendrilsDuration
}];

var tendrilRightAnim = [{
	animation: {
    d: tendrilRightBendPath,
	},
	duration: tendrilsDuration
}, {
	animation: {
    d: tendrilRightPath,
	},
	duration: tendrilsDuration
}];

var wingLeftTopAnim = [{
	animation: {
    d: wingLeftTopBendPath,
	},
	duration: wingsDuration
}, {
	animation: {
    d: wingLeftTopPath,
	},
	duration: wingsDuration
}];

var wingLeftBottomAnim = [{
	animation: {
    d: wingLeftBottomBendPath,
	},
	duration: wingsDuration
}, {
	animation: {
    d: wingLeftBottomPath,
	},
	duration: wingsDuration
}];

var wingRightTopAnim = [{
	animation: {
    d: wingRightTopBendPath,
	},
	duration: wingsDuration
}, {
	animation: {
    d: wingRightTopPath,
	},
	duration: wingsDuration
}];

var wingRightBottomAnim = [{
	animation: {
    d: wingRightBottomBendPath,
	},
	duration: wingsDuration
}, {
	animation: {
    d: wingRightBottomPath,
	},
	duration: wingsDuration
}];

function nextFrame(el, frameArray, whichFrame) {
	if (whichFrame >= frameArray.length) return;

	el.animate(frameArray[whichFrame].animation, frameArray[whichFrame].duration, nextFrame.bind(null, el, frameArray, whichFrame + 1));
}

function animationTendrils() {
  nextFrame(tendrilLeft, tendrilLeftAnim, 0);
  nextFrame(tendrilRight, tendrilRightAnim, 0);
}

animationTendrils();
setInterval(animationTendrils, tendrilsDuration * 2);

function animationWings() {
  nextFrame(wingLeftTop, wingLeftTopAnim, 0);
  nextFrame(wingLeftBottom, wingLeftBottomAnim, 0);
  nextFrame(wingRightTop, wingRightTopAnim, 0);
  nextFrame(wingRightBottom, wingRightBottomAnim, 0);
}

// animationWings();
// setInterval(animationWings, wingsDuration * 2);

var butterflyFrom = 0;
var butterflyTo = flight.getTotalLength();
var butterflyStart = flight.getPointAtLength(butterflyFrom);
var butterflyStartX = butterflyStart.x;
var butterflyStartY = butterflyStart.y;
var butterflyStartAlpha = butterflyStart.alpha;
var butterflyEnd = flight.getPointAtLength(butterflyTo);
var butterflyEndAlpha = butterflyEnd.alpha;

var animationButterfly = function() {
  Snap.animate(butterflyFrom, butterflyTo, function(value) {
    var butterflyMove = flight.getPointAtLength(value);
    var butterflyMoveX = butterflyMove.x;
    var butterflyMoveY = butterflyMove.y;
    var butterflyMoveAlpha = butterflyMove.alpha;
    var x, y, alpha;

    if (butterflyMoveAlpha == butterflyEndAlpha) {
      x = butterflyStartX;
      y = butterflyStartY;
      alpha = butterflyStartAlpha;
    } else {
      x = butterflyMoveX;
      y = butterflyMoveY;
      alpha = butterflyMoveAlpha;
    }

    butterfly.transform('t' + (x - 40) + ',' + (y - 40) + 'r' + (alpha - 135));
  }, 50000, mina.linear, animationButterfly);
};

animationButterfly();
