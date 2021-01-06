<?php

namespace Ecommerce\Analytics\InternalAnalytics;

use Ecommerce\Models\UIDModel;

class ClickModel extends UIDModel {

  protected $name = 'click';
  protected $table = 'clicks';
  protected $primaryKey = 'click_id';
  protected $uidKey = 'click_id';
  protected $allowedFields = [
    'session_id',
    'path',
    'element_id'
  ];
}
