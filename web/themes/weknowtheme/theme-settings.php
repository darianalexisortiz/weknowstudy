<?php

/**
 * @file
 * Theme settings form for weKnow theme theme.
 */

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function weknowtheme_form_system_theme_settings_alter(&$form, &$form_state) {

  $form['weknowtheme'] = [
    '#type' => 'details',
    '#title' => t('weKnow theme'),
    '#open' => TRUE,
  ];

  $form['weknowtheme']['font_size'] = [
    '#type' => 'number',
    '#title' => t('Font size'),
    '#min' => 12,
    '#max' => 18,
    '#default_value' => theme_get_setting('font_size'),
  ];

}
