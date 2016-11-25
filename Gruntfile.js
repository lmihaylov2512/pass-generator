module.exports = function (grunt) {
    
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
                    src: ['**'],
                    dest: 'demo/browser/assets/bootstrap'
                }]
            }
        }
    });
    
    grunt.loadNpmTasks('grunt-exec');
    grunt.loadNpmTasks('grunt-contrib-copy');
    
    grunt.registerTask('build', ['exec', 'copy']);
    
    grunt.registerTask('default', ['build']);
    
};
