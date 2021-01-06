<?php

namespace Ecommerce\Tags;

use Ecommerce\Models\UIDModel;

class TagModel extends UIDModel {

  protected $name = 'tag';
  protected $table = 'tags';
  protected $primaryKey = 'tag_id';
  protected $uidKey = 'tag_id';
  protected $allowedFields = [
    'client_id',
    'value'
  ];
}
