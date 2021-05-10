<?php

if (!function_exists('randstr')) {

  /**
   * Generates random string of specified length (default 256) using the given
   * string of characters (default 0-9a-zA-Z).
   *
   * @param string $chars Charset for string
   * @param int $len String length
   * @return string
   */
  function randstr(
    int $len = 256,
    string $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
  ): string {
    $random = '';
    $max = strlen($chars) - 1;
    for ($i = 0; $i < $len; $i++) {
      $random .= $chars[random_int(0, $max)];
    }
    return $random;
  }
}

/**
 * Requires config files of Ecommerce
 */
require_once 'Config/App.php';
