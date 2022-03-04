module.exports = grunt => {
	require('load-grunt-tasks')(grunt)
	const pathConfig = require('./grunt-settings.js')
	const sass = require('node-sass')

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		config: pathConfig,

		clean: {
			options: { force: true },
			temp: {
				src: ['<%= config.dist.styles %>', '<%= config.dist.scripts %>', '<%= config.dist.images %>', '<%= config.dist.fonts %>']
			}
		},

		sass: {
			dev: {
				options: {
					implementation: sass,
					sourceMap: true,
				},
				files: [
					{
						expand: true,
						cwd: '<%= config.src.styles %>',
						src: ['app.scss'],
						dest: '<%= config.dist.styles %>',
						ext: '.css'
					},
				]
			},
			prod: {
				options: {
					implementation: sass,
					sourceMap: false,
					outputStyle: 'compressed'
				},
				files: [
					{
						src: ['<%= config.src.styles %>app.scss'],
						dest: '<%= config.dist.styles %>app.css'
					},
					{
						src: ['<%= config.src.styles %>maintenance.scss'],
						dest: '<%= config.dist.styles %>maintenance.css'
					},
					{
						src: ['<%= config.src.styles %>editor-style.scss'],
						dest: '<%= config.dist.styles %>editor-style.css'
					}
				]
			}
		},

		concat: {
			options: {
				separator: ';',
			},
			vendors: {
				src: ['<%= config.src.scripts %>vendors/*.js'],
				dest: '<%= config.dist.scripts %>vendors.js'
			},
			classes: {
				src: ['<%= config.src.scripts %>classes/*.js'],
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
				src: ['<%= config.src.scripts %>vendors/*.js'],
				dest: '<%= config.dist.scripts %>vendors.js'
			},
			classes: {
				src: ['<%= config.src.scripts %>classes/*.js'],
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
				files: ['<%= config.src.styles %>**/*.scss'],
				tasks: ['sass:dev'],
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
	grunt.registerTask('dev:full', ['sass:dev', 'concat:vendors', 'concat:classes', 'concat:app', 'copy:images', 'copy:fonts', 'watch'])
	grunt.registerTask('dev:quick', ['watch'])
	grunt.registerTask('build', ['sass:prod', 'uglify:vendors', 'uglify:classes', 'uglify:app', 'copy:images', 'copy:fonts'])
	grunt.registerTask('build:styles', ['sass:prod'])
	grunt.registerTask('build:scripts', ['uglify:vendors', 'uglify:classes', 'uglify:app'])
}
