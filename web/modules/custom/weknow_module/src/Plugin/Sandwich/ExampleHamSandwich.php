<?php

namespace Drupal\weknow_module\Plugin\Sandwich;

use Drupal\weknow_module\SandwichPluginBase;

/**
 * Provides a ham sandwich.
 *
 * @Sandwich(
 *   id = "ham_sandwich",
 *   description = @Translation("Ham, mustard, rocket, sun-dried tomatoes."),
 *   calories = 426
 * )
 */
class ExampleHamSandwich extends SandwichPluginBase {

  /**
   * {inheritdoc}
   */
  public function order(array $extras) {
    $ingredients = array('ham, mustard', 'rocket', 'sun-dried tomatoes');
    $sandwich = array_merge($ingredients, $extras);
    return 'You ordered an ' . implode(', ', $sandwich) . ' sandwich. Enjoy!';
  }

}
