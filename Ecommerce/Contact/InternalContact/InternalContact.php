<?php

namespace Ecommerce\Contact\InternalContact;

use Ecommerce\Contact\ContactInterface;
use Ecommerce\Contact\ContactModel;
use Ecommerce\Observer\IEvent;
use Ecommerce\Observer\IPublisher;

class InternalContact implements ContactInterface {

  use IPublisher;

  /**
   * Contact data
   *
   * @var array
   */
  private $data = null;

  /**
   * ContactModel instance used by service
   *
   * @var ContactModel
   */
  private $model = null;

  /**
   * The InternalContact class is used for managing clients internally (with
   * your own database.)
   */
  public function __construct() {
    $this->initObservers();
    $this->init();
  }

  public function getId(): int {
    return $this->data['contact_id'];
  }

  public function getData(): array {
    return $this->data;
  }

  public function getContact(int $id): ?array {
    $cm = new ContactModel();
    return $cm->asArray()->find($id);
  }

  public function updateData(string $key, $val): void {
    $this->data[$key] = $val;
    if ($this->model === null)
      $this->model = new ContactModel();
    $this->model->update($this->data['contact_id'], $this->data);

    // publish the event
    $eventData = [
      'contact_id' => $this->data['contact_id'],
      $key => $val
    ];
    $this->publish(
      new class($eventData) implements IEvent {
        public function __construct($data) {
          $this->data = $data;
        }

        public function code(): int {
          return IEvent::EVENT_CLIENT_UPDATE;
        }

        public function data() {
          return $this->data;
        }
      }
    );
  }

  /**
   * Initializes the client. Must be called before the client can be used
   * (call in constructor method.)
   *
   * @return void
   */
  private function init(): void {
    // if already initialized, stop
    if ($this->checkContact()) return;

    // try to load from session and then from cookie
    // if (!($this->clientSessionToCookie() || $this->clientCookieToSession())) {

    //   // loading failed, new client has to be created
    //   $this->newContact();
    // }
  }

  /**
   * Returns true if client is loaded in session and in cookie, and if values
   * match.
   *
   * @return boolean
   */
  private function checkContact(): bool {
    // if client not init in session, not init at all
    if (session(S__CLIENT_AUTH) !== true) return false;
    
    // init in session, check if cookie
    helper('cookie');
    $s = get_cookie(C__CLIENT);
    if ($s === null) return false;

    // check if cookie in right format
    $s = explode(':', $s);
    if (sizeof($s) !== 2) return false;
    $uuid = $s[0];
    $token = $s[1];

    // if UUID and token matche those in session, confirm
    // (previously have been set by save())
    return ($uuid == session(S__CLIENT_UUID)) &&
      ($token == session(S__CLIENT_TOKEN));
  }

  /**
   * Creates a new client
   *
   * @return void
   */
  private function newContact() {
    // generate new uuids until unique found, very rare case
    $data = [];
    while (true) {
      // generate uuid
      $uuid = randstr(16);

      // insert into db
      $data['contact_uuid'] = $uuid;
      if ($this->model === null)
        $this->model = new ContactModel();
      $id = $this->model->insert($data, true);

      // if successfully inserted, set the values in the class
      if ($id !== false) {
        $data['contact_id'] = $id;
        $this->data = $data;
        session()->set(S__CLIENT_AUTH, true);
        session()->set(S__CLIENT_ID, $id);
        break;
      }
    }

    // publish the event
    $this->publish(
      new class($id) implements IEvent {
        public function __construct($id) {
          $this->id = $id;
        }

        public function code(): int {
          return IEvent::EVENT_CLIENT_CREATE;
        }

        public function data() {
          return $this->id;
        }
      }
    );
  }

  /**
   * Loads the client data from session and cookie
   *
   * @return boolean True if successfully loaded, else false
   */
  private function clientSessionToCookie(): bool {
    // try to load from session
    if (session(S__CLIENT_AUTH) === true) {
      // load model and find by id
      if ($this->model === null)
        $this->model = new ContactModel();
      $data = $this->model->asArray()
        ->where([
          'contact_id' => session(S__CLIENT_ID)
        ])
        ->first();
      // if valid response
      if (!empty($data) && is_array($data) && isset($data['contact_uuid'])) {
        $this->data = $data;
        return true;
      }
    }

    // client data not in session, try to load from cookie
    helper('cookie');
    $s = get_cookie(C__CLIENT);
    if ($s !== null) {
      $s = explode(':', $s);

      if (sizeof($s) === 2) {
        $uuid = $s[0];
        $token = $s[1];

        // check if the token is good
        $data = null;
        if (($data = $this->authenticate(1, $uuid, $token)) != null) {
          $this->data = $data;
          return true;
        }
      }
    }

    // something failed
    return false;
  }

  /**
   * Saves the client data into session and cookie
   *
   * @return void
   */
  private function save(): void {
    // set client as authenticated in session
    session()->set(S__CLIENT_AUTH, true);
    $uuid = $this->data['contact_uuid'];

    // generate new token
    $tokenRaw = randstr(255);
    $token = password_hash($tokenRaw, PASSWORD_DEFAULT); // MASSIVE slow-down caused by password_hash, and probably by password_verify too.

    // update the token in the class and in the db
    $this->data['token'] = $token;
    if ($this->model === null)
      $this->model = new ContactModel();
    $this->model->update($this->data['contact_id'], [
      'token' => $token
    ]);

    // set the client's cookie
    helper('cookie');
    $str = $uuid . ':' . $tokenRaw;
    $days = 3650;
    set_cookie(C__CLIENT, $str, $days * 24 * 60 * 60);

    // update data in session
    foreach ($this->data as $k => $v)
      session()->set($k, $v);
  }

  /**
   * Checks whether secret matches client's credentials
   *
   * @param integer $mode 0 = password, 1 = token
   * @param string $uuid Contact UID
   * @param string $secret Secret value
   * @return array|null Returns client data if authentication successful, null otherwise
   */
  private function authenticate(int $mode, string $uuid, string $secret): ?array {
    // firstly check if UID passes
    $validator = service('validation');
    $validator->setRules([
      'contact_uuid' => 'required|string|max_length[16]',
      'secret' => 'required|string|max_length[255]'
    ]);

    if (!$validator->run([
      'contact_uuid' => $uuid,
      'secret' => $secret
    ]))
      return null;

    // load model and find by uuid
    if ($this->model === null)
      $this->model = new ContactModel();
    $data = $this->model->asArray()
      ->where([
        'contact_uuid' => $uuid
      ])
      ->first();
    if (!$data) return null;

    // check if the secret matches its hash
    $hash = $data[$mode === 0 ? 'password' : 'token'];
    if (password_verify($secret, $hash)) {
      return $data;
    } else {
      return null;
    }
  }
}