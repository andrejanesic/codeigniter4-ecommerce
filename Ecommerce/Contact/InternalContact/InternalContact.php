<?php

namespace Ecommerce\Contact\InternalContact;

include_once __DIR__ . './../../Common.php';

use CodeIgniter\Model;
use Ecommerce\Contact\ContactInterface;
use Ecommerce\Contact\ContactModel;
use Ecommerce\Observer\IEvent;
use Ecommerce\Observer\IPublisher;

class InternalContact implements ContactInterface {

  use IPublisher;

  /**
   * Contact ID.
   */
  private int $id = null;

  /**
   * Contact UUID.
   */
  private string $uuid = null;

  /**
   * Contact token (non-hashed).
   */
  private string $token = null;

  /**
   * Contact's password (hashed).
   */
  private string $password = null;

  /**
   * Contact email.
   */
  private string $email = null;

  /**
   * Contact first name.
   */
  private string $firstName = null;

  /**
   * Contact last name.
   */
  private string $lastName = null;

  /**
   * Contact phone.
   */
  private string $phone = null;

  /**
   * Contact country.
   */
  private string $country = null;

  /**
   * Contact state.
   */
  private string $state = null;

  /**
   * Contact city.
   */
  private string $city = null;

  /**
   * Contact zip.
   */
  private string $zip = null;

  /**
   * Contact address 1.
   */
  private string $address1 = null;

  /**
   * Contact address 2.
   */
  private string $address2 = null;

  /**
   * Contact last IP address.
   */
  private string $lastIp = null;

  /**
   * Indicates whether data was changed after reading.
   */
  private bool $dirty = false;

  /**
   * ContactModel model.
   */
  private ?Model $model;

