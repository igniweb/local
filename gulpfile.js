var gulp   = require('gulp');
var rename = require('gulp-rename');
var size   = require('gulp-size');
var uglify = require('gulp-uglify');

gulp.task('webix', function() {
    return gulp.src('public/vendor/webix/codebase/webix_debug.js')
        .pipe(uglify())
        .pipe(rename('webix.min.js'))
        .pipe(gulp.dest('public/dist'));
});

gulp.task('size', ['webix'], function() {
    return gulp.src('public/dist/*')
        .pipe(size());
});

gulp.task('default', ['size']);
