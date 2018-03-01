jQuery(function ($) {

    //Pre-loader
    var preloader = $('.preloader');
    $(window).load(function () {
        preloader.remove();
    });

    //#main-slider
    var slideHeight = $(window).height();
    $('#home-slider .item').css('height', slideHeight);

    $(window).resize(function () {
        'use strict',
            $('#home-slider .item').css('height', slideHeight);
    });

    //Scroll Menu
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > slideHeight) {
            $('.main-nav').addClass('navbar-fixed-top');
        } else {
            $('.main-nav').removeClass('navbar-fixed-top');
        }
    });
});

