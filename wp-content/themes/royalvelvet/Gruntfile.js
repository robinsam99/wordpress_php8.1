// Configuring Grunt tasks:
// http://gruntjs.com/configuring-tasks

module.exports = function (grunt) {

    grunt.initConfig({
      pkg: grunt.file.readJSON('package.json'),

      // Tasks

      // grunt-contrib-sass
      // requires you to have Ruby and Sass but is more stable
      sass: {
        dist: {
          options: {
            style: 'compressed',
            loadPath: 'scss/*.scss',
            lineNumbers: false,
            //sourcemap: true,
            quiet: true,
          },
          files: { // Dictionary of files
            'css/main.css': 'scss/*.scss', // 'destination': 'source'
            // 'css/additional.css': 'additional.scss' // if needed
          },
        },
      },

      // grunt-contrib-concat
      // Concatenates JS files in order
      concat: {
        options: {
          separator: ';',
        },
        dist: {
          src: ['js/vendor/modernizr-2.6.2.min.js', 'js/plugins.js', 'js/main.js'],
          dest: 'js/built.js',
        },
      },

      // grunt-contrib-uglify
      // Minifies js files
      uglify: {
        options: {
          mangle: false
        },
        dist: {
          files: {
            'js/built.min.js': ['js/built.js'],
          }
        },
      },

      watch: {

        html: {
          files: [
            '*.html',
          ],
          options: {
            livereload: true,
          },
        },

        php: {
          files: [
            '*.php',
          ],
          options: {
            livereload: true,
          },
        },

        sass: {
          files: [
            '**/*.scss',
          ],
          tasks: ['sass'],
        },

        css: {
          files: [
            'css/*.css',
          ],

          options: {
            livereload: true, // reload the css not the sass changes
          },
        },

        scripts: {
          files: [
            'js/*.js',
          ],
          options: {
            livereload: true,
            spawn: false,
          },
          tasks: ['concat', 'uglify'],
        },

        images: {
          files: [
            'images/{,**/}*.{png,jpg,jpeg,gif,webp,svg}'
          ],
          options: {
            livereload: true,
          },
        },
      },

      browserSync: {
          bsFiles: {
              src: [
                  'css/main.css',
                  'js/main.js',
                  '*.php'
              ]
          },
          options: {
              watchTask: true,
              proxy: 'royalvelvet.dev'
          }
      }
  });

  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-browser-sync');
  grunt.loadNpmTasks('grunt-php');

  grunt.registerTask('default', ['browserSync', 'watch', 'php', 'sass']);
};
