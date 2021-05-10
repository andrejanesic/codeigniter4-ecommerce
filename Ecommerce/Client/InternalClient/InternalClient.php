<?php

namespace Ecommerce\Client\InternalClient;

use Ecommerce\Client\ClientInterface;
use Ecommerce\Client\ClientModel;
use Ecommerce\Observer\IEvent;
use Ecommerce\Observer\IPublisher;

class InternalClient implements ClientInterface {

  use IPublisher;

  /**
   * Client data
   *
   * @var array
   */
  private $data = null;

  /**
   * ClientModel instance used by service
   *
   * @var ClientModel
   */
  private $model = null;

  /**
   * The InternalClient class is used for managing clients internally (with
   * your own database.)
   */
  public function __construct() {
    $this->initObservers();
    $this->init();
  }

  public function getId(): int {
    return $this->data['client_id'];
  }

  public function getData(): array {
    return $this->data;
  }

  public function getClient(int $id): ?array {
    $cm = new ClientModel();
    return $cm->asArray()->find($id);
  }

  public function updateData(string $key, $val): void {
    $this->data[$key] = $val;
    if ($this->model === null)
      $this->model = new ClientModel();
    $this->model->update($this->data['client_id'], $this->data);

    // publish the event
    $eventData = [
      'client_id' => $this->data['client_id'],
      $key => $val
    ];
    $this->publish(
      new class ($eventData) implements IEvent {
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
    if ($this->data !== null) return;

    // try to load from session and then from cookie
    if (!$this->load()) {

      // loading failed, new client has to be created
      $this->new();
    }

    // save new client into session and cookie
    $this->save();
  }

  /**
   * Creates a new client
   *
   * @return void
   */
  private function new() {
    // generate uuid
    $uuid = randstr(16);

    // insert into db
    $data = [
      'client_uuid' => $uuid
    ];
    if ($this->model === null)
      $this->model = new ClientModel();
    $id = $this->model->insert($data, true);

    // set the values in the class
    $data['client_id'] = $id;
    $this->data = $data;

    // publish the event
    $this->publish(
      new class ($id) implements IEvent {
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
  private function load(): bool {
    $clientUuid = null;

    // try to load from session
    if (session(S__CLIENT_AUTH) === true)
      $clientUuid = session(S__CLIENT_UUID);

    // try to load from cookie
    if (!$clientUuid) {
      helper('cookie');
      $s = get_cookie(C__CLIENT);
      if ($s !== null) {
        $s = explode(':', $s);

        if (sizeof($s) === 2) {
          $uuid = $s[0];
          $token = $s[1];

          // check if the token is good
          if ($this->authenticate(1, $uuid, $token))
            $clientUuid = $uuid;
        }
      }
    }

    // if loading succeeded, enter the data into the class
    if ($clientUuid !== null) {
      if ($this->model === null)
        $this->model = new ClientModel();
      $this->data = $this->model->asArray()
        ->where(['client_uuid' => $clientUuid])
        ->first();
      return true;
    }

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
    $uuid = $this->data['client_uuid'];

    // generate new token
    $tokenRaw = randstr(255);
    $token = password_hash($tokenRaw, PASSWORD_DEFAULT);

    // update the token in the class and in the db
    $this->data['token'] = $token;
    if ($this->model === null)
      $this->model = new ClientModel();
    $this->model->update($this->data['client_id'], [
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
   * @param string $uuid Client UID
   * @param string $secret Secret value
   * @return boolean
   */
  private function authenticate(int $mode, string $uuid, string $secret): bool {
    // firstly check if UID passes
    $validator = service('validation');
    $validator->setRules([
      'client_uuid' => 'required|string|max_length[255]',
      'secret' => 'required|string|max_length[255]'
    ]);
    
    if (!$validator->run([
      'client_uuid' => $uuid,
      'secret' => $secret
    ]))
      return false;

    // load model and find y UID
    if ($this->model === null)
      $this->model = new ClientModel();
    $data = $this->model->asArray()
      ->where([
        'client_uuid' => $uuid
      ])
      ->first();
    if (!$data) return false;

    // check if the secret matches its hash
    $hash = $data[$mode === 0 ? 'password' : 'token'];
    return password_verify($secret, $hash);
  }
}
