module.exports = function(grunt) {
  grunt.initConfig({
    compress: {
        com_holiness: {
            options: {
                archive: '../extensions/com_holiness.zip'
            },
            
            files: [
                {cwd: 'com_holiness/', src: ['**/*'], expand: true, dest: ''}, // includes files in path and its subdirs
            ]
        },
        
        mod_hpsearch: {
            options: {
                archive: '../extensions/mod_hpsearch.zip'
            },
            
            files: [
                {cwd: 'mod_hpsearch/', src: ['**/*'], expand: true, dest: ''}, // includes files in path and its subdirs
            ]
        },
        
        mod_devotions: {
            options: {
                archive: '../extensions/mod_devotions.zip'
            },
            
            files: [
                {cwd: 'mod_devotions/', src: ['**/*'], expand: true, dest: ''}, // includes files in path and its subdirs
            ]
        },
        
        mod_regform: {
            options: {
                archive: '../extensions/mod_regform.zip'
            },
            
            files: [
                {cwd: 'mod_regform/', src: ['**/*'], expand: true, dest: ''}, // includes files in path and its subdirs
            ]
        }
    }
  });
  
  grunt.loadNpmTasks('grunt-contrib-compress');
  grunt.registerTask('default', ['compress']);
};

