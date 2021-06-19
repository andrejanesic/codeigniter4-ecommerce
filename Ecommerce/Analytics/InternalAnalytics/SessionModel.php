<?php

namespace Ecommerce\Analytics\InternalAnalytics;

use CodeIgniter\Model;

/**
 * Model used by the Analytics service to track sessions.
 */
class SessionModel extends Model {

  protected $table = 'sessions';
  protected $primaryKey = 'session_id';
  protected $allowedFields = [
    'visitor_id',
    'utm_campaign',
    'utm_source',
    'utm_medium',
    'utm_term',
    'utm_content',
    'referrer'
  ];
}
