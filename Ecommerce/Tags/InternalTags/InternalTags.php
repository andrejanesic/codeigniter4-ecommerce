<?php

namespace Ecommerce\Tags\InternalTags;

use Ecommerce\Tags\TagInterface;
use Ecommerce\Tags\TagModel;
use Config\Services;
use Ecommerce\Observer\IEvent;
use Ecommerce\Observer\IPublisher;

class InternalTags implements TagInterface {

  use IPublisher;

  /**
   * Adds tag to contact. If ID is null, updates the contact, then refreshes.
   *
   * @param string $value Tag value.
   * @return void
   */
  public function addTag(string $value): void {
    $contact = Services::contact()->getContact();
    if ($contact == null) return;

    if ($contact->getId() == null) {
      if ($contact->isDirty()) $contact->update();
      $contact->refresh();
    }
    if ($contact->getId() == null) return;

    $data = [
      'contact_id' => $contact->getId(),
      'value' => $value
    ];

    // check if tag already exists
    $tm = new TagModel();
    $exist = $tm->asArray()->where($data)->first();

    // if tag doesn't exist, add it
    if (!$exist) {
      $id = $tm->insert($data, true);

      if ($id !== false) {
        // publish the event
        $this->publish(
          new class($data) implements IEvent {
            public function __construct($data) {
              $this->data = $data;
            }

            public function code(): int {
              return IEvent::EVENT_TAG_ADD;
            }

            public function data() {
              return $this->data;
            }
          }
        );
      }
    }
  }


  /**
   * Removes tag from contact. If ID is null, updates the contact, then
   * refreshes.
   *
   * @param string $value Tag value.
   * @return void
   */
  public function removeTag(string $value): void {
    $contact = Services::contact()->getContact();
    if ($contact == null) return;

    if ($contact->getId() == null) {
      if ($contact->isDirty()) $contact->update();
      $contact->refresh();
    }
    if ($contact->getId() == null) return;

    $data = [
      'contact_id' => $contact->getId(),
      'value' => $value
    ];
    $tm = new TagModel();
    $tag = $tm->asArray()->where($data)->first();

    if (!$tag) return;
    $tm->delete($tag['tag_id']);

    // publish the event
    $this->publish(
      new class($data) implements IEvent {
        public function __construct($data) {
          $this->data = $data;
        }

        public function code(): int {
          return IEvent::EVENT_TAG_REMOVE;
        }

        public function data() {
          return $this->data;
        }
      }
    );
  }

  /**
   * Returns contact's tags. If ID is null, updates the contact, then
   * refreshes.
   *
   * @return array Array of contact's tag values.
   */
  public function getTags(): array {
    $contact = Services::contact()->getContact();
    if ($contact == null) return;

    if ($contact->getId() == null) {
      if ($contact->isDirty()) $contact->update();
      $contact->refresh();
    }
    if ($contact->getId() == null) return;

    $tm = new TagModel();
    $data = $tm->asArray()
      ->where(['contact_id' => $contact->getId()])
      ->findAll();

    // get only the tag values
    $list = [];
    foreach ($data as $i)
      array_push($list, $i['value']);

    return $list;
  }
}
