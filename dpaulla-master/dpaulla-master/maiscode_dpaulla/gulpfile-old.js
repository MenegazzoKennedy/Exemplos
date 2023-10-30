var gulp		= require('gulp'),
	minifycss	= require('gulp-minify-css'),
	uglify		= require('gulp-uglify'),
	imagemin	= require('gulp-imagemin'),
	rename		= require('gulp-rename'),
	concat		= require('gulp-concat'),
	notify		= require('gulp-notify'),
	concatCss	= require('gulp-concat-css'),
	size		= require('gulp-size'),
	watch		= require('gulp-watch');

// Task for minify and concatenate js files
gulp.task('scripts', function(){
	return 	gulp.src(['js/jquery-3.4.1.js', 'js/popper.js', 'js/bootstrap.js', 'slick/slick.js', 'js/main.js'])
	.pipe(concat('concat.js'))
	.pipe(gulp.dest('js/'))
	.pipe(uglify())
	.pipe(rename({suffix: '.min'}))
	.pipe(size())
	.pipe(gulp.dest('js/'))
	.pipe(notify({message: 'Concatenation and Minification SCRIPTS task completed!!!'}))
});

// Task for minify and concatenate css files
gulp.task('styles', function(){
	return gulp.src(['css/bootstrap.css', 'slick/slick-theme.css', 'slick/slick.css', 'css/stylesheet.css', 'style.css'])
	.pipe(concatCss('stylesheet.concat.css'))
	.pipe(gulp.dest('css/'))
	.pipe(minifycss('style'))
	.pipe(rename({suffix: '.min'}))
	.pipe(size())
	.pipe(gulp.dest('css/'))
	.pipe(notify({message: 'CSS Styles task completed!!!'}));
});

// Task for image compression
gulp.task('images', function(){
	return gulp.src(['img/*'])
	.pipe(imagemin())
	.pipe(size())
	.pipe(gulp.dest('img/'))
	.pipe(notify({message: 'Image task compression completed!'}));
});

// Task for watching
gulp.task('watch', function(){	
	// Watch styles
	gulp.watch('css/stylesheet.css', gulp.series('styles'));
	// Watch scripts
	gulp.watch('js/main.js', gulp.series('scripts'));
});