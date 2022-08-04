<?php

namespace Drupal\weknow_module\Controller;

use Drupal\Core\Controller\ControllerBase;

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
    return $build;
  }
}
