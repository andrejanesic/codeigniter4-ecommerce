<?php

/* ----- Session And Cookie Keys ---- */

defined('S__SESSION_ID') || define('S__SESSION_ID', 'session_id');
defined('C__CLIENT') || define('C__CLIENT', 'client');
defined('S__CLIENT_AUTH') || define('S__CLIENT_AUTH', 'client_auth');
defined('S__CLIENT_ID') || define('S__CLIENT_ID', 'client_id');
defined('S__CLIENT_UID') || define('S__CLIENT_UID', 'client_uid');
defined('S__PASSWORD') || define('S__PASSWORD', 'password');
defined('S__TOKEN') || define('S__TOKEN', 'token');
defined('S__EMAIL') || define('S__EMAIL', 'email');
defined('S__FIRSTNAME') || define('S__FIRSTNAME', 'firstname');
defined('S__LASTNAME') || define('S__LASTNAME', 'lastname');
defined('S__PHONE') || define('S__PHONE', 'phone');
defined('S__COUNTRY') || define('S__COUNTRY', 'country');
defined('S__STATE') || define('S__STATE', 'state');
defined('S__CITY') || define('S__CITY', 'phone');
defined('S__ZIP') || define('S__ZIP', 'zip');
defined('S__ADDRESS_1') || define('S__ADDRESS_1', 'address_1');
defined('S__ADDRESS_2') || define('S__ADDRESS_2', 'address_2');
defined('S__LAST_IP') || define('S__LAST_IP', 'last_ip');
defined('C__CART') || define('C__CART', 'cart');
defined('S__CART') || define('S__CART', 'cart');

/* ----- Standardized data ----- */

