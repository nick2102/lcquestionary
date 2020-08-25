module.exports = function (grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        uglify: {
            options: {
                sourceMap: true,
            },
            build: {
                src: [

                    './assets/js/plugins/axios.min.js',
                    './assets/js/plugins/autocomplete.js',
                    './assets/js/plugins/jspdf.min.js',
                    './assets/js/plugins/html2canvas.js',
                    './assets/js/plugins/sweet-alert.min.js',
                    './assets/js/plugins/Chart.min.js',
                    './assets/js/plugins/gauge.min.js',
                    './assets/js/plugins/gauge2.min.js',
                    './assets/js/services/Request.js',
                    './assets/js/plugins/jquery.validate.min.js',
                    './assets/js/forms-validation.js',
                    './assets/js/global-functions.js',
                    './assets/js/auth.js',
                    './assets/js/questionnaire.js',
                    './assets/js/companies.js',
                ],

                dest: './assets/dist/trainee.min.js'
            },

            buildAdmin : {
                options: {
                    sourceMap: true,
                },
                src: [

                    './assets/js/plugins/axios.min.js',
                    './assets/js/plugins/sweet-alert.min.js',
                    './assets/js/plugins/bootstrap/bootstrap.min.js',
                    './assets/js/plugins/bootstrap/bootstrap-bundle.min.js',
                    './assets/js/admin/quick-search.js',
                    './assets/js/admin/jquery.multi-select.js',
                    './assets/js/services/Request.js',
                    './assets/js/admin/admin-global-functions.js',
                    './assets/js/admin/trainee-admin.js',
                ],

                dest: './assets/js/admin_dist/admin-trainee.min.js'
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');

    // Default task(s).
    grunt.registerTask('default', ['uglify']);
    grunt.registerTask('front', ['uglify:build']);
    grunt.registerTask('admin', ['uglify:buildAdmin']);
}