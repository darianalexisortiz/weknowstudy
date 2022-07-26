<?php

namespace Drupal\weknow_module;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Sandwich plugin manager.
 */
class SandwichPluginManager extends DefaultPluginManager {

  /**
   * Constructs SandwichPluginManager object.
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
      'Plugin/Sandwich',
      $namespaces,
      $module_handler,
      'Drupal\weknow_module\SandwichInterface',
      'Drupal\weknow_module\Annotation\Sandwich'
    );
    $this->alterInfo('sandwich_info');
    $this->setCacheBackend($cache_backend, 'sandwich_plugins');
  }

}
