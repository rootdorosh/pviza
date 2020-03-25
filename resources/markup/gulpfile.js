'use strict';

/****************************************************
* settings
*****************************************************/

const { src, dest, parallel, series, watch } = require('gulp');
const jade = require('gulp-jade');
const formatHtml = require('gulp-format-html');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const spritesmith = require('gulp.spritesmith');
const svgSymbols = require('gulp-svg-symbols');
const rename = require('gulp-rename');
const path = require('path');
const uglify = require('gulp-uglify');
const cleanCSS = require('gulp-clean-css');
const gcmq = require('gulp-group-css-media-queries');
const concat = require('gulp-concat');
const imagemin = require('gulp-imagemin');
const pngquant = require('imagemin-pngquant');
const tinypng = require('gulp-tinypng-compress');
const replace = require('gulp-replace');
const clean = require('gulp-clean');
const htmlreplace = require('gulp-html-replace');

const config = {
	path: {
		src: {
			jade: ['app/jade/*.jade'],
			jadeAjax: 'app/jade/ajax/**/*.jade',
			scss: 'app/sass/*.scss',
			spritePng: 'app/sprite/png/*.png',
			spriteSvg: 'app/sprite/svg/*.svg'
		},
		watch: {
			jade: ['app/jade/**/*.jade','!app/jade/ajax/','!app/jade/ajax/**/'],
			jadeAjax: 'app/jade/ajax/**/*.jade',
			scss: 'app/sass/**/*.scss',
			spritePng: 'app/sprite/png/*.png',
			spriteSvg: 'app/sprite/svg/*.svg'
		},
		dist: {
			html: 'dist/',
			htmlAjax: 'dist/ajax/',
			css: 'dist/css/',
			js: 'dist/js/',
			img: 'dist/img/'
		},
		dev: {
			html: 'dist/**/*.html',
			css: 'dist/css/*.css',
			js: 'dist/js/*.js',
			jsLang: 'dist/js/lang/*.js',
			img: 'dist/img/**/*.{png,jpg,jpeg}',
			imgCopy: 'dist/img/**/*.{svg,ico,webp}',
			font: 'dist/font/**/*',
			video: 'dist/video/**/*',
			json: 'dist/json/**/*'
		},
		prod: {
			html: '../../public/markup/',
			css: '../../public/markup/css/',
			js: '../../public/markup/js/',
			jsLang: '../../public/markup/js/jsLang/',
			img: '../../public/markup/img/',
			font: '../../public/markup/font/',
			video: '../../public/markup/video/',
			json: '../../public/markup/json/'
		},
	},
};


/****************************************************
* clean
*****************************************************/

function cleanBuild() {
  return src(config.path.prod.html, {
		read: false
  })
	.pipe(clean({
		force: true
	}));
}


/****************************************************
* html
*****************************************************/

function jadeBase() {
	return src(config.path.src.jade)
		.pipe(jade())
		.pipe(formatHtml({
			preserve_newlines: false,
		}))
		.pipe(dest(config.path.dist.html));
}

function jadeAjax() {
	return src(config.path.src.jadeAjax)
		.pipe(jade())
		.pipe(formatHtml({
			preserve_newlines: false,
		}))
		.pipe(dest(config.path.dist.htmlAjax));
}

function htmlBuild() {
	return src(config.path.dev.html)
		.pipe(htmlreplace({
			'css': '/markup/css/main.css',
			'js': '/markup/js/main.js'
		}))
		.pipe(replace('img/', '/markup/img/'))
		.pipe(replace('src="video/', 'src="/markup/video/'))
		.pipe(formatHtml({
			preserve_newlines: false,
		}))
		.pipe(dest(config.path.prod.html));
}


/****************************************************
* css
*****************************************************/

function cssBase() {
	return src(config.path.src.scss)
		.pipe(sass({
			outputStyle: 'expanded',
			includePaths: ['app/sass/']
		}).on('error', sass.logError))
		.pipe(autoprefixer())
		.pipe(gcmq())
		.pipe(dest(config.path.dist.css));
}

function cssBuild() {
  return src(config.path.dev.css)
		.pipe(concat('main.css'))
		.pipe(replace('/*!', '/*'))
		.pipe(cleanCSS({
			rebase: false
		}))
    .pipe(dest(config.path.prod.css));
}


