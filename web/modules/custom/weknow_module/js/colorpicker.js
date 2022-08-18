(function ($, Drupal, drupalSettings) {

  Drupal.behaviors.weknowModule = {

    attach: function (context, settings) {
      $('#colorpicker').farbtastic('#color');
    }
  }
})(jQuery, Drupal, drupalSettings);
