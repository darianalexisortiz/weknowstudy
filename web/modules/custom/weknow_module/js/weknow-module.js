

(function ($, Drupal, drupalSettings) {

  Drupal.behaviors.weknowModule = {

    attach: function (context, settings) {
      if (once($('body').hasClass('path-weknow-module'))) {
          const messages = new Drupal.Message();
          const messageId = messages.add('test message');
          //messages.remove(messageId);
          messages.add('test message', {type: 'warning'});
          messages.add('test message', {type: 'error'});
          // Clear ALL
          //messages.clear();
        }
      }
    }
})(jQuery, Drupal, drupalSettings);
