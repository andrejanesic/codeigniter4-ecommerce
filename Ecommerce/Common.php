<?php

/**
 * Static method for generating password, available to public
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

require_once 'Config/App.php';
require_once 'Helpers/twig.php';