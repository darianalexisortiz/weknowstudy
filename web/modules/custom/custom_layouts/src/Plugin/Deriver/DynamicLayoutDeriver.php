<?php

namespace Drupal\custom_layouts\Plugin\Deriver;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\custom_layouts\Plugin\Layout\DynamicLayout;
use Drupal\Core\Layout\LayoutDefinition;

/**
 * Makes a dynamic layout for each layout config entity.
 */
class DynamicLayoutDeriver extends DeriverBase
{

    /**
     * {@inheritdoc}
     */
    public function getDerivativeDefinitions($base_plugin_definition)
    {
        $config = \Drupal::config('custom_layouts.settings');
        $config = $config->get('layouts');
        if (!is_array($config)) {
            return;
        }
        foreach ($config as $key => $layout) {
            // Here we fill in any missing keys on the layout annotation.
            $this->derivatives[$key] = new LayoutDefinition(
                [
                'class' => DynamicLayout::class,
                'label' => $layout['label'],
                'category' => $layout['category'],
                'regions' => $this->getRegions($layout['columns']),
                'template' => $this->getTemplate($layout['columns']),
                'icon_map' => $this->getIcon($layout['columns']),
                ]
            );
        }

        return $this->derivatives;
    }

    /**
     * Helper function to get icon of the layout based on the passed columns value.
     *
     * @param string $columns
     *    value of columns passed through the configuration.
     *
     * @return array
     *    array of icon definition.
     */
    protected function getIcon($columns)
    {
        switch ($columns) {
        case 'two_cols':
            return [['first', 'second']];
        case 'three_cols':
            return [['first', 'second', 'third']];
        case 'four_cols':
            return [['first', 'second', 'third', 'fourth']];
        }
    }

    /**
     * Helper function to get regions by columns value.
     *
     * @param string $columns
     *    value of columns passed through the configuration.
     *
     * @return array
     *    array of regions.
     */
    protected function getRegions($columns)
    {
        switch ($columns) {
        case 'two_cols':
            return ['first' => ['label' => 'First'],
                'second' => ['label' => 'Second'],];
        case 'three_cols':
            return ['first' => ['label' => 'First'],
                'second' => ['label' => 'Second'],
                'third' => ['label' => 'Third'],];
        case 'four_cols':
            return ['first' => ['label' => 'First'],
                'second' => ['label' => 'Second'],
                'third' => ['label' => 'Third'],
                'fourth' => ['label' => 'Fourth'],];
        }
    }

    /**
     * Helper function to get template based on the columns value.
     *
     * @param string $columns
     *    value of columns passed through the configuration.
     *
     * @return string
     *    path to the template file.
     */
    protected function getTemplate($columns)
    {
        $module_handler = \Drupal::service('module_handler');
        $module_path = $module_handler->getModule('custom_layouts')->getPath();
        switch ($columns) {
        case 'two_cols':
            return $module_path . '/templates/layouts/custom-two-col';
        case 'three_cols':
            return $module_path . '/templates/layouts/custom-three-col';
        case 'four_cols':
            return $module_path . '/templates/layouts/custom-four-col';
        }
    }

}
