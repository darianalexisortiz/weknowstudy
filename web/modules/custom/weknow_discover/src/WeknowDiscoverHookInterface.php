<?php

namespace Drupal\weknow_discover;

/**
 * Interface for weknow_discover_hook plugins.
 */
interface WeknowDiscoverHookInterface {

  /**
   * Returns the translated plugin label.
   *
   * @return string
   *   The translated title.
   */
  public function label();

}
