module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        concat: {
            options: {
                separator: ';\n'
            },
            vendor: {
                src: [
                    'bower_components/jquery/dist/jquery.min.js',
                    'bower_components/events/src/*.js',
                ],
                dest: 'public/js/vendor.js'
            },
            dist: {
                src: 'js/**/*.js',
                dest: 'public/js/cram.js'
            },
            css: {
                src: 'css/**/*.css',
                dest: 'public/css/style.css'
            }
        },
        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n',
                mangle: true
            },
            dist: {
                files: {
                    '<%= concat.dist.dest %>': ['<%= concat.dist.dest %>']
                }
            }
        },
        less: {
            development: {
                files: {
                    "css/vendor/bootstrap.css": "bower_components/bootstrap/less/bootstrap.less"
                }
            }
        },
        watch: {
            files: ['<%= concat.vendor.src %>', '<%= concat.dist.src %>'],
            tasks: ['concat', 'uglify']
        }
    });

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-less');

    grunt.registerTask('default', ['less', 'concat', 'uglify', 'watch']);

};