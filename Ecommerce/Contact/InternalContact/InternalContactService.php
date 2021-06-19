<?php

namespace Ecommerce\Contact\InternalContact;

use CodeIgniter\Model;
use CodeIgniter\Config\Services;
use Ecommerce\Contact\ContactInterface;
use Ecommerce\Contact\ContactServiceInterface;
use Ecommerce\Contact\ContactModel;
use Ecommerce\Observer\IPublisher;
use Ecommerce\Contact\InternalContact\InternalContact;
use Ecommerce\Observer\IEvent;

class InternalContactService implements ContactServiceInterface {

  use IPublisher;

  /**
   * ContactModel instance.
   *
   * @var ContactModel
   */
  private ?Model $model = null;

  /**
   * Current contact instance.
   * 
   * @var ContactInterface
   */
  private ?ContactInterface $contact = null;

  /**
   * The InternalContact class is used for managing clients internally (with
   * your own database.)
   */
  public function __construct() {
    $this->model = new ContactModel();
    $this->initObservers();
  }

  /**
   * Initialize the contact. Must be called before doing anything contact-
   * -related. Firstly, try initializing from session data. If in session,
   * check if in cookie. If not in cookie, put session data into cookie. But if
   * data not in session, try to load from cookie. If not in cookie, make new
   * contact and new token.
   *
   * @return void
   */
  public function initContact(): ?InternalContact {
    if ($this->contact != null) return $this->contact;
    helper('cookie');

    // try loading from session
    $sessionValues = $this->getSession();
    if ($sessionValues != null) {
      // well set in session, check cookie
      $sessionUuid = $sessionValues['contact_uuid'];
      $sessionToken = $sessionValues['contact_token'];

      // sync cookie
      $cookieValues = $this->getCookie();
      if ($cookieValues == null) {
        // bad cookie, set again
        $this->setCookie($sessionUuid, $sessionToken);
      } else {
        // cookie set, check if ok
        if (
          $sessionUuid != $cookieValues['contact_uuid'] ||
          $sessionToken != $cookieValues['contact_token']
        ) {
          // bad cookie, set again
          $this->setCookie($sessionUuid, $sessionToken);
        }
      }

      $this->contact = new InternalContact(null, $sessionUuid, $sessionToken);
      return $this->contact;
    }

    // loading from session failed, try loading from cookie
    $cookieValues = $this->getCookie();
    if ($cookieValues != null) {
      $cookieUuid = $cookieValues['contact_uuid'];
      $cookieToken = $cookieValues['contact_token'];
      $data = [
        'contact_uuid' => $cookieUuid,
      ];

      // validate cookie data before checking
      $validator = Services::validation();
      $validator->setRules([
        'contact_uuid' => 'required|string|max_length[16]',
      ]);

      // validate data
      if ($validator->run($data)) {
        // data validated ok, check if auth

        $i = $this->model->asArray()->where($data)->first();
        if (
          !empty($i) &&
          is_array($i) &&
          isset($i['contact_id']) &&
          isset($i['contact_uuid']) &&
          isset($i['contact_token']) &&
          $cookieUuid == $i['contact_uuid'] &&
          $cookieToken == $i['contact_token']
        ) {

          // data found, check if token ok
          $hash = $data['contact_token'];
          if (!password_verify($cookieToken, $hash)) return;

          // token valid, add to session
          $this->setSession(
            $i['contact_id'],
            $i['contact_uuid'],
            $i['contact_token']
          );

          $this->contact = new InternalContact(
            intval($i['contact_id']),
            $i['contact_uuid'],
            $i['contact_token']
          );
          return $this->contact;
        }
      }
    }

    // loading from cookie failed or cookie data invalid, return null
    $this->contact = null;
    return null;
  }

  /**
   * Gets contact data from cookie.
   *
   * @return array|null Returns array with ['contact_uuid': 'foo',
   * 'contact_token': 'bar'] values, or null on error.
   */
  private function getCookie(): ?array {
    helper('cookie');
    $raw = get_cookie(C__CONTACT);
    if ($raw == null) return null;

    $arr = explode(':', $raw);
    if (sizeof($arr) !== 2) return null;

    $uuid = $arr[0];
    $token = $arr[1];

    return [
      'contact_uuid' => $uuid,
      'contact_token' => $token
    ];
  }

