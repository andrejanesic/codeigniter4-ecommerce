<?php

namespace Ecommerce\Config;

use CodeIgniter\Config\Services as CoreServices;
use Ecommerce\Analytics\AnalyticsInterface;
use Ecommerce\Cart\CartInterface;
use Ecommerce\Client\ClientInterface;
use Ecommerce\Orders\OrderInterface;
use Ecommerce\Analytics\InternalAnalytics\InternalAnalytics;
use Ecommerce\Cart\InternalCart\InternalCart;
use Ecommerce\Client\InternalClient\InternalClient;
use Ecommerce\Tags\InternalTags\InternalTags;
use Ecommerce\Tags\TagInterface;
use Omnipay\Omnipay;

class Services extends CoreServices {

	public static function analytics($getShared = true): AnalyticsInterface {
		if ($getShared) {
			return static::getSharedInstance('analytics');
		}

		return new InternalAnalytics();
	}

	public static function client($getShared = true): ClientInterface {
		if ($getShared) {
			return static::getSharedInstance('client');
		}

		return new InternalClient();
	}

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

		// configure your payment gateway here
		try {
			$gw = Omnipay::create('FooBar');
			// $gw->...

			return new OrderInterface($gw);
		} catch (\Exception $e) {
			log_message('error', $e->getMessage());
			return null;
		}
	}

	public static function tags($getShared = true): TagInterface {
		if ($getShared) {
			return static::getSharedInstance('tags');
		}

		return new InternalTags();
	}
}
