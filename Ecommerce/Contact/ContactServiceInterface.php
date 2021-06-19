<?php

namespace Ecommerce\Contact;

/**
 * Contact represent leads or customers. A contact is different from a visitor
 * in that we know some of their personal information (like their username),
 * email, phone, name, etc.
 */
interface ContactServiceInterface {

  /**
   * Returns the current contact. If no contact initialized, attempts to
   * initialize from session, then from cookie. If both fail, returns null.
   *
   * @return ContactInterface|null Returns ContactInterface if successful, null
   * otherwise.
   */
  public function getContact(): ?ContactInterface;

  /**
   * Attempts to load contact from cookie. If successful, sets the contact
   * instance in the service.
   *
   * @return ContactInterface|null Returns the ContactInterface if successful,
   * null otherwise.
   */
  public function initContact(): ?ContactInterface;

  /**
   * Creates a new contact with the given parameters. All parameters are
   * optional except email. Data must be validated before sending.
   *
   * @param string $email Contact's email.
   * @param string $password Contact's password (unhashed).
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
   * @return ContactInterface|null Returns new ContactInterface if successful,
   * null otherwise.
   */
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
  ): ?ContactInterface;

  /**
   * Authenticates the contact via email and password. If successful, returns
   * the contact and loads into the service. Returns null otherwise. Data must
   * be validated before sending.
   *
   * @param string $email Contact's email.
   * @param string $password Contact's password (unhashed).
   * @return ContactInterface|null ContactInterface if successful, null otherwise.
   */
  public function authContact(
    string $email,
    string $password
  ): ?ContactInterface;
}
