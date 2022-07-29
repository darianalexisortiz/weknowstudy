<?php

namespace Drupal\weknow_discover;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * WeknowDiscoverAnnotation plugin manager.
 */
class WeknowDiscoverAnnotationPluginManager extends DefaultPluginManager {

  /**
   * Constructs WeknowDiscoverAnnotationPluginManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct(
      'Plugin/WeknowDiscoverAnnotation',
      $namespaces,
      $module_handler,
      'Drupal\weknow_discover\WeknowDiscoverAnnotationInterface',
      'Drupal\weknow_discover\Annotation\WeknowDiscoverAnnotation'
    );
    $this->alterInfo('weknow_discover_annotation_info');
    $this->setCacheBackend($cache_backend, 'weknow_discover_annotation_plugins');
  }

}
