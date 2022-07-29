<?php

namespace Drupal\weknow_discover;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Plugin\Discovery\YamlDiscovery;
use Drupal\Core\Plugin\Factory\ContainerFactory;

/**
 * Defines a plugin manager to deal with weknow_discover_yamls.
 *
 * Modules can define weknow_discover_yamls in a MODULE_NAME.weknow_discover_yamls.yml file contained
 * in the module's base directory. Each weknow_discover_yaml has the following structure:
 *
 * @code
 *   MACHINE_NAME:
 *     label: STRING
 *     description: STRING
 * @endcode
 *
 * @see \Drupal\weknow_discover\WeknowDiscoverYamlDefault
 * @see \Drupal\weknow_discover\WeknowDiscoverYamlInterface
 * @see plugin_api
 */
class WeknowDiscoverYamlPluginManager extends DefaultPluginManager {

  /**
   * {@inheritdoc}
   */
  protected $defaults = [
    // The weknow_discover_yaml id. Set by the plugin system based on the top-level YAML key.
    'id' => '',
    // The weknow_discover_yaml label.
    'label' => '',
    // The weknow_discover_yaml description.
    'description' => '',
    // Default plugin class.
    'class' => 'Drupal\weknow_discover\WeknowDiscoverYamlDefault',
  ];

  /**
   * Constructs WeknowDiscoverYamlPluginManager object.
   *
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   */
  public function __construct(ModuleHandlerInterface $module_handler, CacheBackendInterface $cache_backend) {
    $this->factory = new ContainerFactory($this);
    $this->moduleHandler = $module_handler;
    $this->alterInfo('weknow_discover_yaml_info');
    $this->setCacheBackend($cache_backend, 'weknow_discover_yaml_plugins');
  }

  /**
   * {@inheritdoc}
   */
  protected function getDiscovery() {
    if (!isset($this->discovery)) {
      $this->discovery = new YamlDiscovery('weknow_discover_yamls', $this->moduleHandler->getModuleDirectories());
      $this->discovery->addTranslatableProperty('label', 'label_context');
      $this->discovery->addTranslatableProperty('description', 'description_context');
    }
    return $this->discovery;
  }

}
