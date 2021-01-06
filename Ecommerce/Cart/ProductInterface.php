<?php

namespace Ecommerce\Cart;

interface ProductInterface {

  /**
   * Returns the product's ID
   *
   * @return string
   */
  public function getId(): string;

  /**
   * Returns the product's price
   *
   * @return float
   */
  public function getPrice(): float;

  /**
   * Returns the product as array
   *
   * @return array
   */
  public function toArray(): array;
}
