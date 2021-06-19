<?php

namespace Ecommerce\Orders;

interface OrderInterface {

  /**
   * Place the order via token. Make sure to validate the data before sending!
   * If successful, event with code IEvent::EVENT_ORDER_SUCCESS and order data
   * is published. Otherwise, event with code IEvent::EVENT_ORDER_FAIL with
   * error data is published.
   *
   * @param array $data Order data based on
   *                    https://github.com/thephpleague/omnipay#credit-card--payment-form-input
   * @param [type] $error Error message will be stored here
   * @return bool True if order placed and complete, false otherwise
   * @throws NoAmountNoValueException Thrown if no products or total order
   *                                  amount given.
   * @throws ProductsTotalValueZeroException Thrown if total value of given
   *                                         products equals zero.
   */
  public function order(array $data, &$error = null): bool;
}
