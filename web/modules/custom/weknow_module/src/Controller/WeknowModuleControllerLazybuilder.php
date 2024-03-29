<?php

namespace Drupal\weknow_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Security\TrustedCallbackInterface;
use Drupal\user\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountInterface;

class WeknowModuleControllerLazybuilder extends ControllerBase implements TrustedCallbackInterface {

  /**
   * Current user.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $currentUser;

  /**
   * Constructs a new BlockController instance.
   *
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current user.
   */
  public function __construct(AccountInterface $current_user) {
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getModuleName() {
    return 'weknow_module';
  }

  /**
   * Examples of defining content using renderable arrays.
   */
  public function arrays() {
    // ...
    $build = array();

    // A #lazy_builder callback can be used to build a highly dynamic section of
    // a render array from scratch. This, combined with the use of placeholders,
    // allows the renderer to cache some, but not all, portions of a render
    // array. Without #lazy_builders, if any element in the render tree is
    // uncacheable the whole tree would need to be re-rendered every time.
    //
    // The general rendering flow is as follows:
    // - Check for cached version of output from previous rendering, if it
    //   exists replace any placeholders in the rendered output with their
    //   dynamic content as generated by the #lazy_builder callback, and return
    //   the resulting HTML.
    // - If no cached version exists render the array to HTML, when an element
    //   that can be placeholdered is encountered insert a placeholder, cache
    //   the HTML after rendering for next time, replace the placeholders with
    //   their dynamic content, and return the resulting HTML.
    //
    // This is especially noticeable when used in conjunction with modules like
    // Big Pipe which do rendering of a page in multiple passes vs. the default
    // single flush renderer.
    //
    // See \Drupal\block\BlockViewBuilder::viewMultiple() for an example from
    // core.
    $build['lazy_builder'] = [
      // Set the value of the #lazy_builder property to an array, the first key
      // of the array is the method, service, or function, to call in oder to
      // generate the dynamic data. The second argument is an array of any
      // arguments to pass to the callback. Arguments can be only primitive
      // types (string, bool, int, float, NULL).
      '#lazy_builder' => [
        static::class . '::lazyBuilder',
        [$this->currentUser->id(), 'Y-m-d'],
      ],
      // #lazy_builder callbacks can be used in conjunction with
      // #create_placeholder to tell the renderer that instead of simply calling
      // the #lazy_builder code right away, to instead insert a placeholder and
      // delay execution of the #lazy_builder code until it's needed.
      //
      // This is somewhat analogous to the way Drupal uses the PSR-4 autoloading
      // standard to "lazy" load PHP files that contain the definition of a
      // class only if, and when, that class is used.
      //
      // To force a element to use a placeholder set #create_placeholder to
      // TRUE.
      //
      // Preferably you would include #cache metadata (see above) and allow
      // the Render API to use that metadata to automatically determine based on
      // the existence of high-cardinality cache contexts in the subtree whether
      // or not the element should use a placeholder.
      '#create_placeholder' => TRUE,
    ];

    // ...

    return $build;
  }

  /**
   * Example #lazy_builder callback.
   *
   * Demonstrates the use of a #lazy_builder callback to build out a render
   * array that can be substituted into the parent array wherever the cacheable
   * placeholder exists.
   *
   * This method is called during the process of rendering the array generated
   * by \Drupal\render_example\Controller\RenderExampleController::arrays().
   *
   * @param int $user_id
   *   UID of the user currently viewing the page.
   * @param string $date_format
   *   Date format to use with \Drupal\Core\Datetime\DateFormatter::format().
   *
   * @return array
   *   A renderable array with content to replace the #lazy_builder placeholder.
   */
  public static function lazyBuilder($user_id, $date_format) {
    $account = User::load($user_id);

    $build = [
      'lazy_builder_welcome' => [
        '#markup' => '<p>' . \Drupal::translation()->translate('Your name is: @name', ['@name' => $account->getDisplayName()]) . '</p>',
      ],
      'lazy_builder_time' => [
        '#markup' => '<p>' . \Drupal::translation()->translate('The current time is @time', ['@time' => \Drupal::service('date.formatter')->format(REQUEST_TIME, 'custom', $date_format)]) . '</p>',
      ],
    ];

    // In order to demonstrate the use of lazy builders we use sleep here to
    // simulate an expensive request.
    sleep(3);
    return $build;
  }

  /**
   * {@inheritDoc}
   */
  public static function trustedCallbacks() {
    // For security reasons we need to declare which methods on this class are
    // safe for use as a callback.
    return ['lazyBuilder'];
  }

}
