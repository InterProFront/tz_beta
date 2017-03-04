var gulp         = require('gulp'),

    autoprefixer = require('gulp-autoprefixer'),
    less         = require('gulp-less'),
    watch        = require('gulp-watch'),
    livereload   = require('gulp-livereload'),
    plumber      = require('gulp-plumber'),
    sourcemaps   = require('gulp-sourcemaps'),

    jslint       = require('gulp-jslint');

var dev_css  = 'dev/less/',
    prod_css = 'css';

var js = '/js';

gulp.task('style', function () {
    gulp.src(dev_css + '*.less')
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(less())
        .pipe(autoprefixer('last 20 version', 'safari 5', 'ie 8', 'ie9', 'opera 12.1', 'chrome', 'ff', 'ios'))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(prod_css))
        .pipe(livereload())
});


gulp.task('watch', function () {
    livereload.listen();
    gulp.watch(dev_css + '*.less', {cwd: './'}, ['style']);
    gulp.watch(dev_css + '**/*.less', {cwd: './'}, ['style']);
});

gulp.task('lint', function () {
    return gulp.src(js + '/*.js')
               .pipe(jslint())
               .pipe(jslint.reporter('my-reporter'));
});