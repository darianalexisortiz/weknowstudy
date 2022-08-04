<?php

namespace Drupal\weknow_module\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for weKnow module routes.
 */
class WeknowModuleControllerCache extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build()
  {
    $current_user = \Drupal::currentUser();

    $build['cache1'] = [
      '#value' => $this->t('Drupal is the coolest'),
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#cache' => [
        'max-age' => \Drupal\Core\Cache\Cache::PERMANENT,
      ],
    ];
    $build['cache2'] = [
      '#value' => $this->t('Hello, it is currently @date_time', ['@date_time' => date('H:i')]),
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#cache' => [
        // Cache for 120 seconds and then invalidate.
        'max-age' => 120,
      ],
    ];
    $build['cache3'] = [
      '#value' => $this->t('Hello %name', ['%name' => $current_user->getAccountName()]),
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#cache' => [
        // The "current user" depends on the request, so we use the 'user' context
        // which tells Drupal to vary by user for this element.
        'context' => ['user'],
        // We also need to indicate that we want to update this if the user edits
        // their name, so we add the appropriate tags so that Drupal can invalidate
        // this element if the user entity changes.
        //
        // In this case the $current_user object is an instance of AccountInterface
        // which is not actually a complete User entity object. So we need to first
        // load the complete entity, and then call the getCacheTags() method.
        'tags' => \Drupal\user\Entity\User::load($current_user->id())->getCacheTags(),
      ],
    ];

    $build['cache4'] = [
      '#value' => $this->t('Content pulled from external API'),
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#cache' => [
        'keys' => ['custom_api_query', 'parameter_1', 'parameter_2'],
        'max-age' => 120,
      ],
    ];

/*     $build['lazy1'] = [
      '#lazy_builder' => [
        // Function or method to call.
        $this::class . '::lazyDateFormat',
        ['Y-m-d']
      ]
    ]; */

    return $build;
  }
}
