Drupal.behaviors.b4ideaScroll = {
    attach: function (context, settings) {
      $(document).ready(function () {
        jQuery(window).scroll(function () {
          var scrolled = jQuery(window).scrollTop();
          // var scrolled = $(window).scrollBottom();
          if (scrolled >= 80) {
            jQuery("#navbar").addClass("sticky");  
          } else {
            jQuery("#navbar").removeClass("sticky");
          }
        });
      });
    },
  };