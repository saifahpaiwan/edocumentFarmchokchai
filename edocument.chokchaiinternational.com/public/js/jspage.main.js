$( document ).ready(function() {
    window.onscroll = function() {scrollFunction()};
    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            $("#header_main").addClass("box-header");
            $(".box-nav-new1").addClass("box-nav1-radius");
            $(".box-nav-new2").addClass("box-nav2-radius");
            $('.navbar').addClass('navbar-scroll');
        } else {
            $("#header_main").removeClass("box-header");
            $(".box-nav-new1").removeClass("box-nav1-radius");
            $(".box-nav-new2").removeClass("box-nav2-radius");
            $('.navbar').removeClass('navbar-scroll');
        }
    }
    
    // Slick Slider
    jQuery(".slick-slider").slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        arrows : false,
        responsive: [{
            breakpoint: 768,
                settings: {
                    slidesToShow: 1
                }
            }, {
            breakpoint: 520,
                settings: {
                    slidesToShow: 1
                }
        }]
    }); 
    // Slick Scroll
    jQuery(function () {
        const slider = jQuery(".slick-slider");
        slider; 
        slider.on("wheel", function (e) {
            e.preventDefault();

            if (e.originalEvent.deltaY < 0) {
            jQuery(this).slick("slickNext");
            } else {
            jQuery(this).slick("slickPrev");
            }
        });
    });

    jQuery(".slick-slider-news").slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows : false,
        responsive: [{
            breakpoint: 768,
                settings: {
                    slidesToShow: 1
                }
            }, {
            breakpoint: 520,
                settings: {
                    slidesToShow: 1
                }
        }]
    }); 
    // Slick Scroll
    jQuery(function () {
        const slider = jQuery(".slick-slider-news");
        slider; 
        slider.on("wheel", function (e) {
            e.preventDefault();

            if (e.originalEvent.deltaY < 0) {
            jQuery(this).slick("slickNext");
            } else {
            jQuery(this).slick("slickPrev");
            }
        });
    });
    
});

(function() { 
    window.inputNumber = function(el) { 
        var min = el.attr('min') || false;
        var max = el.attr('max') || false; 
        var els = {}; 
        els.dec = el.prev();
        els.inc = el.next(); 
        el.each(function() {
            init($(this));
        }); 
        function init(el) { 
            els.dec.on('click', decrement);
            els.inc.on('click', increment); 
            function decrement() {
            var value = el[0].value;
            value--;
                if(!min || value >= min) {
                    el[0].value = value;
                }
            } 
            function increment() {
                var value = el[0].value;
                value++;
                if(!max || value <= max) {
                    el[0].value = value++;
                }
            }
        }
    }
})(); 
inputNumber($('.input-number'));
 
