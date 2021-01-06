<?php

namespace Ecommerce\Orders;

use Ecommerce\Models\UIDModel;

class OrderModel extends UIDModel {

  protected $name = 'order';
  protected $table = 'orders';
  protected $primaryKey = 'order_id';
  protected $uidKey = 'order_id';
  protected $allowedFields = [
    'reference',
    'session_id',
    'client_id',
    'status',
    'path',
    'products',
    'value'
  ];
}
