<?php

namespace Drupal\weknow_discover;

use Drupal\Core\Plugin\PluginBase;

/**
 * Default class used for weknow_discover_yamls plugins.
 */
class WeknowDiscoverYamlDefault extends PluginBase implements WeknowDiscoverYamlInterface {

  /**
   * {@inheritdoc}
   */
  public function label() {
    // The title from YAML file discovery may be a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

}
