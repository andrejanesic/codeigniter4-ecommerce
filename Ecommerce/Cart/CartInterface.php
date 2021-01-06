<?php

namespace Ecommerce\Cart;

interface CartInterface {

  /**
   * Adds product to cart
   *
   * @param array $product
   * @return void
   */
  public function addProduct(ProductInterface $pi): void;

  /**
   * Removes product from cart
   *
   * @param array $product
   * @return void
   */
  public function removeProduct(ProductInterface $pi): void;

  /**
   * Return list of all products in cart
   *
   * @return array
   */
  public function getProducts(): array;

  /**
   * Return all products as key-value array. Example:
   * [
   *   'id' => [           // product id
   *      'price' => 1.0,  // product price
   *      'quantity' => 1  // product quantity (total)
   *   ],
   *   ...
   * ]
   *
   * @return array
   */
  public function toArray(): array;
}
