<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2020
 * @package MShop
 * @subpackage Slider
 */

namespace Aimeos\MShop\Slider\Manager;

interface Iface
	extends \Aimeos\MShop\Common\Manager\Iface, \Aimeos\MShop\Common\Manager\Find\Iface, \Aimeos\MShop\Common\Manager\ListRef\Iface
{
	public function getProvider( \Aimeos\MShop\Slider\Item\Iface $item, string $type ) : \Aimeos\MShop\Slider\Provider\Iface;

	public function saveItem( \Aimeos\MShop\Slider\Item\Iface $item, bool $fetch = true ) : \Aimeos\MShop\Slider\Item\Iface;
}
