<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2019-2020
 * @package MShop
 * @subpackage Slider
 */


namespace Aimeos\MShop\Slider\Provider\Delivery;


/**
 * Manual delivery provider implementation
 *
 * @package MShop
 * @subpackage Slider
 */
class Standard
	extends \Aimeos\MShop\Slider\Provider\Delivery\Base
	implements \Aimeos\MShop\Slider\Provider\Delivery\Iface
{
	/**
	 * Updates the delivery status
	 *
	 * @param \Aimeos\MShop\Order\Item\Iface $order Order instance
	 * @return \Aimeos\MShop\Order\Item\Iface Updated order item
	 */
	public function process( \Aimeos\MShop\Order\Item\Iface $order ) : \Aimeos\MShop\Order\Item\Iface
	{
		return $order->setDeliveryStatus( \Aimeos\MShop\Order\Item\Base::STAT_PENDING );
	}
}
