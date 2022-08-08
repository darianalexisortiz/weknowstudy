<?php

namespace Drupal\weknow_module\Controller;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Returns responses for weKnow module routes.
 */
class WeknowModuleControllerRender extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {
    $current_user = \Drupal::currentUser();

    $build['simple_text'] = [
      '#plain_text' => '<em>This is escaped</em>',
    ];
    $build['simple_markup'] = [
      '#markup' => '<p>' . $this->t('Hello world.') . '</p>',
    ];
    $build['extra_tags'] = [
      '#markup' => '<marquee>' . $this->t('Hello world.') . '</marquee>',
      // An array of tags to allow in addition to those already in the list
      // of allowed tags. Drupal\Component\Utility\Xss::$adminTags
      '#allowed_tags' => ['marquee'],
    ];
    $build['simple_extras'] = [
      // Note the addition of '#type' => 'markup' in this example compared to
      // the one above. Because #markup is such a commonly used element type, you
      // can exclude the '#type' => 'markup' line and it will be assumed
      // automatically if the '#markup' property is present.
      '#type' => 'markup',
      '#markup' => '<p>' . $this->t('This one adds a prefix and suffix, wrapping the item in a blockquote tag.') . '</p>',
      '#prefix' => '<blockquote>',
      '#suffix' => '</blockquote>',
    ];
    $build['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#default_value' => isset($value) ? $value : 'Alice',
      '#attributes' => [
        'class' => ['name', 'custom-class'],
        'data-name' => isset($value) ? $value : 'Alice',
      ],
    ];
    $build['list'] = [
      '#theme' => 'item_list',
      '#items' => [
        $this->t('This is some text that should be put in a list'),
        $this->t('This is some more text that we need in the list'),
      ],
    ];
    $items = array();
    // A simple string item.
    $items[] = 'Simple string';

    // A simple string item as render array.
    $items[] = [
      '#markup' => 'Simple <span>#markup</span> string',
    ];

    // Set custom attributes for a list item.
    $items[] = [
      '#markup' => 'Custom item',
      '#wrapper_attributes' => array(
        'class' => array('custom-item-class'),
      ),
    ];

    // An item with a nested list.
    $items[] = [
      '#markup' => 'Parent item',
      'children' => [
        'Simple string child',
        [
          '#markup' => 'Second child item with custom attributes',
          '#wrapper_attributes' => [
            'class' => array('custom-child-item-class'),
          ],
        ],
      ],
    ];

    $build['theme_element'] = [
      '#theme' => 'item_list',
      '#title' => $this->t('Example of using #theme item_list'),
      '#list_type' => 'ol',
      '#items' => $items,
    ];

    $build['table'] = [
      '#type' => 'table',
      '#caption' => $this->t('Our favorite colors.'),
      '#header' => [$this->t('Name'), $this->t('Favorite color')],
      '#rows' => [
        [$this->t('Amber'), $this->t('teal')],
        [$this->t('Addi'), $this->t('green')],
        [$this->t('Blake'), $this->t('#063')],
        [$this->t('Enid'), $this->t('indigo')],
        [$this->t('Joe'), $this->t('green')],
      ],
      '#description' => $this->t('Example of using #type.'),
    ];

