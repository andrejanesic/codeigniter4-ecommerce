<?php

namespace Ecommerce\Controllers;

use CodeIgniter\Controller;
use Ecommerce\Config\Ecommerce;
use Ecommerce\Config\Services;

class Page extends Controller {

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

    // record a new session/or continue the existing one
    $this->analytics->addSession();

    // record a visit
    $this->analytics->addVisit();
  }
}
