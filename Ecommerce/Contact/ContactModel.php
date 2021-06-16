<?php

namespace Ecommerce\Contact;

use CodeIgniter\Model;

class ContactModel extends Model {

  protected $table = 'contacts';
  protected $primaryKey = 'contact_id';
  protected $useSoftDeletes = true;
  protected $allowedFields = [
    'contact_uuid',
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
