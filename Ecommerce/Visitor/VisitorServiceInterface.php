<?php

namespace Ecommerce\Visitor;

/**
 * Visitors are unidentified contacts. When a visitor signs in or creates their
 * account, their visitor entity is associated with their contact entity.
 */
interface VisitorServiceInterface {

  /**
   * Returns the current visitor.
   *
   * @return VisitorInterface Current visitor.
   */
  public function getVisitor(): VisitorInterface;

  /**
   * Attempts to load visitor from session, then from cookie. If both fail,
   * makes a new visitor.
   *
   * @return VisitorInterface Returns the VisitorInterface.
   */
  public function initVisitor(): VisitorInterface;
}
