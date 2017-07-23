'use strict';

// General
var gulp 		= require('gulp');

// CSS
var sass 		= require('gulp-sass');
var autopre   	= require('gulp-autoprefixer');
var minifycss  	= require('gulp-minify-css');
var rename = require('gulp-rename');
var sassDir = './assets/scss';
var cssDir = './public/css';


var sassConfig = {
    outputStyle: 'expanded',
    errLogToConsole: true
};

// Styles
gulp.task('styles', function () {
    console.log(sassDir);
    return gulp.src(sassDir + '/*.scss')
        .pipe(sass(sassConfig).on('error', sass.logError))
        .pipe(autopre('> 1%', 'last 3 version'))
        .pipe(minifycss())
        .pipe(rename('main.min.css'))
        .pipe(gulp.dest(cssDir));
});

//gulp.task('default', ['styles']);

gulp.task('default', ['styles'], function () {
  gulp.start('styles', function(err) {
	});
});

gulp.task('watch', ['styles'], function () {
  gulp.watch('./assets/scss/*.scss', ['styles']);
});
