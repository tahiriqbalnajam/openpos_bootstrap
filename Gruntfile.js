module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    concat: {
      options: {
        separator: ';'
      },
      dist: {
        src: ['js/jquery*', 'js/*.js'],
        dest: 'dist/<%= pkg.name %>.js'
      }
    },
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
      },
      dist: {
        files: {
          'dist/<%= pkg.name %>.min.js': ['<%= concat.dist.dest %>']
        }
      }
    },
    jshint: {
      files: ['Gruntfile.js', 'js/*.js'],
      options: {
        // options here to override JSHint defaults
        globals: {
          jQuery: true,
          console: true,
          module: true,
          document: true
        }
      }
    },
    tags: {
      js : {
            options: {
                scriptTemplate: '<script type="text/javascript" src="{{ path }}" language="javascript"></script>',
                openTag: '<!-- start js template tags -->',
                closeTag: '<!-- end js template tags -->',
                absolutePath: true
            },
            src: [
                'js/jquery*.js', 'js/*.js',
            ],
            dest: 'application/views/partial/header.php'
       },
       minjs : {
           options: {
               scriptTemplate: '<script type="text/javascript" src="{{ path }}" language="javascript"></script>',
               openTag: '<!-- start minjs template tags -->',
               closeTag: '<!-- end minjs template tags -->',
               absolutePath: true
           },
           src: [
               'dist/*min.js',
           ],
           dest: 'application/views/partial/header.php'
      }
    },
    mochaWebdriver: {
        options: {
            timeout: 1000 * 60 * 3
        },
    	test : {
    		options: {
    			usePhantom: true,
                usePromises: true
    		},
    		src: ['test/**/*.js']
    	}
    },
    watch: {
      files: ['<%= jshint.files %>'],
      tasks: ['jshint']
    },
    cachebreaker: {
        dev: {
            options: {
                match: ['opensourcepos.min.js'],
                src: {
                    path: 'dist/opensourcepos.min.js'
                },
                replacement: 'md5'
            },
            files: {
                src: ['application/views/partial/header.php']
            }
        }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-script-link-tags');
  grunt.loadNpmTasks('grunt-mocha-webdriver');
  grunt.loadNpmTasks('grunt-cache-breaker');

  grunt.registerTask('default', ['tags:js', 'concat', 'uglify', 'tags:minjs', 'cachebreaker']);

};
