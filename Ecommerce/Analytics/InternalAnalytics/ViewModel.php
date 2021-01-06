<?php

namespace Ecommerce\Analytics\InternalAnalytics;

use Ecommerce\Models\UIDModel;

class ViewModel extends UIDModel {

  protected $name = 'view';
  protected $table = 'views';
  protected $primaryKey = 'view_id';
  protected $uidKey = 'view_id';
  protected $allowedFields = [
    'session_id',
    'path',
    'duration'
  ];
}
