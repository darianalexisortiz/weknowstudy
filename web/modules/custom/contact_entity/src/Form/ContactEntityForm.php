<?php

namespace Drupal\contact_entity\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the contact entity entity edit forms.
 */
class ContactEntityForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);

    $entity = $this->getEntity();

    $message_arguments = ['%label' => $entity->toLink()->toString()];
    $logger_arguments = [
      '%label' => $entity->label(),
      'link' => $entity->toLink($this->t('View'))->toString(),
    ];

    switch ($result) {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('New contact entity %label has been created.', $message_arguments));
        $this->logger('contact_entity')->notice('Created new contact entity %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The contact entity %label has been updated.', $message_arguments));
        $this->logger('contact_entity')->notice('Updated contact entity %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.contact_entity.canonical', ['contact_entity' => $entity->id()]);

    return $result;
  }

}
