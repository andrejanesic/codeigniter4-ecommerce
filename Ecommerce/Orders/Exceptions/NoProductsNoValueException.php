<?php

namespace Ecommerce\Orders\Exceptions;

use Exception;

class NoProductsNoValueException extends Exception {

  public function errorMessage() {
    return 'Exception on line ' .
      $this->getLine() .
      ' in ' .
      $this->getFile() .
      ': Order given no products nor total value. At least one product or total order value must be specified.';
  }
}
