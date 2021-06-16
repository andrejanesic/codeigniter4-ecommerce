<?php

namespace Ecommerce\Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Stores E-commerce add-on configuration
 *
 * @package Config
 */
class Ecommerce extends BaseConfig
{

  /* ----- Store support ----- */

  // Supported countries
  public $supportedCountries = [
    'ALA', 'AFG', 'ALB', 'DZA', 'ASM', 'AND', 'AGO', 'AIA', 'ATA', 'ATG', 'ARG', 'ARM', 'ABW', 'AUS', 'AUT', 'AZE', 'BHS', 'BHR', 'BGD', 'BRB', 'BLR', 'BEL', 'BLZ', 'BEN', 'BMU', 'BTN', 'BOL', 'BES', 'BIH', 'BWA', 'BVT', 'BRA', 'IOT', 'BRN', 'BGR', 'BFA', 'BDI', 'CPV', 'KHM', 'CMR', 'CAN', 'CYM', 'CAF', 'TCD', 'CHL', 'CHN', 'CXR', 'CCK', 'COL', 'COM', 'COD', 'COG', 'COK', 'CRI', 'HRV', 'CUB', 'CUW', 'CYP', 'CZE', 'CIV', 'DNK', 'DJI', 'DMA', 'DOM', 'ECU', 'EGY', 'SLV', 'GNQ', 'ERI', 'EST', 'SWZ', 'ETH', 'FLK', 'FRO', 'FJI', 'FIN', 'FRA', 'GUF', 'PYF', 'ATF', 'GAB', 'GMB', 'GEO', 'DEU', 'GHA', 'GIB', 'GRC', 'GRL', 'GRD', 'GLP', 'GUM', 'GTM', 'GGY', 'GIN', 'GNB', 'GUY', 'HTI', 'HMD', 'VAT', 'HND', 'HKG', 'HUN', 'ISL', 'IND', 'IDN', 'IRN', 'IRQ', 'IRL', 'IMN', 'ISR', 'ITA', 'JAM', 'JPN', 'JEY', 'JOR', 'KAZ', 'KEN', 'KIR', 'PRK', 'KOR', 'KWT', 'KGZ', 'LAO', 'LVA', 'LBN', 'LSO', 'LBR', 'LBY', 'LIE', 'LTU', 'LUX', 'MAC', 'MDG', 'MWI', 'MYS', 'MDV', 'MLI', 'MLT', 'MHL', 'MTQ', 'MRT', 'MUS', 'MYT', 'MEX', 'FSM', 'MDA', 'MCO', 'MNG', 'MNE', 'MSR', 'MAR', 'MOZ', 'MMR', 'NAM', 'NRU', 'NPL', 'NLD', 'NCL', 'NZL', 'NIC', 'NER', 'NGA', 'NIU', 'NFK', 'MNP', 'NOR', 'OMN', 'PAK', 'PLW', 'PSE', 'PAN', 'PNG', 'PRY', 'PER', 'PHL', 'PCN', 'POL', 'PRT', 'PRI', 'QAT', 'MKD', 'ROU', 'RUS', 'RWA', 'REU', 'BLM', 'SHN', 'KNA', 'LCA', 'MAF', 'SPM', 'VCT', 'WSM', 'SMR', 'STP', 'SAU', 'SEN', 'SRB', 'SYC', 'SLE', 'SGP', 'SXM', 'SVK', 'SVN', 'SLB', 'SOM', 'ZAF', 'SGS', 'SSD', 'ESP', 'LKA', 'SDN', 'SUR', 'SJM', 'SWE', 'CHE', 'SYR', 'TWN', 'TJK', 'TZA', 'THA', 'TLS', 'TGO', 'TKL', 'TON', 'TTO', 'TUN', 'TUR', 'TKM', 'TCA', 'TUV', 'UGA', 'UKR', 'ARE', 'GBR', 'UMI', 'USA', 'URY', 'UZB', 'VUT', 'VEN', 'VNM', 'VGB', 'VIR', 'WLF', 'ESH', 'YEM', 'ZMB', 'ZWE',
  ];

  // Supported currencies
  public $supportedCurrencies = [
    'AFN', 'ALL', 'DZD', 'ARS', 'AUD', 'AZN', 'BSD', 'BDT', 'BBD', 'BZD', 'BMD', 'BOB', 'BWP', 'BRL', 'GBP', 'BND', 'BGN', 'CAD', 'CLP', 'CNY', 'COP', 'CRC', 'HRK', 'CZK', 'DKK', 'DOP', 'XCD', 'EGP', 'EUR', 'FJD', 'GTQ', 'HKD', 'HNL', 'HUF', 'INR', 'IDR', 'ILS', 'JMD', 'JPY', 'KZT', 'KES', 'LAK', 'MMK', 'LBP', 'LRD', 'MOP', 'MYR', 'MVR', 'MRO', 'MUR', 'MXN', 'MAD', 'NPR', 'TWD', 'NZD', 'NIO', 'NOK', 'PKR', 'PGK', 'PEN', 'PHP', 'PLN', 'QAR', 'RON', 'RUB', 'WST', 'SAR', 'SCR', 'SGD', 'SBD', 'ZAR', 'KRW', 'LKR', 'SEK', 'CHF', 'SYP', 'THB', 'TOP', 'TTD', 'TRY', 'UAH', 'AED', 'USD', 'VUV', 'VND', 'XOF', 'YER'
  ];


  /* ----- Observers ----- */

  /**
   * This array maps services to APIs they should update.
   * 
   * Create an instance of every Observer class you wish to update here, then
   * "map" which should update it.
   * 
   * The events which are sent to APIs are IEvent objects, and the data transmi-
   * -tted through IEvent->data() depends on the event nature. You need to check
   * the type and format of the returned data to work with it.
   * 
   * NOTE: ONLY THE SERVICES UPDATE THE APIs -- NOT THE OTHER WAY ROUND. You can-
   * -not update any object internally (in your db, etc.) from an API's IObserver
   * class. To do this, you need to extend a service interface and modify it (for
   * example, create a new class, inherit Internal(Service), and override, then
   * make it the default service in Ecommerce\Config\Services.)
   * 
   * NOTE: the classes which provide the update must be IPublishers. All classes
   * which are included in Ecommerce\Config\Services are IPublishers, and can be
   * used here.
   * 
   * You can also create IObservers for APIs on your own. Place them into the
   * /ThirdParty/ directory, and make sure to do require_once at the beginning of
   * this file.
   */

  // Example:
  // require_once __DIR__ . '/../ThirdParty/ObserverForFooAPI.php';
  // require_once __DIR__ . '/../ThirdParty/ObserverForBarAPI.php';
  // $observerForFoo = new ObserverForFooAPI();
  // $observerForBar = new ObserverForBarAPI();

  public $observerMap = [
    // InternalClient::class => [
    //   $observerForFoo, // these will get updated whenever InternalClient updates
    //   $observerForBar,
    // ],
  ];


  /* ----- Payment gateway ----- */
  public $paymentGateway = 'FooBar'; // put the class name of your Omnipay pay-
                                     // -ment gateway here, e.g.: Foo::class
}
