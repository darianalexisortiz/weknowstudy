<?php

namespace Drupal\weknow_module\Annotation;

/**
 * Defines a Sandwich annotation object.
 *
 * @see \Drupal\plugin_type_example\SandwichPluginManager
 * @see plugin_api
 *
 * Note that the "@ Annotation" line below is required and should be the last
 * line in the docblock. It's used for discovery of Annotation definitions.
 *
 * @Annotation
 */

use Drupal\Component\Annotation\Plugin;

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * A brief, human readable, description of the sandwich type.
   *
   * This property is designated as being translatable because it will appear
   * in the user interface. This provides a hint to other developers that they
   * should use the Translation() construct in their annotation when declaring
   * this property.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $description;

  /**
   * The number of calories per serving of this sandwich type.
   *
   * This property is a float value, so we indicate that to other developers
   * who are writing annotations for a Sandwich plugin.
   *
   * @var int
   */
  public $calories;

}
