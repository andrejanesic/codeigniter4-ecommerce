<?php

namespace Ecommerce\Visitor;

use CodeIgniter\Model;

class VisitorModel extends Model {

  protected $table = 'visitors';
  protected $primaryKey = 'visitor_id';
  protected $useSoftDeletes = true;
  protected $allowedFields = [
    'visitor_uuid',
    'visitor_token',
    'contact_id'
  ];
}
