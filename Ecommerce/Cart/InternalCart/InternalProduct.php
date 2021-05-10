<?php

namespace Ecommerce\Cart\InternalCart;

use Ecommerce\Cart\ProductInterface;

class InternalProduct implements ProductInterface {

  public function __construct(string $id, float $price) {
    $this->id = $id;
    $this->price = $price;
  }

  public function getId(): int {
    return intval($this->id);
  }

  public function getPrice(): float {
    return $this->price;
  }

  public function toArray(): array {
    return [
      'id' => $this->id,
      'price' => $this->price
    ];
  }
}
