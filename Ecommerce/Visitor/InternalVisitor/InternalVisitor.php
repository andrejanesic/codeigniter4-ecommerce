<?php

namespace Ecommerce\Visitor\InternalVisitor;

use CodeIgniter\Config\Services;
use CodeIgniter\Model;
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
   * VisitorModel instance.
   */
  private Model $model;

  /**
   * Constructor. Initializes observers and visitor data.
   */
  public function __construct() {
    $this->model = new VisitorModel();
    $this->initObservers();
    $this->init();
  }

  /**
   * Initialize the visitor. Firstly, try initializing from session data. If in
   * session, check if in cookie. If not in cookie, put session data into
   * cookie. But if data not in session, try to load from cookie. If not in
   * cookie, make new visitor and new token.
   *
   * @return void
   */
  private function init(): void {
    helper('cookie');

    // try loading from session
    $sessionValues = $this->getSession();
    if ($sessionValues != null) {
      // well set in session, check cookie
      $sessionUuid = $sessionValues['visitor_uuid'];
      $sessionToken = $sessionValues['visitor_token'];

      // sync cookie
      $cookieValues = $this->getCookie();
      if ($cookieValues == null) {
        // bad cookie, set again
        $this->setCookie($sessionUuid, $sessionToken);
      } else {
        // cookie set, check if ok
        if (
          $sessionUuid != $cookieValues['visitor_uuid'] ||
          $sessionToken != $cookieValues['visitor_token']
        ) {
          // bad cookie, set again
          $this->setCookie($sessionUuid, $sessionToken);
        }
      }

      $this->uuid = $sessionUuid;
      $this->token = $sessionToken;
      return;
    }

    // loading from session failed, try loading from cookie
    $cookieValues = $this->getCookie();
    if ($cookieValues != null) {
      $cookieUuid = $cookieValues['visitor_uuid'];
      $cookieToken = $cookieValues['visitor_token'];
      $data = [
        'visitor_uuid' => $cookieUuid,
        'visitor_token' => $cookieToken
      ];

      // validate cookie data before checking
      $validator = Services::validation();
      $validator->setRules([
        'visitor_uuid' => 'required|string|max_length[16]',
        'visitor_token' => 'required|string|max_length[32]'
      ]);

      // validate data
      if ($validator->run($data)) {
        // data validated ok, check if auth

        $i = $this->model->asArray()->where($data)->first();
        if (
          !empty($i) &&
          is_array($i) &&
          isset($i['visitor_id']) &&
          isset($i['visitor_uuid']) &&
          isset($i['visitor_token']) &&
          $cookieUuid == $i['visitor_uuid'] &&
          $cookieToken == $i['visitor_token']
        ) {
          // data found, valid, add to session
          $this->setSession(
            $i['visitor_id'],
            $i['visitor_uuid'],
            $i['visitor_token']
          );

          $this->id = intval($i['visitor_id']);
          $this->uuid = $i['visitor_uuid'];
          $this->token = $i['visitor_token'];
          $this->contactId = intval($i['contact_id']);
          return;
        }
      }
    }

    // loading from cookie failed or cookie data invalid, set new
    for ($i = 3; $i > 0; $i--) {
      // try 3 times in case of error or if we generate existing uuid/token
      $uuid = randstr(16);
      $token = randstr(32);
      $data = [
        'visitor_uuid' => $uuid,
        'visitor_token' => $token
      ];

      // insert into db
      $id = $this->model->insert($data, true);

      // if failed to insert
      if (is_null($id) || (is_bool($id) && !$id)) continue;

      // save data
      $this->setSession($id, $uuid, $token);
      $this->setCookie($uuid, $token);
      $this->id = $id;
      $this->uuid = $uuid;
      $this->token = $token;
      return;
    }
  }

  /**
   * Gets visitor data from cookie.
   *
   * @return array|null Returns array with ['visitor_uuid': 'foo',
   * 'visitor_token': 'bar'] values, or null on error.
   */
  private function getCookie(): ?array {
    helper('cookie');
    $raw = get_cookie(C__VISITOR);
    if ($raw == null) return null;

    $arr = explode(':', $raw);
    if (sizeof($arr) !== 2) return null;

    $uuid = $arr[0];
    $token = $arr[1];

    return [
      'visitor_uuid' => $uuid,
      'visitor_token' => $token
    ];
  }

  /**
   * Saves visitor data into cookie.
   *
   * @param string $uuid Visitor UUID.
   * @param string $token Visitor token.
   * @return void
   */
  private function setCookie(string $uuid, string $token): void {
    helper('cookie');
    $str = $uuid . ':' . $token;
    $days = 3650;
    set_cookie(C__VISITOR, $str, $days * 24 * 60 * 60);
  }

  /**
   * Get visitor data from session.
   * 
   * @return array|null Returns array with ['visitor_id': 1,
   * 'visitor_uuid': 'foo', 'visitor_token': 'bar'] values, or null on error.
   */
  private function getSession(): ?array {
    $id = session(S__VISITOR_ID);
    $uuid = session(S__VISITOR_UUID);
    $token = session(S__VISITOR_TOKEN);
    if (is_null($id) || is_null($uuid) || is_null($token)) return null;

    return [
      'visitor_id' => $id,
      'visitor_uuid' => $uuid,
      'visitor_token' => $token,
    ];
  }

  /**
   * Saves visitor data into session.
   *
   * @param integer $id Visitor ID.
   * @param string $uuid Visitor UUID.
   * @param string $token Visitor token.
   * @return void
   */
  private function setSession(int $id, string $uuid, string $token): void {
    session()->set(S__VISITOR_ID, $id);
    session()->set(S__VISITOR_UUID, $uuid);
    session()->set(S__VISITOR_TOKEN, $token);
  }

  /**
   * Fetches ID and contact ID data if not set.
   *
   * @return void
   */
  private function fetch(): void {
    // if all data set, nothing to do
    if (
      $this->id !== null &&
      $this->uuid !== null &&
      $this->token !== null &&
      $this->contactId !== null
    ) return;

    // use available data to find rest
    $data = [];
    if ($this->id !== null) $data['visitor_id'] = $this->id;
    if ($this->uuid !== null) $data['visitor_uuid'] = $this->uuid;
    if ($this->token !== null) $data['visitor_token'] = $this->token;

    // if still empty, cannot fetch, inadequate data
    if ($data === []) return;

    // fetch from db
    $i = $this->model->asArray()->where($data)->first();
    if (is_array($i)) {
      $this->id = intval($i['visitor_id']);
      $this->uuid = $i['visitor_uuid'];
      $this->token = $i['visitor_token'];
      if (isset($i['contact_id']) && $i['contact_id'] !== null)
        $this->contactId = intval($i['contact_id']);
    }
  }

  public function getId(): int {
    // if id not init, find via uuid and token
    if ($this->id === null) $this->fetch();
    return $this->id;
  }

  public function getUuid(): string {
    if ($this->uuid === null) $this->fetch();
    return $this->uuid;
  }

  public function getToken(): string {
    if ($this->token === null) $this->fetch();
    return $this->token;
  }

  public function getContactId(): ?int {
    if ($this->contactId === null) $this->fetch();
    return $this->contactId;
  }
}
