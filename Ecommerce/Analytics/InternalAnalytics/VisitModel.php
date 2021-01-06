<?php

namespace Ecommerce\Analytics\InternalAnalytics;

use Ecommerce\Models\UIDModel;

class VisitModel extends UIDModel {

  protected $name = 'visit';
  protected $table = 'visits';
  protected $primaryKey = 'visit_id';
  protected $uidKey = 'visit_id';
  protected $allowedFields = [
    'session_id',
    'path'
  ];
}