    $rows = [
      // Simple row.
      ['Cell 1', 'Cell 2', 'Cell 3'],
      // Row with attributes on the row and some of its cells.
      ['data' => ['Cell 1', ['data' => 'Cell 2', 'colspan' => 2]], 'class' => ['funky']],
    ];
    $colgroup = [
      // <colgroup> with one <col> element.
      [
        [
          // Attribute for the <col> element.
          'class' => ['funky'],
        ],
      ],
      // <colgroup> with attributes and inner <col> elements.
      [
        'data' => [
          [
            // Attribute for the <col> element.
            'class' => ['funky'],
          ],
        ],
        // Attribute for the <colgroup> element.
        'class' => ['jazzy'],
      ],
    ];
    $header = ['one', 'two', 'three'];
    $rows = [[1, 2, 3], [4, 5, 6], [7, 8, 9]];
    $attributes = [];
    $caption = NULL;
    $colgroups = $colgroup;
    $build['table2'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#attributes' => $attributes,
      '#caption' => $caption,
      '#colgroups' => $colgroups,
      '#sticky' => FALSE,
    ];
    $build['tabledrag'] = [
      '#type' => 'table',
      '#id' => 'draggable-table',
      '#caption' => $this->t('Our favorite colors.'),
      '#header' => [
        $this->t('Name'),
        $this->t('Favorite color'),
        $this->t('Weight'),
      ],
      // #tabledrag can be used on #table elements in the context of a form.
      // When enabled, the table will be rendered with a drag & drop interface
      // that can be used to re-order elements within the table. Any changes you
      // make to the order will be made available to your validation and submit
      // handlers via values in $form_state->getValues().
      //
      // The #tabledrag property contains an array of options passed to the
      // drupal_attach_tabledrag() function. These options are used to generate
      // the necessary JavaScript settings to configure the tableDrag behavior
      // for this table.
      //
      // For more in-depth documentation of the options below see
      // drupal_attach_tabledrag().
      '#tabledrag' => [
        [
          // The HTML ID of the table to make draggable. See #id above.
          'table_id' => 'draggable-table',
          // The action to be done on the form item. Either 'match' 'depth', or
          // 'order'.
          'action' => 'order',
          // String describing where the "action" option should be performed.
          // Either 'parent', 'sibling', 'group', or 'self'.
          'relationship' => 'sibling',
          // Class name applied on all related form elements for this action.
          // See below.
          'group' => 'table-order-weight',
        ],
      ],
      // Rather than defining the values to insert into the table using the
      // #rows property you can define each row as a sub element of the table
      // render array. And each column in the row as a sub element of the row
      // array.
      [
        // Apply the 'draggable' class to each row in the table that you want to
        // be made draggable.
        '#attributes' => ['class' => ['draggable']],
        // The first two columns are render arrays that display a string of
        // text.
        'name' => ['#plain_text' => $this->t('Amber')],
        'color' => ['#plain_text' => $this->t('teal')],
        // The third column is a #weight form field.
        'weight' => [
          '#type' => 'weight',
          '#title_display' => 'invisible',
          // Set the default value to whatever the current weight, or order, of
          // the element that this row represents is.
          '#default_value' => 1,
          // Set a class on each field that represents the value to manipulate
          // when the table is reordered. The name of this class should match
          // the value used for the 'group' argument in the #tabledrag property
          // above.
          '#attributes' => ['class' => ['table-order-weight']],
        ],
      ],
      // The rest of this array is additional rows so there is some data in the
      // table to drag around.
      [
        '#attributes' => ['class' => ['draggable']],
        'name' => ['#plain_text' => $this->t('Addi')],
        'color' => ['#plain_text' => $this->t('green')],
        'weight' => ['#type' => 'weight', '#title_display' => 'invisible', '#default_value' => 2, '#attributes' => ['class' => ['table-order-weight']]],
      ],
      [
        '#attributes' => ['class' => ['draggable']],
        'name' => ['#plain_text' => $this->t('Blake')],
        'color' => ['#plain_text' => $this->t('#063')],
        'weight' => ['#type' => 'weight', '#title_display' => 'invisible', '#default_value' => 3, '#attributes' => ['class' => ['table-order-weight']]],
      ],
      [
        '#attributes' => ['class' => ['draggable']],
        'name' => ['#plain_text' => $this->t('Enid')],
        'color' => ['#plain_text' => $this->t('indigo')],
        'weight' => ['#type' => 'weight', '#title_display' => 'invisible', '#default_value' => 4, '#attributes' => ['class' => ['table-order-weight']]],
      ],
      [
        '#attributes' => ['class' => ['draggable']],
        'name' => ['#plain_text' => $this->t('Joe')],
        'color' => ['#plain_text' => $this->t('green')],
        'weight' => ['#type' => 'weight', '#title_display' => 'invisible', '#default_value' => 5, '#attributes' => ['class' => ['table-order-weight']]],
      ],
    ];
    $build['marqueeright'] = [
      '#theme' => 'render_example_marquee',
      '#content' => $this->t('Hello world toward the right!'),
      '#attributes' => [
        'class' => ['my-marquee-element-right'],
        'direction' => 'right',
      ],
    ];
    $build['marqueeleft'] = [
      '#theme' => 'render_example_marquee',
      '#content' => $this->t('Hello world toward the left!'),
      '#attributes' => [
        'class' => ['my-marquee-element-left'],
        'direction' => 'left',
      ],
    ];

    $build['awesome'] = [
      '#type' => 'marquee',
      '#theme' => 'render_example_marquee',
      '#content' => 'Whoa cool, a marquee!',
      '#attributes' => [
        'scrollamount' => 'random',
        'direction' => 'right',
        'scrolldelay' => 5
      ],
      '#pre_render' => array(
        array('\Drupal\weknow_module\Element\Marquee', 'preRenderMarquee'),
      ),
    ];

