<?php

namespace Drupal\weknow_discover;

/**
 * Interface for weknow_discover_annotation plugins.
 */
interface WeknowDiscoverAnnotationInterface {

  /**
   * Returns the translated plugin label.
   *
   * @return string
   *   The translated title.
   */
  public function label();

}
