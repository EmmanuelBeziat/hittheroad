const mix = require('laravel-mix')

require('dotenv').config()

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your WordPlate applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JavaScript files.
 |
 */

const theme = process.env.WP_THEME

// Add near top of file
const ImageminPlugin = require('imagemin-webpack-plugin').default

mix.webpackConfig({
	plugins: [
		new ImageminPlugin({
			// disable: process.env.NODE_ENV !== 'production', // Disable during development
			pngquant: {
				quality: '90-100',
			},
			test: /\.(jpe?g|png|gif|svg)$/i,
		})
	],
})

mix.setResourceRoot('../')
mix.setPublicPath(`public/themes/${theme}/assets`)

mix.disableNotifications()
mix.js('resources/scripts/app.js', 'app.js').sourceMaps()
mix.sass('resources/styles/app.scss', 'app.css', []).sourceMaps()
mix.copy('resources/images', `public/themes/${theme}/assets/images`, false)
