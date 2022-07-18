<?php

namespace Drupal\weknow_module\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for AweKnow module routes.
 */
class WeknowModuleController extends ControllerBase
{

    /**
     * Builds the response.
     */
    public function build()
    {

        $build['content'] = [
        '#type' => 'item',
        '#markup' => $this->t('Examples forms'),
        ];
        $build['dependent_dropdown'] = [
        '#title' => $this
        ->t('Dependent Dropdown'),
        '#type' => 'link',
        '#attributes' => [
          'class' => [
            'link-weKnow',
          ],
        ],
        '#url' => \Drupal\Core\Url::fromRoute('weknow_module.dependent_dropdown'),
        ];

        $build['submit_driven'] = [
        '#title' => $this
        ->t('Submit Driven'),
        '#type' => 'link',
        '#attributes' => [
          'class' => [
            'link-weKnow',
          ],
        ],
        '#url' => \Drupal\Core\Url::fromRoute('weknow_module.submit_driven'),
        ];
        $build['#attached']['library'][] = 'weknow_module/weknow_module';

        return $build;
    }

}
