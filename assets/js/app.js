/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.scss in this case)
require('../css/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
require('metismenu/dist/metisMenu');
require('bootstrap/dist/js/bootstrap.min');
const swal = require('sweetalert/dist/sweetalert.min.js');
window.Cookies = require('js-cookie/src/js.cookie');

require('./inspinia');
require('./main.js');
require('./daterangePicker');
require('./filter');
require('./forms');
require('./selectize');
require('./sweetAlert');
require('./table');
require('./tableHeadFixer');
