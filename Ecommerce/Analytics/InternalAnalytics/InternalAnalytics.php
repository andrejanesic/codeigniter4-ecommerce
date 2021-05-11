<?php

namespace Ecommerce\Analytics\InternalAnalytics;

use Ecommerce\Analytics\AnalyticsInterface;
use Config\Services;
use Ecommerce\Observer\IEvent;
use Ecommerce\Observer\IPublisher;

class InternalAnalytics implements AnalyticsInterface {

  use IPublisher;

  public function addSession(array $data = null): int {
    // firstly check if session was already registered
    if (($id = session(S__SESSION_ID)) !== null)
      return $id;

    $rules = [
      'client_id' => 'required|is_not_unique[clients.client_id]',
      'utm_source' => 'permit_empty|string|max_length[150]',
      'utm_medium' => 'permit_empty|string|max_length[150]',
      'utm_campaign' => 'permit_empty|string|max_length[150]',
      'utm_term' => 'permit_empty|string|max_length[150]',
      'utm_content' => 'permit_empty|string|max_length[150]',
      'referrer' => 'permit_empty|string|max_length[100]'
    ];

    $data = [];
    $request = service('request');
    foreach ($rules as $k => $v)
      if (!isset($data[$k]))
        $data[$k] = $request->getVar($k);

    // get the client id if not previously set
    if (!isset($data['client_id'])) {
      $client = Services::client();
      $data['client_id'] = $client->getId();
    }

    $validation = service('validation');
    $validation->setRules($rules);
    if (!$validation->run($data))
      return -1;

    $model = new SessionModel();
    $id = $model->insert($data, true);

    // insert session data
    if (is_int($id) && $id > 0) {

      // set the session id in session
      session()->set(S__SESSION_ID, $id);

      // publish the event
      $this->publish(
        new class($id) implements IEvent {
          public function __construct($id) {
            $this->id = $id;
          }

          public function code(): int {
            return IEvent::EVENT_SESSION_CREATE;
          }

          public function data() {
            return $this->id;
          }
        }
      );

      return $id;
    } else {
      return -1;
    }
  }

  public function getSession(): int {
    return $this->addSession();
  }

  public function addVisit(array $data = null): int {
    $id = session(S__SESSION_ID);
    if (!$id) $id = $this->addSession();
    if ($id === -1) return -1;

    $rules = [
      'session_id' => 'required|is_not_unique[sessions.session_id]',
      'path' => 'permit_empty|string'
    ];

    $data = [];
    $request = service('request');
    foreach ($rules as $k => $v)
      if (!isset($data[$k]))
        $data[$k] = $request->getVar($k);
    $data['session_id'] = $id;

    $validation = service('validation');
    $validation->setRules($rules);
    if (!$validation->run($data)) return -1;

    $model = new VisitModel();
    $id = $model->insert($data, true);

    // publish the event
    $this->publish(
      new class($id) implements IEvent {
        public function __construct($id) {
          $this->id = $id;
        }

        public function code(): int {
          return IEvent::EVENT_VISIT_CREATE;
        }

        public function data() {
          return $this->id;
        }
      }
    );

    return $id;
  }

  public function addView(array $data = null): int {
    $id = session(S__SESSION_ID);
    if (!$id) $id = $this->addSession();
    if ($id === -1) return -1;

    $rules = [
      'session_id' => 'required|is_not_unique[sessions.session_id]',
      'path' => 'permit_empty|string',
      'duration' => 'permit_empty|int'
    ];

    $data = [];
    $request = service('request');
    foreach ($rules as $k => $v)
      if (!isset($data[$k]))
        $data[$k] = $request->getVar($k);
    $data['session_id'] = $id;

    $validation = service('validation');
    $validation->setRules($rules);
    if (!$validation->run($data)) return -1;

    $model = new ViewModel();
    $id = $model->insert($data, true);

    // publish the event
    $this->publish(
      new class($id) implements IEvent {
        public function __construct($id) {
          $this->id = $id;
        }

        public function code(): int {
          return IEvent::EVENT_VIEW_CREATE;
        }

        public function data() {
          return $this->id;
        }
      }
    );
    
    return $id;
  }

  public function addClick(array $data = null): int {
    $id = session(S__SESSION_ID);
    if (!$id) $id = $this->addSession();
    if ($id === -1) return -1;

    $rules = [
      'session_id' => 'required|is_not_unique[sessions.session_id]',
      'path' => 'permit_empty|string',
      'element_id' => 'required|string|max_length[100]'
    ];

    $data = [];
    $request = service('request');
    foreach ($rules as $k => $v)
      if (!isset($data[$k]))
        $data[$k] = $request->getVar($k);
    $data['session_id'] = $id;

    $validation = service('validation');
    $validation->setRules($rules);
    if (!$validation->run($data)) return -1;

    $model = new ClickModel();
    $id = $model->insert($data, true);

    // publish the event
    $this->publish(
      new class($id) implements IEvent {
        public function __construct($id) {
          $this->id = $id;
        }

        public function code(): int {
          return IEvent::EVENT_CLICK_CREATE;
        }

        public function data() {
          return $this->id;
        }
      }
    );
    
    return $id;
  }
}
