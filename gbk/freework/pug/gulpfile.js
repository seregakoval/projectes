var gulp        =  require('gulp');
var sass        = require('gulp-sass');
var postcss     = require('gulp-postcss');
var concat      = require('gulp-concat');
var browserSync = require('browser-sync');
var uglify      = require('gulp-uglifyjs');
var cssnano     = require('gulp-cssnano');
var rename      = require('gulp-rename');
var del         = require('del');
var plumber     = require('gulp-plumber');
var notify      = require('gulp-notify');
var pug         = require('gulp-pug');
var reload      = require('gulp-reload');
var autoprefixer = require('gulp-autoprefixer');
var rigger      = require('gulp-rigger');


gulp.task('build-file', function () {
    gulp.src('js/*.js')
        .pipe(rigger())
        .pipe(gulp.dest('js/dist/'));
});
gulp.task('html', function () {
    return gulp.src('pug/*.pug')
        .pipe(plumber({errorHandler:
            notify.onError(function (err) {
                return {
                    title: 'pug',
                    message: err.message
                };
            })
        }))
        .pipe(pug({
            pretty: true
        }))
        .pipe(gulp.dest('./'))
        .pipe(reload({stream: true}));


});

gulp.task('sass', function(){
    return gulp.src('sass/**/*.scss')
        .pipe(plumber({errorHandler:
            notify.onError(function (err) {
                return {
                    title: 'sass',
                    message: err.message
                };
            })
        }))
    .pipe(autoprefixer({
        browsers: ['last 2 versions', '> 5%', 'Firefox ESR']
    }))
    .pipe(sass())
    .pipe(gulp.dest('css'))
    .pipe(browserSync.reload({stream: true}))
});
// gulp.task('scripts', function(){
//     return gulp.src([
//         'vendor/bower/jquery/dist/jquery.min.js',
//         'vendor/bower/bootstrap/dist/js/bootstrap.min.js',
//         'js/libs/*.js'
//     ])
//     // return gulp.src([
//     //     'js/libs/*.js'
//     // ])
//     .pipe(concat('main_js.min.js'))
//     // .pipe(uglify())
//     .pipe(gulp.dest('js/dist/'));
// });
gulp.task('css-libs', ['sass'], function() {
     return gulp.src('css/main.css')
     .pipe(cssnano())
     .pipe(rename({suffix: '.min'}))
     .pipe(gulp.dest('css'));
});
gulp.task('browser-sync', function() {
    browserSync({
        server: {
            daseDir: ''
        },
        notify: false,
    });
});
gulp.task("clean", function(){
    return del.sync('dist');
});
gulp.task('watch', function() {
    gulp.watch('pug/**/*.pug', ['html'], browserSync.reload);
    gulp.watch('sass/**/*.scss', ['sass']);
    gulp.watch('css/main.css', ['css-libs']);
    gulp.watch('js/*.js', ['build-file']);
    // gulp.watch('js/libs/*.js', ['scripts']);
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