  /**
   * Saves contact data into cookie.
   *
   * @param string $uuid Visitor UUID.
   * @param string $token Visitor token (non-hashed).
   * @return void
   */
  private function setCookie(string $uuid, string $token): void {
    helper('cookie');
    $str = $uuid . ':' . $token;
    $days = 3650;
    set_cookie(C__CONTACT, $str, $days * 24 * 60 * 60);
  }

  /**
   * Get contact data from session.
   * 
   * @return array|null Returns array with ['contact_id': 1,
   * 'contact_uuid': 'foo', 'contact_token': 'bar'] values, or null on error.
   */
  private function getSession(): ?array {
    $id = session(S__CONTACT_ID);
    $uuid = session(S__CONTACT_UUID);
    $token = session(S__CONTACT_TOKEN);
    if (is_null($id) || is_null($uuid) || is_null($token)) return null;

    return [
      'contact_id' => $id,
      'contact_uuid' => $uuid,
      'contact_token' => $token,
    ];
  }

  /**
   * Saves contact data into session.
   *
   * @param integer $id Visitor ID.
   * @param string $uuid Visitor UUID.
   * @param string $token Visitor token (non-hashed).
   * @return void
   */
  private function setSession(int $id, string $uuid, string $token): void {
    session()->set(S__CONTACT_ID, $id);
    session()->set(S__CONTACT_UUID, $uuid);
    session()->set(S__CONTACT_TOKEN, $token);
  }

  public function getContact(): ?InternalContact {
    return $this->contact;
  }

  public function makeContact(
    string $email,
    ?string $password = null,
    ?string $firstName = null,
    ?string $lastName = null,
    ?string $phone = null,
    ?string $country = null,
    ?string $state = null,
    ?string $city = null,
    ?string $zip = null,
    ?string $address1 = null,
    ?string $address2 = null,
    ?string $lastIp = null
  ): ?InternalContact {
    // #TODO replace for loop with genuine rand function to avoid possible
    // duplicate generation
    for ($i = 3; $i > 0; $i--) {
      // try 3 times in case of error or if we generate existing uuid/token
      $uuid = randstr(16);
      $token = randstr(32);
      $data = [
        'contact_uuid' => $uuid,
        'contact_token' => $token
      ];

      // hash token before inserting into db. this line is a bit time-
      // consuming, so #TODO find better solution here for hashing token
      $data['contact_token'] = password_hash(
        $data['contact_token'],
        PASSWORD_DEFAULT
      );

      // insert into db
      $id = $this->model->insert($data, true);

      // if failed to insert
      if (is_null($id) || (is_bool($id) && !$id)) continue;

      // save data
      $this->setSession($id, $uuid, $token);
      $this->setCookie($uuid, $token);

      // set contact in service
      $this->contact = new InternalContact($id, $uuid, $token);

      // publish event
      $data['contact_id'] = $id;
      $this->publish(
        new class($data) implements IEvent {
          public function __construct($d) {
            $this->data = $d;
          }

          public function code(): int {
            return IEvent::EVENT_VISITOR_CREATE;
          }

          public function data() {
            return $this->data;
          }
        }
      );
      return $this->contact;
    }
  }

  public function authContact(
    string $email,
    string $password
  ): InternalContact {
    // find by email
    $i = $this->model->where(['email' => $email])->first();
    if (!is_array($i)) return null;

    // verify password
    if (!password_verify($password, $i['password'])) return null;

    /// all verified, set contact in service
    $this->contact = new InternalContact(
      intval(keyornull($i, 'contact_id')),
      keyornull($i, 'contact_uuid'),
      keyornull($i, 'email'),
      keyornull($i, 'first_name'),
      keyornull($i, 'last_name'),
      keyornull($i, 'phone'),
      keyornull($i, 'country'),
      keyornull($i, 'state'),
      keyornull($i, 'city'),
      keyornull($i, 'zip'),
      keyornull($i, 'address_1'),
      keyornull($i, 'address_2'),
      keyornull($i, 'last_ip'),
    );
    return $this->contact;
  }
}
