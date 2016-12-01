 jQuery(document).ready(function(){
    var $button = jQuery('#gon-messenger-header'),
    $text   = jQuery('#gon-messenger-body'),
    visible = false;
    $button.click(function(){
    if ( visible ) {
      $text.slideUp('fast',function(){
        $text.addClass('gon-hide')
             .slideDown(0);
             jQuery('#gon-toggle-button').toggleClass( 'gon-close');
             jQuery('#gon-toggle-button').toggleClass( 'gon-open');
      });
    } else {
      $text.slideUp(0,function(){
        $text.removeClass('gon-hide')
             .slideDown('fast');
        jQuery('#gon-toggle-button').toggleClass( 'gon-close');
        jQuery('#gon-toggle-button').toggleClass( 'gon-open');
      });
    }
  visible = ! visible;
  });
});
