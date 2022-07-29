<?php

namespace Drupal\weknow_discover;

use Drupal\Core\Plugin\PluginBase;

/**
 * Default class used for weknow_discover_hooks plugins.
 */
class WeknowDiscoverHookDefault extends PluginBase implements WeknowDiscoverHookInterface {

  /**
   * {@inheritdoc}
   */
  public function label() {
    // The title from hook discovery may be a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

}
