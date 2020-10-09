<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2019-2020
 * @package MShop
 * @subpackage Slider
 */


namespace Aimeos\MShop\Slider\Provider\Decorator;


/**
 * Delivery type decorator for slider providers
 *
 * @package MShop
 * @subpackage Slider
 */
class Delivery
	extends \Aimeos\MShop\Slider\Provider\Decorator\Base
	implements \Aimeos\MShop\Slider\Provider\Decorator\Iface
{
	private $beConfig = array(
		'delivery.partial' => array(
			'code' => 'delivery.partial',
			'internalcode' => 'delivery.partial',
			'label' => 'Choice of partitial delivery',
			'type' => 'boolean',
			'internaltype' => 'boolean',
			'default' => '0',
			'required' => false,
		),
		'delivery.collective' => array(
			'code' => 'delivery.collective',
			'internalcode' => 'delivery.collective',
			'label' => 'Choice of collective delivery',
			'type' => 'boolean',
			'internaltype' => 'boolean',
			'default' => '0',
			'required' => false,
		),
	);

	private $feConfig = array(
		'delivery.type' => array(
			'code' => 'delivery.type',
			'internalcode' => 'type',
			'label' => 'Delivery type',
			'type' => 'list',
			'internaltype' => 'integer',
			'default' => [1 => 'complete delivery'],
			'required' => true
		),
	);


	/**
	 * Initializes a new slider provider object using the given context object.
	 *
	 * @param \Aimeos\MShop\Slider\Provider\Iface $provider Slider provider or decorator
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object with required objects
	 * @param \Aimeos\MShop\Slider\Item\Iface $sliderItem Slider item with configuration for the provider
	 */
	public function __construct( \Aimeos\MShop\Slider\Provider\Iface $provider,
		\Aimeos\MShop\Context\Item\Iface $context, \Aimeos\MShop\Slider\Item\Iface $sliderItem )
	{
		parent::__construct( $provider, $context, $sliderItem );

		if( $this->getConfigValue( 'delivery.partial', 0 ) ) {
			$this->feConfig['delivery.type']['default'][0] = 'partial delivery';
		}

		if( $this->getConfigValue( 'delivery.collective', 0 ) ) {
			$this->feConfig['delivery.type']['default'][2] = 'collective delivery';
		}
	}


	/**
	 * Checks the backend configuration attributes for validity.
	 *
	 * @param array $attributes Attributes added by the shop owner in the administraton interface
	 * @return array An array with the attribute keys as key and an error message as values for all attributes that are
	 * 	known by the provider but aren't valid
	 */
	public function checkConfigBE( array $attributes ) : array
	{
		$error = $this->getProvider()->checkConfigBE( $attributes );
		$error += $this->checkConfig( $this->beConfig, $attributes );

		return $error;
	}


	/**
	 * Returns the configuration attribute definitions of the provider to generate a list of available fields and
	 * rules for the value of each field in the administration interface.
	 *
	 * @return array List of attribute definitions implementing \Aimeos\MW\Common\Critera\Attribute\Iface
	 */
	public function getConfigBE() : array
	{
		return array_merge( $this->getProvider()->getConfigBE(), $this->getConfigItems( $this->beConfig ) );
	}


	/**
	 * Returns the configuration attribute definitions of the provider to generate a list of available fields and
	 * rules for the value of each field in the frontend.
	 *
	 * @param \Aimeos\MShop\Order\Item\Base\Iface $basket Basket object
	 * @return array List of attribute definitions implementing \Aimeos\MW\Common\Critera\Attribute\Iface
	 */
	public function getConfigFE( \Aimeos\MShop\Order\Item\Base\Iface $basket ) : array
	{
		$feconfig = $this->feConfig;

		try
		{
			$values = $this->feConfig['delivery.type']['default'];

			$type = \Aimeos\MShop\Order\Item\Base\Slider\Base::TYPE_DELIVERY;
			$slider = $this->getBasketSlider( $basket, $type, $this->getSliderItem()->getCode() );

			if( ( $value = $slider->getAttribute( 'delivery.type', 'delivery' ) ) != '' ) {
				$feconfig['delivery.type']['default'] = $this->sort( $values, (int) $value );
			} else {
				$feconfig['delivery.type']['default'] = $values;
			}
		}
		catch( \Aimeos\MShop\Slider\Exception $e ) {} // If slider isn't available

		return array_merge( $this->getProvider()->getConfigFE( $basket ), $this->getConfigItems( $feconfig ) );
	}


	/**
	 * Checks the frontend configuration attributes for validity.
	 *
	 * @param array $attributes Attributes entered by the customer during the checkout process
	 * @return array An array with the attribute keys as key and an error message as values for all attributes that are
	 * 	known by the provider but aren't valid resp. null for attributes whose values are OK
	 */
	public function checkConfigFE( array $attributes ) : array
	{
		$result = $this->getProvider()->checkConfigFE( $attributes );
		$result += array_merge( $result, $this->checkConfig( $this->feConfig, $attributes ) );

		if( isset( $attributes['delivery.type'] )
			&& !isset( $this->feConfig['delivery.type']['default'][$attributes['delivery.type']] )
		) {
			$result['delivery.type'] = $this->getContext()->getI18n()->dt( 'mshop', 'Invalid delivery type' );
		}

		return $result;
	}


	/**
	 * Sorts the entry with the given key to the first position
	 *
	 * @param array $values Associative list of keys and codes
	 * @param int $value Key that should be at first position
	 * @return array Sorted associative array
	 */
	protected function sort( array $values, int $value ) : array
	{
		if( !isset( $values[$value] ) ) {
			return $values;
		}

		$code = $values[$value];
		unset( $values[$value] );

		return [$value => $code] + $values;
	}
}
