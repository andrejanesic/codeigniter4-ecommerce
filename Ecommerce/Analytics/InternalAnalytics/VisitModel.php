<?php

namespace Ecommerce\Analytics\InternalAnalytics;

use CodeIgniter\Model;

/**
 * Model used by the Analytics service to track page visits. Visits are differ-
 * ent to Views in that Visits can be bounces, but Views cannot.
 */
class VisitModel extends Model {

  protected $table = 'visits';
  protected $primaryKey = 'visit_id';
  protected $allowedFields = [
    'session_id',
    'path'
  ];
}
