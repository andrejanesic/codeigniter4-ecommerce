<?php

namespace Ecommerce\Observer;

interface IEvent {

  /* ----- Event codes ----- */

  // Analytics
  const EVENT_SESSION_CREATE = 000;
  const EVENT_VISIT_CREATE   = 001;
  const EVENT_VIEW_CREATE    = 002;
  const EVENT_CLICK_CREATE   = 003;

  // Cart
  const EVENT_CART_ADD       = 100;
  const EVENT_CART_REMOVE    = 101;

  // Client
  const EVENT_CONTACT_CREATE  = 200;
  const EVENT_CONTACT_UPDATE  = 201;

  // Order
  const EVENT_ORDER_SUCCESS   = 300;
  const EVENT_ORDER_FAIL      = 301;

  // Tag
  const EVENT_TAG_ADD         = 400;
  const EVENT_TAG_REMOVE      = 401;

  // Visitor
  const EVENT_VISITOR_CREATE  = 500;
  const EVENT_VISITOR_UPDATE  = 501;

  /**
   * Get the event code
   *
   * @return int
   */
  public function code(): int;

  /**
   * Get the event data
   *
   * @return mixed
   */
  public function data();
}
