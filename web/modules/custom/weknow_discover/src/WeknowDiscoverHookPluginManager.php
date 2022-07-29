<?php

namespace Drupal\weknow_discover;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Plugin\Discovery\HookDiscovery;
use Drupal\Core\Plugin\Factory\ContainerFactory;

/**
 * Defines a plugin manager to deal with weknow_discover_hooks.
 *
 * @see \Drupal\weknow_discover\WeknowDiscoverHookDefault
 * @see \Drupal\weknow_discover\WeknowDiscoverHookInterface
 * @see plugin_api
 */
class WeknowDiscoverHookPluginManager extends DefaultPluginManager {

  /**
   * {@inheritdoc}
   */
  protected $defaults = [
    // The weknow_discover_hook id. Set by the plugin system based on the array key.
    'id' => '',
    // The weknow_discover_hook label.
    'label' => '',
    // The weknow_discover_hook description.
    'description' => '',
    // Default plugin class.
    'class' => 'Drupal\weknow_discover\WeknowDiscoverHookDefault',
  ];

  /**
   * Constructs WeknowDiscoverHookPluginManager object.
   *
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   */
  public function __construct(ModuleHandlerInterface $module_handler, CacheBackendInterface $cache_backend) {
    $this->factory = new ContainerFactory($this);
    $this->moduleHandler = $module_handler;
    $this->alterInfo('weknow_discover_hook_info');
    $this->setCacheBackend($cache_backend, 'weknow_discover_hook_plugins');
  }

  /**
   * {@inheritdoc}
   */
  protected function getDiscovery() {
    if (!isset($this->discovery)) {
      $this->discovery = new HookDiscovery($this->moduleHandler, 'weknow_discover_hook_info');
    }
    return $this->discovery;
  }

}
