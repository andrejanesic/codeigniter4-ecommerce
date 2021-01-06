<?php

namespace Ecommerce\Validation;

class OrderRules {

  /**
   * Checks whether the currency is supported
   *
   * @param string $currency
   * @param [type] $error
   * @return boolean
   */
  public function supported_currency($currency = null, &$error = null): bool {
    if (empty($currency) || !is_string($currency)) return false;

    $currency = strtoupper($currency);
    if (!in_array($currency, config('Ecommerce')->supportedCurrencies)) {
      $error = 'The currency ' . $currency . ' is not supported.';
      return false;
    }
    return true;
  }

  /**
   * Checks whether the country is supported
   *
   * @param string $country
   * @param [type] $error
   * @return boolean
   */
  public function supported_country($country = null, &$error = null): bool {
    if (empty($country) || !is_string($country)) return false;

    $country = strtoupper($country);
    if (!in_array($country, config('Ecommerce')->supportedCountries)) {
      $error = 'The country ' . $country . ' is not supported.';
      return false;
    }
    return true;
  }

  /**
   * Checks whether the given country requires a secondary address
   *
   * @param string $address
   * @param string $data
   * @param [type] $error
   * @return boolean
   */
  public function country_require_address($address = null, $country = null, &$error = null): bool {
    if (empty($country) || !is_string($country)) {
      $error = 'Country is required.';
      return false;
    } else {
      $country = strtoupper($country);
    }

    // if country doesn't require
    if (!in_array($country, [
      'CHN', 'JPN', 'RUS'
    ])) {
      return true;
    }

    // if country requires
    if (empty($address) || !is_string($address)) {
      $error = 'The country of ' . $country . ' requires providing a second address.';
      return false;
    }
    return true;
  }

  /**
   * Checks whether the given country requires a state
   *
   * @param string $address
   * @param string $data
   * @param [type] $error
   * @return boolean
   */
  public function country_require_state($state = null, $country = null, &$error = null): bool {
    if (empty($country) || !is_string($country)) {
      $error = 'Country is required.';
      return false;
    } else {
      $country = strtoupper($country);
    }

    // if country doesn't require
    if (!in_array($country, [
      'ARG', 'AUS', 'BGR', 'CAN', 'CHN', 'CYP', 'EGY', 'FRA', 'IND', 'IDN', 'ITA', 'JPN', 'MYS', 'MEX', 'NLD', 'PAN', 'PHL', 'POL', 'ROU', 'RUS', 'SRB', 'SGP', 'ZAF', 'ESP', 'SWE', 'THA', 'TUR', 'GBR', 'USA'
    ])) {
      return true;
    }

    // if country requires
    if (empty($state) || !is_string($state)) {
      $error = 'The country of ' . $country . ' requires providing your state.';
      return false;
    }
    return true;
  }

  /**
   * Checks whether the given country requires a state
   *
   * @param string $address
   * @param string $data
   * @param [type] $error
   * @return boolean
   */
  public function country_require_zip($zip = null, $country = null, &$error = null): bool {
    if (empty($country) || !is_string($country)) {
      $error = 'Country is required.';
      return false;
    } else {
      $country = strtoupper($country);
    }

    // if country doesn't require
    if (!in_array($country, [
      'ARG', 'AUS', 'BGR', 'CAN', 'CHN', 'CYP', 'EGY', 'FRA', 'IND', 'IDN', 'ITA', 'JPN', 'MYS', 'MEX', 'NLD', 'PAN', 'PHL', 'POL', 'ROU', 'RUS', 'SRB', 'SGP', 'ZAF', 'ESP', 'SWE', 'THA', 'TUR', 'GBR', 'USA'
    ])) {
      return true;
    }

    // if country requires
    if (empty($zip) || !is_string($zip)) {
      $error = 'The country of ' . $country . ' requires providing your ZIP code.';
      return false;
    }
    return true;
  }
}
