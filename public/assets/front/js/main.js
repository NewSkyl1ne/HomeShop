$(function ($) {
    "use strict";


    $(document).ready(function () {
     /*------addClass/removeClass categories-------*/
     $(".categories_menu_inner > ul > li").on("mouseover", function() {
        $(this).find('.link-area a').toggleClass('open').parent().parent().find('.categories_mega_menu, categorie_sub').addClass('open');
          $(this).siblings().find('.categories_mega_menu, .categorie_sub').removeClass('open');
    });

     /*categories slideToggle*/
    $(".categories_title").on("mouseover", function() {
        $(this).addClass('active');
        $('.categories_menu_inner').slideDown('medium');
    }); 


  $(document).on('mouseover', function(e) 
  {
      var container = $(".categories_menu_inner, .categories_mega_menu, .categories_title");

      // if the target of the click isn't the container nor a descendant of the container
      if (!container.is(e.target) && container.has(e.target).length === 0) 
      {
        $('.categories_menu_inner').slideUp('medium');
        $('.categories_mega_menu, .categorie_sub').removeClass('open');
         $(".categories_mega_menu").removeClass('open');
         $(".categories_title").removeClass('active');
      }
  });

     /*------addClass/removeClass categories-------*/


    $('nav').coreNavigation({
        menuPosition: "left",
        container: false,
        dropdownEvent: 'hover',
        onOpenDropdown: function(){
            console.log('open');
        },
        onCloseDropdown: function(){
            console.log('close');
        }
    });

    $('#example').DataTable({
        "paging":   true,
        "ordering": true,
        "info":     true
    });


    //   magnific popup activation
    $('.video-play-btn').magnificPopup({
        type: 'video'
    });
    $('.img-popup').magnificPopup({
        type: 'image'
    });


// Tooltip Section

    $('[data-toggle="tooltip"]').tooltip({

    });

    $('[rel-toggle="tooltip"]').tooltip();

    $('[data-toggle="tooltip"]').on('click',function(){
        $(this).tooltip('hide');
    })


    $('[rel-toggle="tooltip"]').on('click',function(){
        $(this).tooltip('hide');
    })

// Tooltip Section Ends

  /*-----------------------------
      Accordion Active js
  -----------------------------*/
  $("#accordion, #accordion2").accordion({
    heightStyle: "content",
    collapsible: true,
    icons: {
      "header": "ui-icon-caret-1-e",
      "activeHeader": " ui-icon-caret-1-s"
    }
  });
    $("#product-details-tab").tabs();


    // Hero Area Slider
    var $mainSlider = $('.intro-carousel');
    $mainSlider.owlCarousel({
        loop: true,
        navText: ['<i class="fas fa-angle-double-left"></i>', '<i class="fas fa-angle-double-right"></i>'],
        nav: true,
        dots: false,
        autoplay: false,
        autoplayTimeout: 6000,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1000,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 1
            },
            960: {
                items: 1
            },
            1200: {
                items: 1
            },
            1920: {
                items: 1
            }
        },

    });

(function($) {
    var $currentItem = $('.owl-item', $mainSlider).eq(2);
    var $class1 = $currentItem.find('.subtitle').attr('data-animation');
    $currentItem.find('.subtitle').addClass($class1);
    setTimeout(function(){
            $currentItem.find('.subtitle').removeClass($class1);
    }, 900);

    var $class2 = $currentItem.find('.title').attr('data-animation');
    $currentItem.find('.title').addClass($class2);
    setTimeout(function(){
            $currentItem.find('.title').removeClass($class2);
    }, 900);

    var $class3 = $currentItem.find('.text').attr('data-animation');
    $currentItem.find('.text').addClass($class3);
    setTimeout(function(){
            $currentItem.find('.text').removeClass($class3);
    }, 900);

})(jQuery);

$mainSlider.on('changed.owl.carousel', function(event) {
    var $currentItem = $('.owl-item', $mainSlider).eq(event.item.index)
    
    var $class11 = $currentItem.find('.subtitle').attr('data-animation');
    $currentItem.find('.subtitle').addClass($class11);
    setTimeout(function(){
            $currentItem.find('.subtitle').removeClass($class11);
    }, 900);

    var $class22 = $currentItem.find('.title').attr('data-animation');
    $currentItem.find('.title').addClass($class22);
    setTimeout(function(){
            $currentItem.find('.title').removeClass($class22);
    }, 900);
    var $class33 = $currentItem.find('.text').attr('data-animation');
    $currentItem.find('.text').addClass($class33);
    setTimeout(function(){
            $currentItem.find('.text').removeClass($class33);
    }, 900);

});

    // flas_deal_slider
    var $flas_deal_slider = $('.flas-deal-slider');
    $flas_deal_slider.owlCarousel({
        loop: true,
        nav: false,
        dots: true,
        margin: 30,
        autoplay: false,
        autoplayTimeout: 6000,
        smartSpeed: 1000,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 1
            }
        }
    });

    // Product deal countdown
    $('[data-countdown]').each(function () {
        var $this = $(this),
            finalDate = $(this).data('countdown');
        $this.countdown(finalDate, function (event) {
            $this.html(event.strftime('<span>%D : <small>Days</small></span> <span>%H : <small>Hrs</small></span>  <span>%M : <small>Min</small></span> <span>%S <small>Sec</small></span>'));
        });
    });

    // trending item  slider
    var $trending_slider = $('.trending-item-slider');
    $trending_slider.owlCarousel({
        items: 4,
        autoplay: true,
        margin: 0,
        loop: true,
        dots: true,
        nav: true,
        center: false,
        autoplayHoverPause: true,
        navText: ["<i class='fa fa-angle-double-left'></i>", "<i class='fa fa-angle-double-right'></i>"],
        smartSpeed: 800,
        responsive: {
            0: {
                items: 1,
            },
            414: {
                items: 2,
            },
            768: {
                items: 2,
            },
            992: {
                items: 3
            },
            1200: {
                items: 4
            }
        }
    });

    // aside_review_slider
    var $aside_review_slider = $('.aside-review-slider');
    $aside_review_slider.owlCarousel({
        loop: true,
        nav: false,
        dots: true,
        margin: 30,
        autoplay: false,
        autoplayTimeout: 6000,
        smartSpeed: 1000,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 1
            }
        }
    });

    /**------------------------------
     * Product Details  carousel
     * ---------------------------**/
    $('.one-item-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.all-item-slider',
        responsive: [{
                breakpoint: 991,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    vertical: false,
                    horizontal: true,
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.all-item-slider').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.one-item-slider',
        vertical: true,
        arrows: true,
        prevArrow: '<i class="fa fa fa-chevron-up slidPrv4"></i>',
        nextArrow: '<i class="fa fa-chevron-down slidNext4"></i>',
        verticalSwiping: true,
        dots: false,
        centerMode: true,
        centerPadding: '0px',
        focusOnSelect: true,
        responsive: [{
            breakpoint: 768,
            settings: {
                vertical: false,
                slidesToShow: 3
            }
        }]
    });
});

    /**------------------------------
     * Quick View
     * ---------------------------**/
    $('.quick-one-item-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.quick-all-item-slider',
        responsive: [{
                breakpoint: 991,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    vertical: false,
                    horizontal: true,
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.quick-all-item-slider').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.quick-one-item-slider',
        arrows: true,
        prevArrow: '<i class="fa fa fa-chevron-up slidPrv4"></i>',
        nextArrow: '<i class="fa fa-chevron-down slidNext4"></i>',
        dots: false,
        centerMode: true,
        centerPadding: '0px',
        focusOnSelect: true,
        responsive: [{
            breakpoint: 768,
            settings: {
                vertical: false,
                slidesToShow: 3
            }
        }]
    });


    $(document).on('click', '.cart-remove', function (e) {
        e.preventDefault();
        $(this).parent().parent().remove();
    });

    $('.carticon').on('click', function () {
        $(this).next().toggleClass('show');
    });

    /*-------------------------------
        back to top
    ------------------------------*/
    $(document).on('click', '.bottomtotop', function () {
        $("html,body").animate({
            scrollTop: 0
        }, 2000);
    });

    //define variable for store last scrolltop
    var lastScrollTop = '';
    $(window).on('scroll', function () {
        var $window = $(window);
        if ($window.scrollTop( ) > 300 ) {
            $(".mainmenu-area").addClass('nav-fixed');
        } else {
            $(".mainmenu-area").removeClass('nav-fixed');
        }

        /*---------------------------
            back to top show / hide
        ---------------------------*/
        var st = $(this).scrollTop();
        var ScrollTop = $('.bottomtotop');
        if ($(window).scrollTop() > 1000) {
            ScrollTop.fadeIn(1000);
        } else {
            ScrollTop.fadeOut(1000);
        }
        lastScrollTop = st;

    });

    $(window).on('load', function () {
  
        /*---------------------
            Preloader
        -----------------------*/
        var preLoder = $("#preloader");
        preLoder.addClass('hide');
        var backtoTop = $('.back-to-top')
        /*-----------------------------
            back to top
        -----------------------------*/
        var backtoTop = $('.bottomtotop')
        backtoTop.fadeOut(100);
    });

    // Coupon code toggle code
    $('#coupon-link').on('click', function(){
        $("#coupon-form,#check-coupon-form").toggle();
    })

    //cart item remove code
    $('.cart-remove').on('click', function(){
        $(this).parent().parent().remove();
    });

    

});