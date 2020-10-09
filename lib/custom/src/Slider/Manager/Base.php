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
 * Abstract class for slider managers.
 *
 * @package MShop
 * @subpackage Slider
 */
abstract class Base
	extends \Aimeos\MShop\Common\Manager\Base
{
	use \Aimeos\MShop\Common\Manager\ListRef\Traits;


	/**
	 * Returns the slider provider which is responsible for the slider item.
	 *
	 * @param \Aimeos\MShop\Slider\Item\Iface $item Delivery or payment slider item object
	 * @param string $type Slider type code
	 * @return \Aimeos\MShop\Slider\Provider\Iface Slider provider object
	 * @throws \Aimeos\MShop\Slider\Exception If provider couldn't be found
	 */
	public function getProvider( \Aimeos\MShop\Slider\Item\Iface $item, string $type ) : \Aimeos\MShop\Slider\Provider\Iface
	{
		$type = ucwords( $type );
		$names = explode( ',', $item->getProvider() );

		if( ctype_alnum( $type ) === false ) {
			throw new \Aimeos\MShop\Slider\Exception( sprintf( 'Invalid characters in type name "%1$s"', $type ) );
		}

		if( ( $provider = array_shift( $names ) ) === null ) {
			throw new \Aimeos\MShop\Slider\Exception( sprintf( 'Provider in "%1$s" not available', $item->getProvider() ) );
		}

		if( ctype_alnum( $provider ) === false ) {
			throw new \Aimeos\MShop\Slider\Exception( sprintf( 'Invalid characters in provider name "%1$s"', $provider ) );
		}

		$classname = '\Aimeos\MShop\Slider\Provider\\' . $type . '\\' . $provider;

		if( class_exists( $classname ) === false ) {
			throw new \Aimeos\MShop\Slider\Exception( sprintf( 'Class "%1$s" not available', $classname ) );
		}

		$context = $this->getContext();
		$config = $context->getConfig();
		$provider = new $classname( $context, $item );

		self::checkClass( \Aimeos\MShop\Slider\Provider\Factory\Iface::class, $provider );

		/** mshop/seider/provider/delivery/decorators
		 * Adds a list of decorators to all delivery provider objects automatcally
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap decorators
		 * ("\Aimeos\MShop\Slider\Provider\Decorator\*") around the delivery provider.
		 *
		 *  mshop/slider/provider/delivery/decorators = array( 'decorator1' )
		 *
		 * This would add the decorator named "decorator1" defined by
		 * "\Aimeos\MShop\Slider\Provider\Decorator\Decorator1" to all delivery provider
		 * objects.
		 *
		 * @param array List of decorator names
		 * @since 2014.03
		 * @category Developer
		 * @see mshop/slider/provider/payment/decorators
		 */

		/** mshop/slider/provider/payment/decorators
		 * Adds a list of decorators to all payment provider objects automatcally
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap decorators
		 * ("\Aimeos\MShop\Slider\Provider\Decorator\*") around the payment provider.
		 *
		 *  mshop/slider/provider/payment/decorators = array( 'decorator1' )
		 *
		 * This would add the decorator named "decorator1" defined by
		 * "\Aimeos\MShop\Slider\Provider\Decorator\Decorator1" to all payment provider
		 * objects.
		 *
		 * @param array List of decorator names
		 * @since 2014.03
		 * @category Developer
		 * @see mshop/slider/provider/delivery/decorators
		 */
		$decorators = $config->get( 'mshop/slider/provider/' . $item->getType() . '/decorators', [] );

		$provider = $this->addSliderDecorators( $item, $provider, $names );
		return $this->addSliderDecorators( $item, $provider, $decorators );
	}


	/**
	 * Wraps the named slider decorators around the slider provider.
	 *
	 * @param \Aimeos\MShop\Slider\Item\Iface $sliderItem Slider item object
	 * @param \Aimeos\MShop\Slider\Provider\Iface $provider Slider provider object
	 * @param array $names List of decorator names that should be wrapped around the provider object
	 * @return \Aimeos\MShop\Slider\Provider\Iface
	 */
	protected function addSliderDecorators( \Aimeos\MShop\Slider\Item\Iface $sliderItem,
		\Aimeos\MShop\Slider\Provider\Iface $provider, array $names ) : \Aimeos\MShop\Slider\Provider\Iface
	{
		$classprefix = '\Aimeos\MShop\Slider\Provider\Decorator\\';

		foreach( $names as $name )
		{
			if( ctype_alnum( $name ) === false ) {
				throw new \Aimeos\MShop\Slider\Exception( sprintf( 'Invalid characters in class name "%1$s"', $name ) );
			}

			$classname = $classprefix . $name;

			if( class_exists( $classname ) === false ) {
				throw new \Aimeos\MShop\Slider\Exception( sprintf( 'Class "%1$s" not available', $classname ) );
			}

			$provider = new $classname( $provider, $this->getContext(), $sliderItem );

			self::checkClass( \Aimeos\MShop\Slider\Provider\Decorator\Iface::class, $provider );
		}

		return $provider;
	}
}
