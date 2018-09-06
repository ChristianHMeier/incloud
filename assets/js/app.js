/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

const $ = require('jquery');
require("jquery-ui");
require('jquery-ui/ui/version'); 
require('jquery-ui/ui/plugin'); 
require('jquery-ui/ui/widget');
require("jquery-ui/ui/widgets/datepicker");
require('bootstrap');

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.scss');
require("jquery-ui/themes/base/all.css");
// require("jquery-ui-bundle/jquery-ui.theme.css");
// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// var $ = require('jquery');

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
