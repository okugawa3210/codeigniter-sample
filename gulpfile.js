var gulp = require('gulp');
var mainBowerFiles = require('main-bower-files');
var $ = require('gulp-load-plugins')();

gulp.task('vendor', function() {
  'use strict';
  // js
  gulp
    .src(mainBowerFiles({
      filter: '**/*.js'
    }))
    .pipe($.concat('vendor.min.js'))
    .pipe($.uglify({
      preserveComments: 'some'
    }))
    .pipe(gulp.dest('public/assets/javascripts'));
  // css
  gulp
    .src(mainBowerFiles({
      filter: '**/*.{less,css,scss}'
    }))
    .pipe($.if('*.less', $.less()))
    .pipe($.if('*.scss', $.sass()))
    .pipe($.concat('vendor.min.css'))
    .pipe($.minifyCss())
    .pipe(gulp.dest('public/assets/stylesheets'));
  // font
  gulp
    .src(mainBowerFiles({
      filter: '**/*.{eot,svg,ttf,woff,woff2}'
    }))
    .pipe(gulp.dest('public/assets/fonts'));
  gulp
    .src([
      'bower_components/bootstrap/dist/fonts/*',
      'bower_components/font-awesome/fonts/*'
    ])
    .pipe(gulp.dest('public/assets/fonts'));
});

gulp.task('style', function() {
  'use strict';
  gulp
    .src('src/stylesheets/*.{less,css,scss}')
    .pipe($.plumber())
    .pipe($.if('*.less', $.less()))
    .pipe($.if('*.scss', $.compass({
      config_file: 'config.rb',
      css: 'dest/stylesheets/',
      sass: 'src/stylesheets/'
    })))
    // .pipe($.concat('application.min.css'))
    .pipe($.minifyCss())
    .pipe($.rename({
      extname: '.min.css'
    }))
    .pipe(gulp.dest('public/assets/stylesheets'));
});

gulp.task('script', function() {
  'use strict';
  gulp
    .src('src/javascripts/**/*.js')
    .pipe($.plumber())
    .pipe($.babel())
    // .pipe($.concat('application.min.js'))
    .pipe($.uglify({
      preserveComments: 'some'
    }))
    .pipe($.rename({
      extname: '.min.js'
    }))
    .pipe(gulp.dest('public/assets/javascripts'));
});

gulp.task('watch', ['init'], function() {
  'use strict';
  gulp.watch('src/**/*', ['style', 'script']);
});

gulp.task('init', ['vendor', 'style', 'script']);

gulp.task('default', ['watch']);
