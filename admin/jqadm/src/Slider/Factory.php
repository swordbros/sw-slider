<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2020
 * @package Admin
 * @subpackage JQAdm
 */


namespace Aimeos\Admin\JQAdm\Swordbros\Slider;


/**
 * Factory for slider JQAdm client
 *
 * @package Admin
 * @subpackage JQAdm
 */
class Factory
	extends \Aimeos\Admin\JQAdm\Common\Factory\Base
	implements \Aimeos\Admin\JQAdm\Common\Factory\Iface
{
	/**
	 * Creates a slider client object
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Shop context instance with necessary objects
	 * @param string|null $name Admin name (default: "Standard")
	 * @return \Aimeos\Admin\JQAdm\Iface Filter part implementing \Aimeos\Admin\JQAdm\Iface
	 * @throws \Aimeos\Admin\JQAdm\Exception If requested client implementation couldn't be found or initialisation fails
	 */
	public static function create( \Aimeos\MShop\Context\Item\Iface $context, string $name = null ) : \Aimeos\Admin\JQAdm\Iface
	{
		if( $name === null ) {
			$name = $context->getConfig()->get( 'admin/jqadm/slider/name', 'Standard' );
		}

		$iface = '\\Aimeos\\Admin\\JQAdm\\Iface';
		$classname = '\\Aimeos\\Admin\\JQAdm\\Swordbros\\Slider\\' . $name;

		if( ctype_alnum( $name ) === false ) {
			throw new \Aimeos\Admin\JQAdm\Exception( sprintf( 'Invalid characters in class name "%1$s"', $classname ) );
		}

		$client = self::createAdmin( $context, $classname, $iface );

		return self::addClientDecorators( $context, $client, 'swordbros/slider' );
	}

}
