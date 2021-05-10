<?php

namespace Ecommerce\Observer;

trait IPublisher {

  /**
   * Array of observers
   *
   * @var array
   */
  private $observers = [];

  /**
   * Add an observer
   *
   * @param IObserver $o
   * @return void
   */
  public function addObserver(IObserver ...$obs): void {
    foreach ($obs as $o)
      if (!in_array($o, $this->observers))
        array_push($this->observers, $o);
  }

  /**
   * Remove an observer
   *
   * @param IObserver $o
   * @return void
   */
  public function initObservers(): void {
    $ecom = config('Ecommerce');

    // if key is not in map, skip
    if (!isset($ecom->observerMap[static::class])) return;

    // fetch the registered observer classes
    $this->observers = $ecom->observerMap[static::class];
  }

  /**
   * Remove an observer
   *
   * @param IObserver $o
   * @return void
   */
  public function removeObserver(IObserver ...$obs): void {
    foreach ($obs as $o) {
      $index = array_search($o, $this->observers, true);
      if ($index === false) return;
      array_splice($this->observers, $index, 1);
    }
  }

  /**
   * Publish the event
   *
   * @param IEvent $ie
   * @return void
   */
  public function publish(IEvent $e): void {
    foreach ($this->observers as $o)
      $o->listen($e);
  }
}
