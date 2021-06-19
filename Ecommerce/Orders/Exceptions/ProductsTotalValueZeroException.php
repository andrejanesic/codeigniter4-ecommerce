<?php

namespace Ecommerce\Orders\Exceptions;

use Exception;

/**
 * Thrown when the OrderInterface receives an order request with products whose
 * total value equals zero.
 */
class ProductsTotalValueZeroException extends Exception {

  public function errorMessage() {
    return 'Exception on line ' .
      $this->getLine() .
      ' in ' .
      $this->getFile() .
      ': Total value of given products is 0.';
  }
}
