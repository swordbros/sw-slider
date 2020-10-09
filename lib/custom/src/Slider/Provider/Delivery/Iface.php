<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2020
 * @package MShop
 * @subpackage Slider
 */

namespace Aimeos\MShop\Slider\Provider\Delivery;


/**
 * Interface with specific methods for delivery providers
 *
 * @package MShop
 * @subpackage Slider
 */
interface Iface extends \Aimeos\MShop\Slider\Provider\Iface, \Aimeos\MShop\Slider\Provider\Factory\Iface
{
	/**
	 * Sends the order details to the ERP system for further processing
	 *
	 * @param \Aimeos\MShop\Order\Item\Iface $order Order invoice object to process
	 * @return \Aimeos\MShop\Order\Item\Iface Updated order item
	 */
	public function process( \Aimeos\MShop\Order\Item\Iface $order ) : \Aimeos\MShop\Order\Item\Iface;

	/**
	 * Sends the details of all orders to the ERP system for further processing
	 *
	 * @param \Aimeos\MShop\Order\Item\Iface[] $orders List of order invoice objects
	 * @return \Aimeos\MShop\Order\Item\Iface[] Updated order items
	 */
	public function processBatch( array $orders ) : array;
}
