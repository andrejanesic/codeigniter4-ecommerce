<?php

namespace Ecommerce\Visitor;

/**
 * Visitors are unidentified contacts. When a visitor signs in or creates their
 * account, their visitor entity is associated with their contact entity.
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
}
