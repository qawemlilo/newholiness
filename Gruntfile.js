module.exports = function(grunt) {
  grunt.initConfig({
    compress: {
        template: {
            options: {
                archive: '../extensions/js_wright.zip'
            },
            
            files: [
                {cwd: 'template/js_wright/', src: ['**/*'], expand: true, dest: ''}, // includes files in path and its subdirs
            ]
        },
        
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
        
        mod_members: {
            options: {
                archive: '../extensions/mod_hpmembers.zip'
            },
            
            files: [
                {cwd: 'mod_hpmembers/', src: ['**/*'], expand: true, dest: ''}, // includes files in path and its subdirs
            ]
        }
    },
    
    exec: {
        minify: {
            cmd: 'uglifyjs com_holiness/site/assets/js/uploader/jquery.knob.js \
         com_holiness/site/assets/js/uploader/jquery.ui.widget.js \
         com_holiness/site/assets/js/uploader/jquery.iframe-transport.js \
         com_holiness/site/assets/js/uploader/jquery.fileupload.js \
         com_holiness/site/assets/js/uploader/script.js \
         -o com_holiness/site/assets/js/uploader/script.min.js'
        },
        
        minify_tmp: {
            cmd: 'uglifyjs template/js_wright/wright/js/bootstrap/transition.js \
         template/js_wright/wright/js/bootstrap/dropdown.js \
         template/js_wright/wright/js/bootstrap/tooltip.js \
         template/js_wright/wright/js/bootstrap/popover.js \
         template/js_wright/wright/js/bootstrap/affix.js \
         template/js_wright/wright/js/bootstrap/alert.js \
         -o template/js_wright/wright/js/bootstrap.min.js'
        }
    }
  });
  
  grunt.loadNpmTasks('grunt-contrib-compress');
  grunt.loadNpmTasks('grunt-exec');
  
  grunt.registerTask('default', ['compress']);
  grunt.registerTask('minify', ['exec:minify']);
  grunt.registerTask('minifytmp', ['exec:minify_tmp']);
};

