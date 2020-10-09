<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2020
 * @package MShop
 * @subpackage Slider
 */


namespace Aimeos\MShop\Slider\Manager;


/**
 * Common interface for all slider manager implementations.
 *
 * @package MShop
 * @subpackage Slider
 */
interface Iface
	extends \Aimeos\MShop\Common\Manager\Iface, \Aimeos\MShop\Common\Manager\Find\Iface, \Aimeos\MShop\Common\Manager\ListRef\Iface
{
	/**
	 * Returns the slider provider which is responsible for the slider item.
	 *
	 * @param \Aimeos\MShop\Slider\Item\Iface $item Delivery or payment slider item object
	 * @param string $type Slider type code
	 * @return \Aimeos\MShop\Slider\Provider\Iface Slider provider object
	 * @throws \Aimeos\MShop\Slider\Exception If provider couldn't be found
	 */
	public function getProvider( \Aimeos\MShop\Slider\Item\Iface $item, string $type ) : \Aimeos\MShop\Slider\Provider\Iface;

	/**
	 * Adds a new or updates an existing slider item in the storage.
	 *
	 * @param \Aimeos\MShop\Slider\Item\Iface $item New or existing slider item that should be saved to the storage
	 * @param bool $fetch True if the new ID should be returned in the item
	 * @return \Aimeos\MShop\Slider\Item\Iface Updated item including the generated ID
	 */
	public function saveItem( \Aimeos\MShop\Slider\Item\Iface $item, bool $fetch = true ) : \Aimeos\MShop\Slider\Item\Iface;
}
