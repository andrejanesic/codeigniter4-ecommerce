<?php

namespace Ecommerce\Visitor;

/**
 * Visitors are unidentified contacts. When a visitor signs in or creates their
 * account, their visitor entity is associated with their contact entity.
 */
interface VisitorServiceInterface {

  /**
   * Returns the current visitor. If no visitor initialized, attempts to
   * initialize from session, then from cookie. If both fail, returns null.
   *
   * @return VisitorInterface|null Returns VisitorInterface if successful, null
   * otherwise.
   */
  public function getVisitor(): ?VisitorInterface;

  /**
   * Attempts to load visitor from cookie. If successful, sets the visitor
   * instance in the service.
   *
   * @return VisitorInterface|null Returns the VisitorInterface if successful,
   * null otherwise.
   */
  public function initVisitor(): ?VisitorInterface;
}
