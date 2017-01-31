// Gulp components
var gulp = require('gulp');
var cssnano = require('gulp-cssnano');
var sass = require('gulp-sass');
var rename = require('gulp-rename');
var newer = require('gulp-newer');
var babel = require('gulp-babel');
var uglify = require('gulp-uglify');
// Paths
var destination = '../../../web/assets';
var sassSource = 'src/scss/**/*.scss';

var jsVendorSource = 'src/js/vendor';
var jsxSource = 'src/js/**/*.jsx';

// Tasks

gulp.task('watch', function() {
    gulp.watch(jsxSource, ['copy-react', 'copy-react-dom', 'compile-jsx']);
    gulp.watch(sassSource, ['sass'])
});

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
});

// Javascript


gulp.task('copy-react', function() {
    return gulp.src('node_modules/react/dist/react.js')
        .pipe(newer(jsVendorSource + '/react.js'))
        .pipe(gulp.dest(jsVendorSource));
});
gulp.task('copy-react-dom', function() {
    return gulp.src('node_modules/react-dom/dist/react-dom.js')
        .pipe(newer(jsVendorSource + '/react-dom.js'))
        .pipe(gulp.dest(jsVendorSource));
});

gulp.task('copy-react-to-vendor', function() {
    return gulp.src([
            jsVendorSource + '/react.js',
            jsVendorSource + '/react-dom.js'
        ])
        .pipe(gulp.dest(destination + '/js/vendor'))

});

gulp.task('compile-jsx', () => {
    return gulp.src(jsxSource)
        .pipe(babel({
            presets: ['react']
        }))
        .pipe(rename({extname: '.js'}))
        .pipe(gulp.dest(destination + '/js'))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest(destination + '/js'))
        ;
});
