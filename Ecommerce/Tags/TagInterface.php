<?php

namespace Ecommerce\Tags;

interface TagInterface {

  /**
   * Add tag to contact. Contact must be initialized.
   *
   * @param string $value Tag value.
   * @return void
   */
  public function addTag(string $value): void;

  /**
   * Remove tag from contact. Contact must be initialized.
   *
   * @param string $value Tag value.
   * @return void
   */
  public function removeTag(string $value): void;

  /**
   * Get contact's tags. Contact must be initialized.
   *
   * @return array Array of contact's tag values.
   */
  public function getTags(): array;
}
