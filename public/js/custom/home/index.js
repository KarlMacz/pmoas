$(document).ready(function() {
    $(function() {
        if($(window).scrollTop() > ($('header').height() - $('.navbar').height())) {
            if($('.navbar').hasClass('navbar-transparent')) {
                $('.navbar').removeClass('navbar-transparent');
            }
        } else {
            if(!$('.navbar').hasClass('navbar-transparent')) {
                $('.navbar').addClass('navbar-transparent');
            }
        }
    });

    $(window).scroll(function() {
        if($(this).scrollTop() > ($('header').height() - ($('body').data('offset') + 1))) {
            if($('.navbar').hasClass('navbar-transparent')) {
                $('.navbar').removeClass('navbar-transparent');
            }

            $('.navbar .navbar-brand').fadeIn(250);
        } else {
            if(!$('.navbar').hasClass('navbar-transparent')) {
                $('.navbar').addClass('navbar-transparent');
            }

            $('.navbar .navbar-brand').fadeOut(250);
        }
    });
});
