<?php

namespace Ecommerce\Analytics\InternalAnalytics;

use CodeIgniter\Model;

/**
 * Model used by the Analytics service to clicks on the page. "element_id" rep-
 * resents the ID of the target element, and "path" represents the slug of the
 * page on which the event occurred.
 */
class ClickModel extends Model {

  protected $table = 'clicks';
  protected $primaryKey = 'click_id';
  protected $allowedFields = [
    'session_id',
    'path',
    'element_id'
  ];
}
