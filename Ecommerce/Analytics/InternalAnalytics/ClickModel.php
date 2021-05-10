<?php

namespace Ecommerce\Analytics\InternalAnalytics;

use CodeIgniter\Model;

class ClickModel extends Model {

  protected $table = 'clicks';
  protected $primaryKey = 'click_id';
  protected $allowedFields = [
    'session_id',
    'path',
    'element_id'
  ];
}
