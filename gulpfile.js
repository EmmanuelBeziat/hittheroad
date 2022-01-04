const { src, dest, series, parallel, watch } = require('gulp')
const clean = require('gulp-clean')
const sass = require('gulp-sass')(require('sass'))
const uglify = require('gulp-uglify')
const concat = require('gulp-concat')
const cssnano = require('cssnano')
const postcss = require('gulp-postcss')
const plumber = require('gulp-plumber')
const sourcemaps = require('gulp-sourcemaps')
const autoprefixer = require('autoprefixer')
const rename = require('gulp-rename')

const root = 'www/wp-content/themes/hittheroad-2021'
const destination = root + '/assets'

const cleanCSS = () => {
	return src(destination + '/css', { read: false, allowEmpty: true })
		.pipe(clean())
}
const cleanJS = () => {
	return src(destination + '/js', { read: false, allowEmpty: true })
		.pipe(clean())
}
const cleanImages = () => {
	return src(destination + '/images', { read: false, allowEmpty: true })
		.pipe(clean())
}

const cleanFonts = () => {
	return src(destination + '/fonts', { read: false, allowEmpty: true })
		.pipe(clean())
}

const images = () => {
	return src('./markup/images/**/*', { base: './markup/images' })
		.pipe(dest(destination + '/images'))
}

const fonts = () => {
	return src('./markup/fonts/**/*', { base: './markup/fonts' })
		.pipe(dest(destination + '/fonts'))
}

const scripts = () => {
	return src('./markup/scripts/app.js')
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(uglify())
		.pipe(sourcemaps.write('.'))
		.pipe(dest(destination + '/js'))
}

const scriptsVendors = () => {
	return src('./markup/scripts/vendors/*.js')
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(concat('vendors.js'))
		.pipe(uglify())
		.pipe(sourcemaps.write('.'))
		.pipe(dest(destination + '/js'))
}

const styles = () => {
	return src('./markup/styles/app.scss')
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
		.pipe(postcss([autoprefixer, cssnano]))
		.pipe(sourcemaps.write('.'))
		.pipe(dest(destination + '/css'))
}

const stylesMaintenance = () => {
	return src('./markup/styles/maintenance.scss')
		.pipe(plumber())
		.pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
		.pipe(postcss([autoprefixer, cssnano]))
		.pipe(dest(destination + '/css'))
}

const stylesEditor = () => {
	return src('./markup/styles/editor-style.scss')
		.pipe(plumber())
		.pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
		.pipe(postcss([autoprefixer, cssnano]))
		.pipe(dest(destination + '/css'))
}


const watchTasks = () => {
	watch('./markup/styles/**/*.scss', series(cleanCSS, styles))
	watch('./markup/styles/maintenance.scss', series(stylesMaintenance))
	watch('./markup/styles/editor-style.scss', series(stylesEditor))
	watch('./markup/scripts/app.js', series(scripts))
	watch('./markup/scripts/vendors/*.js', series(scriptsVendors))
}

module.exports = {
	clean: parallel(cleanCSS, cleanJS, cleanImages, cleanFonts),
	styles: series(styles),
	maintenance: series(stylesMaintenance),
	editor: series(stylesEditor),
	scripts: series(scripts),
	scriptsVendors: series(scriptsVendors),
	images: series(images),
	fonts: series(fonts),
	watch: watchTasks,
	default: parallel(series(cleanCSS, styles, stylesMaintenance, stylesEditor), series(cleanJS, scripts, scriptsVendors), series(cleanImages, images), series(cleanFonts, fonts))
}
