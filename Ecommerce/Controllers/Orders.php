<?php

namespace Ecommerce\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Config\Services;
use Ecommerce\Config\Services as EcommerceServices;
use Ecommerce\Orders\OrderInterface;

/**
 * Page controller can be used for building simple, front-end marketing pages.
 * Analytics and client tracking are automatically handled, so all you have to
 * worry about is creating the actual view and response.
 */
abstract class Orders extends Controller {

  use ResponseTrait;

  /**
   * Client service instance
   *
   * @var \Ecommerce\Client\ClientInterface
   */
  protected $client;

  /**
   * Analytics service instance
   *
   * @var \Ecommerce\Analytics\AnalyticsInterface
   */
  protected $analytics;

  /**
   * Constructor.
   */
  public function initController(
    \CodeIgniter\HTTP\RequestInterface $request,
    \CodeIgniter\HTTP\ResponseInterface $response,
    \Psr\Log\LoggerInterface $logger
  ) {
    // Do Not Edit This Line
    parent::initController($request, $response, $logger);

    // load the client service
    $this->client = Services::client();

    // load the analytics service
    $this->analytics = Services::analytics();
  }

  /**
   * Simple token checkout method.
   *
   * @param array $items Order items. Defaults to cart items.
   * @return mixed
   */
  protected function orderToken(array $items = null) {
    $request = Services::request();

    

    // get the orders service
    $orders = EcommerceServices::orders();

    // get the cart service
    $cart = EcommerceServices::cart();

    // create items array from cart data
    if ($items === null) {
      $items = [];
      foreach ($cart->toArray() as $id => $data) {
        array_push($items, $data);
      }
    }

    // default result
    $res = OrderInterface::ORDER_FAIL;

    // make the config array
    $config = [
      'token' => $request->getVar('token'), // replace with your data
      'currency' => strtoupper($request->getVar('currency')),
      'items' => $items,
      'card' => [
        'firstName' => $request->getVar('firstname'),
        'lastName' => $request->getVar('lastname'),
        'email' => $request->getVar('email'),
        'billingCountry' => strtoupper($request->getVar('country')),
        'billingState' => $request->getVar('state'),
        'billingCity' => $request->getVar('city'),
        'billingPostcode' => $request->getVar('zip'),
        'billingAddress1' => $request->getVar('address_1'),
        'billingAddress2' => $request->getVar('address_2'),
        'billingPhone' => $request->getVar('phone'),
        // demo only when not in production
        'demo' => strtolower(getenv('CI_ENVIRONMENT')) !== 'production',
      ]
    ];

    // create an error string to hold possible error messages
    $error = '';

    // place the order and save the result
    $res = $orders->order($config, $error);

    // check the result
    if ($res === OrderInterface::ORDER_SUCCESS) {
      // call success
      $this->orderSuccess($config);

      // return response to frontend
      return $this->respond('', 200);
    } else {
      // call fail
      $this->orderFail($config);

      // respond to frontend
      return $this->failForbidden();
    }
  }

  /**
   * Abstract method. Called when an order is successfully placed.
   *
   * @param array $orderConfig Order configuration.
   * @return mixed
   */
  public abstract function orderSuccess(array $orderConfig);

  /**
   * Abstract method. Called when an order fails to be placed.
   *
   * @param array $orderConfig Order configuration.
   * @return mixed
   */
  public abstract function orderFail(array $orderConfig);
}
