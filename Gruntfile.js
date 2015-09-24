module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

    // deployments: grunt.file.readJSON("config/settings/deployments.json"),
    // rsync: grunt.file.readJSON("config/settings/rsync.json"),

    clean: {
      hooks: ['.git/hooks/pre-commit']
    },

    shell: {
      hooks: {
        command: ['cp config/githooks/pre-commit .git/hooks/', 'chmod 755 .git/hooks/pre-commit'].join(";")
      }
    },

    copy: {
      plugins: {
        files: [
          // Foundation
          {cwd: "node_modules/foundation-sites/scss/foundation", src: '**', dest: 'public/assets/styles/sass/foundation', expand: true, flatten: false},
          {isFile: true, rename: function(dest, src){ return dest + "_" + src; }, cwd: "node_modules/foundation-sites/foundation/scss", src: 'foundation.scss', dest: 'public/assets/styles/sass/', expand: true, flatten: false},
          {isFile: true, rename: function(dest, src){ return dest + "_" + src; }, cwd: "node_modules/foundation-sites/foundation/scss", src: 'normalize.scss', dest: 'public/assets/styles/sass/', expand: true, flatten: false},
        ]
      }
    },

    concat: {
      dist: {
        src: [
          'public/assets/scripts/built/bower.js',
          'public/assets/scripts/vendor/*',
          'public/assets/scripts/classes/*',
          'public/assets/scripts/templates/*',
          'public/assets/scripts/main.js'
        ],
        dest: 'public/assets/scripts/built/scripts.js',
      },
    },

    uglify: {
      options: {
        mangle: false,
        compress: false,
        beautify: false
      },
      my_target: {
        files: {
          'public/assets/scripts/built/built.js': [
            'public/assets/scripts/built/scripts.js'
            ]
        }
      }
    },

    compass: {
      dist: {
        options: {
          sassDir: 'public/assets/styles/sass',
          cssDir: 'public/assets/styles/css',
          imagesDir: 'public/assets/images',
          javascriptsDir: 'public/assets/scripts',
          outputStyle: "nested",
          environment: "development",
          require: "sass-json-vars"
        }
      }
    },

    cssmin: {
      my_target: {
        files: [{
          expand: true,
          cwd: 'public/assets/styles/css',
          src: ['*.css', '!*.min.css'],
          dest: 'public/assets/styles/css',
          ext: '.min.css'
        }]
      }
    },

    browserify: {
      dist: {
        files: {
          'public/assets/scripts/built/scripts.js': [
            'public/assets/scripts/main.js'
          ],
        },
        options: {
        //  transform: ['babelify']
        }
      }
    },

    watch: {
      all: {
        files: ['site/**/*.php', 'public/content/**/*.txt'],
        options: {
          livereload: true
        }
      },
      sass: {
        files: ['public/assets/styles/sass/**/*.scss'],
        tasks: ['compass'],
        options: {
          livereload: true
        }
      },
      scripts: {
        files: ['public/assets/scripts/**/*.js',  'node_modules/underscore/underscore.js', 'public/assets/scripts/built/variables.js','!public/assets/scripts/built/*'],
        tasks: ['json:main','browserify'],
        options: {
          livereload: true
        }
      },
      json: {
        files: ['public/assets/styles/sass/_variables.json'],
        tasks: ['json:main','browserify', 'compass'],
        options: {
          livereload: true
        }
      },
      configFiles: {
        files: [ 'Gruntfile.js', 'config/*.js' ],
        options: {
          reload: true
        }
      }
    },

    bless: {
      css: {
        options: {
          'force': true
        },
        files: {
          'public/assets/styles/css/app-blessed.css': 'public/assets/styles/css/app.css',
          'public/assets/styles/css/app-blessed.min.css': 'public/assets/styles/css/app.min.css',
        }
      }
    },

    json: {
      main: {
          options: {
              namespace: 'settings',
              includePath: false,
              commonjs: true
          },
          src: ['public/assets/styles/sass/_variables.json'],
          dest: 'public/assets/scripts/built/variables.js'
      }
    }

  });

  // TASKS

  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-shell');
  grunt.loadNpmTasks('grunt-deployments');
  grunt.loadNpmTasks("grunt-rsync");
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-bless');
  grunt.loadNpmTasks('grunt-browserify');
  grunt.loadNpmTasks('grunt-json');

  grunt.registerTask('hookmeup', ['clean:hooks', 'shell:hooks']);
  grunt.registerTask("init", ["copy:plugins"]);
  grunt.registerTask("compile", ["compass", "json:main", "browserify", "uglify", 'cssmin', 'bless']);

  // grunt.registerTask("sync-down", ["db_pull","rsync:dev"]);
  // grunt.registerTask("get-content", ["rsync:production"]);
  // grunt.registerTask('default', [""]);

};