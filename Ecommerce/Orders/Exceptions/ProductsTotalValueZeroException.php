<?php

namespace Ecommerce\Orders\Exceptions;

use Exception;

class ProductsTotalValueZeroException extends Exception {

  public function errorMessage() {
    return 'Exception on line ' .
      $this->getLine() .
      ' in ' .
      $this->getFile() .
      ': Total value of given products is 0.';
  }
}
