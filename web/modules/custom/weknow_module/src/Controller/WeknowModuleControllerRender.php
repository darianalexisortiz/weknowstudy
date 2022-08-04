<?php

namespace Drupal\weknow_module\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for weKnow module routes.
 */
class WeknowModuleControllerRender extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build()
  {
    $build['simple_text'] = [
      '#plain_text' => '<em>This is escaped</em>',
    ];
    $build['simple_markup'] = [
      '#markup' => '<p>' . $this->t('Hello world.') . '</p>',
    ];
    $build['extra_tags'] = [
      '#markup' => '<marquee>' . $this->t('Hello world.') . '</marquee>',
      // An array of tags to allow in addition to those already in the list
      // of allowed tags. Drupal\Component\Utility\Xss::$adminTags
      '#allowed_tags' => ['marquee'],
    ];
    $build['simple_extras'] = [
      // Note the addition of '#type' => 'markup' in this example compared to
      // the one above. Because #markup is such a commonly used element type, you
      // can exclude the '#type' => 'markup' line and it will be assumed
      // automatically if the '#markup' property is present.
      '#type' => 'markup',
      '#markup' => '<p>' . $this->t('This one adds a prefix and suffix, wrapping the item in a blockquote tag.') . '</p>',
      '#prefix' => '<blockquote>',
      '#suffix' => '</blockquote>',
    ];

    return $build;
  }
}
