(function ($, Drupal, drupalSettings) {

  Drupal.behaviors.weknowModule = {

    attach: function (context, settings) {
      once('message', 'body', context).forEach(function () {
        const messages = new Drupal.Message();
        const messageId = messages.add('There are no open modals!');
        $(window).on('dialog:beforecreate', function (e, dialog, $element, settings) {
          $('body').addClass('modal-dialog-open');
        });
        $(window).on('dialog:beforeclose', function (e, dialog, $element, settings) {
          $('body').removeClass('modal-dialog-open');
          messages.clear();
          messages.add('Again, there are no open modals');
        });
        $('.link-weKnow').on('click', function () {
          messages.remove(messageId);
          messages.add('There is an open modal', {
            type: 'warning'
          });
          messages.add('I am red but this is not really a mistake', {
            type: 'error'
          });
        });
      })
    }
  }
})(jQuery, Drupal, drupalSettings);
