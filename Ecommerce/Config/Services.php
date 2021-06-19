<?php

namespace Ecommerce\Config;

use CodeIgniter\Config\Services as CoreServices;
use Ecommerce\Analytics\AnalyticsInterface;
use Ecommerce\Cart\CartInterface;
use Ecommerce\Contact\ContactInterface;
use Ecommerce\Orders\OrderInterface;
use Ecommerce\Analytics\InternalAnalytics\InternalAnalytics;
use Ecommerce\Cart\InternalCart\InternalCart;
use Ecommerce\Contact\ContactServiceInterface;
use Ecommerce\Contact\InternalContact\InternalContactService;
use Ecommerce\Orders\InternalOrders\InternalOrders;
use Ecommerce\Tags\InternalTags\InternalTags;
use Ecommerce\Tags\TagInterface;
use Ecommerce\Visitor\InternalVisitor\InternalVisitorService;
use Ecommerce\Visitor\VisitorServiceInterface;

class Services extends CoreServices {

	/**
	 * Service for processing analytics.
	 *
	 * @param boolean $getShared
	 * @return AnalyticsInterface
	 */
	public static function analytics($getShared = true): AnalyticsInterface {
		if ($getShared) {
			return static::getSharedInstance('analytics');
		}

		return new InternalAnalytics();
	}

	/**
	 * Service for contact management.
	 *
	 * @param boolean $getShared
	 * @return ContactInterface
	 */
	public static function contact($getShared = true): ContactServiceInterface {
		if ($getShared) {
			return static::getSharedInstance('contact');
		}

		return new InternalContactService();
	}

	/**
	 * Service for cart management.
	 *
	 * @param boolean $getShared
	 * @return CartInterface
	 */
	public static function cart($getShared = true): CartInterface {
		if ($getShared) {
			return static::getSharedInstance('cart');
		}

		return new InternalCart();
	}

	/**
	 * Service for processing orders. In case there is an issue during initializ-
	 * -ation, the returned value is null.
	 *
	 * @param boolean $getShared
	 * @return OrderInterface|null
	 */
	public static function orders($getShared = true): ?OrderInterface {
		if ($getShared) {
			return static::getSharedInstance('orders');
		}

		try {
			$gw = config('Ecommerce')->paymentGateway;
			$gw = new $gw;

			return new InternalOrders($gw);
		} catch (\Exception $e) {
			log_message('error', $e->getMessage());
			return null;
		}
	}

	/**
	 * Service for tag management.
	 *
	 * @param boolean $getShared
	 * @return TagInterface
	 */
	public static function tags($getShared = true): TagInterface {
		if ($getShared) {
			return static::getSharedInstance('tags');
		}

		return new InternalTags();
	}

	/**
	 * Service for visitor management.
	 *
	 * @param boolean $getShared
	 * @return VisitorServiceInterface
	 */
	public static function visitor($getShared = true): VisitorServiceInterface {
		if ($getShared) {
			return static::getSharedInstance('visitor');
		}

		return new InternalVisitorService();
	}
}
