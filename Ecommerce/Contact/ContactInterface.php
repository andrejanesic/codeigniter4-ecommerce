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
   * Returns the contact's token. (Hashed.)
   *
   * @return string|null Contact's token, or null if not existent.
   */
  public function getToken(): string;

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

  /**
   * Refreshes the contact's data from the database. WARNING: queries the
   * database. Use sparsely.
   *
   * @return void
   */
  public function refresh(): void;

  /**
   * Sets a new token on the contact.
   *
   * @param string $newToken New token (unhashed).
   * @return void
   */
  public function setToken(string $newToken): void;

  /**
   * Sets a new password on the contact.
   *
   * @param string $newPassword New password (unhashed).
   * @return void
   */
  public function setPassword(string $newPassword): void;

  /**
   * Sets a new email on the contact.
   *
   * @param string $newEmail New email.
   * @return void
   */
  public function setEmail(string $newEmail): void;

  /**
   * Sets a new first name on the contact.
   *
   * @param string $newFirstname New first name.
   * @return void
   */
  public function setFirstname(string $newFirstname): void;

  /**
   * Sets a new last name on the contact.
   *
   * @param string $newLastname New last name.
   * @return void
   */
  public function setLastname(string $newLastname): void;

  /**
   * Sets a new phone number on the contact.
   *
   * @param string $newPhone New phone number.
   * @return void
   */
  public function setPhone(string $newPhone): void;

  /**
   * Sets a new country on the contact.
   *
   * @param string $newCountry New country.
   * @return void
   */
  public function setCountry(string $newCountry): void;

  /**
   * Sets a new state on the contact.
   *
   * @param string $newState New state.
   * @return void
   */
  public function setState(string $newState): void;

  /**
   * Sets a new city on the contact.
   *
   * @param string $newCity New city.
   * @return void
   */
  public function setCity(string $newCity): void;

  /**
   * Sets a new zip code on the contact.
   *
   * @param string $newZip New zip code.
   * @return void
   */
  public function setZip(string $newZip): void;

  /**
   * Sets a new address 1 on the contact.
   *
   * @param string $newAddress1 New address 1.
   * @return void
   */
  public function setAddress1(string $newAddress1): void;

  /**
   * Sets a new address 2 on the contact.
   *
   * @param string $newAddress2 New address 2.
   * @return void
   */
  public function setAddress2(string $newAddress2): void;

  /**
   * Sets a new last IP address on the contact.
   *
   * @param string $newLastIp New IP address.
   * @return void
   */
  public function setLastIp(string $newLastIp): void;

  /**
   * Updates the contact in the database with the latest data. WARNING: queries
   * the database. Use sparsely.
   *
   * @return void
   */
  public function update(): void;

  /**
   * Returns whether data was changed after initial reading. If true, data
   * should be updated by calling update(), otherwise changes are lost.
   *
   * @return boolean True if changed after reading, false otherwise.
   */
  public function isDirty(): bool;
}
