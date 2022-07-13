<?php

namespace Drupal\react_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "react_block_example",
 *   admin_label = @Translation("React Block"),
 *   category = @Translation("React Block")
 * )
 */
class ExampleBlock extends BlockBase
{

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $build['content'] = [
            //'#markup' => $this->t('It worksa!'),
            '#markup' => '<div id="react-app"></div>',
            /* '#attached' => [
                'library' => [
                    'react_block/react_block'
                ]
            ] */
        ];
        return $build;
    }
}
