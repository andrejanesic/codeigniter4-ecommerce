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
class Page extends Controller {

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
   * @return mixed
   */
  public function orderToken() {
    $request = Services::request();
    $orders = EcommerceServices::orders();

    // default result
    $res = OrderInterface::ORDER_FAIL;

    // make the config array
    $config = [
      'token' => $request->getVar('eestoken'), // replace with your data
      'currency' => strtoupper($request->getVar('currency')),
      'items' => [
        [
          'name' => 'TestLineItem843',
          'quantity' => 1,
          'price' => 34.49
        ],
      ],
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
        'demo' => true, // remove in production
      ]
    ];

    // create an error string to hold possible error messages
    $error = '';

    // place the order and save the result
    $res = $orders->order($config, $error);

    // check the result
    if ($res === OrderInterface::ORDER_SUCCESS)
      
      // update client data here
      //
      // ...
      //

      // return response to frontend script
      return $this->respond('', 200);
    else
      return $this->failForbidden();
  }
}
