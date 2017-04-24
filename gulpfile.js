// Gulp
var gulp = require('gulp');

// Plugins
var browserSync = require('browser-sync');
var babel = require('gulp-babel');
var concat = require('gulp-concat');
var flatten = require('gulp-flatten');
var cleanCSS = require('gulp-clean-css');
var plumber = require('gulp-plumber');
var lineec = require('gulp-line-ending-corrector'); // Consistent Line Endings for non UNIX systems. Gulp Plugin for Line Ending Corrector (A utility that makes sure your files have consistent line endings)
var prefix = require('gulp-autoprefixer');
var rename = require('gulp-rename');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var uglify = require('gulp-uglify');
var imagemin = require('gulp-imagemin');

// Change this to current project url
var URL = 'wbkn.dev';

// Paths
var paths = {
	scripts: [
		// 'bower_components/foundation-sites/js/foundation.core.js',
		// 'bower_components/foundation-sites/js/foundation.util.box.js',
		// 'bower_components/foundation-sites/js/foundation.util.keyboard.js',
		// 'bower_components/foundation-sites/js/foundation.util.mediaQuery.js',
		// 'bower_components/foundation-sites/js/foundation.util.motion.js',
		// 'bower_components/foundation-sites/js/foundation.util.nest.js',
		// 'bower_components/foundation-sites/js/foundation.util.timerAndImageLoader.js',
		// 'bower_components/foundation-sites/js/foundation.util.touch.js',
		// 'bower_components/foundation-sites/js/foundation.util.triggers.js',
		// 'bower_components/foundation-sites/js/foundation.abide.js',
		// 'bower_components/foundation-sites/js/foundation.accordion.js',
		// 'bower_components/foundation-sites/js/foundation.accordionMenu.js',
		// 'bower_components/foundation-sites/js/foundation.core.js',
		// 'bower_components/foundation-sites/js/foundation.drilldown.js',
		// 'bower_components/foundation-sites/js/foundation.dropdown.js',
		// 'bower_components/foundation-sites/js/foundation.dropdownMenu.js',
		// 'bower_components/foundation-sites/js/foundation.equalizer.js',
		// 'bower_components/foundation-sites/js/foundation.interchange.js',
		// 'bower_components/foundation-sites/js/foundation.magellan.js',
		// 'bower_components/foundation-sites/js/foundation.offcanvas.js',
		// 'bower_components/foundation-sites/js/foundation.orbit.js',
		// 'bower_components/foundation-sites/js/foundation.responsiveMenu.js',
		// 'bower_components/foundation-sites/js/foundation.responsiveToggle.js',
		// 'bower_components/foundation-sites/js/foundation.reveal.js',
		// 'bower_components/foundation-sites/js/foundation.slider.js',
		// 'bower_components/foundation-sites/js/foundation.sticky.js',
		// 'bower_components/foundation-sites/js/foundation.tabs.js',
		// 'bower_components/foundation-sites/js/foundation.toggler.js',
		// 'bower_components/foundation-sites/js/foundation.tooltip.js',
		'assets/js/navigation.js',
		'assets/js/skip-link-focus-fix.js',
		'assets/js/theme.js',
	],
	copyScripts: [
	],
	vendorScripts: [
	],
	vendorStyles: [
	],
	images: ['assets/images/**'],
	fonts: ['assets/fonts/**'],
	scss: [
		'assets/scss/*.scss',
		'assets/scss/**/*.scss',
	],
	php: [
		'*.php',
		'lib/*.php',
	]
};

// Compile Sass

gulp.task('sass-dev', function() {
	gulp.src(paths.scss)
		.pipe(plumber())
		.pipe(sourcemaps.init()) // Initialize sourcemap plugin
		.pipe(sass({
			includePaths: ['assets/scss', 'bower_components/foundation-sites/scss', 'bower_components/motion-ui'],
			outputStyle: 'expanded'
		}).on('error', sass.logError))
		.pipe(sourcemaps.write())
		.pipe(lineec())
		.pipe(gulp.dest('./dist/css/'))
		.pipe(browserSync.stream({match: '**/*.css'}));
});

