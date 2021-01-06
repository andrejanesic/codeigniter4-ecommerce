<?php

namespace Ecommerce\Client;

use Ecommerce\Models\UIDModel;

class ClientModel extends UIDModel {

  protected $name = 'client';
  protected $table = 'clients';
  protected $primaryKey = 'client_id';
  protected $uidKey = 'client_uid';
  protected $allowedFields = [
    'client_uid',
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
  protected $beforeUpdate = ['beforeUpdate'];

  /**
   * Sets the email field if client_uid is set
   *
   * @param array $data
   * @return mixed
   */
  protected function beforeUpdate(array $data) {
    if (isset($data['data']['client_uid'])) {
      $data['data']['email'] = $data['data']['client_uid'];
    }
    return $data;
  }
}
