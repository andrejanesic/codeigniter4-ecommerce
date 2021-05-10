<?php

namespace Ecommerce\Analytics\InternalAnalytics;

use CodeIgniter\Model;

class VisitModel extends Model {

  protected $table = 'visits';
  protected $primaryKey = 'visit_id';
  protected $allowedFields = [
    'session_id',
    'path'
  ];
}
