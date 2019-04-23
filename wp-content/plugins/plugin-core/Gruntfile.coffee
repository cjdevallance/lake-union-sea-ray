module.exports = (grunt) ->

    # Initialize configuration - Define tasks
    grunt.initConfig

        pkg: grunt.file.readJSON 'package.json'
        config:
            banner: "/* <%= pkg.name %> - <%= grunt.template.today('yyyy-mm-dd') %> */"

        pot:
            options:
                text_domain: 'plugin-core'
                dest: 'languages/'
                keywords: ['__', '_e', '_x']

            files:
                src: ['**/*.php'],
                expand: true

    # Define dependencies

    grunt.loadNpmTasks 'grunt-pot';

    # Build project
    grunt.registerTask 'default', [
        'pot'
    ]
