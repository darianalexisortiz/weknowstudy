/**
 * @file
 * weKnow theme behaviors.
 */
(function (Drupal, drupalSettings) {

  'use strict';

  Drupal.behaviors.weknowtheme = {
    attach: function (context, settings) {
      //Override the default implementation of Drupal.theme.placeholder with our
      // own custom one.
      Drupal.theme.placeholder = function (str) {
        return '<em class="weKnow-placeholder">' + Drupal.checkPlain(str) + '</em>';
      }

      // If we have a nice user name, let's replace the
      // site name with a greeting.
      if (drupalSettings.weKnow =! 'undefined') {
        var siteName = document.getElementsByClassName("site-branding__name")[0];
        siteName.getElementsByTagName('a')[0].innerHTML = '<h1>Howdy, ' + Drupal.theme('placeholder', drupalSettings.weKnow.name) + '!</h1>';
      }
/*       Modernizr.addTest('itsWednesday', function () {
        var d = new Date();
        return d.getDay() === 1;
      });
      if (Modernizr.emoji) {
        //alert('🎉');
      } else {
        console.log('no emoji for you');
      } */
   }
  };


}(Drupal, drupalSettings));
