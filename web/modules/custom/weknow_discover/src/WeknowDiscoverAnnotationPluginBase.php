<?php

namespace Drupal\weknow_discover;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for weknow_discover_annotation plugins.
 */
abstract class WeknowDiscoverAnnotationPluginBase extends PluginBase implements WeknowDiscoverAnnotationInterface {

  /**
   * {@inheritdoc}
   */
  public function label() {
    // Cast the label to a string since it is a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

}
