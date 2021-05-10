<?php

namespace Ecommerce\Client;

use CodeIgniter\Model;

class ClientModel extends Model {

  protected $table = 'clients';
  protected $primaryKey = 'client_id';
  protected $useSoftDeletes = true;
  protected $allowedFields = [
    'client_uuid',
    'password',
    'token',
    'email',
    'firstname',
    'lastname',
    'phone',
    'country',
    'state',
    'city',
    'zip',
    'address1',
    'address2',
    'last_ip'
  ];

}