gulp.task('sass-build', function() {
	gulp.src(paths.scss)
		.pipe(plumber())
		.pipe(sass({
			includePaths: ['assets/scss', 'bower_components/foundation-sites/scss', 'bower_components/motion-ui'],
			outputStyle: 'expanded',
		}).on('error', sass.logError))
		.pipe(prefix({
			browsers: ["last 2 versions", "> 1%", "ie 10", "Firefox ESR"],
			remove: false,
			cascade: false
		}))
		.pipe(cleanCSS({compatibility: 'ie10'}))
		.pipe(rename({ suffix: '.min' }))
		.pipe(lineec())
		.pipe(gulp.dest('./dist/css/'))
});

//Optimize images, SVGs, ...
gulp.task('optimizeImages', function () {
	return gulp.src(paths.images)
		.pipe(imagemin(
			[imagemin.gifsicle(),
				imagemin.jpegtran(),
				imagemin.optipng(),
				imagemin.svgo([
					{
						removeStyleElement: true
					},
					{
						removeHiddenElems: true
					},
					{
						cleanupIDs: true
					},
					{
						convertStyleToAttrs: true
					}
				])
			]
		))
		.pipe(gulp.dest('dist/images/'));
});

// Copy scripts
gulp.task('copyScripts', function() {
	return gulp.src(paths.copyScripts)
		.pipe(flatten())
		.pipe(gulp.dest('dist/js/'))
		.pipe(browserSync.stream());
});

gulp.task('copyScripts-build', function() {
	return gulp.src(paths.copyScripts)
		.pipe(flatten())
		.pipe(uglify({
			outSourceMap: true
		}))
		.pipe(rename({ suffix: '.min' }))
		.pipe(gulp.dest('dist/js/'));
});

// Copy vendor scripts
gulp.task('vendorScripts', function() {
	return gulp.src(paths.vendorScripts)
		.pipe(flatten())
		.pipe(gulp.dest('dist/js/vendor/'))
		.pipe(browserSync.stream());
});

// Copy vendor scripts
gulp.task('vendorScripts-build', function() {
	return gulp.src(paths.vendorScripts)
		.pipe(flatten())
		.pipe(uglify({
			outSourceMap: true
		}))
		.pipe(rename({ suffix: '.min' }))
		.pipe(gulp.dest('dist/js/vendor/'))
		.pipe(browserSync.stream());
});

// Copy vendor styles
gulp.task('vendorStyles', function() {
	return gulp.src(paths.vendorStyles)
		.pipe(flatten())
		.pipe(gulp.dest('dist/css/vendor/'))
		.pipe(browserSync.stream());
});

// Copy vendor styles
gulp.task('vendorStyles-build', function() {
	return gulp.src(paths.vendorStyles)
		.pipe(flatten())
		.pipe(cleanCSS({compatibility: 'ie10'}))
		.pipe(rename({ suffix: '.min' }))
		.pipe(gulp.dest('dist/css/vendor/'))
		.pipe(browserSync.stream());
});


// Concat
gulp.task('concat-dev', function() {
	gulp.src( paths.scripts )
		.pipe(plumber())
		.pipe(babel())
		.pipe(concat('theme.js'))
		.pipe(lineec())
		.pipe(gulp.dest('dist/js'))
		.pipe(browserSync.stream({match: '**/*.js'}));
});

gulp.task('concat-build', function() {
  gulp.src( paths.scripts )
	.pipe(plumber())
	.pipe(babel())
	.pipe(concat('theme.js'))
	.pipe(uglify({
		outSourceMap: true
	}))
	.pipe(rename({ suffix: '.min' }))
	.pipe(lineec())
	.pipe(gulp.dest('dist/js'));
});

gulp.task('browser-sync', function() {
	browserSync.init({
		proxy: URL
	});
});

gulp.task('reloadPHP', function() {
	gulp.src( paths.php )
		.pipe(browserSync.stream());
});

// Watch files
gulp.task('watch', function(event) {
	// browserSync.create();
	//gulp.watch(paths.php, ['reloadPHP']);
	gulp.watch(paths.scss, ['sass-dev']);
	gulp.watch(paths.scripts, ['concat-dev']);
	gulp.watch(paths.copyScripts, ['copyScripts']);
	gulp.watch(paths.images, ['optimizeImages']);
});

gulp.task('default', [ 'browser-sync', 'watch', 'sass-dev', 'concat-dev', 'copyScripts', 'vendorScripts', 'vendorStyles', 'optimizeImages' ]);
gulp.task('build', [ 'sass-build', 'concat-build', 'copyScripts-build', 'vendorScripts-build', 'vendorStyles-build', 'optimizeImages' ]);
