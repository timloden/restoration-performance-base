const config = require('./gulp.config.js');

/**
 * Load Plugins.
 *
 * Load gulp plugins and passing them semantic names.
 */
const gulp = require('gulp'); // Gulp of-course.

// CSS related plugins.
const sass = require('gulp-sass'); // Gulp plugin for Sass compilation.
const minifycss = require('gulp-uglifycss'); // Minifies CSS files.
const autoprefixer = require('gulp-autoprefixer'); // Autoprefixing magic.
const mmq = require('gulp-merge-media-queries'); // Combine matching media queries into one.

// JS related plugins.
const concat = require('gulp-concat'); // Concatenates JS files.
const uglify = require('gulp-uglify'); // Minifies JS files.
const babel = require('gulp-babel'); // Compiles ESNext to browser compatible JS.

// Utility related plugins.
const rename = require('gulp-rename'); // Renames files E.g. style.css -> style.min.css.
const lineec = require('gulp-line-ending-corrector'); // Consistent Line Endings for non UNIX systems. Gulp Plugin for Line Ending Corrector (A utility that makes sure your files have consistent line endings).
const filter = require('gulp-filter'); // Enables you to work on a subset of the original files by filtering them using a glob.
const sourcemaps = require('gulp-sourcemaps'); // Maps code in a compressed file (E.g. style.css) back to it’s original position in a source file (E.g. structure.scss, which was later combined with other css files to generate style.css).
const browserSync = require('browser-sync').create(); // Reloads browser and injects CSS. Time-saving synchronized browser testing.
const plumber = require('gulp-plumber'); // Prevent pipe breaking caused by errors from gulp plugins.
const cache = require('gulp-cache'); // Cache files in stream for later use.
const remember = require('gulp-remember');

// Helper function to allow browser reload with Gulp 4.
const reload = (done) => {
    browserSync.reload();
    done();
};

function watch() {
    browserSync.init({
        proxy: config.projectURL,
        open: config.browserAutoOpen,
        injectChanges: config.injectChanges,
        watchEvents: ['change', 'add', 'unlink', 'addDir', 'unlinkDir'],
    });

    gulp.watch(config.watchPhp, reload); // Reload on PHP file changes.
    gulp.watch(config.watchStyles, gulp.parallel('styles')); // Reload on SCSS file changes.
    gulp.watch(config.watchJsVendor, gulp.series('vendorJS', reload)); // Reload on vendorsJS file changes.
    gulp.watch(config.watchJsCustom, gulp.series('customJS', reload)); // Reload on customJS file changes.
}

function styles() {
    return gulp
        .src(config.styleSRC, { allowEmpty: true })
        .pipe(sourcemaps.init())
        .pipe(
            sass({
                errLogToConsole: config.errLogToConsole,
                outputStyle: config.outputStyle,
                precision: config.precision,
            })
        )
        .on('error', sass.logError)
        .pipe(sourcemaps.write({ includeContent: false }))
        .pipe(sourcemaps.init({ loadMaps: true }))
        .pipe(autoprefixer(config.BROWSERS_LIST))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(config.styleDestination))
        .pipe(filter('**/*.css')) // Filtering stream to only css files.
        .pipe(mmq({ log: true })) // Merge Media Queries only for .min.css version.
        .pipe(browserSync.stream()) // Reloads style.css if that is enqueued.
        .pipe(rename({ suffix: '.min' }))
        .pipe(minifycss({ maxLineLen: 10 }))
        .pipe(gulp.dest(config.styleDestination))
        .pipe(filter('**/*.css')) // Filtering stream to only css files.
        .pipe(browserSync.stream()); // Reloads style.min.css if that is enqueued.
}

function customJS() {
    return gulp
        .src(config.jsCustomSRC, { since: gulp.lastRun('customJS') }) // Only run on changed files.
        .pipe(
            babel({
                presets: [
                    [
                        '@babel/preset-env', // Preset to compile your modern JS to ES5.
                        {
                            targets: { browsers: config.BROWSERS_LIST }, // Target browser list to support.
                        },
                    ],
                ],
            })
        )
        .pipe(remember(config.jsCustomSRC)) // Bring all files back to stream.
        .pipe(concat(config.jsCustomFile + '.js'))
        .pipe(lineec()) // Consistent Line Endings for non UNIX systems.
        .pipe(gulp.dest(config.jsCustomDestination))
        .pipe(
            rename({
                basename: config.jsCustomFile,
                suffix: '.min',
            })
        )
        .pipe(uglify())
        .pipe(lineec()) // Consistent Line Endings for non UNIX systems.
        .pipe(gulp.dest(config.jsCustomDestination));
}

function vendorJS() {
    return gulp
        .src(
            [
                'node_modules/bootstrap/dist/js/bootstrap.bundle.js',
                './node_modules/tiny-slider/dist/tiny-slider.js',
                config.jsVendorSRC,
            ],
            { since: gulp.lastRun('customJS') }
        ) // Only run on changed files.
        .pipe(
            babel({
                presets: [
                    [
                        '@babel/preset-env', // Preset to compile your modern JS to ES5.
                        {
                            targets: { browsers: config.BROWSERS_LIST }, // Target browser list to support.
                        },
                    ],
                ],
            })
        )
        .pipe(remember(config.jsVendorSRC)) // Bring all files back to stream.
        .pipe(concat(config.jsVendorFile + '.js'))
        .pipe(lineec()) // Consistent Line Endings for non UNIX systems.
        .pipe(gulp.dest(config.jsVendorDestination))
        .pipe(
            rename({
                basename: config.jsVendorFile,
                suffix: '.min',
            })
        )
        .pipe(uglify())
        .pipe(lineec()) // Consistent Line Endings for non UNIX systems.
        .pipe(gulp.dest(config.jsVendorDestination));
}

// Don't forget to expose the tasks!
exports.watch = watch;
exports.styles = styles;
exports.customJS = customJS;
exports.vendorJS = vendorJS;

/*
 * Specify if tasks run in series or parallel using `gulp.series` and `gulp.parallel`
 */
var build = gulp.parallel(styles, customJS, vendorJS, watch);

/*
 * You can still use `gulp.task` to expose tasks
 */
gulp.task('build', build);

/*
 * Define default task that can be called by just running `gulp` from cli
 */
gulp.task('default', build);
