<?php

namespace Ecommerce\Orders\Exceptions;

use Exception;

/**
 * Thrown when the OrderInterface receives an order request with no products
 * or total value specified.
 */
class NoProductsNoValueException extends Exception {

  public function errorMessage() {
    return 'Exception on line ' .
      $this->getLine() .
      ' in ' .
      $this->getFile() .
      ': Order given no products nor total value. At least one product or total order value must be specified.';
  }
}
