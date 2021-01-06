<?php

namespace Ecommerce\Tags;

interface TagInterface {

  /**
   * Add tag to client
   *
   * @param string $value Tag value
   * @param integer|null $client Client ID
   * @return void
   */
  public function addTag(string $value, int $client = null): void;

  /**
   * Remove tag from client
   *
   * @param string $value Tag value
   * @param integer|null $client Client ID
   * @return void
   */
  public function removeTag(string $value, int $client = null): void;

  /**
   * Get client's tags
   *
   * @param integer|null $client Client ID
   * @return array
   */
  public function getTags(int $client = null): array;
}
