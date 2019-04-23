/* jshint node:true */
module.exports = function( grunt ){
    'use strict';

    grunt.initConfig({
        // setting folder templates
        dirs: {
            css: 'assets/css',
            less: 'assets/css',
            js: 'assets/js'
        },

        // Compile all .less files.
        less: {
            compile: {
                options: {
                    // These paths are searched for @imports
                    paths: ['<%= less.css %>/']
                },
                files: [{
                    expand: true,
                    cwd: '<%= dirs.css %>/',
                    src: [
                        '*.less',
                        '!mixins.less'
                    ],
                    dest: '<%= dirs.css %>/',
                    ext: '.css'
                }]
            }
        },

        // Minify all .css files.
        cssmin: {
            minify: {
                expand: true,
                cwd: '<%= dirs.css %>/',
                src: ['*.css'],
                dest: '<%= dirs.css %>/',
                ext: '.css'
            }
        },

        // Minify .js files.
        uglify: {
            options: {
                preserveComments: 'some'
            },
            jsfiles: {
                files: [{
                    expand: true,
                    cwd: '<%= dirs.js %>/',
                    src: [
                        '*.js',
                        '!*.min.js',
                        '!Gruntfile.js',
                    ],
                    dest: '<%= dirs.js %>/',
                    ext: '.min.js'
                }]
            }
        },

        // Watch changes for assets
        watch: {
            less: {
                files: [
                    '<%= dirs.less %>/*.less',
                ],
                tasks: ['less', 'cssmin'],
            },
            js: {
                files: [
                    '<%= dirs.js %>/*js',
                    '!<%= dirs.js %>/*.min.js'
                ],
                tasks: ['uglify']
            }
        },

        pot: {
            options:{
                text_domain: 'inventory-plugin', //Your text domain. Produces my-text-domain.pot
                dest: 'languages/', //directory to place the pot file
                keywords: ['__', '_e', '_x'] //functions to look for
            },
            files:{
                src:  [ '**/*.php' ], //Parse all php files
                expand: true
            }
        }
    })

    // Load NPM tasks to be used here
    grunt.loadNpmTasks( 'grunt-contrib-less' );
    grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
    grunt.loadNpmTasks( 'grunt-contrib-uglify' );
    grunt.loadNpmTasks( 'grunt-contrib-watch' );
    grunt.loadNpmTasks( 'grunt-pot' ) ;

    // Register tasks
    grunt.registerTask( 'default', [
        'less',
        'cssmin',
        'uglify',
        'pot'
    ]);

};