module.exports = grunt => {
	require('load-grunt-tasks')(grunt)
	const pathConfig = require('./grunt-settings.js')
	const sass = require('sass')
	const postcssImport = require('postcss-import')
	const { default: postcssNested } = require('postcss-nested') // ESM-only package
	const cssnano = require('cssnano')

	const styleEntries = {
		expand: true,
		cwd: '<%= config.src.styles %>',
		src: ['app.css', 'maintenance.css', 'editor-style.css', 'login-style.css'],
		dest: '<%= config.dist.styles %>'
	}

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		config: pathConfig,

		clean: {
			options: { force: true },
			temp: {
				src: ['<%= config.dist.styles %>', '<%= config.dist.scripts %>', '<%= config.dist.images %>', '<%= config.dist.fonts %>']
			}
		},

		// Only Bootstrap is still written in Sass, compiled then imported by app.css
		sass: {
			bootstrap: {
				options: {
					implementation: sass,
					loadPaths: ['node_modules'],
					quietDeps: true,
					silenceDeprecations: ['import'],
					sourceMap: false,
					style: 'expanded'
				},
				files: {
					'.tmp/bootstrap.css': '<%= config.src.styles %>vendors/custom-bootstrap.scss'
				}
			}
		},

		postcss: {
			dev: {
				options: {
					map: true,
					processors: [postcssImport(), postcssNested()]
				},
				files: [styleEntries]
			},
			prod: {
				options: {
					map: false,
					processors: [postcssImport(), postcssNested(), cssnano()]
				},
				files: [styleEntries]
			}
		},

		concat: {
			options: {
				separator: ';',
			},
			vendors: {
				src: ['<%= config.src.scripts %>vendors/*.js', '!<%= config.src.scripts %>vendors/maplibre-gl.js'],
				dest: '<%= config.dist.scripts %>vendors.js'
			},
			classes: {
				src: ['<%= config.src.scripts %>classes/*.js', '!<%= config.src.scripts %>classes/maplibre.js'],
				dest: '<%= config.dist.scripts %>classes.js'
			},
			app: {
				src: ['<%= config.src.scripts %>app.js'],
				dest: '<%= config.dist.scripts %>app.js'
			}
		},

		uglify: {
			options: {
			},
			vendors: {
				src: ['<%= config.src.scripts %>vendors/*.js', '!<%= config.src.scripts %>vendors/maplibre-gl.js'],
				dest: '<%= config.dist.scripts %>vendors.js'
			},
			classes: {
				src: ['<%= config.src.scripts %>classes/*.js', '!<%= config.src.scripts %>classes/maplibre.js'],
				dest: '<%= config.dist.scripts %>classes.js'
			},
			app: {
				src: ['<%= config.src.scripts %>app.js'],
				dest: '<%= config.dist.scripts %>app.js'
			}
		},

		copy: {
			images: {
				expand: true,
				cwd: '<%= config.src.images %>',
				src: '**',
				dest: '<%= config.dist.images %>',
				//flatten: true,
				filter: 'isFile',
			},
			fonts: {
				expand: true,
				cwd: '<%= config.src.fonts %>',
				src: '**',
				dest: '<%= config.dist.fonts %>',
				//flatten: true,
				filter: 'isFile',
			}
		},

		watch: {
			configFiles: {
				files: [ 'Gruntfile.js', 'grunt-settings.js' ],
				options: {
					reload: true
				}
			},
			options: {
				debounceDelay: 1,
			},
			/* notify: {
				options: {
					enabled: true,
					max_js_hint_notifications: 5,
					title: 'HtR'
				},
				watch: {
					options: {
						title: 'Task complete',
						message: 'SASS finished running'
					}
				}
			}, */
			styles: {
				files: ['<%= config.src.styles %>**/*.css'],
				tasks: ['postcss:dev'],
			},
			bootstrap: {
				files: ['<%= config.src.styles %>vendors/custom-bootstrap.scss'],
				tasks: ['sass:bootstrap', 'postcss:dev'],
			},
			images: {
				files: ['<%= config.src.images %>**/*.{png,jpg,jpeg,gif,svg,webp}'],
				tasks: ['newer:copy:images'],
				options: {
					spawn: false
				}
			},
			scripts: {
				files: ['<%= config.src.scripts %>*.js'],
				tasks: ['concat:app'],
			},
			scriptsVendors: {
				files: ['<%= config.src.scripts %>vendors/*.js'],
				tasks: ['concat:vendors'],
			},
			scriptsClasses: {
				files: ['<%= config.src.scripts %>classes/*.js'],
				tasks: ['concat:classes'],
			}
		}
	})

	grunt.registerTask('default', ['build'])
	grunt.registerTask('dev:full', ['sass:bootstrap', 'postcss:dev', 'concat:vendors', 'concat:classes', 'concat:app', 'copy:images', 'copy:fonts', 'watch'])
	grunt.registerTask('dev:quick', ['sass:bootstrap', 'watch'])
	grunt.registerTask('build', ['sass:bootstrap', 'postcss:prod', 'uglify:vendors', 'uglify:classes', 'uglify:app', 'copy:images', 'copy:fonts'])
	grunt.registerTask('build:styles', ['sass:bootstrap', 'postcss:prod'])
	grunt.registerTask('build:scripts', ['uglify:vendors', 'uglify:classes', 'uglify:app'])
}
