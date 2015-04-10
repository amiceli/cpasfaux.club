module.exports = function(grunt) {

    grunt.initConfig({
        //  LESS file compilation
        //  This instruction is launched with grunt watch
        less: {
            desktop: {
                options: {
                    paths: ["stylesheet"]
                },
                files: {
                    "public/css/styles.css": "public/less/style.less"
                }
            }
        },

        cssmin: {
            desktop: {
                files: {
                    'public/css/styles.min.css': ['public/css/styles.css']
                }
            }
        },

        // Watch less file changes for compile
        watch: {
            stylesheet: {
                files: ['public/less/**/*.less'],
                tasks: ['less', 'cssmin', 'autoprefixer']
            },
            js: {
                files: ['public/js/**/*.js'],
                tasks: ['uglify']
            }
        },

        autoprefixer: {
            desktop: {
              src: 'public/css/styles.min.css'
            }
        },

        uglify: {
            my_target: {
                files: {
                    'public/js/slider.min.js': ['public/js/slider.js'],
                    'public/js/jukeboxes.min.js': ['public/js/jukeboxes.js'],
                    'public/js/citations.min.js': ['public/js/citations.js']
                }
            }
        },

        

    });

    grunt.registerTask('prod', ['less', 'cssmin', 'autoprefixer', 'uglify']);

    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-bower-clean');

}
