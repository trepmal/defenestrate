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
            'src_js/prism.js',
            'src_js/functions.js'
          ]
        }
      }
    },
    cssmin: {
      options: {
        report: 'gzip'
      },
      minify: {
        expand: true,
        cwd: 'src_css',
        src: [
          '*.css'
        ],
        dest: 'dest/',
        ext: '.min.css'
      },
      combine: {
        files: {
          'css/defenestrate.min.css': [
            'dest/*.min.css'
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