    $build['node_add_dialog'] = [
      '#type' => 'link',
      '#title' => $this->t('Some text'),
      // $this->getDestinationArray() is used to create a ?destination= style query
      // string so that after a form is submitted in the modal you return to the
      // current page.
      '#url' => Url::fromRoute('node.add', ['node_type' => 'recipe'], ['query' => $this->getDestinationArray()]),
      '#options' => [
        'attributes' => [
          // Adding the class 'use-ajax' tells the Drupal AJAX system to process
          // this link, and bind an event handler so that when someone clicks on the
          // link we make an AJAX request instead of just linking to the URL
          // directly.
          'class' => ['use-ajax'],
          // This data attribute tells Drupal to use the ModalRenderer
          // (application/vnd.drupal-modal) to handle this particular request rather
          // then the normal MainContentRenderer.
          'data-dialog-type' => 'modal',
          // This contains settings to pass to the Drupal modal dialog JavaScript,
          // in this case setting the width of the modal window that'll be opened.
          'data-dialog-options' => Json::encode(['width' => 700]),
        ],
      ],
      // In order for the above classes and data attributes to do anything we also
      // need to attach the relevant JavaScript.
      '#attached' => ['library' => ['core/drupal.dialog.ajax']],
    ];

    $build['titlelinks'] = [
      '#type' => 'html_tag',
      '#tag' => 'h2',
      '#value' => 'Links',
    ];

    $build['link1routerinternal'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#prefix' => 'URL internal',
      '#value' => Url::fromRoute('weknow_module.render')->toString(),
    ];

    $build['link1routerexternal'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#prefix' => 'URL external',
      '#value' => Url::fromUri('http://example.com')->toString(),
    ];

    // Link to an internal path defined by a route.
    $link2internal = Link::createFromRoute('This is a link', 'entity.node.canonical', ['node' => 42]);

    // Link to an external URI.
    $link2external = Link::fromTextAndUrl('This is a link', Url::fromUri('http://example.com'));

    // Get output as a render array. Preferred.
    $build['link2internal'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#prefix' => 'Link internal',
      '#value' => $link2internal->toString(),
    ];

    $build['link2routerinternalarray'] = $link2internal->toRenderable();
    // Get output as a string.
    $build['link2routerexternal'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#prefix' => '<br>Link external',
      '#value' => $link2external->toString(),
    ];
    $build['link3'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#prefix' => 'Example using an external URI',
      '#value' => Url::fromUri('https://drupal.org/about')->toString(),
    ];
    $build['link4'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#prefix' => 'Example using an un-routed internal URI',
      '#value' => Url::fromUri('base:/robots.txt')->toString(),
    ];
    $build['link5'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#prefix' => 'Example using user-input for an internal path',
      '#value' => Url::fromUri('internal:/weknow-module/render')->toString(),
    ];
    $build['link6'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#prefix' => 'Example using entity scheme',
      '#value' => Url::fromUri('entity:node/12')->toString(),
    ];
    $build['link7'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#prefix' => 'From route with additional parameters',
      '#value' =>  Url::fromRoute('entity.node.canonical', ['node' => 12])->toString(),
    ];
    $options = ['fragment' => 'feedback'];
    $build['link8'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#prefix' => 'Example linking to a page with a fragment appended',
      '#value' =>  Url::fromRoute('entity.node.canonical', ['node' => 12], $options)->toString(),
    ];
    $options2 = ['query' => ['name' => 'joe', 'hats' => 'no']];
    $build['link9'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#prefix' => 'Example linking to a page with a fragment appended',
      '#value' =>  Url::fromRoute('entity.node.canonical', ['node' => 12], $options2)->toString(),
    ];
    $build['link10'] = [
      '#type' => 'link',
      '#prefix' => 'Render a link ',
      '#title' => $this->t('A link to example.com'),
      '#url' => Url::fromUri('https://example.com'),
      '#suffix' => '<br>',
    ];
    $build['link11'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#prefix' => 'Examples of creating links',
      '#value' =>  Link::createFromRoute('Text of the link', 'entity.node.canonical', ['node' => 12])->toString(),
    ];
    $urldrupalabout = Url::fromUri('https://drupal.org/about');

    $build['link12'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#prefix' => 'Examples of creating links',
      '#value' =>  Link::fromTextAndUrl('Text to display', $urldrupalabout)->toString(),
    ];
    $build['link13'] = Link::fromTextAndUrl('Text to display 2', $urldrupalabout)->toRenderable();
    $build['link13']['#suffix'] = '<br>';
    $build['link13']['#attributes'] = ['class' => ['my-link'], 'data-id' => 'uniqueid'];

    $linkn = Link::fromTextAndUrl('This is a link', Url::fromRoute('entity.node.canonical', ['node' => 12]));
    $build['link14'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#prefix' => 'Examples of creating links',
      '#value' => t('You can click this %link', ['%link' => $linkn->toString()]),
    ];
    return $build;
  }

}
