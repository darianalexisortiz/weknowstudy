<?php

namespace Drupal\contact_entity\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Contact entity routes.
 */
class ContactEntityController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
