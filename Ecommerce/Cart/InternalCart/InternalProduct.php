<?php

namespace Ecommerce\Cart\InternalCart;

use Ecommerce\Cart\ProductInterface;

class InternalProduct implements ProductInterface {

  public function __construct(string $id, float $price, string $name) {
    $this->id = $id;
    $this->price = $price;
    $this->name = $name;
  }

  public function getId(): int {
    return intval($this->id);
  }

  public function getName(): string {
    return $this->name;
  }

  public function getPrice(): float {
    return $this->price;
  }

  public function toArray(): array {
    return [
      'id' => $this->id,
      'price' => $this->price,
      'name' => $this->name,
    ];
  }
}
