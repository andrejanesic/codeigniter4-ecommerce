<?php

namespace Ecommerce\Visitor\InternalVisitor;

include_once __DIR__ . './../../Common.php';

use CodeIgniter\Model;
use Ecommerce\Observer\IEvent;
use Ecommerce\Observer\IPublisher;
use Ecommerce\Visitor\VisitorInterface;
use Ecommerce\Visitor\VisitorModel;

class InternalVisitor implements VisitorInterface {

  use IPublisher;

  /**
   * Visitor ID.
   */
  private ?int $id = null;

  /**
   * Visitor UUID.
   */
  private ?string $uuid = null;

  /**
   * Visitor token.
   */
  private ?string $token = null;

  /**
   * Visitor contact ID.
   */
  private ?int $contactId = null;

  /**
   * Indicates whether data was changed after reading.
   */
  private bool $dirty = false;

  /**
   * VisitorModel instance.
   */
  private ?Model $model = null;

  /**
   * Default constructor. Initialized from InternalVisitorService.
   * 
   * @param integer $id Visitor's ID.
   * @param string $uuid Visitor's UUID.
   * @param string $token Visitor's token, unahshed.
   * @param int $contactId Visitor's contact ID.
   */
  public function __construct(
    int $id = null,
    string $uuid = null,
    string $token = null,
    int $contactId = null
  ) {
    $this->model = new VisitorModel();
    $this->initObservers();
    $this->id = $id;
    $this->uuid = $uuid;
    $this->token = $token;
    $this->contactId = $contactId;
  }

  public function getId(): int {
    return $this->id;
  }

  public function getUuid(): string {
    return $this->uuid;
  }

  public function getToken(): string {
    return $this->token;
  }

  public function getContactId(): ?int {
    return $this->contactId;
  }

  public function refresh(): void {
    // use available data to find rest
    $data = [];
    if ($this->id !== null) $data['visitor_id'] = $this->id;
    if ($this->uuid !== null) $data['visitor_uuid'] = $this->uuid;

    // if still empty, cannot fetch, inadequate data
    if ($data === []) return;

    // fetch from db
    $i = $this->model->asArray()->where($data)->first();
    if (!is_array($i)) return;
    $this->id = intval(keyornull($i, 'visitor_id'));
    $this->uuid = keyornull($i, 'visitor_uuid');
    $this->token = keyornull($i, 'visitor_token');
    $this->contactId = intval(keyornull($i, 'contact_id'));
  }

  public function setToken(string $newToken): void {
    if ($this->token == $newToken) return;
    $this->dirty = true;
    $this->token = $newToken;
  }

  public function setContactId(int $newContactId): void {
    if ($this->contactId == $newContactId) return;
    $this->dirty = true;
    $this->contactId = $newContactId;
  }

  public function update(): void {
    if ($this->id === null || $this->uuid = null) return;
    if (!$this->dirty) return;

    // populate data to update
    $data = [];
    if ($this->token != null) {
      $data['visitor_token'] = $this->token;
      session()->set(S__VISITOR_TOKEN, $this->token);
    }
    if ($this->contactId != null) $data['contact_id'] = $this->contactId;
    if ($data === []) return;

    $where = [];
    if ($this->id != null) {
      $data['visitor_id'] = $this->id;
    } else if ($this->uuid != null) {
      $data['visitor_uuid'] = $this->uuid;
    } else {
      // error, no visitor reference
      return;
    }

    // update
    $this->model->where($where)->update(null, $data);
    $this->publish(
      new class($data) implements IEvent {
        public function __construct($d) {
          $this->data = $d;
        }

        public function code(): int {
          return IEvent::EVENT_VISITOR_UPDATE;
        }

        public function data() {
          return $this->data;
        }
      }
    );
  }

  public function isDirty(): bool {
    return $this->dirty;
  }
}
