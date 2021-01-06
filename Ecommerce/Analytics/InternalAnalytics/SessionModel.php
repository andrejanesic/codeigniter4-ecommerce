<?php

namespace Ecommerce\Analytics\InternalAnalytics;

use Ecommerce\Models\UIDModel;

class SessionModel extends UIDModel {

  protected $name = 'session';
  protected $table = 'sessions';
  protected $primaryKey = 'session_id';
  protected $uidKey = 'session_id';
  protected $allowedFields = [
    'client_id',
    'utm_campaign',
    'utm_source',
    'utm_medium',
    'utm_term',
    'utm_content',
    'referrer'
  ];
}
