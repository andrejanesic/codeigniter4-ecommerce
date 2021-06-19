<?php

namespace Ecommerce\Contact;

use CodeIgniter\Model;

class ContactModel extends Model {

  protected $table = 'contacts';
  protected $primaryKey = 'contact_id';
  protected $useSoftDeletes = true;
  protected $allowedFields = [
    'contact_uuid',
    'contact_token',
    'password',
    'email',
    'first_name',
    'last_name',
    'phone',
    'country',
    'state',
    'city',
    'zip',
    'address_1',
    'address_2',
    'last_ip'
  ];

}
