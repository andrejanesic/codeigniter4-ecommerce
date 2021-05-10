<?php

namespace Ecommerce\Controllers;

use CodeIgniter\Controller;
use Ecommerce\Config\Services;

/**
 * Page controller can be used for building simple, front-end marketing pages.
 * Analytics and client tracking are automatically handled, so all you have to
 * worry about is creating the actual view and response.
 */
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
