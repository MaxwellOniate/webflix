const gulp = require('gulp');
const php = require('gulp-connect-php');
const browserSync = require('browser-sync').create();
const sass = require('gulp-sass');
const reload = browserSync.reload;

// Move the javascript files into our src/js folder.
gulp.task('js', function() {
  return gulp
    .src([
      'node_modules/bootstrap/dist/js/bootstrap.min.js',
      'node_modules/jquery/dist/jquery.min.js',
      'node_modules/popper.js/dist/umd/popper.min.js'
    ])
    .pipe(gulp.dest('dist/assets/js'))
    .pipe(browserSync.stream());
});

// Compile sass into CSS & auto-inject into browsers
gulp.task('sass', function() {
  return gulp
    .src(['node_modules/bootstrap/scss/bootstrap.scss', 'src/scss/*.scss'])
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('dist/assets/css'))
    .pipe(browserSync.stream());
});

// Server Configuration
gulp.task('php', async function() {
  php.server({
    base: './',
    port: 80,
    keepalive: true
  });
});

gulp.task(
  'browserSync',
  gulp.series(['php'], async function() {
    browserSync.init({
      proxy: 'localhost/webflix/dist/',
      baseDir: './',
      open: true,
      notify: false
    });
  })
);

const watchPHP = 'dist/**/*.php';
const watchSCSS = 'src/scss/*.scss';

// Watch all .php and .scss files
gulp.task(
  'dev',
  gulp.series(['browserSync'], function() {
    gulp
      .watch([watchPHP, watchSCSS])
      .on('change', gulp.series(['sass'], reload));
  })
);
