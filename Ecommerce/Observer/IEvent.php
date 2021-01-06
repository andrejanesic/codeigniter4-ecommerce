<?php

namespace Ecommerce\Observer;

interface IEvent {

  /* ----- Event codes ----- */

  // Analytics
  const EVENT_SESSION_START = 000;
  const EVENT_NEW_VISIT     = 001;
  const EVENT_NEW_VIEW      = 002;
  const EVENT_NEW_CLICK     = 003;

  // Cart
  const EVENT_CART_ADD      = 100;
  const EVENT_CART_REMOVE   = 101;
  
  // Client
  const EVENT_CLIENT_CREATE = 200;
  const EVENT_CLIENT_UPDATE = 201;

  // Order
  const EVENT_ORDER_SUCCESS = 300;
  const EVENT_ORDER_FAIL    = 301;

  // Tag
  const EVENT_TAG_ADD       = 400;
  const EVENT_TAG_REMOVE    = 401;

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
