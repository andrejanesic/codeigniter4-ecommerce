<?php

namespace Ecommerce\Cart;

interface CartInterface {

  /**
   * Adds product to cart.
   *
   * @param array $product
   * @return void
   */
  public function addProduct(ProductInterface $pi): void;

  /**
   * Removes product from cart.
   *
   * @param array $product
   * @return void
   */
  public function removeProduct(ProductInterface $pi): void;

  /**
   * Return array of all products (ProductInterfaces) in cart.
   *
   * @return array
   */
  public function getProducts(): array;

  /**
   * Return all products in cart as key-value array. Example:
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