defined('COUNTRY_CODES') || define('COUNTRY_CODES', [
  'Aaland Islands' => 'ALA',
  'Afghanistan' => 'AFG',
  'Albania' => 'ALB',
  'Algeria' => 'DZA',
  'American Samoa' => 'ASM',
  'Andorra' => 'AND',
  'Angola' => 'AGO',
  'Anguilla' => 'AIA',
  'Antarctica' => 'ATA',
  'Antigua and Barbuda' => 'ATG',
  'Argentina' => 'ARG',
  'Armenia' => 'ARM',
  'Aruba' => 'ABW',
  'Australia' => 'AUS',
  'Austria' => 'AUT',
  'Azerbaijan' => 'AZE',
  'Bahamas (the)' => 'BHS',
  'Bahrain' => 'BHR',
  'Bangladesh' => 'BGD',
  'Barbados' => 'BRB',
  'Belarus' => 'BLR',
  'Belgium' => 'BEL',
  'Belize' => 'BLZ',
  'Benin' => 'BEN',
  'Bermuda' => 'BMU',
  'Bhutan' => 'BTN',
  'Bolivia (Plurinational State of)' => 'BOL',
  'Bonaire, Sint Eustatius and Saba' => 'BES',
  'Bosnia and Herzegovina' => 'BIH',
  'Botswana' => 'BWA',
  'Bouvet Island' => 'BVT',
  'Brazil' => 'BRA',
  'British Indian Ocean Territory (the)' => 'IOT',
  'Brunei Darussalam' => 'BRN',
  'Bulgaria' => 'BGR',
  'Burkina Faso' => 'BFA',
  'Burundi' => 'BDI',
  'Cabo Verde' => 'CPV',
  'Cambodia' => 'KHM',
  'Cameroon' => 'CMR',
  'Canada' => 'CAN',
  'Cayman Islands (the)' => 'CYM',
  'Central African Republic (the)' => 'CAF',
  'Chad' => 'TCD',
  'Chile' => 'CHL',
  'China' => 'CHN',
  'Christmas Island' => 'CXR',
  'Cocos (Keeling) Islands (the)' => 'CCK',
  'Colombia' => 'COL',
  'Comoros (the)' => 'COM',
  'Congo (the Democratic Republic of the)' => 'COD',
  'Congo (the)' => 'COG',
  'Cook Islands (the)' => 'COK',
  'Costa Rica' => 'CRI',
  'Croatia' => 'HRV',
  'Cuba' => 'CUB',
  'Curaçao' => 'CUW',
  'Cyprus' => 'CYP',
  'Czechia' => 'CZE',
  'Cote d\'Ivoire' => 'CIV',
  'Denmark' => 'DNK',
  'Djibouti' => 'DJI',
  'Dominica' => 'DMA',
  'Dominican Republic (the)' => 'DOM',
  'Ecuador' => 'ECU',
  'Egypt' => 'EGY',
  'El Salvador' => 'SLV',
  'Equatorial Guinea' => 'GNQ',
  'Eritrea' => 'ERI',
  'Estonia' => 'EST',
  'Eswatini' => 'SWZ',
  'Ethiopia' => 'ETH',
  'Falkland Islands (the) [Malvinas]' => 'FLK',
  'Faroe Islands (the)' => 'FRO',
  'Fiji' => 'FJI',
  'Finland' => 'FIN',
  'France' => 'FRA',
  'French Guiana' => 'GUF',
  'French Polynesia' => 'PYF',
  'French Southern Territories (the)' => 'ATF',
  'Gabon' => 'GAB',
  'Gambia (the)' => 'GMB',
  'Georgia' => 'GEO',
  'Germany' => 'DEU',
  'Ghana' => 'GHA',
  'Gibraltar' => 'GIB',
  'Greece' => 'GRC',
  'Greenland' => 'GRL',
  'Grenada' => 'GRD',
  'Guadeloupe' => 'GLP',
  'Guam' => 'GUM',
  'Guatemala' => 'GTM',
  'Guernsey' => 'GGY',
  'Guinea' => 'GIN',
  'Guinea-Bissau' => 'GNB',
  'Guyana' => 'GUY',
  'Haiti' => 'HTI',
  'Heard Island and McDonald Islands' => 'HMD',
  'Holy See (the)' => 'VAT',
  'Honduras' => 'HND',
  'Hong Kong' => 'HKG',
  'Hungary' => 'HUN',
  'Iceland' => 'ISL',
  'India' => 'IND',
  'Indonesia' => 'IDN',
  'Iran (Islamic Republic of)' => 'IRN',
  'Iraq' => 'IRQ',
  'Ireland' => 'IRL',
  'Isle of Man' => 'IMN',
  'Israel' => 'ISR',
  'Italy' => 'ITA',
  'Jamaica' => 'JAM',
  'Japan' => 'JPN',
  'Jersey' => 'JEY',
  'Jordan' => 'JOR',
  'Kazakhstan' => 'KAZ',
  'Kenya' => 'KEN',
  'Kiribati' => 'KIR',
  'Korea (the Democratic People\'s Republic of)' => 'PRK',
  'Korea (the Republic of)' => 'KOR',
  'Kuwait' => 'KWT',
  'Kyrgyzstan' => 'KGZ',
  'Lao People\'s Democratic Republic (the)' => 'LAO',
  'Latvia' => 'LVA',
  'Lebanon' => 'LBN',
  'Lesotho' => 'LSO',
  'Liberia' => 'LBR',
  'Libya' => 'LBY',
  'Liechtenstein' => 'LIE',
  'Lithuania' => 'LTU',
  'Luxembourg' => 'LUX',
  'Macao' => 'MAC',
  'Madagascar' => 'MDG',
  'Malawi' => 'MWI',
  'Malaysia' => 'MYS',
  'Maldives' => 'MDV',
  'Mali' => 'MLI',
  'Malta' => 'MLT',
  'Marshall Islands (the)' => 'MHL',
  'Martinique' => 'MTQ',
  'Mauritania' => 'MRT',
  'Mauritius' => 'MUS',
  'Mayotte' => 'MYT',
  'Mexico' => 'MEX',
  'Micronesia (Federated States of)' => 'FSM',
  'Moldova (the Republic of)' => 'MDA',
  'Monaco' => 'MCO',
  'Mongolia' => 'MNG',
  'Montenegro' => 'MNE',
  'Montserrat' => 'MSR',
  'Morocco' => 'MAR',
  'Mozambique' => 'MOZ',
  'Myanmar' => 'MMR',
  'Namibia' => 'NAM',
  'Nauru' => 'NRU',
  'Nepal' => 'NPL',
  'Netherlands (the)' => 'NLD',
  'New Caledonia' => 'NCL',
  'New Zealand' => 'NZL',
  'Nicaragua' => 'NIC',
  'Niger (the)' => 'NER',
  'Nigeria' => 'NGA',
  'Niue' => 'NIU',
  'Norfolk Island' => 'NFK',
  'Northern Mariana Islands (the)' => 'MNP',
  'Norway' => 'NOR',
  'Oman' => 'OMN',
  'Pakistan' => 'PAK',
  'Palau' => 'PLW',
  'Palestine, State of' => 'PSE',
  'Panama' => 'PAN',
  'Papua New Guinea' => 'PNG',
  'Paraguay' => 'PRY',
  'Peru' => 'PER',
  'Philippines (the)' => 'PHL',
  'Pitcairn' => 'PCN',
  'Poland' => 'POL',
  'Portugal' => 'PRT',
  'Puerto Rico' => 'PRI',
  'Qatar' => 'QAT',
  'Republic of North Macedonia' => 'MKD',
  'Romania' => 'ROU',
  'Russian Federation (the)' => 'RUS',
  'Rwanda' => 'RWA',
  'Reunion' => 'REU',
  'Saint Barthélemy' => 'BLM',
  'Saint Helena, Ascension and Tristan da Cunha' => 'SHN',
  'Saint Kitts and Nevis' => 'KNA',
  'Saint Lucia' => 'LCA',
  'Saint Martin (French part)' => 'MAF',
  'Saint Pierre and Miquelon' => 'SPM',
  'Saint Vincent and the Grenadines' => 'VCT',
  'Samoa' => 'WSM',
  'San Marino' => 'SMR',
  'Sao Tome and Principe' => 'STP',
  'Saudi Arabia' => 'SAU',
  'Senegal' => 'SEN',
  'Serbia' => 'SRB',
  'Seychelles' => 'SYC',
  'Sierra Leone' => 'SLE',
  'Singapore' => 'SGP',
  'Sint Maarten (Dutch part)' => 'SXM',
  'Slovakia' => 'SVK',
  'Slovenia' => 'SVN',
  'Solomon Islands' => 'SLB',
  'Somalia' => 'SOM',
  'South Africa' => 'ZAF',
  'South Georgia and the South Sandwich Islands' => 'SGS',
  'South Sudan' => 'SSD',
  'Spain' => 'ESP',
  'Sri Lanka' => 'LKA',
  'Sudan (the)' => 'SDN',
  'Suriname' => 'SUR',
  'Svalbard and Jan Mayen' => 'SJM',
  'Sweden' => 'SWE',
  'Switzerland' => 'CHE',
  'Syrian Arab Republic' => 'SYR',
  'Taiwan (Province of China)' => 'TWN',
  'Tajikistan' => 'TJK',
  'Tanzania, United Republic of' => 'TZA',
  'Thailand' => 'THA',
  'Timor-Leste' => 'TLS',
  'Togo' => 'TGO',
  'Tokelau' => 'TKL',
  'Tonga' => 'TON',
  'Trinidad and Tobago' => 'TTO',
  'Tunisia' => 'TUN',
  'Turkey' => 'TUR',
  'Turkmenistan' => 'TKM',
  'Turks and Caicos Islands (the)' => 'TCA',
  'Tuvalu' => 'TUV',
  'Uganda' => 'UGA',
  'Ukraine' => 'UKR',
  'United Arab Emirates (the)' => 'ARE',
  'United Kingdom of Great Britain and Northern Ireland' => 'GBR',
  'United States Minor Outlying Islands' => 'UMI',
  'United States of America' => 'USA',
  'Uruguay' => 'URY',
  'Uzbekistan' => 'UZB',
  'Vanuatu' => 'VUT',
  'Venezuela (Bolivarian Republic of)' => 'VEN',
  'Viet Nam' => 'VNM',
  'Virgin Islands (British)' => 'VGB',
  'Virgin Islands (U.S.)' => 'VIR',
  'Wallis and Futuna' => 'WLF',
  'Western Sahara' => 'ESH',
  'Yemen' => 'YEM',
  'Zambia' => 'ZMB',
  'Zimbabwe' => 'ZWE',
]);

