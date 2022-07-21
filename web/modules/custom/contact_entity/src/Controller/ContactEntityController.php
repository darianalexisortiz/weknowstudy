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
    $entity_type = 'node';
    $service_node = \Drupal::service('entity_type.manager')->getStorage($entity_type);
    $node_4 = $service_node->load(4);
    $nodes = \Drupal::entityTypeManager()->getStorage($entity_type)->loadMultiple([4, 11, 10]);
    $node = \Drupal::entityTypeManager()->getStorage('node')->create(['type' => 'vendor', 'title' => 'Test API']);
/*    $node->save(); */
    $build['node4'] = [
      '#type' => 'item',
      '#markup' => $this->t('Title node ID 4: ') . $node_4->get('title')->value,
    ];
    $titles_nodes = [];
    foreach ($nodes as $key => $value) {
      $titles_nodes[] = $value->get('title')->value;
    }

    $build['multiplenode'] = [
      '#type' => 'item',
      '#markup' => $this->t('Titles nodes IDs 4, 11 and 10: ' . implode(', ', $titles_nodes)),
    ];

    $query = \Drupal::entityQuery('node');
    $vendors_ids = $query
    ->condition('type', 'vendor')
    ->condition('status', 1)
    ->execute();

    foreach ($nodes as $key => $value) {
      $build['vendor' . $key] = [
        '#type' => 'item',
        '#markup' => $this->t('Label') . ' ' . $key . ': ' . $value->label(),
      ];
    }
    return $build;
  }

}
