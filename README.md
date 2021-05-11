# CodeIgniter 4 Ecommerce

Set of services and models for creating a basic e-commerce website with CodeIgniter. Contains:

- **Analytics service** — track sessions, visits, views, clicks and visitors
- **Cart service** — basic cart manipulation and convenient Product interface
- **Client service** — track clients and their data
- **Orders service** — place orders via your favorite API (see supported APIs below)
- **Tags service** — for tagging Clients based on intent

You can also configure your services to update external marketing APIs (ActiveCampaign, Segment, Google Analytics, etc.)

## How to use

With this package, you can quickly add e-commerce functionality to any CodeIgniter 4 project in seconds.

Everything you need is already built in:

1. Track website visitors (including buyers) across sessions. The Client service stores data for each of your website visitors in a cookie to maintain persistency across sessions. Each user is saved in your database.
2. Easily track sessions and page visits. Simply use the `Ecommerce\Controllers\Page` controller as a basis for all your marketing pages.
3. Monitor clicks and page views. Create a script on the front-end that sends click and view data in a POST request, then use the built-in `Ecommerce\Controllers\Analytics` controller for accepting the requests and registering clicks and page views.
4. Accept orders with the Orders service. Create a controller for accepting orders. Configure your payment processor in `Ecommerce\Config\Ecommerce->paymentProcessor`, then use the Orders service to facilitate transactions.
5. If you need to send data to an external service, make an `Ecommerce\Observer\IObserver` and register it in `Ecommerce\Config\Ecommerce->observerMap` (for more info, see Key Concepts > IObservers.

## Key Concepts

### Client Service

The Client service is designed to monitor website visitors and easily let you turn them into buyers.

Each client has to be initialized whenever a new page is requested. The built-in `Page` controller handles that, but make sure you use it instead of the `BaseController` shipped with CodeIgniter.

Clients that are not users do not have their data set. When they reach checkout, their data should be updated, and when they finally buy, they should also receive a password for logging in.

### Analytics Service

The Analytics service tracks 4 key elements: Visits, Views, Clicks and Sessions.

**Sessions** and **Visits** must be tracked any time a page is loaded. **Sessions** are used to track user sessions, and are stored in CodeIgniter's `session()`.

**Visits** represent visits to pages. They include both views and bounces. A visit should be recorded any time a controller has to respond with a page.

**Views** and **Clicks** are not registered from the back-end upon loading the page. These have to be sent by the browser from the front-end, and additionally recorded (plug-and-play implementation provided in `Ecommerce\Controllers\Analytics`.)

**Views** are different than Visits in that Views may <u>not</u> include bounces. On the contrary — a View should only be sent if a visitor did <u>not</u> bounce.

**Clicks** represent clicks on the page. A Click must be submitted with the page slug (the `path` parameter) and the ID of the element that was clicked (the `element_id` parameter.)

### IObservers

IObservers can be used for sending data to third party tools, or other parts of your application.

Every service in the package works like a publisher. Upon initialization, the `IPublisher` class looks for observers that were assigned to it. When an event in the code occurs that should be propagated to observers, the publisher calls all of its assigned observers and passes the event code and data.

1. `IPublisher` > fetches (initialized) `IObserver` assigned to it in `Ecommerce\Config\Ecommerce->observerMap` array.
2. An event in the code happens that has to be propagated. `IPublisher` create a new `IEvent` class, that has to implement two functions:
   1. `code(): int` — used for passing the event code
   2. `data(): mixed` — used for passing the event data.
3. `IPublisher` calls all `IObserver` instances it was assigned to, passing them the newly-created `IEvent` object instance.
4. `IObserver` instances each handle the event on their own.

IObservers are observers that listen to events occurring in the system.

They are registered at runtime in `Ecommerce\Config\Ecommerce->observerMap`. For each class, its assigned observers have to be added as an array whose key is the `::class` value of the class.

For example, let's say a user clicked a button on our website.

The click has been registered with a front-end script on our site. The script sent a POST request to the server, which then handled the request with the built-in `Ecommerce\Controllers\Analytics` controller.

The controller called the default `AnalyticsInterface` service (`InternalAnalytics`) method `addClick`, which is an `IPublisher`. Upon initialization, `IPublisher` fetches all the observers related to it from the `observerMap` (see array below.)

When the click was registered in the database, `InternalAnalytics` fired the `publish` event, which then called each of the registered observers.

The observer named `observerSegment`'s method `listen(IEvent $ie)` was called. The method firstly verifies that the event is of the correct type (by checking the `IEvent->code(): int`, and if it matches `IEvent::EVENT_NEW_CLICK`, the method then sends data to the Segment application servers for third-party processing.

Example value in `$observerMap` mentioned above:

```php
$observerMap = [
    AnalyticsInterface::class => [
        ObserverClass::class // IObserver class name. ObserverClass::init() will be called to get instance
    ]
]
```

This way, any event — be it a view, click, or even order — can be propagated to third party tools.

**NOTE:** third party tools can <u>not</u> modify the original event. It is provided as a read-only object and the code execution cannot be altered by observers (i.e. cannot be used for async communication with another server.)

## Installation

1. **Download the library:**

   `git clone` this library into your `app/ThirdParty` directory

2. **Install the dependencies:**

   - [Omnipay](https://packagist.org/packages/omnipay/common): `composer require omnipay/common`

3. **Add the library:**

   Inside `app/Config/Autoload.php`, locate the `$ps4` array, and append the following line:

   `'Ecommerce'  => APPPATH . 'ThirdParty/Ecommerce',`

4. **Add validation rules:**

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

7. **Start using!**

   Use `Ecommerce\Controllers\Page` as your base controller to track website visitors and sessions.

   You can create a custom controller for processing Views and Clicks, or use the built-in `Ecommerce\Controllers\Analytics` controller for plug-and-play processing.
   
   Create a controller for accepting order data, then decide how you want to manage your Clients based on the orders and use the built-in Order service for processing transactions.