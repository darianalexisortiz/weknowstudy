<?php

namespace Drupal\weknow_module\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for AweKnow module routes.
 */
class WeknowModuleControllerTranslate extends ControllerBase {

    /**
     * Builds the response.
     */
    public function build()
    {
        $user = \Drupal::currentUser();
        $build['t1'] = [
          '#type' => 'html_tag',
          '#tag' => 'p',
          '#value' => t('User name: @name', array('@name' => $user->getDisplayName())),
        ];
        $build['t2'] = [
          '#type' => 'html_tag',
          '#tag' => 'p',
          '#value' => t('Hello @name, welcome back!', array('@name' => $user->getDisplayName())),
        ];
        $build['t3'] = [
          '#type' => 'html_tag',
          '#tag' => 'p',
          '#value' => t('The user path is in %path.', array('%path' => $user->getDisplayName())),
        ];
        $build['t4'] = [
          '#type' => 'html_tag',
          '#tag' => 'p',
          '#value' => t('Hello <a href=":url">@name</a>', array(':url' => 'http://example.com', '@name' => $user->getDisplayName())),
        ];


        return $build;
    }

}
