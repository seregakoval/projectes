var gulp        =  require('gulp');
var sass        = require('gulp-sass');
var browserSync = require('browser-sync');
var concat      = require('gulp-concat');
var uglify      = require('gulp-uglifyjs');
var cssnano     = require('gulp-cssnano');
var rename      = require('gulp-rename');
var del         = require('del');

gulp.task('sass', function(){
    return gulp.src('app/sass/**/*.scss')
    .pipe(sass())
    .pipe(gulp.dest('app/css'))
    .pipe(browserSync.reload({stream: true}))
});
gulp.task('scripts', function(){
    return gulp.src([
        'app/libs/main_js.js'
    ])
    .pipe(concat('main_js.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('app/js'));
});
gulp.task('css-libs', ['sass'], function() {
     return gulp.src('app/css/style.css')
     .pipe(cssnano())
     .pipe(rename({suffix: '.min'}))
     .pipe(gulp.dest('app/css'));
});
gulp.task('browser-sync', function() {
    browserSync({
        server: {
            daseDir: 'app'
        },
        notify: false,
    });
});
gulp.task("clean", function(){
    return del.sync('dist');
});
gulp.task('watch', ['browser-sync', 'css-libs','scripts'], function() {
    gulp.watch('app/sass/**/*.scss', ['sass']);
    gulp.watch('app/*.html', browserSync.reload);
    gulp.watch('app/js/**/*.js', browserSync.reload);
});
gulp.task('build', ['clean', 'sass', 'scripts'], function() {
    var buildcss = gulp.src([
        'app/css/style.min.css'
    ])
    .pipe(gulp.dest('dist/css'));
    var buildFonts = gulp.src('app/fonts/**/*')
    .pipe(gulp.dest('dist/fonts'));
    var buildjs = gulp.src('app/js/**/*')
    .pipe(gulp.dest('dist/js'));
    /*var buildHtml = gulp.src('*.html')
    .pipe(gulp.dest('dist'));*/
});
