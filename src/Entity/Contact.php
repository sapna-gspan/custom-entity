<?php

namespace Drupal\content_entity_lw\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\content_entity_lw\ContactInterface;
use Drupal\user\UserInterface;
use Drupal\Core\Entity\EntityChangedTrait;

/**
 * Defines the ContentEntityExample entity.
 *
 * @ingroup content_entity_lw
 *
 * [...]
 * 
 *  The following annotation is the actual definition of the entity type which
 *  is read and cached. Don't forget to clear cache after changes.
 * 
 * @ContentEntityType(
 *   id = "content_entity_lw_contact",
 *   label = @Translation("Contact entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\content_entity_lw\Entity\Controller\ContactListBuilder",
 *     "form" = {
 *       "add" = "Drupal\content_entity_lw\Form\ContactForm",
 *       "edit" = "Drupal\content_entity_lw\Form\ContactForm",
 *       "delete" = "Drupal\content_entity_lw\Form\ContactDeleteForm",
 *     },
 *     "access" = "Drupal\content_entity_lw\ContactAccessControlHandler",
 *   },
 *   list_cache_contexts = { "user" },
 *   base_table = "contact",
 *   admin_permission = "administer content_entity_lw entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/content_entity_lw_contact/{content_entity_lw_contact}",
 *     "edit-form" = "/content_entity_lw_contact/{content_entity_lw_contact}/edit",
 *     "delete-form" = "/contact/{content_entity_lw_contact}/delete",
 *     "collection" = "/content_entity_lw_contact/list"
 *   },
 *   field_ui_base_route = "content_entity_lw.contact_settings",
 * )
 */

class Contact extends ContentEntityBase implements ContactInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   *
   * When a new entity instance is added, set the user_id entity reference to
   * the current user as the creator of the instance.
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   *
   * Define the field properties here.
   *
   * Field name, type and size determine the table structure.
   *
   * In addition, we can define how the field and its content can be manipulated
   * in the GUI. The behaviour of the widgets used can be determined here.
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Contact entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Contact entity.'))
      ->setReadOnly(TRUE);

    // Name field for the contact.
    // We set display options for the view as well as the form.
    // Users with correct privileges can change the view and edit configuration.
    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Contact entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      // Set no default value.
      ->setDefaultValue(NULL)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('view', TRUE);

      $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Name'))
      ->setDescription(t('The description of the Contact entity.'))
      // Set no default value.
      ->setDefaultValue(NULL)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -7,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['venue'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Venue'))
      ->setDescription(t('The venue of the Contact entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      // Set no default value.
      ->setDefaultValue(NULL)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('view', TRUE);

      $fields['startdate'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('StartDate'))
      ->setDescription(t('The start date of the Contact entity.'))
      // Set no default value.
      ->setDefaultValue(NULL)
      ->setDisplayConfigurable('view', TRUE);

      $fields['enddate'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('EndDate'))
      ->setDescription(t('The end date of the Contact entity.'))
      // Set no default value.
      ->setDefaultValue(NULL)
      ->setDisplayConfigurable('view', TRUE);

    // Owner field of the contact.
    // Entity reference field, holds the reference to the user object.
    // The view shows the user name field of the user.
    // The form presents a auto complete field for the user name.

    // Role field for the contact.
    // The values shown in options are 'administrator' and 'user'.


    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language code'))
      ->setDescription(t('The language code of ContentEntityExample entity.'));
    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }
}