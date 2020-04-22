<?php

namespace Drupal\content_entity_lw\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the content_entity_lw entity edit forms.
 *
 * @ingroup content_entity_lw
 */
class ContactForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'event_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'event.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state,$content_entity_lw_contact = NULL) {
    if (isset($content_entity_lw_contact)) {
      $this->id = $content_entity_lw_contact;
      $contact_entity = \Drupal::entityTypeManager()->getStorage('content_entity_lw_contact')->load($content_entity_lw_contact);
    }
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => isset($content_entity_lw_contact) ? $contact_entity->title:'',
    ];
    $form['startdate'] = [
      '#title' => t('Start Date'),
      '#type' => 'date',
      '#default_value' => isset($content_entity_lw_contact) ? $contact_entity->startdate->value:
      array(
        'month' => format_date(time(), 'custom', 'n'), 
        'day' => format_date(time(), 'custom', 'j'), 
        'year' => format_date(time(), 'custom', 'Y'),
      ),
    ];
    $form['enddate'] = [
      '#title' => t('End Date'),
      '#type' => 'date',
     '#default_value' => isset( $content_entity_lw_contact) ? $contact_entity->enddate->value:
     array(
        'month' => format_date(time(), 'custom', 'n'), 
        'day' => format_date(time(), 'custom', 'j'), 
        'year' => format_date(time(), 'custom', 'Y'),
      ),
    ];
    $form['venue'] = [
      '#type' => 'textfield',
      '#title' => $this->t('venue'),
      '#default_value' => isset( $_GET['id']) ? $contact_entity->venue:'',
    ];
    $form['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#default_value' => isset( $content_entity_lw_contact) ? $contact_entity->description->value:'',
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    if (isset($this->id)) {
      $id = $this->id;
      $contact_entity = \Drupal::entityTypeManager()->getStorage('content_entity_lw_contact')->load($id);
      $contact_entity->title = $form_state->getValue('title');
      $contact_entity->startdate = $form_state->getValue('startdate');
      $contact_entity->enddate = $form_state->getValue('enddate');
      $contact_entity->description = $form_state->getValue('description');
       // An array with taxonomy terms.
       $contact_entity->venue = $form_state->getValue('venue');
     $contact_entity->save();
    }
    else{
      $new= \Drupal::entityTypeManager()->getStorage('content_entity_lw_contact')->create([
        'title' => $form_state->getValue('title'),
        'startdate' => $form_state->getValue('startdate'),
        'enddate' => $form_state->getValue('enddate'),
         'description' => $form_state->getValue('description'),
         // An array with taxonomy terms.
         'venue' => $form_state->getValue('venue'),
       ]);
       $new->save();
       parent::submitForm($form, $form_state);
    }

    

  }

}
