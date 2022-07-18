<?php

namespace Drupal\weknow_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a weKnow module form.
 */
class DependentDropdown extends FormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'weknow_module_dependent_dropdown';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $instrument_family_options = static::getFirstDropdownOptions();
    if (empty($form_state->getValue('instrument_family_dropdown'))) {
      // Use a default value.
      $selected_family = key($instrument_family_options);
    } else {
      $selected_family = $form_state->getValue('instrument_family_dropdown');
    }

    $form['instrument_family_fieldset'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Choose an instrument family'),
    ];

    $form['instrument_family_fieldset']['instrument_family_dropdown'] = [
      '#type' => 'select',
      '#title' => $this->t('Instrument Type'),
      '#options' => $instrument_family_options,
      '#default_value' => $selected_family,
      '#ajax' => [
        'callback' => '::instrumentDropdownCallback',
        'wrapper' => 'instrument-fieldset-container',
        'event' => 'change',
      ],
    ];

    $form['instrument_family_fieldset']['choose_family'] = [
      '#type' => 'submit',
      '#value' => $this->t('Choose'),
      '#states' => [
        'visible' => ['body' => ['value' => true]],
      ],
    ];

    $form['instrument_fieldset_container'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'instrument-fieldset-container'],
    ];

    $form['instrument_fieldset_container']['instrument_fieldset'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Choose an instrument'),
    ];

    $form['instrument_fieldset_container']['instrument_fieldset']['instrument_dropdown'] = [
      '#type' => 'select',
      '#title' => $instrument_family_options[$selected_family] . ' ' . $this->t('Instruments'),
      '#options' => static::getSecondDropdownOptions($selected_family),
      '#default_value' => !empty($form_state->getValue('instrument_dropdown')) ? $form_state->getValue('instrument_dropdown') : '',
    ];
    $form['instrument_fieldset_container']['instrument_fieldset']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    if ($selected_family == 'none') {
      $form['instrument_fieldset_container']['instrument_fieldset']['instrument_dropdown']['#title'] = $this->t('You must choose an instrument family first.');
      $form['instrument_fieldset_container']['instrument_fieldset']['instrument_dropdown']['#disabled'] = true;
      $form['instrument_fieldset_container']['instrument_fieldset']['submit']['#disabled'] = true;
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $trigger = (string) $form_state->getTriggeringElement()['#value'];
    if ($trigger == 'Submit') {
      \Drupal::messenger()->addStatus(
        $this->t(
          'Your values have been submitted. Instrument family: @family, Instrument: @instrument',
          [
            '@family' => $form_state->getValue('instrument_family_dropdown'),
            '@instrument' => $form_state->getValue('instrument_dropdown'),
          ]
        )
      );
    } else {
      $form_state->setRebuild();
    }
  }

  /**
   * Ajax callback for instrument family select field.
   *
   * This callback will occur *after* the form has been rebuilt by buildForm().
   * Since that's the case, the $form array should contain the right values for
   * the instrument type field that reflect the current value of the instrument
   * family field.
   *
   * @param array                                $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The portion of the render structure that will replace the
   *   instrument-dropdown-replace form element.
   */
  public function instrumentDropdownCallback(array $form, FormStateInterface $form_state)
  {
    return $form['instrument_fieldset_container'];
  }

  /**
   * Helper function to populate the first dropdown.
   *
   * This would normally be pulling data from the database.
   *
   * @return array
   *   Dropdown options.
   */
  public static function getFirstDropdownOptions()
  {
    return [
      'none' => 'none',
      'String' => 'String',
      'Woodwind' => 'Woodwind',
      'Brass' => 'Brass',
      'Percussion' => 'Percussion',
    ];
  }

  /**
   * Helper function to populate the second dropdown.
   *
   * This would normally be pulling data from the database.
   *
   * @param string $key
   *   This will determine which set of options is returned.
   *
   * @return array
   *   Dropdown options
   */
  public static function getSecondDropdownOptions($key = '')
  {
    switch ($key) {
      case 'String':
        $options = [
          'Violin' => 'Violin',
          'Viola' => 'Viola',
          'Cello' => 'Cello',
          'Double Bass' => 'Double Bass',
        ];
        break;

      case 'Woodwind':
        $options = [
          'Flute' => 'Flute',
          'Clarinet' => 'Clarinet',
          'Oboe' => 'Oboe',
          'Bassoon' => 'Bassoon',
        ];
        break;

      case 'Brass':
        $options = [
          'Trumpet' => 'Trumpet',
          'Trombone' => 'Trombone',
          'French Horn' => 'French Horn',
          'Euphonium' => 'Euphonium',
        ];
        break;

      case 'Percussion':
        $options = [
          'Bass Drum' => 'Bass Drum',
          'Timpani' => 'Timpani',
          'Snare Drum' => 'Snare Drum',
          'Tambourine' => 'Tambourine',
        ];
        break;

      default:
        $options = ['none' => 'none'];
        break;
    }
    return $options;
  }
}
