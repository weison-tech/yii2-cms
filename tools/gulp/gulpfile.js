var gulp = require('gulp');
var uglify = require('gulp-uglify');
var cssMin = require('gulp-css');


// Need because of `yii console`
var rename = require('gulp-rename');
var minimist = require('minimist');
var options = minimist(process.argv.slice(2), { string: 'src', string: 'dist' });
var destDir = options.dist.substring(0, options.dist.lastIndexOf("/")); 
var destFile = options.dist.replace(/^.*[\\\/]/, '');


// Use `compress-js` task for JavaScript files 
gulp.task('compress-js', function() {
  gulp.src(options.src)
    .pipe(uglify())
	.pipe(rename(destFile))
    .pipe(gulp.dest(destDir))
});

// Use `compress-css` task for CSS files
gulp.task('compress-css', function() {
  gulp.src(options.src)
    .pipe(cssMin())
	.pipe(rename(destFile))
    .pipe(gulp.dest(destDir))
});