<?php

namespace Ecommerce\Tags;

use CodeIgniter\Model;

class TagModel extends Model {

  protected $table = 'tags';
  protected $primaryKey = 'tag_id';
  protected $useSoftDeletes = true;
  protected $allowedFields = [
    'contact_id',
    'value'
  ];
}
