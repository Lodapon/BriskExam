/*
Template: Metorik - Responsive Bootstrap 4 Admin Dashboard Template
Author: iqonicthemes.in
Design and Developed by: iqonicthemes.in
NOTE: This file contains the styling for responsive Template.
*/

/*----------------------------------------------
Index Of Script
------------------------------------------------

:: Page Loader
:: Scrollbar
:: Page Menu
:: Header fixed
:: Tooltip
:: Sidebar Widget
:: Magnific Popup
:: Ripple Effect
:: FullScreen
:: Page faq
:: Owl Carousel
:: Select input
:: Search input
:: Counter
:: Progress Bar
:: Wow Animation
:: Mailbox
:: chatuser
:: chatuser main
:: Chat
:: todo Page
:: Sidebar Widget


------------------------------------------------
Index Of Script
----------------------------------------------*/

(function(jQuery) {


    "use strict";

    jQuery(document).ready(function() {


        /*---------------------------------------------------------------------
        Page Loader
        -----------------------------------------------------------------------*/
        jQuery("#load").fadeOut();
        jQuery("#loading").delay().fadeOut("");



        /*---------------------------------------------------------------------
        Scrollbar
        -----------------------------------------------------------------------*/
        let Scrollbar = window.Scrollbar;
        if (jQuery('#sidebar-scrollbar').length) {
            Scrollbar.init(document.querySelector('#sidebar-scrollbar'), options);
        }
        let Scrollbar1 = window.Scrollbar;
        if (jQuery('#right-sidebar-scrollbar').length) {
            Scrollbar1.init(document.querySelector('#right-sidebar-scrollbar'), options);
        }



        /*---------------------------------------------------------------------
        Page Menu
        -----------------------------------------------------------------------*/
        jQuery(document).on('click', '.wrapper-menu', function() {
            jQuery(this).toggleClass('open');
            jQuery("body").toggleClass("sidebar-main");
        });



        /*---------------------------------------------------------------------
         Header fixed
         -----------------------------------------------------------------------*/

        jQuery(window).scroll(function() {
            if (jQuery(window).scrollTop() >= 50) {
                jQuery('.iq-top-navbar').addClass('fixed-header');
            } else {
                jQuery('.iq-top-navbar').removeClass('fixed-header');
            }
        });



        /*---------------------------------------------------------------------
        Tooltip
        -----------------------------------------------------------------------*/
        jQuery('[data-toggle="popover"]').popover();
        jQuery('[data-toggle="tooltip"]').tooltip();



        /*---------------------------------------------------------------------
        Sidebar Widget
        -----------------------------------------------------------------------*/
        function checkClass(ele, type, className) {
            switch (type) {
                case 'addClass':
                    if (!ele.hasClass(className)) {
                        ele.addClass(className);
                    }
                    break;
                case 'removeClass':
                    if (ele.hasClass(className)) {
                        ele.removeClass(className);
                    }
                    break;
                case 'toggleClass':
                    ele.toggleClass(className);
                    break;
            }
        }
        jQuery('.iq-sidebar-menu .active').each(function(ele, index) {
            jQuery(this).addClass('active');
            jQuery(this).find('.iq-submenu').addClass('show');
        })

        /*---------------------------------------------------------------------
        Magnific Popup
        -----------------------------------------------------------------------*/
        /*jQuery('.popup-gallery').magnificPopup({
            delegate: 'a.popup-img',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            mainClass: 'mfp-img-mobile',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                titleSrc: function(item) {
                    return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
                }
            }
        });
        jQuery('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });*/


        /*---------------------------------------------------------------------
        Ripple Effect
        -----------------------------------------------------------------------*/
        jQuery(document).on('click', ".iq-waves-effect", function(e) {
            // Remove any old one
            jQuery('.ripple').remove();
            // Setup
            let posX = jQuery(this).offset().left,
                posY = jQuery(this).offset().top,
                buttonWidth = jQuery(this).width(),
                buttonHeight = jQuery(this).height();

            // Add the element
            jQuery(this).prepend("<span class='ripple'></span>");


            // Make it round!
            if (buttonWidth >= buttonHeight) {
                buttonHeight = buttonWidth;
            } else {
                buttonWidth = buttonHeight;
            }

            // Get the center of the element
            let x = e.pageX - posX - buttonWidth / 2;
            let y = e.pageY - posY - buttonHeight / 2;


            // Add the ripples CSS and start the animation
            jQuery(".ripple").css({
                width: buttonWidth,
                height: buttonHeight,
                top: y + 'px',
                left: x + 'px'
            }).addClass("rippleEffect");
        });

        /*---------------------------------------------------------------------
        FullScreen
        -----------------------------------------------------------------------*/
        jQuery(document).on('click', '.iq-full-screen', function() {
            let elem = jQuery(this);
            if (!document.fullscreenElement &&
                !document.mozFullScreenElement && // Mozilla
                !document.webkitFullscreenElement && // Webkit-Browser
                !document.msFullscreenElement) { // MS IE ab version 11

                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                } else if (document.documentElement.msRequestFullscreen) {
                    document.documentElement.msRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                }
            } else {
                if (document.cancelFullScreen) {
                    document.cancelFullScreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
            }
            elem.find('i').toggleClass('ri-fullscreen-line').toggleClass('ri-fullscreen-exit-line');
        });

        /*---------------------------------------------------------------------
        Page faq
        -----------------------------------------------------------------------*/
        jQuery('.iq-accordion .iq-accordion-block .accordion-details').hide();
        jQuery('.iq-accordion .iq-accordion-block:first').addClass('accordion-active').children().slideDown('slow');
        jQuery(document).on("click", '.iq-accordion .iq-accordion-block', function() {
            if (jQuery(this).children('div.accordion-details ').is(':hidden')) {
                jQuery('.iq-accordion .iq-accordion-block').removeClass('accordion-active').children('div.accordion-details ').slideUp('slow');
                jQuery(this).toggleClass('accordion-active').children('div.accordion-details ').slideDown('slow');
            }
        });


        /*---------------------------------------------------------------------
       Owl Carousel
       -----------------------------------------------------------------------*/
        // jQuery('.owl-carousel').each(function() {
        //     let jQuerycarousel = jQuery(this);
        //     jQuerycarousel.owlCarousel({
        //         items: jQuerycarousel.data("items"),
        //         loop: jQuerycarousel.data("loop"),
        //         margin: jQuerycarousel.data("margin"),
        //         nav: jQuerycarousel.data("nav"),
        //         dots: jQuerycarousel.data("dots"),
        //         autoplay: jQuerycarousel.data("autoplay"),
        //         autoplayTimeout: jQuerycarousel.data("autoplay-timeout"),
        //         navText: ["<i class='fa fa-angle-left fa-2x'></i>", "<i class='fa fa-angle-right fa-2x'></i>"],
        //         responsiveClass: true,
        //         responsive: {
        //             // breakpoint from 0 up
        //             0: {
        //                 items: jQuerycarousel.data("items-mobile-sm"),
        //                 nav: false,
        //                 dots: true
        //             },
        //             // breakpoint from 480 up
        //             480: {
        //                 items: jQuerycarousel.data("items-mobile"),
        //                 nav: false,
        //                 dots: true
        //             },
        //             // breakpoint from 786 up
        //             786: {
        //                 items: jQuerycarousel.data("items-tab")
        //             },
        //             // breakpoint from 1023 up
        //             1023: {
        //                 items: jQuerycarousel.data("items-laptop")
        //             },
        //             1199: {
        //                 items: jQuerycarousel.data("items")
        //             }
        //         }
        //     });
        // });

        /*---------------------------------------------------------------------
        Select input
        -----------------------------------------------------------------------*/
        jQuery('.select2jsMultiSelect').select2({
            tags: true
        });

        /*---------------------------------------------------------------------
        Search input
        -----------------------------------------------------------------------*/
        jQuery(document).on('click', function(e) {
            let myTargetElement = e.target;
            let selector, mainElement;
            if (jQuery(myTargetElement).hasClass('search-toggle') || jQuery(myTargetElement).parent().hasClass('search-toggle') || jQuery(myTargetElement).parent().parent().hasClass('search-toggle')) {
                if (jQuery(myTargetElement).hasClass('search-toggle')) {
                    selector = jQuery(myTargetElement).parent();
                    mainElement = jQuery(myTargetElement);
                } else if (jQuery(myTargetElement).parent().hasClass('search-toggle')) {
                    selector = jQuery(myTargetElement).parent().parent();
                    mainElement = jQuery(myTargetElement).parent();
                } else if (jQuery(myTargetElement).parent().parent().hasClass('search-toggle')) {
                    selector = jQuery(myTargetElement).parent().parent().parent();
                    mainElement = jQuery(myTargetElement).parent().parent();
                }
                if (!mainElement.hasClass('active') && jQuery(".navbar-list li").find('.active')) {
                    jQuery('.navbar-list li').removeClass('iq-show');
                    jQuery('.navbar-list li .search-toggle').removeClass('active');
                }

                selector.toggleClass('iq-show');
                mainElement.toggleClass('active');

                e.preventDefault();
            } else if (jQuery(myTargetElement).is('.search-input')) {} else {
                jQuery('.navbar-list li').removeClass('iq-show');
                jQuery('.navbar-list li .search-toggle').removeClass('active');
            }
        });


        /*---------------------------------------------------------------------
        Counter
        -----------------------------------------------------------------------*/
        // jQuery('.counter').counterUp({
        //     delay: 10,
        //     time: 1000
        // });


        /*---------------------------------------------------------------------
        Progress Bar
        -----------------------------------------------------------------------*/
        jQuery('.iq-progress-bar > span').each(function() {
            let progressBar = jQuery(this);
            let width = jQuery(this).data('percent');
            progressBar.css({
                'transition': 'width 2s'
            });

            setTimeout(function() {
                progressBar.appear(function() {
                    progressBar.css('width', width + '%');
                });
            }, 100);
        });


        /*---------------------------------------------------------------------
        Wow Animation
        -----------------------------------------------------------------------*/
        let wow = new WOW({
            boxClass: 'wow',
            animateClass: 'animated',
            offset: 0,
            mobile: false,
            live: true
        });
        wow.init();


        /*---------------------------------------------------------------------
        Mailbox
        -----------------------------------------------------------------------*/
        jQuery(document).on('click', 'ul.iq-email-sender-list li', function() {
            jQuery(this).next().addClass('show');
        });

        jQuery(document).on('click', '.email-app-details li h4', function() {
            jQuery('.email-app-details').removeClass('show');
        });


        /*---------------------------------------------------------------------
        chatuser
        -----------------------------------------------------------------------*/
        jQuery(document).on('click', '.chat-head .chat-user-profile', function() {
            jQuery(this).parent().next().toggleClass('show');
        });
        jQuery(document).on('click', '.user-profile .close-popup', function() {
            jQuery(this).parent().parent().removeClass('show');
        });

        /*---------------------------------------------------------------------
        chatuser main
        -----------------------------------------------------------------------*/
        jQuery(document).on('click', '.chat-search .chat-profile', function() {
            jQuery(this).parent().next().toggleClass('show');
        });
        jQuery(document).on('click', '.user-profile .close-popup', function() {
            jQuery(this).parent().parent().removeClass('show');
        });

        /*---------------------------------------------------------------------
        Chat
        -----------------------------------------------------------------------*/
        jQuery(document).on('click', '#chat-start', function() {
            jQuery('.chat-data-left').toggleClass('show');
        });
        jQuery(document).on('click', '.close-btn-res', function() {
            jQuery('.chat-data-left').removeClass('show');
        });
        jQuery(document).on('click', '.iq-chat-ui li', function() {
            jQuery('.chat-data-left').removeClass('show');
        });
        jQuery(document).on('click', '.sidebar-toggle', function() {
            jQuery('.chat-data-left').addClass('show');
        });

        /*---------------------------------------------------------------------
        todo Page
        -----------------------------------------------------------------------*/
        jQuery(document).on('click', '.todo-task-list > li > a', function() {
            jQuery('.todo-task-list li').removeClass('active');
            jQuery('.todo-task-list .sub-task').removeClass('show');
            jQuery(this).parent().toggleClass('active');
            jQuery(this).next().toggleClass('show');
        });
        jQuery(document).on('click', '.todo-task-list > li li > a', function() {
            jQuery('.todo-task-list li li').removeClass('active');
            jQuery(this).parent().toggleClass('active');
        });

        /*---------------------------------------------------------------------
        Sidebar Widget
        -----------------------------------------------------------------------*/
        jQuery(document).ready(function() {
            jQuery().on('click', '.todo-task-lists li', function() {
                if (jQuery(this).find('input:checkbox[name=todo-check]').is(":checked")) {

                    jQuery(this).find('input:checkbox[name=todo-check]').attr("checked", false);
                    jQuery(this).removeClass('active-task');
                } else {
                    jQuery(this).find('input:checkbox[name=todo-check]').attr("checked", true);
                    jQuery(this).addClass('active-task');
                }
            });
        });

    });


    /*---------------------------------------------------------------------
     circle progress bar
    -----------------------------------------------------------------------*/
    $(function() {

        $(".progress-round").each(function() {

            var value = $(this).attr('data-value');
            var left = $(this).find('.progress-left .progress-bar');
            var right = $(this).find('.progress-right .progress-bar');

            if (value > 0) {
                if (value <= 50) {
                    right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
                } else {
                    right.css('transform', 'rotate(180deg)')
                    left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
                }
            }

        })

        function percentageToDegrees(percentage) {

            return percentage / 100 * 360

        }

    });



    /*---------------------------------------------------------------------
    Form Validation
    -----------------------------------------------------------------------*/


    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);



    /*---------------------------------------------------------------------
      Form Wizard - 1
    -----------------------------------------------------------------------*/

    var current_fs, next_fs, previous_fs;
    var opacity;
    var current = 1;
    var steps = jQuery("fieldset").length;

    setProgressBar(current);

    $(".next").click(function() {

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();


        jQuery("#top-tab-list li").eq(jQuery("fieldset").index(next_fs)).addClass("active");
        jQuery("#top-tab-list li").eq(jQuery("fieldset").index(current_fs)).addClass("done");


        next_fs.show();
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now) {
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative',

                });

                next_fs.css({
                    'opacity': opacity
                });
            },
            duration: 500
        });
        setProgressBar(++current);
    });

    jQuery(".previous").click(function() {

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();


        jQuery("#top-tab-list li").eq(jQuery("fieldset").index(current_fs)).removeClass("active");
        jQuery("#top-tab-list li").eq(jQuery("fieldset").index(previous_fs)).removeClass("done");


        previous_fs.show();

        current_fs.animate({
            opacity: 0
        }, {
            step: function(now) {
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({
                    'opacity': opacity
                });
            },
            duration: 500
        });
        setProgressBar(--current);
    });

    function setProgressBar(curStep) {
        var percent = parseFloat(100 / steps) * curStep;
        percent = percent.toFixed();
        jQuery(".progress-bar")
            .css("width", percent + "%")
    }

    jQuery(".submit").click(function() {
        return false;
    })


    /*---------------------------------------------------------------------
     validate form wizard
    -----------------------------------------------------------------------*/

    var navListItems = jQuery('div.setup-panel div a'),
        allWells = jQuery('.setup-content'),
        allNextBtn = jQuery('.nextBtn');

    allWells.hide();

    navListItems.click(function(e) {
        e.preventDefault();
        var $target = jQuery(jQuery(this).attr('href')),
            $item = jQuery(this);

        if (!$item.hasClass('disabled')) {
            navListItems.addClass('active');
            $item.parent().addClass('active');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function() {
        var curStep = jQuery(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = jQuery('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='email'],input[type='password'],input[type='url'],textarea"),
            isValid = true;

        jQuery(".form-group").removeClass("has-error");
        for (var i = 0; i < curInputs.length; i++) {
            if (!curInputs[i].validity.valid) {
                isValid = false;
                jQuery(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid)
            nextStepWizard.removeClass('disabled').trigger('click');
    });

    jQuery('div.setup-panel div a.active').trigger('click');

    /*---------------------------------------------------------------------
     Vertical form wizard
    -----------------------------------------------------------------------*/


    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    var current = 1;
    var steps = jQuery("fieldset").length;

    setProgressBar(current);

    $(".next").click(function() {

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();


        jQuery("#top-tabbar-vertical li").eq(jQuery("fieldset").index(next_fs)).addClass("active");


        next_fs.show();
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now) {
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({
                    'opacity': opacity
                });
            },
            duration: 500
        });
        setProgressBar(++current);
    });

    jQuery(".previous").click(function() {

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        jQuery("#top-tabbar-vertical li").eq(jQuery("fieldset").index(current_fs)).removeClass("active");

        previous_fs.show();

        current_fs.animate({
            opacity: 0
        }, {
            step: function(now) {
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({
                    'opacity': opacity
                });
            },
            duration: 500
        });
        setProgressBar(--current);
    });

    function setProgressBar(curStep) {
        var percent = parseFloat(100 / steps) * curStep;
        percent = percent.toFixed();
        jQuery(".progress-bar")
            .css("width", percent + "%")
    }

    jQuery(".submit").click(function() {
        return false;
    })

    /*---------------------------------------------------------------------
     validate Vertical form wizard
    -----------------------------------------------------------------------*/

    var navListItem = jQuery('div.setup-panel-data div a'),
        allWell = jQuery('.setup-content-data'),
        allNextButton = jQuery('.next-Btn');

    allWell.hide();

    navListItem.click(function(e) {
        e.preventDefault();
        var $target = jQuery(jQuery(this).attr('href')),
            $item = jQuery(this);

        if (!$item.hasClass('disabled')) {
            navListItem.addClass('active');
            $item.parent().addClass('active');
            allWell.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allNextButton.click(function() {
        var curStep = jQuery(this).closest(".setup-content-data"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = jQuery('div.setup-panel-data div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='email'],input[type='password'],input[type='url'],input[type='date'],input[type='radio'],textarea"),
            isValid = true;


        jQuery(".form-group").removeClass("has-error");
        for (var i = 0; i < curInputs.length; i++) {
            if (!curInputs[i].validity.valid) {
                isValid = false;
                jQuery(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid)
            nextStepWizard.removeClass('disabled').trigger('click');
    });

    jQuery('div.setup-panel-data div a.active').trigger('click');

})(jQuery);

