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
/*     $entity_type = 'node';
    $node = \Drupal::service('entity_type.manager')->getStorage($entity_type);
    $node_4 = $service->load(4);
    $nodes = \Drupal::entityTypeManager()->getStorage($entity_type)->loadMultiple([4, 11, 10]);
    $node = \Drupal::entityTypeManager()->getStorage('node')->create(['type' => 'vendor', 'title' => 'Test API']);
    $node->save(); */
    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
