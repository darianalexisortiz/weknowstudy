<?php
/**
 * Respond to contact entity view count being incremented.
 *
 * This hooks allows modules to respond whenever the total number of times the
 * current user has viewed a specific contact entity during their current session is
 * increased.
 *
 * @param int $current_count
 *   The number of times that the current user has viewed the contact entity during this
 *   session.
 * @param \Drupal\contact_entity\ContactEntityInterface $entity
 *   The contact entity being viewed.
 */
function hook_contact_entity_count_incremented($current_count, \Drupal\contact_entity\ContactEntityInterface $entity) {
  // If this is the first time the user has viewed this node we display a
  // message letting them know.
  if ($current_count === 1) {
    $messenger = \Drupal::messenger();
    $messenger->addStatus(t('This is the first time you have viewed the contact entity %title.', array('%title' => $entity->label())));
  }
}
/**
 * @param int $current_count
 *   The number of times that the current user has viewed the contact entity during this
 *   session.
 * @param \Drupal\contact_entity\ContactEntityInterface $entity
 *   The contact entity being viewed.
 */
function hook_contact_entity_count_incremented_alter($current_count) {
  $current_counts[] = $current_counts[1] - 5;
}
