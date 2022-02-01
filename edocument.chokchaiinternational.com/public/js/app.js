/* Template Name: Adminox - Bootstrap 4 Landing Page Tamplat
   Author: CoderThemes
   File Description: Main JS file of the template
*/


! function($) {
    "use strict";

    var Adminox = function() {};



    Adminox.prototype.initSmoothLink = function() {
        $('.navbar-nav a').on('click', function(event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top - 0
            }, 1500, 'easeInOutExpo');
            event.preventDefault();
        });
    },

    Adminox.prototype.init = function() {
        this.initSmoothLink();
    },
    //init
    $.Adminox = new Adminox, $.Adminox.Constructor = Adminox
}(window.jQuery),

//initializing
function($) {
    "use strict";
    $.Adminox.init();
}(window.jQuery);