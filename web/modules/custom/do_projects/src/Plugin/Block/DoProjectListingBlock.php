<?php

/**
 * @file
 * Contains \Drupal\do_projects\Plugin\Block\DoProjectListingBlock.
 */

namespace Drupal\do_projects\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'DoProjectListingBlock' block.
 *
 * @Block(
 *  id = "do_project_listing_block",
 *  admin_label = @Translation("Do project listing block"),
 * )
 */
class DoProjectListingBlock extends BlockBase {


  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    // The underscore library is already available via dependencies.
    // Make an http request to the drupal.org API.
    // https://www.drupal.org/api-d7/node.json?type=project_module&sort=field_download_count&direction=DESC
    // Pass the full JSON along to the page via drupalSettings.
    $do = file_get_contents(drupal_get_path('module', 'do_projects') .'/do_project.listing.json');
    $do_json = json_decode($do);

    $build['do_project_listing_block'] = array(
      '#markup' => 'Implement DoProjectListingBlock.',
      '#attached' => array(
        'library' => array(
          'do_projects/do_projects.projects'
        ),
        'drupalSettings' => array(
          'doProjects' => array(
            'projects' => $do_json
          )
        )
      )
    );

    return $build;
  }

}
