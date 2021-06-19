<?php

namespace Ecommerce\Analytics\InternalAnalytics;

use Ecommerce\Analytics\AnalyticsInterface;
use CodeIgniter\Config\Services;
use Ecommerce\Config\Services as EcomServices;
use Ecommerce\Observer\IEvent;
use Ecommerce\Observer\IPublisher;

class InternalAnalytics implements AnalyticsInterface {

  use IPublisher;

  public function addSession(array $data = null): int {
    // firstly check if session was already registered
    if (($id = session(S__SESSION_ID)) !== null)
      return $id;

    $rules = [
      'visitor_id' => 'required|is_not_unique[visitors.visitor_id]',
      'utm_source' => 'permit_empty|string|max_length[150]',
      'utm_medium' => 'permit_empty|string|max_length[150]',
      'utm_campaign' => 'permit_empty|string|max_length[150]',
      'utm_term' => 'permit_empty|string|max_length[150]',
      'utm_content' => 'permit_empty|string|max_length[150]',
      'referrer' => 'permit_empty|string|max_length[100]'
    ];

    $data = [];
    $request = Services::request();
    foreach ($rules as $k => $v)
      if (!isset($data[$k]))
        $data[$k] = $request->getVar($k);

    // get the client id if not previously set
    $data['visitor_id'] = EcomServices::visitor()->initVisitor()->getId();

    $validation = service('validation');
    $validation->setRules($rules);
    if (!$validation->run($data))
      return -1;

    // create session model
    $model = new SessionModel();
    $id = $model->insert($data, true);

    // insert session data
    if (is_int($id) && $id > 0) {

      // set the session id in session
      session()->set(S__SESSION_ID, $id);
      session()->set(S__SESSION_UTM_SOURCE, $data['utm_source'] || null);
      session()->set(S__SESSION_UTM_MEDIUM, $data['utm_medium'] || null);
      session()->set(S__SESSION_UTM_CAMPAIGN, $data['utm_campaign'] || null);
      session()->set(S__SESSION_UTM_TERM, $data['utm_term'] || null);
      session()->set(S__SESSION_UTM_CONTENT, $data['utm_content'] || null);

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

  /**
   * Default implementation of the addClick method. Requires session_id, path
   * and element_id. Propagates event with code IEvent::EVENT_CLICK_CREATE, and
   * data array containing click_id, path and element_id.
   *
   * @param array $data
   * @return integer
   */
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
      new class(
        $id,
        $request->getVar('path'),
        $request->getVar('element_id')
      ) implements IEvent {
        public function __construct($id, $path, $el) {
          $this->data = [
            'click_id' => $id,
            'element_id' => $el,
            'path' => $path,
          ];
        }

        public function code(): int {
          return IEvent::EVENT_CLICK_CREATE;
        }

        public function data() {
          return $this->data;
        }
      }
    );

    return $id;
  }
}
