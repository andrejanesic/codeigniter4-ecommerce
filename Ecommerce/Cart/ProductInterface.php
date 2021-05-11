<?php

namespace Ecommerce\Cart;

interface ProductInterface {

  /**
   * Returns the product ID.
   *
   * @return string
   */
  public function getId(): int;

  /**
   * Returns the product price.
   *
   * @return float
   */
  public function getPrice(): float;

  /**
   * Returns the product name.
   * 
   * @return string
   */
  public function getName(): string;

  /**
   * Returns the product as array.
   *
   * @return array
   */
  public function toArray(): array;
}
