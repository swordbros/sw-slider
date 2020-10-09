<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2020
 * @package MShop
 * @subpackage Slider
 */


namespace Aimeos\MShop\Slider\Item;


/**
 * Generic interface for delivery and payment item DTOs.
 * @package MShop
 * @subpackage Slider
 */
interface Iface
	extends \Aimeos\MShop\Common\Item\Iface, \Aimeos\MShop\Common\Item\Config\Iface,
		\Aimeos\MShop\Common\Item\ListRef\Iface, \Aimeos\MShop\Common\Item\Position\Iface,
		\Aimeos\MShop\Common\Item\Status\Iface, \Aimeos\MShop\Common\Item\Time\Iface,
		\Aimeos\MShop\Common\Item\TypeRef\Iface
{
	/**
	 * Returns the code of the slider item.
	 *
	 * @return string Slider item code
	 */
	public function getCode() : string;

	/**
	 * Sets a new code for the slider item.
	 *
	 * @param string $code Code as defined by the slider provider
	 * @return \Aimeos\MShop\Slider\Item\Iface Slider item for chaining method calls
	 */
	public function setCode( string $code ) : \Aimeos\MShop\Slider\Item\Iface;

	/**
	 * Returns the name of the slider provider the item belongs to.
	 *
	 * @return string Name of the slider provider
	 */
	public function getProvider() : string;

	/**
	 * Sets the new name of the slider provider the item belongs to.
	 *
	 * @param string $provider Name of the slider provider
	 * @return \Aimeos\MShop\Slider\Item\Iface Slider item for chaining method calls
	 */
	public function setProvider( string $provider ) : \Aimeos\MShop\Slider\Item\Iface;

	/**
	 * Returns the label of the slider item.
	 *
	 * @return string Slider item label
	 */
	public function getLabel() : string;

	/**
	 * Sets a new label for the slider item.
	 *
	 * @param string $label Label as defined by the slider provider
	 * @return \Aimeos\MShop\Slider\Item\Iface Slider item for chaining method calls
	 */
	public function setLabel( string $label ) : \Aimeos\MShop\Slider\Item\Iface;
}
