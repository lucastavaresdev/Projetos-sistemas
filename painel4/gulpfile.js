var gulp = require('gulp')
    , sass = require('gulp-sass')
    , include = require('gulp-file-include')
    , clean = require('gulp-clean')
    , autoprefixer = require('gulp-autoprefixer')
    , imagemin = require('gulp-imagemin')
    , cssnano= require('gulp-cssnano')
    , uglify = require('gulp-uglify')
    , concat = require('gulp-concat')
    , rename = require('gulp-rename')
    , browserSync = require('browser-sync')


gulp.task('clean', function(){
        return gulp.src('dist')
            .pipe(clean());
})



gulp.task('copy', ['clean'], function () {
    gulp.src([
        'src/componentes/**/*',
        'src/js/**/*',
        'src/*.php',
        'src/css/**/*',
        'src/img/**/*',
        'src/php/**/*',
        'src/**/*.html',
        'src/templates/*',
    ], { "base": "src" })//o base mantem a estrutura
        .pipe(gulp.dest('dist'))
})




gulp.task('html', function(){
    return gulp.src([
            './src/**/*.html',
            './src/**/*.php',
        ])
        .pipe(include())
        .pipe(gulp.dest('./dist/'))
})



gulp.task('default', ['copy'], function(){
    gulp.start('html')
    // gulp.start('html' ,'imagemin', 'sass', 'build-js')
})



gulp.task('serve',['copy'], function () {
    browserSync.init({
        server: {
            baseDir: 'dist'
        }
});

    gulp.watch('./dist/**/*').on('change', browserSync.reload)

    //monitora alteração caso sera alteradao reload o browser
 gulp.watch('./src/css/**/*.css', ['default'])
    gulp.watch('./src/**/*.html', ['default'])
    gulp.watch('./src/**/*.php', ['default'])
    gulp.watch('./src/js/**/*', ['default'])
})


