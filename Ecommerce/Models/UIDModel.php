<?php

namespace Ecommerce\Models;

use CodeIgniter\Model;

class UIDModel extends Model {

  /**
   * Model's name
   *
   * @var string
   */
  protected $name = 'object';

  /**
   * Model's unique (external) identifier key
   *
   * @var string
   */
  protected $uidKey = 'uid';

  protected $beforeInsert = ['beforeInsert'];

  /**
   * Generate model UID
   *
   * @return string Model UID
   */
  public static function uid(): string {
    return sha1(randstr(30) . time());
  }

  /**
   * Sets UID key on object before proceeding
   *
   * @param array $data
   * @return array
   */
  protected function beforeInsert(array $data): array {
    // only if primary and UID key are different, and UID key not set already
    if (!isset($data['data'][$this->uidKey]) && $this->primaryKey !== $this->uidKey) {
      $data['data'][$this->uidKey] = UIDModel::uid();
    }
    return $data;
  }
}
