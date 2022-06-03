<?php
namespace Drupal\custom_layouts\Plugin\Layout;

use Drupal\Core\Layout\LayoutDefault;

/**
 * A layout from layout configuration.
 *
 * @Layout(
 *   id = "dynamic_layout",
 *   deriver = "Drupal\custom_layouts\Plugin\Deriver\DynamicLayoutDeriver"
 * )
 */
class DynamicLayout extends LayoutDefault
{
}
