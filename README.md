# CodeIgniter 4 E-Commerce

Set of services and models for creating a basic E-commerce website with CodeIgniter. Contains:

- Analytics service — track sessions, visits, views, clicks and visitors
- Cart service — basic cart manipulation and convenient Product interface
- Client management service — track clients and their data
- Orders service — place orders via your favorite API (see supported APIs below)
- Tags service — for tagging Clients based on intent

You can also configure your services to update external marketing APIs (ActiveCampaign, Google Analytics, etc.)

## Installation

1. **Download the library:**

   `git clone` this library into your `app/ThirdParty` directory

2. **Install the dependencies:**

   - [Omnipay](https://packagist.org/packages/omnipay/common): `composer require omnipay/common`

3. **Add the library:**

   Inside `app/Config/Autoload.php`, locate the `$ps4` array, and append the following line:

   `'Ecommerce'  => APPPATH . 'ThirdParty/Ecommerce',`

4. **Add the validation rules:**

   Inside `app/Config/Validation.php`, locate the `$ruleSets` array, and append the following line:

   `\Ecommerce\Validation\OrderRules::class,`

5. **Add Common.php:**

   Open `app/Common.php` and append the following line to the end:

   `require_once 'ThirdParty' . DIRECTORY_SEPARATOR . 'Ecommerce' . DIRECTORY_SEPARATOR . 'Common.php';`

6. **Configure:**

   1. Make sure to set your database credentials in `.env` (as well as credentials for any APIs you wish to use)
   2. Perform all migrations with `php spark migrate`
   3. Configure which third-party APIs you want to update when your analytics, cart, client, orders and other services update (in file `Observer/Map.php`)
   4. Install and configure your Omnipay [payment gateway](https://github.com/thephpleague/omnipay#payment-gateways)