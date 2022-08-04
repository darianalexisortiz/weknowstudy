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
  public function build() {
    $current_user = \Drupal::currentUser();

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
    $build['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#default_value' => isset($value) ? $value : 'Alice',
      '#attributes' => [
        'class' => ['name', 'custom-class'],
        'data-name' => isset($value) ? $value : 'Alice',
      ],
    ];
    $build['list'] = [
      '#theme' => 'item_list',
      '#items' => [
        $this->t('This is some text that should be put in a list'),
        $this->t('This is some more text that we need in the list'),
      ],
    ];
    $items = array();
    // A simple string item.
    $items[] = 'Simple string';

    // A simple string item as render array.
    $items[] = [
      '#markup' => 'Simple <span>#markup</span> string',
    ];

    // Set custom attributes for a list item.
    $items[] = [
      '#markup' => 'Custom item',
      '#wrapper_attributes' => array(
        'class' => array('custom-item-class'),
      ),
    ];

    // An item with a nested list.
    $items[] = [
      '#markup' => 'Parent item',
      'children' => [
        'Simple string child',
        [
          '#markup' => 'Second child item with custom attributes',
          '#wrapper_attributes' => [
            'class' => array('custom-child-item-class'),
          ],
        ],
      ],
    ];

    $build['theme_element'] = [
      '#theme' => 'item_list',
      '#title' => $this->t('Example of using #theme item_list'),
      '#list_type' => 'ol',
      '#items' => $items,
    ];
    return $build;
  }
}
