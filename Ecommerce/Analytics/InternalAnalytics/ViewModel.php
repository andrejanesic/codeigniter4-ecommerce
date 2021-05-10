<?php

namespace Ecommerce\Analytics\InternalAnalytics;

use CodeIgniter\Model;

/**
 * Model used by the Analytics service to track page views. Bounces are never
 * counted into Views.
 */
class ViewModel extends Model {

  protected $table = 'views';
  protected $primaryKey = 'view_id';
  protected $allowedFields = [
    'session_id',
    'path',
    'duration'
  ];
}
