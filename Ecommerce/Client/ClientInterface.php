<?php

namespace Ecommerce\Client;

interface ClientInterface {

  /**
   * Returns the ID of the client
   *
   * @return integer
   */
  public function getId(): int;

  /**
   * Returns client's personal data
   *
   * @return array
   */
  public function getData(): array;

  /**
   * Returns data of the selected client
   *
   * @param int $id Client ID
   * @return array|null Client data if found, else null
   */
  public function getClient(int $id): ?array;

  /**
   * Updates client's personal data
   *
   * @param string $key Data key
   * @param mixed $val New value
   * @return void
   */
  public function updateData(string $key, $val): void;
}