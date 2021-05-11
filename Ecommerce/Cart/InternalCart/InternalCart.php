<?php

namespace Ecommerce\Cart\InternalCart;

use Ecommerce\Cart\CartInterface;
use Ecommerce\Cart\ProductInterface;
use Ecommerce\Observer\IEvent;
use Ecommerce\Observer\IPublisher;

class InternalCart implements CartInterface {

  use IPublisher;

  /**
   * Default constructor. Initializes cart from previous session
   */
  public function __construct() {
    $this->init();
  }

  /**
   * Products list
   *
   * @var array
   */
  private $data = [];

  public function addProduct(ProductInterface $p): void {
    array_push($this->data, $p);

    session()->set(S__CART, $this->data);
    $this->save();

    // publish the event
    $this->publish(
      new class($p) implements IEvent {
        public function __construct($p) {
          $this->product = $p;
        }

        public function code(): int {
          return IEvent::EVENT_CART_ADD;
        }

        public function data() {
          return $this->product;
        }
      }
    );
  }

  public function removeProduct(ProductInterface $p): void {
    $i = array_search($p, $this->data);
    if ($i !== false)
      array_slice($this->data, $i, 1);

    session()->set(S__CART, $this->data);
    $this->save();

    // publish the event
    $this->publish(
      new class($p) implements IEvent {
        public function __construct($p) {
          $this->product = $p;
        }

        public function code(): int {
          return IEvent::EVENT_CART_REMOVE;
        }

        public function data() {
          return $this->product;
        }
      }
    );
  }

  public function getProducts(): array {
    return $this->data;
  }

  public function toArray(): array {
    $items = [];
    foreach ($this->data as $p) {
      $id = $p->getId();
      if (!isset($items[$id])) {
        $items[$id] = [
          'price' => $p->getPrice(),
          'quantity' => 1,
          'name' => $p->getName(),
        ];
      }

      $items[$id]['quantity']++;
    }
    return $items;
  }

  /**
   * Initializes cart
   *
   * @return void
   */
  private function init(): void {
    if (!session(S__CART))
      $this->load();
  }

  /**
   * Load the cart from its cookie
   *
   * @return void
   */
  private function load(): void {
    helper('cookie');
    $s = get_cookie(C__CART);
    if ($s === null) {
      $this->data = [];
      session()->set(S__CART, $this->data);
      return;
    }

    $rule = ['v' => 'string|min_length[1]|max_length[100]'];
    $data = explode(',', $s);
    $validator = service('validation');
    foreach ($data as $d) {
      $validator->reset();
      $validator->setRules($rule);
      if (!$validator->run(['v' => $d])) continue;
      array_push($this->data, $d);
    }
    session()->set(S__CART, $this->data);
  }

  /**
   * Save the cart into its cookie
   *
   * @return void
   */
  private function save(): void {
    helper('cookie');
    $str = join(',', $this->data);
    $days = 3650;
    set_cookie(C__CART, $str, $days * 24 * 60 * 60);
  }
}
