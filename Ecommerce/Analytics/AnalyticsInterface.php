<?php

namespace Ecommerce\Analytics;

interface AnalyticsInterface {

  /**
   * Records a session
   *
   * @param array $data
   * @return int
   */
  public function addSession(array $data = null): int;

  /**
   * Returns current session ID
   *
   * @param array $data
   * @return int
   */
  public function getSession(): int;

  /**
   * Records a visit
   *
   * @param array $data
   * @return int
   */
  public function addVisit(array $data = null): int;

  /**
   * Records a view
   *
   * @param array $data
   * @return int
   */
  public function addView(array $data = null): int;

  /**
   * Records a click
   *
   * @param array $data
   * @return int
   */
  public function addClick(array $data = null): int;
}