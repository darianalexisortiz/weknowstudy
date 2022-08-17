<?php

namespace Drupal\weknow_module\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'field_example_color_background' formatter.
 *
 * @FieldFormatter(
 *   id = "field_example_color_background",
 *   module = "weknow_module",
 *   label = @Translation("Change the background of the output text"),
 *   field_types = {
 *     "field_example_rgb"
 *   }
 * )
 */
class ColorBackgroudFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $text_color = 'inherit';
      if ($this->getSetting('adjust_text_color')) {
        $text_color = $this->lightness($item->value) < 50 ? 'white' : 'black';
      }

      $elements[$delta] = [
        '#type' => 'html_tag',
        '#tag' => 'p',
        '#value' => $this->t('The content area color has been changed to @code', ['@code' => $item->value]),
        '#attributes' => [
          'style' => 'background-color: ' . $item->value . '; color: ' . $text_color,
        ],
      ];
    }
    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    // Set default values for the formatter's configuration. The keys of this
    // array should match the form element names in ::settingsForm(), and the
    // schema defined in config/schema/field_example.schema.yml.
    return [
      'adjust_text_color' => TRUE,
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    // Create a new array with one or more form elements to add to the formatter
    // configuration form that is exposed when a user clicks the gear icon to
    // configure a field formatter on the manage display page for an entity
    // type.
    $elements = [];

    // The keys of the array, 'adjust_text_color' in this case, should match
    // what is defined in ::defaultSettings(), and the field_example.schema.yml
    // schema. The values collected by the form will be automatically stored
    // as part of the field instance configuration so you do not need to
    // implement form submission processing.
    $elements['adjust_text_color'] = [
      '#type' => 'checkbox',
      // The current configuration for this setting for the field instance can
      // be accessed via $this->getSetting().
      '#default_value' => $this->getSetting('adjust_text_color'),
      '#title' => $this->t('Adjust foreground text color'),
      '#description' => $this->t('Switch the foreground color between black and white depending on lightness of the background color.'),
    ];
    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {

    // This optional summary text is displayed on the manage displayed in place
    // of the formatter configuration form when the form is closed. You'll
    // usually see it in the list of fields on the manage display page where
    // this formatter is used.
    $state = $this->getSetting('adjust_text_color') ? $this->t('yes') : $this->t('no');
    $summary[] = $this->t('Adjust text color: @state', ['@state' => $state]);
    return $summary;
  }

  /**
   * Determine lightness of a color.
   *
   * This might not be the best way to determine if the contrast between the
   * foreground and background colors is legible. But it'll work well enough for
   * this demonstration.
   *
   * Logic from https://stackoverflow.com/a/12228730/8616016.
   *
   * @param string $color
   *   A color in hex format, leading '#' is optional.
   *
   * @return float
   *   Percentage of lightness of the provided color.
   */
  protected function lightness(string $color) {
    $hex = ltrim($color, '#');
    // Convert the hex string to RGB.
    $r = hexdec($hex[0] . $hex[1]);
    $g = hexdec($hex[2] . $hex[3]);
    $b = hexdec($hex[4] . $hex[5]);

    // Calculate the HSL lightness value and return that as a percent.
    return ((max($r, $g, $b) + min($r, $g, $b)) / 510.0) * 100;
  }

}
