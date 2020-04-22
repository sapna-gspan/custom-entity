<?php

namespace Drupal\content_entity_lw\Entity\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Routing\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a list controller for content_entity_example entity.
 *
 * @ingroup content_entity_lw
 */
class ContactListBuilder extends EntityListBuilder {


 

  /**
   * {@inheritdoc}
   *
   * Building the header and content lines for the contact list.
   *
   * Calling the parent::buildHeader() adds a column for the possible actions
   * and inserts the 'edit' and 'delete' links as defined for the entity type.
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['title'] = $this->t('Title');
    $header['startdate'] = $this->t('Start Date');
    $header['enddate'] = $this->t('End Date');
    $header['venue'] = $this->t('Venue');
    $header['description'] = $this->t('Description');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\content_entity_example\Entity\Contact */
    $row['id'] = $entity->id();
    $row['title'] = $entity->title->value;
    $row['startdate'] = $entity->startdate->value;
    $row['enddate'] = $entity->enddate->value;
    $row['venue'] = $entity->venue->value;
    $row['description'] = $entity->description->value;
    return $row + parent::buildRow($entity);
  }

}
