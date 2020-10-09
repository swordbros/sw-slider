<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2020
 * @package MShop
 * @subpackage Slider
 */


namespace Aimeos\MShop\Slider\Provider\Decorator;


/**
 * Negation decorator for slider providers
 *
 * This decorator inverts the results of the following decorators or the
 * slider provider itself. In combination with the category decorator that
 * enforces a product of a configured category being in the basket, it can be
 * use to disable the slider option if such a product is in the basket.
 *
 * @package MShop
 * @subpackage Slider
 */
class Not
	extends \Aimeos\MShop\Slider\Provider\Decorator\Base
	implements \Aimeos\MShop\Slider\Provider\Decorator\Iface
{
	/**
	 * Checks if the products are withing the allowed code is allowed for the slider provider.
	 *
	 * @param \Aimeos\MShop\Order\Item\Base\Iface $basket Basket object
	 * @return bool True if payment provider can be used, false if not
	 */
	public function isAvailable( \Aimeos\MShop\Order\Item\Base\Iface $basket ) : bool
	{
		return !$this->getProvider()->isAvailable( $basket );
	}
}
