<?php

namespace Drupal\weknow_module\Form;

use Drupal\Component\Utility\Html;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a weKnow module form.
 */
class SubmitDriven extends FormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'weknow_module_submit_driven';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {

    $ajax_wrapper_id = Html::getUniqueId('box-container');
    $form['#prefix'] = '<div id="' . $ajax_wrapper_id . '">';
    $form['#suffix'] = '</div>';
    if ($form_state->has('string')) {
      $form['box'] = [
        '#markup' => '<p>' . $this->t('You clicked submit on @date', ['@date' => date('c')]) . '</p>'
      ];

      $form['item'] = [
        '#markup' =>  '<p>' . t('You submitted %string which results in %reversed when reversed.', ['%string' => $form_state->get('string'), '%reversed' => $form_state->get('reversed_string')]) . '</p>',
      ];
    } else {
      $form['box'] = [
        '#type' => 'markup',
        '#markup' => '<h1>Initial markup for box</h1>',
      ];
      $form['item'] = [
        '#type' => 'textfield',
        '#required' => TRUE,
        '#title' => $this->t('Enter some text'),
        '#description' => $this->t('Must be at least 5 characters.'),
      ];
      $form['submit'] = [
        '#type' => 'submit',
        '#ajax' => [
          'callback' => '::promptCallback',
          'wrapper' => $ajax_wrapper_id,
        ],
        '#value' => $this->t('Submit'),
      ];
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    $title = $form_state->getValue('item');
    if (strlen($title) < 5) {
      $form_state->setErrorByName('item', $this->t('The text must be at least 5 characters long.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $string = $form_state->getValue('item');
    $form_state->set('string', $string);
    $form_state->set('reversed_string', strrev($string));
    $form_state->setRebuild();
  }

  /**
   * Ajax callback for "Submit" button.
   *
   * This callback is called regardless of what happens in validation and
   * submission processing. It needs to return the content that will be used to
   * replace the DOM element identified by the '#ajax' properties 'wrapper' key.
   *
   * @return array
   *   Renderable array (the box element)
   */

  public function promptCallback(array &$form, FormStateInterface $form_state)
  {
    if ($form_state->hasAnyErrors()) {
      $renderer = \Drupal::service('renderer');
      $status_messages = ['#type' => 'status_messages'];
      $form['#prefix'] .= $renderer->renderRoot($status_messages);
    }
    return $form;
  }
}
