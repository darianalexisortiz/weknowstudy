<?php

namespace Drupal\weknow_discover\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines weknow_discover_annotation annotation object.
 *
 * @Annotation
 */
class WeknowDiscoverAnnotation extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The human-readable name of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $title;

  /**
   * The description of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $description;

}
