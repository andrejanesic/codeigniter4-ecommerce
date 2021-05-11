<?php

namespace Ecommerce\Observer;

abstract class IObserver {

  /**
   * IObserver class instance.
   *
   * @var IObserver
   */
  private static $instance = null;

  /**
   * Used to initialize IObserver by IPublishers.
   *
   * @return IObserver
   */
  public static function init(): IObserver {
    if (self::$instance == null)
      self::$instance = new self;
    return self::$instance;
  }

  /**
   * React to the passed event.
   *
   * @param IEvent $ie
   * @return void
   */
  public abstract function listen(IEvent $ie): void;
}