  /**
   * Default constructor. Initialized from InternalContactService.
   *
   * @param integer $id Contact's ID.
   * @param string $uuid Contact's UUID.
   * @param string $token Contact's token, unhashed.
   * @param string $email Contact's email.
   * @param string $firstName Contact's first name.
   * @param string $lastName Contact's last name.
   * @param string $phone Contact's phone.
   * @param string $country Contact's country.
   * @param string $state Contact's state.
   * @param string $city Contact's city.
   * @param string $zip Contact's zip code.
   * @param string $address1 Contact's address 1.
   * @param string $address2 Contact's address 2.
   * @param string $lastIp Contact's last IP address.
   */
  public function __construct(
    int $id = null,
    string $uuid = null,
    string $token = null,
    string $email = null,
    string $firstName = null,
    string $lastName = null,
    string $phone = null,
    string $country = null,
    string $state = null,
    string $city = null,
    string $zip = null,
    string $address1 = null,
    string $address2 = null,
    string $lastIp = null
  ) {
    $this->model = new ContactModel();
    $this->initObservers();
    $this->id = $id;
    $this->uuid = $uuid;
    $this->token = $token;
    $this->email = $email;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->phone = $phone;
    $this->country = $country;
    $this->state = $state;
    $this->city = $city;
    $this->zip = $zip;
    $this->address1 = $address1;
    $this->address2 = $address2;
    $this->lastIp = $lastIp;
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

  public function getEmail(): ?string {
    return $this->email;
  }

  public function getFirstname(): ?string {
    return $this->firstName;
  }

  public function getLastname(): ?string {
    return $this->lastName;
  }

  public function getPhone(): ?string {
    return $this->phone;
  }

  public function getCountry(): ?string {
    return $this->country;
  }

  public function getState(): ?string {
    return $this->state;
  }

  public function getCity(): ?string {
    return $this->city;
  }

  public function getZip(): ?string {
    return $this->zip;
  }

  public function getAddress1(): ?string {
    return $this->address1;
  }

  public function getAddress2(): ?string {
    return $this->address2;
  }

  public function getLastIp(): ?string {
    return $this->lastIp;
  }

  public function refresh(): void {
    // use available data to find rest
    $data = [];
    if ($this->id !== null) $data['contact_id'] = $this->id;
    if ($this->uuid !== null) $data['contact_uuid'] = $this->uuid;

    // if still empty, cannot fetch, inadequate data
    if ($data === []) return;

    // fetch from db
    $i = $this->model->asArray()->where($data)->first();
    if (!is_array($i)) return;
    $this->id = intval(keyornull($i, 'contact_id'));
    $this->uuid = keyornull($i, 'contact_uuid');
    $this->email = keyornull($i, 'email');
    $this->firstName = keyornull($i, 'first_name');
    $this->lastName = keyornull($i, 'last_name');
    $this->phone = keyornull($i, 'phone');
    $this->country = keyornull($i, 'country');
    $this->state = keyornull($i, 'state');
    $this->city = keyornull($i, 'city');
    $this->zip = keyornull($i, 'zip');
    $this->address1 = keyornull($i, 'address_1');
    $this->address2 = keyornull($i, 'address_2');
    $this->lastIp = keyornull($i, 'last_ip');
  }

  public function setToken(string $newToken): void {
    if ($this->token === $newToken) return;
    $this->dirty = true;
    $this->token = $newToken;
  }

  public function setPassword(string $newPassword): void {
    $t = password_hash($newPassword, PASSWORD_DEFAULT);
    if ($t === $this->password) return;
    $this->dirty = true;
    $this->password = $t;
  }

  public function setEmail(string $newEmail): void {
    if ($this->email === $newEmail) return;
    $this->dirty = true;
    $this->email = $newEmail;
  }

  public function setFirstname(string $newFirstname): void {
    if ($this->firstName === $newFirstname) return;
    $this->dirty = true;
    $this->firstName = $newFirstname;
  }

  public function setLastname(string $newLastname): void {
    if ($this->lastName === $newLastname) return;
    $this->dirty = true;
    $this->lastName = $newLastname;
  }

  public function setPhone(string $newPhone): void {
    if ($this->phone === $newPhone) return;
    $this->dirty = true;
    $this->phone = $newPhone;
  }

  public function setCountry(string $newConuntry): void {
    if ($this->country === $newConuntry) return;
    $this->dirty = true;
    $this->country = $newConuntry;
  }

  public function setState(string $newState): void {
    if ($this->state === $newState) return;
    $this->dirty = true;
    $this->state = $newState;
  }

  public function setCity(string $newCity): void {
    if ($this->city === $newCity) return;
    $this->dirty = true;
    $this->city = $newCity;
  }

  public function setZip(string $newZip): void {
    if ($this->zip === $newZip) return;
    $this->dirty = true;
    $this->zip = $newZip;
  }

  public function setAddress1(string $newAddress1): void {
    if ($this->address1 === $newAddress1) return;
    $this->dirty = true;
    $this->address1 = $newAddress1;
  }

  public function setAddress2(string $newAddress2): void {
    if ($this->address2 === $newAddress2) return;
    $this->dirty = true;
    $this->address2 = $newAddress2;
  }

  public function setLastIp(string $newLastIp): void {
    if ($this->lastIp === $newLastIp) return;
    $this->dirty = true;
    $this->lastIp = $newLastIp;
  }

  public function update(): void {
    if ($this->id === null) return;
    if (!$this->dirty) return;

    // populate data to update
    $data = [];
    if ($this->token != null) {
      $data['contact_token'] = $this->token;
      session()->set(S__CONTACT_TOKEN, $this->token);
    }
    if ($this->password != null) $data['password'] = $this->password;
    if ($this->email != null) $data['email'] = $this->email;
    if ($this->firstName != null) $data['first_name'] = $this->firstName;
    if ($this->lastName != null) $data['last_name'] = $this->lastName;
    if ($this->phone != null) $data['phone'] = $this->phone;
    if ($this->country != null) $data['country'] = $this->country;
    if ($this->state != null) $data['state'] = $this->state;
    if ($this->city != null) $data['city'] = $this->city;
    if ($this->zip != null) $data['zip'] = $this->zip;
    if ($this->address1 != null) $data['address_1'] = $this->address1;
    if ($this->address2 != null) $data['address_2'] = $this->address2;
    if ($this->lastIp != null) $data['last_ip'] = $this->lastIp;

    if ($data === []) return;
    $this->model->update($this->id, $data);
    $this->publish(
      new class($data) implements IEvent {
        public function __construct($d) {
          $this->data = $d;
        }

        public function code(): int {
          return IEvent::EVENT_CONTACT_UPDATE;
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
