<?php

namespace Ecommerce\Tags\InternalTags;

use Ecommerce\Tags\TagInterface;
use Ecommerce\Tags\TagModel;
use Config\Services;
use Ecommerce\Observer\IEvent;
use Ecommerce\Observer\IPublisher;

class InternalTags implements TagInterface {

  use IPublisher;

  public function addTag(string $value, int $client = null): void {
    if ($client === null)
      $client = Services::client()->getId();
    if ($client === null) return;

    $data = [
      'client_id' => $client,
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

  public function removeTag(string $value, int $client = null): void {
    if ($client === null)
      $client = Services::client()->getId();
    if ($client === null) return;

    $data = [
      'client_id' => $client,
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

  public function getTags(int $client = null): array {
    if ($client === null)
      $client = Services::client()->getId();
    if ($client === null) return [];

    $tm = new TagModel();
    $data = $tm->asArray()
      ->where(['client_id' => $client])
      ->findAll();

    // get only the tag values
    $list = [];
    foreach ($data as $i)
      array_push($list, $i['value']);

    return $list;
  }
}
