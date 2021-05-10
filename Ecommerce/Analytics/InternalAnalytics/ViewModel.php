<?php

namespace Ecommerce\Analytics\InternalAnalytics;

use CodeIgniter\Model;

class ViewModel extends Model {

  protected $table = 'views';
  protected $primaryKey = 'view_id';
  protected $allowedFields = [
    'session_id',
    'path',
    'duration'
  ];
}
