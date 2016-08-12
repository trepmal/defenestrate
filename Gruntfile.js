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
            'src/js/prism.js',
            'src/js/functions.js'
          ]
        }
      }
    },
    cssmin: {
      options: {
        report: 'gzip',
        root: '../../../'
      },
      minify: {
        expand: true,
        cwd: 'src/css',
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
    },
    compress: {
      main: {
        options: {
          mode: 'gzip'
        },
        files: [
          // Each of the files in the src/ folder will be output to
          // the dist/ folder each with the extension .gz.js
          {
            expand: true,
            cwd: 'css/',
            src: ['defenestrate.min.css'],
            dest: 'css/',
            ext: '.min.css.gz'
          },
          {
            expand: true,
            cwd: 'js/',
            src: ['defenestrate.min.js'],
            dest: 'js/',
            ext: '.min.js.gz'
          }
        ]
      }
    }
  });

  require('load-grunt-tasks')(grunt);

// grunt.loadNpmTasks('grunt-contrib-uglify');
// grunt.loadNpmTasks('grunt-contrib-cssmin');
// grunt.loadNpmTasks('grunt-contrib-cssmin');

  // Default task(s).
  grunt.registerTask('default', ['uglify', 'cssmin', 'compress']);

};