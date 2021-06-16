<?php

namespace Ecommerce\Contact;

/**
 * Contact represent leads or customers. A contact is different from a visitor
 * in that we know some of their personal information (like their username),
 * email, phone, name, etc.
 */
interface ContactInterface {

  /**
   * Returns the contact's private ID.
   *
   * @return integer Contact's ID.
   */
  public function getId(): int;

  /**
   * Returns the contact's UUID.
   *
   * @return string|null Contact's UUID.
   */
  public function getUuid(): string;

  /**
   * Returns the contact's password. (Hashed.)
   *
   * @return string|null Contact's password, or null if not existent.
   */
  public function getPassword(): ?string;

  /**
   * Returns the contact's token. (Hashed.)
   *
   * @return string|null Contact's token, or null if not existent.
   */
  public function getToken(): ?string;

  /**
   * Returns the contact's email.
   *
   * @return string|null Contact's email, or null if not existent.
   */
  public function getEmail(): ?string;

  /**
   * Returns the contact's first name.
   *
   * @return string|null Contact's first name, or null if not existent.
   */
  public function getFirstname(): ?string;

  /**
   * Returns the contact's last name.
   *
   * @return string|null Contact's last name, or null if not existent.
   */
  public function getLastname(): ?string;

  /**
   * Returns the contact's phone number.
   *
   * @return string|null Contact's phone number, or null if not existent.
   */
  public function getPhone(): ?string;

  /**
   * Returns the contact's country.
   *
   * @return string|null Contact's country, or null if not existent.
   */
  public function getCountry(): ?string;

  /**
   * Returns the contact's state.
   *
   * @return string|null Contact's state, or null if not existent.
   */
  public function getState(): ?string;

  /**
   * Returns the contact's city.
   *
   * @return string|null Contact's city, or null if not existent.
   */
  public function getCity(): ?string;

  /**
   * Returns the contact's zip code.
   *
   * @return string|null Contact's zip, or null if not existent.
   */
  public function getZip(): ?string;

  /**
   * Returns the contact's address 1.
   *
   * @return string|null Contact's address 1, or null if not existent.
   */
  public function getAddress1(): ?string;

  /**
   * Returns the contact's address 2.
   *
   * @return string|null Contact's address 2, or null if not existent.
   */
  public function getAddress2(): ?string;

  /**
   * Returns the contact's last IP address.
   *
   * @return string|null Contact's last IP address, or null if not existent.
   */
  public function getLastIp(): ?string;
}