<?php

namespace Ecommerce\Visitor;

/**
 * Visitors are unidentified contacts. When a visitor signs in or creates their
 * account, their visitor entity must be associated with their contact entity.
 */
interface VisitorInterface {

  /**
   * Returns the visitor's private ID.
   *
   * @return integer Visitor's private ID.
   */
  public function getId(): int;

  /**
   * Returns the visitor's public UUID.
   *
   * @return string Visitor's public UUID.
   */
  public function getUuid(): string;

  /**
   * Return's the visitor's access token.
   *
   * @return string Visitor's token.
   */
  public function getToken(): string;

  /**
   * Return's the visitor's contact ID, if set.
   *
   * @return integer|null Contact ID if set, null otherwise.
   */
  public function getContactId(): ?int;

  /**
   * Refreshes the visitor's data from the database. WARNING: queries the
   * database. Use sparsely.
   *
   * @return void
   */
  public function refresh(): void;

  /**
   * Sets a new token on the visitor.
   *
   * @param string $newToken New token (unhashed).
   * @return void
   */
  public function setToken(string $newToken): void;

  /**
   * Sets a new contact ID on the visitor.
   *
   * @param int $newContactId New contact ID.
   * @return void
   */
  public function setContactId(int $newContactId): void;

  /**
   * Updates the visitor in the database with the latest data. WARNING: queries
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
