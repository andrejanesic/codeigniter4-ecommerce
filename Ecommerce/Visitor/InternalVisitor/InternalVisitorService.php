<?php

namespace Ecommerce\Visitor\InternalVisitor;

include_once __DIR__ . './../../Config/Constants.php';

use CodeIgniter\Model;
use CodeIgniter\Config\Services;
use Ecommerce\Observer\IEvent;
use Ecommerce\Visitor\VisitorInterface;
use Ecommerce\Visitor\VisitorServiceInterface;
use Ecommerce\Visitor\VisitorModel;
use Ecommerce\Observer\IPublisher;
use Error;

class InternalVisitorService implements VisitorServiceInterface {

  use IPublisher;

  /**
   * VisitorModel instance.
   * 
   * @var VisitorModel
   */
  private ?Model $model = null;

  /**
   * Current visitor instance.
   * 
   * @var VisitorInterface
   */
  private ?VisitorInterface $visitor = null;

  /**
   * Constructor. Initializes observers and visitor data.
   */
  public function __construct() {
    $this->model = new VisitorModel();
    $this->initObservers();
  }

  /**
   * Initialize the visitor. Must be called before any other function of the
   * package, otherwise the visitor is not recorded. Firstly, try initializing
   * from session data. If in session, check if in cookie. If not in cookie,
   * put session data into cookie. But if data not in session, try to load from
   * cookie. If not in cookie, make new visitor and new token.
   *
   * @return void
   */
  public function initVisitor(): VisitorInterface {
    if ($this->visitor != null) return $this->visitor;
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

      $this->visitor = new InternalVisitor(null, $sessionUuid, $sessionToken);
      return $this->visitor;
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

          $this->visitor = new InternalVisitor(
            intval($i['visitor_id']),
            $i['visitor_uuid'],
            $i['visitor_token'],
            intval($i['contact_id'])
          );

          // publish event
          $this->publish(
            new class($i) implements IEvent {
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
          return $this->visitor;
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

      $this->visitor = new InternalVisitor($id, $uuid, $token);
      return $this->visitor;
    }
    throw new Error('Couldn\'t generate visitor.');
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

  public function getVisitor(): VisitorInterface {
    return $this->initVisitor();
  }
}
