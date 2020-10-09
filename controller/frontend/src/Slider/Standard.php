<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2020
 * @package Controller
 * @subpackage Frontend
 */


namespace Aimeos\Controller\Frontend\Slider;


/**
 * Default implementation of the slider frontend controller
 *
 * @package Controller
 * @subpackage Frontend
 */
class Standard
	extends \Aimeos\Controller\Frontend\Base
	implements Iface, \Aimeos\Controller\Frontend\Common\Iface
{
	private $conditions = [];
	private $domain = 'media';
	private $domains = [];
	private $filter;
	private $manager;


	/**
	 * Common initialization for controller classes
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Common MShop context object
	 */
	public function __construct( \Aimeos\MShop\Context\Item\Iface $context )
	{
		parent::__construct( $context );

		$this->manager = \Aimeos\MShop::create( $context, 'slider' );
		$this->filter = $this->manager->createSearch( true );
		$this->conditions[] = $this->filter->getConditions();
	}


	/**
	 * Clones objects in controller and resets values
	 */
	public function __clone()
	{
		$this->filter = clone $this->filter;
	}


	/**
	 * Adds slider IDs for filtering
	 *
	 * @param array|string $attrIds Slider ID or list of IDs
	 * @return \Aimeos\Controller\Frontend\Slider\Iface Slider controller for fluent interface
	 * @since 2019.04
	 */
	public function slider( $attrIds ) : Iface
	{
		if( !empty( $attrIds ) ) {
			$this->conditions[] = $this->filter->compare( '==', 'slider.id', $attrIds );
		}

		return $this;
	}


	/**
	 * Adds generic condition for filtering sliders
	 *
	 * @param string $operator Comparison operator, e.g. "==", "!=", "<", "<=", ">=", ">", "=~", "~="
	 * @param string $key Search key defined by the slider manager, e.g. "slider.status"
	 * @param array|string $value Value or list of values to compare to
	 * @return \Aimeos\Controller\Frontend\Slider\Iface Slider controller for fluent interface
	 * @since 2019.04
	 */
	public function compare( string $operator, string $key, $value ) : Iface
	{
		$this->conditions[] = $this->filter->compare( $operator, $key, $value );
		return $this;
	}


	/**
	 * Adds the domain of the sliders for filtering
	 *
	 * @param string $domain Domain of the sliders
	 * @return \Aimeos\Controller\Frontend\Slider\Iface Slider controller for fluent interface
	 * @since 2019.04
	 */
	public function domain( string $domain ) : Iface
	{
		$this->domain = $domain;
		return $this;
	}


	/**
	 * Returns the slider for the given slider code
	 *
	 * @param string $code Unique slider code
	 * @param string $type Type assigned to the slider
	 * @return \Aimeos\MShop\Slider\Item\Iface Slider item including the referenced domains items
	 * @since 2019.04
	 */
	public function find( string $code, string $type ) : \Aimeos\MShop\Slider\Item\Iface
	{
		return $this->manager->findItem( $code, $this->domains, $this->domain, $type, true );
	}


	/**
	 * Creates a search function string for the given name and parameters
	 *
	 * @param string $name Name of the search function without parenthesis, e.g. "slider:prop"
	 * @param array $params List of parameters for the search function with numeric keys starting at 0
	 * @return string Search function string that can be used in compare()
	 */
	public function function( string $name, array $params ) : string
	{
		return $this->filter->createFunction( $name, $params );
	}


	/**
	 * Returns the slider for the given slider ID
	 *
	 * @param string $id Unique slider ID
	 * @return \Aimeos\MShop\Slider\Item\Iface Slider item including the referenced domains items
	 * @since 2019.04
	 */
	public function get( string $id ) : \Aimeos\MShop\Slider\Item\Iface
	{
		return $this->manager->getItem( $id, $this->domains, true );
	}


	/**
	 * Adds a filter to return only items containing a reference to the given ID
	 *
	 * @param string $domain Domain name of the referenced item, e.g. "price"
	 * @param string|null $type Type code of the reference, e.g. "default" or null for all types
	 * @param string|null $refId ID of the referenced item of the given domain or null for all references
	 * @return \Aimeos\Controller\Frontend\Slider\Iface Slider controller for fluent interface
	 * @since 2019.04
	 */
	public function has( string $domain, string $type = null, string $refId = null ) : Iface
	{
		$params = [$domain];
		!$type ?: $params[] = $type;
		!$refId ?: $params[] = $refId;

		$func = $this->filter->createFunction( 'slider:has', $params );
		$this->conditions[] = $this->filter->compare( '!=', $func, null );
		return $this;
	}


	/**
	 * Parses the given array and adds the conditions to the list of conditions
	 *
	 * @param array $conditions List of conditions, e.g. ['&&' => [['>' => ['slider.status' => 0]], ['==' => ['slider.type' => 'color']]]]
	 * @return \Aimeos\Controller\Frontend\Slider\Iface Slider controller for fluent interface
	 * @since 2019.04
	 */
	public function parse( array $conditions ) : Iface
	{
		if( ( $cond = $this->filter->toConditions( $conditions ) ) !== null ) {
			$this->conditions[] = $cond;
		}

		return $this;
	}


	/**
	 * Adds a filter to return only items containing the property
	 *
	 * @param string $type Type code of the property, e.g. "htmlcolor"
	 * @param string|null $value Exact value of the property
	 * @param string|null $langId ISO country code (en or en_US) or null if not language specific
	 * @return \Aimeos\Controller\Frontend\Slider\Iface Slider controller for fluent interface
	 * @since 2019.04
	 */
	public function property( string $type, string $value = null, string $langId = null ) : Iface
	{
		$func = $this->filter->createFunction( 'slider:prop', [$type, $langId, $value] );
		$this->conditions[] = $this->filter->compare( '!=', $func, null );
		return $this;
	}


	/**
	 * Returns the sliders filtered by the previously assigned conditions
	 *
	 * @param int &$total Parameter where the total number of found sliders will be stored in
	 * @return \Aimeos\Map Ordered list of slider items implementing \Aimeos\MShop\Slider\Item\Iface
	 * @since 2019.04
	 */
	public function search( int &$total = null ) : \Aimeos\Map
	{
		$expr = array_merge( $this->conditions, [$this->filter->compare( '==', 'slider.domain', $this->domain )] );
		$this->filter->setConditions( $this->filter->combine( '&&', $expr ) );

		return $this->manager->searchItems( $this->filter, $this->domains, $total );
	}


	/**
	 * Sets the start value and the number of returned sliders for slicing the list of found sliders
	 *
	 * @param int $start Start value of the first slider in the list
	 * @param int $limit Number of returned sliders
	 * @return \Aimeos\Controller\Frontend\Slider\Iface Slider controller for fluent interface
	 * @since 2019.04
	 */
	public function slice( int $start, int $limit ) : Iface
	{
		$this->filter->setSlice( $start, $limit );
		return $this;
	}


	/**
	 * Sets the sorting of the result list
	 *
	 * @param string|null $key Sorting of the result list like "position", null for no sorting
	 * @return \Aimeos\Controller\Frontend\Slider\Iface Slider controller for fluent interface
	 * @since 2019.04
	 */
	public function sort( string $key = null ) : Iface
	{
		$sort = [];
		$list = ( $key ? explode( ',', $key ) : [] );

		foreach( $list as $sortkey )
		{
			$direction = ( $sortkey[0] === '-' ? '-' : '+' );
			$sortkey = ltrim( $sortkey, '+-' );

			switch( $sortkey )
			{
				case 'position':
					$sort[] = $this->filter->sort( $direction, 'slider.type' );
					$sort[] = $this->filter->sort( $direction, 'slider.position' );
					break;
				default:
					$sort[] = $this->filter->sort( $direction, $sortkey );
			}
		}

		$this->filter->setSortations( $sort );
		return $this;
	}


	/**
	 * Adds slider types for filtering
	 *
	 * @param array|string $codes Slider ID or list of IDs
	 * @return \Aimeos\Controller\Frontend\Slider\Iface Slider controller for fluent interface
	 * @since 2019.04
	 */
	public function type( $codes ) : Iface
	{
		if( !empty( $codes ) ) {
			$this->conditions[] = $this->filter->compare( '==', 'slider.type', $codes );
		}

		return $this;
	}


	/**
	 * Sets the referenced domains that will be fetched too when retrieving items
	 *
	 * @param array $domains Domain names of the referenced items that should be fetched too
	 * @return \Aimeos\Controller\Frontend\Slider\Iface Slider controller for fluent interface
	 * @since 2019.04
	 */
	public function uses( array $domains ) : Iface
	{
		$this->domains = $domains;
		return $this;
	}
}
