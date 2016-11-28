module.exports = function (grunt) {
    
    //initialize tasks configurations
    grunt.initConfig({
        exec: {
            install_bower: {
                cmd: 'bower install'
            }
        },
        copy: {
            jquery: {
                files: [{
                    expand: true,
                    cwd: 'bower_components/jquery/dist',
                    src: '**',
                    dest: 'demo/browser/assets/jquery'
                }]
            },
            bootstrap: {
                files: [{
                    expand: true,
                    cwd: 'bower_components/bootstrap/dist/',
                    src: '**',
                    dest: 'demo/browser/assets/bootstrap'
                }]
            }
        }
    });
    
    //register npm tasks
    grunt.loadNpmTasks('grunt-exec');
    grunt.loadNpmTasks('grunt-contrib-copy');
    
    //register tasks aliases
    grunt.registerTask('build', ['exec', 'copy']);
    grunt.registerTask('default', ['build']);
    
};
