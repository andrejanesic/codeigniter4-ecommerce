<?php

namespace Ecommerce\Observer;

require_once 'Map.php';

interface IObserver {

  /**
   * React to the passed event
   *
   * @param IEvent $ie
   * @return void
   */
  public function listen(IEvent $ie): void;
}
