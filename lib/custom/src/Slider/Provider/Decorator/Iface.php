<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2020
 * @package MShop
 * @subpackage Slider
 */


namespace Aimeos\MShop\Slider\Provider\Decorator;


/**
 * Slider decorator interface.
 *
 * @package MShop
 * @subpackage Slider
 */
interface Iface
	extends \Aimeos\MShop\Slider\Provider\Iface
{
	/**
	 * Initializes a new slider provider object using the given context object.
	 *
	 * @param \Aimeos\MShop\Slider\Provider\Iface $provider Slider provider or decorator
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object with required objects
	 * @param \Aimeos\MShop\Slider\Item\Iface $sliderItem Slider item with configuration for the provider
	 * @return null
	 */
	public function __construct( \Aimeos\MShop\Slider\Provider\Iface $provider,
		\Aimeos\MShop\Context\Item\Iface $context, \Aimeos\MShop\Slider\Item\Iface $sliderItem );
}