/****************************************************
* js
*****************************************************/

var jsList = [
	'axios.js',
	'vue.js',
	'app.js',
	'jquery.js',
	'bowser.js',
	'jquery.resizeend.js',
	'jquery.lazySize.js',
	'TweenMax.js',
	'scrollMagic.js',
	'animation.gsap.js',
	'typed.js',
	'jquery.maskedinput.js',
	'jquery.waypoints.js',
	'common.js',
	'main.js'
];

for (var i in jsList) {
	jsList[i] = config.path.dist.js + jsList[i];
}

function jsAllBuild() {
	return src(jsList)
		.pipe(concat('main.js'))
    .pipe(uglify({
			mangle: false,
			compress: {
				collapse_vars: false,
				dead_code: false,
				evaluate: false,
				hoist_funs: false,
				join_vars: false,
				properties: false
			}
		}))
		.pipe(dest(config.path.prod.js));
}

var jsListLang = [
	'en.js',
	'ru.js',
	'uk.js'
];

for (var i in jsListLang) {
	jsListLang[i] = config.path.dist.js + 'lang/' + jsListLang[i];
}

function jsLangBuild() {
	return src(jsListLang)
    .pipe(uglify({
			mangle: false,
			compress: {
				collapse_vars: false,
				dead_code: false,
				evaluate: false,
				hoist_funs: false,
				join_vars: false,
				properties: false
			}
		}))
		.pipe(dest(config.path.prod.jsLang));
}

/****************************************************
* img
*****************************************************/

function imgTinypng() {
	return src(config.path.dev.img)
		.pipe(tinypng({
			key: 'OLAEukwtNxkoCEq0uF1Id0ZsjSQU7fgY',
			sigFile: 'images/.tinypng-sigs',
			log: true
		}))
		.pipe(dest(config.path.build.img));
}

function imgMinBuild() {
	return src(config.path.dev.img)
		.pipe(imagemin({
			progressive: true,
			svgoPlugins: [{removeViewBox: false}],
			use: [pngquant()],
			interlaced: true
		}))
		.pipe(dest(config.path.prod.img));
}

function imgCopyBuild() {
	return src(config.path.dev.imgCopy)
		.pipe(dest(config.path.prod.img));
}


/****************************************************
* sprite
*****************************************************/

function spritePng() {
  return src(config.path.src.spritePng)
		.pipe(spritesmith({
	    imgName: 'sprite.png',
	    cssName: '../../app/sass/sprite/_main.scss',
	    padding: 10,
	    algorithm: 'top-down',
	    imgPath: '../img/sprite.png?v=' + Date.now()
	  }))
		.pipe(dest(config.path.dist.img));
}

function spriteSvg() {
  return src(config.path.src.spriteSvg)
    .pipe(svgSymbols({
    	id: '%f',
    	templates: [
    		path.join(__dirname, 'app/node/gulp-svg-symbols/templates/svg-symbols.svg')
    	]
    }))
    .pipe(rename('sprite.svg'))
    .pipe(dest(config.path.dist.img));
}


/****************************************************
* font
*****************************************************/

function fontBuild() {
	return src(config.path.dev.font)
		.pipe(dest(config.path.prod.font));
}


/****************************************************
* video
*****************************************************/

function videoBuild() {
	return src(config.path.dev.video)
		.pipe(dest(config.path.prod.video));
}


/****************************************************
* json
*****************************************************/

function jsonBuild() {
	return src(config.path.dev.json)
		.pipe(dest(config.path.prod.json));
}


/****************************************************
* watch
*****************************************************/

function watcher() {
	watch(config.path.watch.jade, jadeBase);
	watch(config.path.watch.jadeAjax, jadeAjax);
	watch(config.path.watch.scss, cssBase);
	watch(config.path.watch.spritePng, spritePng);
	watch(config.path.watch.spriteSvg, spriteSvg);
}

/****************************************************
* default
*****************************************************/

exports.default = parallel(jadeBase, jadeAjax, cssBase, spritePng, spriteSvg, watcher);


/****************************************************
* build
*****************************************************/

exports.build = series(cleanBuild, htmlBuild, cssBuild, fontBuild, videoBuild, jsonBuild, jsAllBuild, jsLangBuild, imgMinBuild, imgCopyBuild);
