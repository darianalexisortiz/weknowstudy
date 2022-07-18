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
            'use-ajax',
          ],
          'data-dialog-type' => 'dialog',
          'data-dialog-options' => json_encode(
              [
              'width' => 800,
              'height' => 500,
              ]
          ),
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
            'use-ajax',
          ],
          'data-dialog-type' => 'modal',
            'data-dialog-options' => json_encode(
                [
                'width' => 800,
                'height' => 500,
                ]
            ),
        ],
        '#url' => \Drupal\Core\Url::fromRoute('weknow_module.submit_driven'),
        ];
        $build['#attached']['library'][] = 'weknow_module/weknow_module';

        return [
          '#theme' => 'weknow',
          '#form_link1' => $build['submit_driven'],
          '#form_link2' => $build['dependent_dropdown'],
        ];
    }

}
