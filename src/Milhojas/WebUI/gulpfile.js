// Gulp components
var gulp = require('gulp');
var cssnano = require('gulp-cssnano');
var sass = require('gulp-sass');
var rename = require('gulp-rename');

// Paths
var destination = '../../../web/assets';
var sassSource = 'src/scss/**/*.scss';

// Tasks

// SASS compile to CSS
gulp.task('sass', function() {
    gulp.src(sassSource)
        .pipe(sass({
            style: 'expanded'
        }))
        .pipe(gulp.dest(destination + '/css'))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(cssnano())
        .pipe(gulp.dest(destination + '/css'))
})
