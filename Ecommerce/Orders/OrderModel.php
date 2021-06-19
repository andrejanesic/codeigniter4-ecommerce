<?php

namespace Ecommerce\Orders;

use CodeIgniter\Model;

class OrderModel extends Model {

  protected $name = 'order';
  protected $table = 'orders';
  protected $primaryKey = 'order_id';
  protected $allowedFields = [
    'reference',
    'session_id',
    'contact_id',
    'status',
    'path',
    'products',
    'value'
  ];
}
