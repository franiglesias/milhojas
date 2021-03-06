// Gulp components
var gulp = require('gulp');
var cssnano = require('gulp-cssnano');
var sass = require('gulp-sass');
var rename = require('gulp-rename');
var newer = require('gulp-newer');
var babel = require('gulp-babel');
var uglify = require('gulp-uglify');
var sherpa = require('style-sherpa');
var jquery = require('gulp-jquery');
// Paths
var destination = '../../../web/assets';

// Sources
var sassSource = 'src/scss/**/*.scss';
var jsVendorSource = 'src/js/vendor';
var jsxSource = 'src/js/**/*.jsx';
var jsSource = ['src/js/**/*.js', '!src/js/foundation/*.js'];
var htmlSource = 'src/**/*.html';

var foundationSrc = [
    'node_modules/foundation-sites/dist/js/foundation.js',
    'node_modules/foundation-sites/vendor/jquery/dist/jquery.js'
];


var foundationSrc = [
    'node_modules/foundation-sites/dist/js/foundation.js',
    'node_modules/foundation-sites/vendor/jquery/dist/jquery.js'
];
// Tasks

gulp.task('default', [
    'sass',
    'compile-jsx',
    'scripts',
    'styleguide',
    'html',
    'watch'
]);

gulp.task('update', [
    'copy-react',
    'copy-react-dom',
    'copy-foundation',
    'default'
]);

gulp.task('watch', function () {
    gulp.watch(jsxSource, ['compile-jsx']);
    gulp.watch(jsSource, ['scripts']);
    gulp.watch(sassSource, ['sass']);
    gulp.watch([
        'src/style/index.md', 'src/style/template.hbs'
    ], ['styleguide']);
    gulp.watch(htmlSource, ['html']);
});

// SASS compile to CSS
gulp.task('sass', function () {
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

gulp.task('copy-react', function () {
    return gulp.src('node_modules/react/dist/react.js')
        .pipe(newer(jsVendorSource + '/react.js'))
        .pipe(gulp.dest(jsVendorSource));
});
gulp.task('copy-react-dom', function () {
    return gulp.src('node_modules/react-dom/dist/react-dom.js')
        .pipe(newer(jsVendorSource + '/react-dom.js'))
        .pipe(gulp.dest(jsVendorSource));
});


gulp.task('copy-foundation', function () {
    gulp.src(foundationSrc)
        .pipe(gulp.dest(jsVendorSource))
});


gulp.task('compile-jsx', () => {
    return gulp.src(jsxSource)
        .pipe(babel({
            presets: ['react']
        }))
        .pipe(rename({
            extname: '.js'
        }))
        .pipe(gulp.dest(destination + '/js'))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(uglify())
        .pipe(gulp.dest(destination + '/js'));
})
gulp.task('scripts', function () {
    gulp.src(jsSource)
        .pipe(gulp.dest(destination + '/js'))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(uglify())
        .pipe(gulp.dest(destination + '/js'));
});

gulp.task('styleguide', function () {
    sherpa('src/style/index.md', {
        output: 'src/style.html',
        template: 'src/style/template.hbs'
    });
});

gulp.task('html', function () {
    gulp.src(htmlSource)
        .pipe(gulp.dest(destination))
});