defined('CURRENCY_CODES') || define('CURRENCY_CODES', [
  'United Arab Emirates Dirham' => 'AED',
  'Afghanistan Afghani' => 'AFN',
  'Albania Lek' => 'ALL',
  'Armenia Dram' => 'AMD',
  'Netherlands Antilles Guilder' => 'ANG',
  'Angola Kwanza' => 'AOA',
  'Argentina Peso' => 'ARS',
  'Australia Dollar' => 'AUD',
  'Aruba Guilder' => 'AWG',
  'Azerbaijan Manat' => 'AZN',
  'Bosnia and Herzegovina Convertible Mark' => 'BAM',
  'Barbados Dollar' => 'BBD',
  'Bangladesh Taka' => 'BDT',
  'Bulgaria Lev' => 'BGN',
  'Bahrain Dinar' => 'BHD',
  'Burundi Franc' => 'BIF',
  'Bermuda Dollar' => 'BMD',
  'Brunei Darussalam Dollar' => 'BND',
  'Bolivia BolÃ­viano' => 'BOB',
  'Brazil Real' => 'BRL',
  'Bahamas Dollar' => 'BSD',
  'Bhutan Ngultrum' => 'BTN',
  'Botswana Pula' => 'BWP',
  'Belarus Ruble' => 'BYN',
  'Belize Dollar' => 'BZD',
  'Canada Dollar' => 'CAD',
  'Congo/Kinshasa Franc' => 'CDF',
  'Switzerland Franc' => 'CHF',
  'Chile Peso' => 'CLP',
  'China Yuan Renminbi' => 'CNY',
  'Colombia Peso' => 'COP',
  'Costa Rica Colon' => 'CRC',
  'Cuba Convertible Peso' => 'CUC',
  'Cuba Peso' => 'CUP',
  'Cape Verde Escudo' => 'CVE',
  'Czech Republic Koruna' => 'CZK',
  'Djibouti Franc' => 'DJF',
  'Denmark Krone' => 'DKK',
  'Dominican Republic Peso' => 'DOP',
  'Algeria Dinar' => 'DZD',
  'Egypt Pound' => 'EGP',
  'Eritrea Nakfa' => 'ERN',
  'Ethiopia Birr' => 'ETB',
  'Euro Member Countries' => 'EUR',
  'Fiji Dollar' => 'FJD',
  'Falkland Islands (Malvinas) Pound' => 'FKP',
  'United Kingdom Pound' => 'GBP',
  'Georgia Lari' => 'GEL',
  'Guernsey Pound' => 'GGP',
  'Ghana Cedi' => 'GHS',
  'Gibraltar Pound' => 'GIP',
  'Gambia Dalasi' => 'GMD',
  'Guinea Franc' => 'GNF',
  'Guatemala Quetzal' => 'GTQ',
  'Guyana Dollar' => 'GYD',
  'Hong Kong Dollar' => 'HKD',
  'Honduras Lempira' => 'HNL',
  'Croatia Kuna' => 'HRK',
  'Haiti Gourde' => 'HTG',
  'Hungary Forint' => 'HUF',
  'Indonesia Rupiah' => 'IDR',
  'Israel Shekel' => 'ILS',
  'Isle of Man Pound' => 'IMP',
  'India Rupee' => 'INR',
  'Iraq Dinar' => 'IQD',
  'Iran Rial' => 'IRR',
  'Iceland Krona' => 'ISK',
  'Jersey Pound' => 'JEP',
  'Jamaica Dollar' => 'JMD',
  'Jordan Dinar' => 'JOD',
  'Japan Yen' => 'JPY',
  'Kenya Shilling' => 'KES',
  'Kyrgyzstan Som' => 'KGS',
  'Cambodia Riel' => 'KHR',
  'Comorian Franc' => 'KMF',
  'Korea (North) Won' => 'KPW',
  'Korea (South) Won' => 'KRW',
  'Kuwait Dinar' => 'KWD',
  'Cayman Islands Dollar' => 'KYD',
  'Kazakhstan Tenge' => 'KZT',
  'Laos Kip' => 'LAK',
  'Lebanon Pound' => 'LBP',
  'Sri Lanka Rupee' => 'LKR',
  'Liberia Dollar' => 'LRD',
  'Lesotho Loti' => 'LSL',
  'Libya Dinar' => 'LYD',
  'Morocco Dirham' => 'MAD',
  'Moldova Leu' => 'MDL',
  'Madagascar Ariary' => 'MGA',
  'Macedonia Denar' => 'MKD',
  'Myanmar (Burma) Kyat' => 'MMK',
  'Mongolia Tughrik' => 'MNT',
  'Macau Pataca' => 'MOP',
  'Mauritania Ouguiya' => 'MRU',
  'Mauritius Rupee' => 'MUR',
  'Maldives (Maldive Islands) Rufiyaa' => 'MVR',
  'Malawi Kwacha' => 'MWK',
  'Mexico Peso' => 'MXN',
  'Malaysia Ringgit' => 'MYR',
  'Mozambique Metical' => 'MZN',
  'Namibia Dollar' => 'NAD',
  'Nigeria Naira' => 'NGN',
  'Nicaragua Cordoba' => 'NIO',
  'Norway Krone' => 'NOK',
  'Nepal Rupee' => 'NPR',
  'New Zealand Dollar' => 'NZD',
  'Oman Rial' => 'OMR',
  'Panama Balboa' => 'PAB',
  'Peru Sol' => 'PEN',
  'Papua New Guinea Kina' => 'PGK',
  'Philippines Peso' => 'PHP',
  'Pakistan Rupee' => 'PKR',
  'Poland Zloty' => 'PLN',
  'Paraguay Guarani' => 'PYG',
  'Qatar Riyal' => 'QAR',
  'Romania Leu' => 'RON',
  'Serbia Dinar' => 'RSD',
  'Russia Ruble' => 'RUB',
  'Rwanda Franc' => 'RWF',
  'Saudi Arabia Riyal' => 'SAR',
  'Solomon Islands Dollar' => 'SBD',
  'Seychelles Rupee' => 'SCR',
  'Sudan Pound' => 'SDG',
  'Sweden Krona' => 'SEK',
  'Singapore Dollar' => 'SGD',
  'Saint Helena Pound' => 'SHP',
  'Sierra Leone Leone' => 'SLL',
  'Somalia Shilling' => 'SOS',
  'Seborga Luigino' => 'SPL',
  'Suriname Dollar' => 'SRD',
  'Sao Tome And Principe Dobra' => 'STN',
  'El Salvador Colon' => 'SVC',
  'Syria Pound' => 'SYP',
  'eSwatini Lilangeni' => 'SZL',
  'Thailand Baht' => 'THB',
  'Tajikistan Somoni' => 'TJS',
  'Turkmenistan Manat' => 'TMT',
  'Tunisia Dinar' => 'TND',
  'Tonga Pa\'anga' => 'TOP',
  'Turkey Lira' => 'TRY',
  'Trinidad and Tobago Dollar' => 'TTD',
  'Tuvalu Dollar' => 'TVD',
  'Taiwan New Dollar' => 'TWD',
  'Tanzania Shilling' => 'TZS',
  'Ukraine Hryvnia' => 'UAH',
  'Uganda Shilling' => 'UGX',
  'United States Dollar' => 'USD',
  'Uruguay Peso' => 'UYU',
  'Uzbekistan Som' => 'UZS',
  'Venezuela BolÃ­var' => 'VEF',
  'Viet Nam Dong' => 'VND',
  'Vanuatu Vatu' => 'VUV',
  'Samoa Tala' => 'WST',
  'Yemen Rial' => 'YER',
  'South Africa Rand' => 'ZAR',
  'Zambia Kwacha' => 'ZMW',
  'Zimbabwe Dollar' => 'ZWD'
]);
