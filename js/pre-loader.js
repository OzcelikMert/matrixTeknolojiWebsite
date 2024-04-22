// Prealoder
function prealoader () {
    if ($('#preloader_1').length) {
      $('#preloader_1').fadeOut(); // will first fade out the loading animation
      $('#loader-wrapper').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
      $('body').delay(350).css({'overflow':'visible'});
    };
}

// Window load function
jQuery(window).on('load', function () {
    (function ($) {
       prealoader ()
    })(jQuery);
});