
(function($) {
	'use strict';

	/*Video background , javascript library in assets*/
    var url = $('.field--name-field-video-background-lin ').find('a').attr('href');
    var videoUrl="{videoURL:'";
    var settings="',containment:'#block-findyourdreamhousewithus',autoPlay:true, mute:true, startAt:0, opacity:1}";
   // alert(videoUrl + url + settings);
   // alert(url);
    $( "#block-findyourdreamhousewithus" ).attr("data-property", videoUrl + url + settings);



	/*Add bg class to Contact form , contact page*/
    $( '.contact-message-feedback-form' ).wrap( "<div class='wrap-contact-form'></div>" );

    /*Add wraper class to contact page*/
    $( '.wrap-contact-form ,#block-getintouch' ).wrapAll( "<div class='contact-section'></div>" );

    /*Add content after Register block*/
    $(".user-register-form").append("<h5>Register</h5>");

    /*Add content after Login block*/
    $("#user-login-form").append("<h5>Login</h5>");
    $("#user-login-form").append("<p>If you have an account with us, Please log in.</p>");

    /*Add content after feeadback*/
   // $(".comment-comment-sheltek-review-form").append("<h5>Login</h5>");

    /*Add wraper around Author elements*/
    $( '.img-author,.desc-author' ).wrapAll( "<div class='author-block'></div>" );


    /*ScrollUp*/
    $(window).scroll(function() {
        if ($(this).scrollTop() >100) {
            $('#scrollUp').fadeIn(200);
        } else {
            $('#scrollUp').fadeOut(200);
        }
    });
    /* On click back to top*/
    $("a[href='#top']").click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });


    //**Menu mobile
    $('.menu--real-state-menu').meanmenu();


    /*Slide range*/
    $( "#slider-range" ).slider({
        range: true,
        min: 0,
        max: 100000,
        values: [ 10000, 85000 ],
        slide: function( event, ui ) {
            $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
            $('.form-item-min-price > input[data-drupal-selector="edit-min-price"]').val("" + ui.values[ 0 ] + "");
            $('.form-item-max-price > input[data-drupal-selector="edit-max-price"]').val("" + ui.values[ 1 ] + "");
        }
    });


    /*Slider property page home-page*/
    $('.property-slider .flexslider').flexslider({
        animation: "slide",
        controlNav: "thumbnails",
        directionNav:false,
        slideshow: true,                //Boolean: Animate slider automatically
        slideshowSpeed: 4000         //Integer: Set the speed of the slideshow cycling, in milliseconds
    });


     /*Slider with terms home-page*/
    (function() {

        // store the slider in a local variable
        var $window = $(window),
            flexslider = { vars:{} };

        // tiny helper function to add breakpoints
        function getGridSize() {
            return (window.innerWidth < 600) ? 1 :
                (window.innerWidth < 900) ? 3 : 4;
        }
        function getGridSizePartner() {
            return (window.innerWidth < 600) ? 1 :
                (window.innerWidth < 900) ? 4 : 5;
        }

        // $(function() {
        //     SyntaxHighlighter.all();
        // });

        $window.ready(function() {
            $('.termslider .flexslider').flexslider({
                animation: "slide",
                animationLoop: false,
                slideshowSpeed: 3000,
                itemWidth:268,
                touch:true,
                controlNav: false,
                directionNav: false,
                minItems: getGridSize(), // use function to pull in initial value
                maxItems: getGridSize() // use function to pull in initial value
            });
            $('.termslider').draggable();

            /*Slider with partenrs home-page*/
            $('.partnerslider .flexslider').flexslider({
                animation: "slide",
                animationLoop: false,
                itemWidth:231,
                touch:true,
                mousewheel: true,
                controlNav: false,
                directionNav: false,
                minItems: getGridSizePartner(), // use function to pull in initial value
                maxItems: getGridSizePartner() // use function to pull in initial value
            });
        });

        // check grid size on resize event
        $window.resize(function() {
            var gridSize = getGridSize();

            flexslider.vars.minItems = gridSize;
            flexslider.vars.maxItems = gridSize;
        });
    }());




    /* Fixed navigation on scroll*/
    var width = window.innerWidth;

    if ( $(window).width() >420) {
        /*function scroll-fix nav*/
        $(window).bind('scroll', function () {
            if ($(window).scrollTop() > 50) {
                $('.site-navigation').addClass('fixed');
                $('.menu-item--expanded').addClass('fix');
            } else {
                $('.site-navigation').removeClass('fixed');
                $('.menu-item--expanded').removeClass('fix');
            }
        });
    }

    /*  Explorer and Firefox placeholder sethings */
    $("input[placeholder]").each(function () {
        var $this = $(this);
        if($this.val() == ""){
            $this.val($this.attr("placeholder")).focus(function(){
                if($this.val() == $this.attr("placeholder")) {
                    $this.val("");
                }
            }).blur(function(){
                if($this.val() == "") {
                    $this.val($this.attr("placeholder"));
                }
            });
        }
    });

   /*
          if ( $(window).width() < 420) {
                var browser = $(window).width();
                // Returns width of HTML document
                var document = $(document).width();
         $('.menu-toggle').click(function (e) {
            $('.menu--real-state-menu').addClass('mobile').slideToggle('slow');
            e.preventDefault();
            console.log("click");
            $(this).find('i').toggleClass('fa-bars fa-times');
        });


        $('.menu-item--expanded').click(function (e) {
            console.log("click");
            $('.menu-item--expanded > ul').addClass('responsive');
            e.preventDefault();

            //Close all <div> but the <div> right after the clicked <a>
            $(e.target).next('ul.responsive').siblings('ul.responsive').slideUp('fast');

            //Toggle open/close on the <div> after the <h3>, opening it if not open.
            $(e.target).next('ul.responsive').slideToggle('fast');
            $(this).attr('data-before', 'anything'); //anything is the 'content' value
        });
                }*/



})(jQuery);
//# sourceMappingURL=../scripts/application.js.map
