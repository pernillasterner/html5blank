'use strict';

var gulp = require('gulp'),
  sass = require('gulp-sass'),
  minify = require('gulp-minify'),
  sourcemaps = require('gulp-sourcemaps'),
  autoprefixer = require('gulp-autoprefixer'),
  browserSync = require('browser-sync').create();

// Static Server + watching scss/php files
gulp.task('serve', ['sass'], function() {
  browserSync.init({
    proxy: 'https://berattarministeriet.asd',
    notify: false,
    online: true
  });

  gulp.watch('./assets/sass/**/*.scss', ['sass']);
  gulp.watch(['./**/*.php', './js/*.js']).on('change', browserSync.reload);
});

// Compile sass into CSS & auto-inject into browsers
gulp.task('sass', function() {
  gulp.src(['./assets/sass/main.scss', './assets/sass/lib/*.scss'])
    .pipe(sourcemaps.init())
    .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./assets/css'))
    .pipe(browserSync.stream());
});

gulp.task('sass:watch', function() {
  gulp.watch('./assets/sass/**/*.scss', ['sass']);
});

gulp.task('default', ['sass']);
gulp.task('watch', ['sass', 'sass:watch']);
