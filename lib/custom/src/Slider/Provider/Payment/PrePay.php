<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2012
 * @copyright Aimeos (aimeos.org), 2015-2020
 * @package MShop
 * @subpackage Slider
 */


namespace Aimeos\MShop\Slider\Provider\Payment;


/**
 * Payment provider for pre-paid orders.
 *
 * @package MShop
 * @subpackage Slider
 */
class PrePay
	extends \Aimeos\MShop\Slider\Provider\Payment\Base
	implements \Aimeos\MShop\Slider\Provider\Payment\Iface
{
	/**
	 * Cancels the authorization for the given order if supported.
	 *
	 * @param \Aimeos\MShop\Order\Item\Iface $order Order invoice object
	 * @return \Aimeos\MShop\Order\Item\Iface Updated order item
	 */
	public function cancel( \Aimeos\MShop\Order\Item\Iface $order ) : \Aimeos\MShop\Order\Item\Iface
	{
		$order->setPaymentStatus( \Aimeos\MShop\Order\Item\Base::PAY_CANCELED );
		return $this->saveOrder( $order );
	}


	/**
	 * Executes the payment again for the given order if supported.
	 * This requires support of the payment gateway and token based payment
	 *
	 * @param \Aimeos\MShop\Order\Item\Iface $order Order invoice object
	 * @return \Aimeos\MShop\Order\Item\Iface Updated order item
	 */
	public function repay( \Aimeos\MShop\Order\Item\Iface $order ) : \Aimeos\MShop\Order\Item\Iface
	{
		$order->setPaymentStatus( \Aimeos\MShop\Order\Item\Base::PAY_PENDING );
		return $this->saveOrder( $order );
	}


	/**
	 * Updates the orders for whose status updates have been received by the confirmation page
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object with parameters and request body
	 * @param \Aimeos\MShop\Order\Item\Iface $order Order item that should be updated
	 * @return \Aimeos\MShop\Order\Item\Iface Updated order item
	 * @throws \Aimeos\MShop\Slider\Exception If updating the orders failed
	 */
	public function updateSync( \Psr\Http\Message\ServerRequestInterface $request,
		\Aimeos\MShop\Order\Item\Iface $order ) : \Aimeos\MShop\Order\Item\Iface
	{
		if( $order->getPaymentStatus() === \Aimeos\MShop\Order\Item\Base::PAY_UNFINISHED )
		{
			$order->setPaymentStatus( \Aimeos\MShop\Order\Item\Base::PAY_PENDING );
			$order = $this->saveOrder( $order );
		}

		return $order;
	}


	/**
	 * Checks what features the payment provider implements.
	 *
	 * @param int $what Constant from abstract class
	 * @return bool True if feature is available in the payment provider, false if not
	 */
	public function isImplemented( int $what ) : bool
	{
		return $what === \Aimeos\MShop\Slider\Provider\Payment\Base::FEAT_CANCEL;
	}
}
