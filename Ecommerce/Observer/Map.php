<?php

namespace Ecommerce\Observer;

//require_once __DIR__ . '/../ThirdParty/ObserverForFooAPI.php';
//require_once __DIR__ . '/../ThirdParty/ObserverForBarAPI.php';

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
// $observerForFoo = new ObserverForFooAPI();
// $observerForBar = new ObserverForBarAPI();

$observerMap = [
  // InternalClient::class => [
  //   $observerForFoo, // these will get updated whenever InternalClient updates
  //   $observerForBar,
  // ],
];
