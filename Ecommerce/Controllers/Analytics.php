<?php

namespace Ecommerce\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;
use Ecommerce\Config\Services;

/**
 * Simple plug-and-play controller for accepting View and Click requests.
 */
class Analytics extends Controller {

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
   * For adding Views from the front-end.
   *
   * @return mixed
   */
  public function addView() {
    $id = session(S__SESSION_ID);
    if (!$id) $id = $this->analytics->addSession();
    if ($id === -1) return $this->failForbidden();

    $rules = [
      'session_id' => 'required|is_not_unique[sessions.session_id]',
      'path' => 'permit_empty|string',
      'duration' => 'permit_empty|int'
    ];

    $request = service('request');
    $data = [
      'session_id' => $id,
      'path' => $request->getVar('path'),
      'duration' => $request->getVar('duration')
    ];

    $validation = service('validation');
    $validation->setRules($rules);
    if (!$validation->run($data)) return $this->failValidationError();

    $this->analytics->addClick();
    return $this->respond('', 200);
  }

  /**
   * For adding Clicks from the front-end.
   *
   * @return mixed
   */
  public function addClick() {
    $id = session(S__SESSION_ID);
    if (!$id) $id = $this->analytics->addSession();
    if ($id === -1) return $this->failForbidden();

    $rules = [
      'session_id' => 'required|is_not_unique[sessions.session_id]',
      'path' => 'permit_empty|string',
      'element_id' => 'required|string|max_length[100]'
    ];

    $request = service('request');
    $data = [
      'session_id' => $id,
      'path' => $request->getVar('path'),
      'element_id' => $request->getVar('element_id')
    ];

    $validation = service('validation');
    $validation->setRules($rules);
    if (!$validation->run($data)) return $this->failValidationError();

    $this->analytics->addClick();
    return $this->respond('', 200);
  }
}
