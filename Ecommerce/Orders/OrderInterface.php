<?php

namespace Ecommerce\Orders;

use Ecommerce\Config\Services;
use Ecommerce\Observer\IEvent;
use Ecommerce\Observer\IPublisher;
use Exception;
use Omnipay\Common\GatewayInterface;

class OrderInterface {

  use IPublisher;

  const ORDER_SUCCESS                  = 0;
  const ORDER_ERROR_NO_AMOUNT_NO_ITEMS = 100;
  const ORDER_ERROR_PRODUCTS_INVALID   = 101;
  const ORDER_FAIL                     = 102;

  /**
   * Omnipay gateway interface used by the class
   *
   * @var Omnipay\Common\GatewayInterface;
   */
  private $gateway;

  /**
   * Set up the Omnipay gateway in the constructor
   */
  public function __construct(GatewayInterface $gwi) {
    $this->gateway = $gwi;
  }

  /**
   * Place the order via token. Make sure to validate the data before sending!
   * If successful, event with code IEvent::EVENT_ORDER_SUCCESS and order data
   * is published. Otherwise, event with code IEvent::EVENT_ORDER_FAIL with
   * error data is published.
   *
   * @param array $data Order data based on
   *                    https://github.com/thephpleague/omnipay#credit-card--payment-form-input
   * @param [type] $error Error message will be stored here
   * @return int Order status code
   */
  public function order(array $data, &$error = null): int {
    if (!isset($data['amount'])) {

      // we need either the total amount or the items as an array
      if (!isset($data['items']) || empty($data['items']))
        return static::ORDER_ERROR_NO_AMOUNT_NO_ITEMS;

      // calculate the total amount
      $data['amount'] = 0.0;
      foreach ($data['items'] as $i) {

        // the price and quantity need to be float, int respectively
        if (
          !isset($i['price']) ||
          !is_float($i['price']) ||
          !isset($i['quantity']) ||
          !is_integer($i['quantity'])
        ) continue;
        $data['amount'] += $i['price'] * $i['quantity'];
      }

      // if sum is still 0, then all products are wrong
      if ($data['amount'] == 0)
        return static::ORDER_ERROR_PRODUCTS_INVALID;
    }

    // continue with data
    $om = new OrderModel();
    $orderData = [
      'session_id' => Services::analytics()->getSession(),
      'client_id' => Services::client()->getId(),
      'status' => 'PREPARE',
      'amount' => $data['amount']
    ];

    if (isset($data['items'])) {
      $orderData['items'] = json_encode($data['items']);
    }

    // insert the new order and get the ID for Omnipay
    $id = $om->insert($orderData, true);
    $data['transactionId'] = $id;

    // place the transaction and capture the funds
    try {
      $response = $this->gateway->purchase($data)->send();

      // transaction was approved
      if ($response->isSuccessful()) {
        $reference = $response->getTransactionReference();

        // update the order reference in the db
        $om->update($id, [
          'reference' => $reference
        ]);
        $orderData['reference'] = $reference;
        $orderData['order_id'] = $id;

        // publish the event
        $this->publish(
          new class($orderData) implements IEvent {
            public function __construct($od) {
              $this->data = $od;
            }

            public function code(): int {
              return IEvent::EVENT_ORDER_SUCCESS;
            }

            public function data() {
              return $this->data;
            }
          }
        );

        return static::ORDER_SUCCESS;
      } else {
        $error = $response->getMessage();

        // publish the event
        $this->publish(
          new class($error) implements IEvent {
            public function __construct($e) {
              $this->data = $e;
            }

            public function code(): int {
              return IEvent::EVENT_ORDER_FAIL;
            }

            public function data() {
              return $this->data;
            }
          }
        );

        return static::ORDER_FAIL;
      }
    } catch (Exception $e) {
      $error = $e->getMessage();

      // publish the event
      $this->publish(
        new class($error) implements IEvent {
          public function __construct($e) {
            $this->data = $e;
          }

          public function code(): int {
            return IEvent::EVENT_ORDER_FAIL;
          }

          public function data() {
            return $this->data;
          }
        }
      );

      return static::ORDER_FAIL;
    }
  }
}
