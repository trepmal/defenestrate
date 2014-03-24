module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
      },
      my_target: {
        files: {
          'js/defenestrate.min.js': [
          	'src_js/functions.js'
          ]
        }
      }
    },
    // concat: {
    //   css: {
    //     src: [
    //         'fonts/sourcesanspro/sourcesanspro.css',
    //         'fonts/anticslab.css',
    //         'fonts/genericons/genericons.css',
    //         'style.css'
    //     ],
    //     dest: 'defenestrate.css'
    //   }
    // },

    // concat: {
    //   all: {
    //     src: [
    //       'css/sourcesanspro.css',
    //       'css/anticslab.css',
    //       'css/genericons.css'
    //     ],
    //     dest: 'css/fonts.css'
    //   }
    // },
    cssmin: {
      minify: {
        expand: true,
        cwd: 'src_css',
        src: [
          // 'fonts/sourcesanspro/sourcesanspro.css',
          '*.css'
        ],
        dest: 'dest/',
        ext: '.min.css'
      },
      combine: {
        files: {
          'css/defenestrate.min.css': [
            'dest/*.min.css'
            // 'css/style.min.css'
          ]
        }
      }
    }
  });

  require('load-grunt-tasks')(grunt);

// grunt.loadNpmTasks('grunt-contrib-uglify');
// grunt.loadNpmTasks('grunt-contrib-cssmin');
// grunt.loadNpmTasks('grunt-contrib-cssmin');

  // Default task(s).
  grunt.registerTask('default', ['uglify', 'cssmin']);

};