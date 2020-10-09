<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2020
 * @package Controller
 * @subpackage Frontend
 */


namespace Aimeos\Controller\Frontend\Slider;


/**
 * Interface for slider frontend controllers
 *
 * @package Controller
 * @subpackage Frontend
 */
interface Iface
{
	/**
	 * Adds slider IDs for filtering
	 *
	 * @param array|string $attrIds Slider ID or list of IDs
	 * @return \Aimeos\Controller\Frontend\Slider\Iface Slider controller for fluent interface
	 * @since 2019.04
	 */
	public function slider( $attrIds ) : Iface;

	/**
	 * Adds generic condition for filtering sliders
	 *
	 * @param string $operator Comparison operator, e.g. "==", "!=", "<", "<=", ">=", ">", "=~", "~="
	 * @param string $key Search key defined by the slider manager, e.g. "slider.status"
	 * @param array|string $value Value or list of values to compare to
	 * @return \Aimeos\Controller\Frontend\Slider\Iface Slider controller for fluent interface
	 * @since 2019.04
	 */
	public function compare( string $operator, string $key, $value ) : Iface;

	/**
	 * Adds the domain of the sliders for filtering
	 *
	 * @param string $domain Domain of the sliders
	 * @return \Aimeos\Controller\Frontend\Slider\Iface Slider controller for fluent interface
	 * @since 2019.04
	 */
	public function domain( string $domain ) : Iface;

	/**
	 * Returns the slider for the given slider code
	 *
	 * @param string $code Unique slider code
	 * @param string $type Type assigned to the slider
	 * @return \Aimeos\MShop\Slider\Item\Iface Slider item including the referenced domains items
	 * @since 2019.04
	 */
	public function find( string $code, string $type ) : \Aimeos\MShop\Slider\Item\Iface;

	/**
	 * Creates a search function string for the given name and parameters
	 *
	 * @param string $name Name of the search function without parenthesis, e.g. "slider:prop"
	 * @param array $params List of parameters for the search function with numeric keys starting at 0
	 * @return string Search function string that can be used in compare()
	 */
	public function function( string $name, array $params ) : string;

	/**
	 * Returns the slider for the given slider ID
	 *
	 * @param string $id Unique slider ID
	 * @return \Aimeos\MShop\Slider\Item\Iface Slider item including the referenced domains items
	 * @since 2019.04
	 */
	public function get( string $id ) : \Aimeos\MShop\Slider\Item\Iface;

	/**
	 * Adds a filter to return only items containing a reference to the given ID
	 *
	 * @param string $domain Domain name of the referenced item, e.g. "price"
	 * @param string|null $type Type code of the reference, e.g. "default" or null for all types
	 * @param string|null $refId ID of the referenced item of the given domain or null for all references
	 * @return \Aimeos\Controller\Frontend\Product\Iface Product controller for fluent interface
	 * @since 2019.04
	 */
	public function has( string $domain, string $type = null, string $refId = null ) : Iface;

	/**
	 * Parses the given array and adds the conditions to the list of conditions
	 *
	 * @param array $conditions List of conditions, e.g. ['&&' => [['>' => ['slider.status' => 0]], ['==' => ['slider.type' => 'color']]]]
	 * @return \Aimeos\Controller\Frontend\Slider\Iface Slider controller for fluent interface
	 * @since 2019.04
	 */
	public function parse( array $conditions ) : Iface;

	/**
	 * Adds a filter to return only items containing the property
	 *
	 * @param string $type Type code of the property, e.g. "isbn"
	 * @param string|null $value Exact value of the property
	 * @param string|null $langId ISO country code (en or en_US) or null if not language specific
	 * @return \Aimeos\Controller\Frontend\Slider\Iface Product controller for fluent interface
	 * @since 2019.04
	 */
	public function property( string $type, string $value = null, string $langId = null ) : Iface;

	/**
	 * Returns the sliders filtered by the previously assigned conditions
	 *
	 * @param int &$total Parameter where the total number of found sliders will be stored in
	 * @return \Aimeos\Map Ordered list of items implementing \Aimeos\MShop\Slider\Item\Iface
	 * @since 2019.04
	 */
	public function search( int &$total = null ) : \Aimeos\Map;

	/**
	 * Sets the start value and the number of returned sliders for slicing the list of found sliders
	 *
	 * @param int $start Start value of the first slider in the list
	 * @param int $limit Number of returned sliders
	 * @return \Aimeos\Controller\Frontend\Slider\Iface Slider controller for fluent interface
	 * @since 2019.04
	 */
	public function slice( int $start, int $limit ) : Iface;

	/**
	 * Sets the sorting of the result list
	 *
	 * @param string|null $key Sorting of the result list like "position", null for no sorting
	 * @return \Aimeos\Controller\Frontend\Slider\Iface Slider controller for fluent interface
	 * @since 2019.04
	 */
	public function sort( string $key = null ) : Iface;

	/**
	 * Adds slider types for filtering
	 *
	 * @param array|string $codes Slider type or list of types
	 * @return \Aimeos\Controller\Frontend\Slider\Iface Slider controller for fluent interface
	 * @since 2019.04
	 */
	public function type( $codes ) : Iface;

	/**
	 * Sets the referenced domains that will be fetched too when retrieving items
	 *
	 * @param array $domains Domain names of the referenced items that should be fetched too
	 * @return \Aimeos\Controller\Frontend\Slider\Iface Slider controller for fluent interface
	 * @since 2019.04
	 */
	public function uses( array $domains ) : Iface;
}
