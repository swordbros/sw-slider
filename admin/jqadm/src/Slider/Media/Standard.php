<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2020
 * @package Admin
 * @subpackage JQAdm
 */


namespace Aimeos\Admin\JQAdm\Slider\Media;

sprintf( 'media' ); // for translation


/**
 * Default implementation of slider media JQAdm client.
 *
 * @package Admin
 * @subpackage JQAdm
 */
class Standard
	extends \Aimeos\Admin\JQAdm\Common\Admin\Factory\Base
	implements \Aimeos\Admin\JQAdm\Common\Admin\Factory\Iface
{
	/** admin/jqadm/slider/media/name
	 * Name of the media subpart used by the JQAdm slider implementation
	 *
	 * Use "Myname" if your class is named "\Aimeos\Admin\Jqadm\Slider\Media\Myname".
	 * The name is case-sensitive and you should avoid camel case names like "MyName".
	 *
	 * @param string Last part of the JQAdm class name
	 * @since 2017.07
	 * @category Developer
	 */


	/**
	 * Adds the required data used in the slider template
	 *
	 * @param \Aimeos\MW\View\Iface $view View object
	 * @return \Aimeos\MW\View\Iface View object with assigned parameters
	 */
	public function addData( \Aimeos\MW\View\Iface $view ) : \Aimeos\MW\View\Iface
	{
		$context = $this->getContext();

		$typeManager = \Aimeos\MShop::create( $context, 'media/type' );
		$listTypeManager = \Aimeos\MShop::create( $context, 'slider/lists/type' );

		$search = $typeManager->createSearch( true )->setSlice( 0, 10000 );
		$search->setConditions( $search->compare( '==', 'media.type.domain', 'catalog' ) );
		$search->setSortations( [$search->sort( '+', 'media.type.position' )] );

		$listSearch = $listTypeManager->createSearch( true )->setSlice( 0, 10000 );
		$listSearch->setConditions( $listSearch->compare( '==', 'slider.lists.type.domain', 'catalog' ) );
		$listSearch->setSortations( [$listSearch->sort( '+', 'slider.lists.type.position' )] );

		$view->mediaListTypes = $listTypeManager->searchItems( $listSearch );
		$view->mediaTypes = $typeManager->searchItems( $search );

		return $view;
	}


	/**
	 * Copies a resource
	 *
	 * @return string|null HTML output
	 */
	public function copy() : ?string
	{
		$view = $this->getObject()->addData( $this->getView() );
		$view->mediaData = $this->toArray( $view->item, true );
		$view->mediaBody = '';

		foreach( $this->getSubClients() as $client ) {
			$view->mediaBody .= $client->copy();
		}

		return $this->render( $view );
	}


	/**
	 * Creates a new resource
	 *
	 * @return string|null HTML output
	 */
	public function create() : ?string
	{
		$view = $this->getObject()->addData( $this->getView() );
		$siteid = $this->getContext()->getLocale()->getSiteId();

		$itemData = $this->toArray( $view->item );
		$data = array_replace_recursive( $itemData, $view->param( 'media', [] ) );

		foreach( $data as $idx => $entry )
		{
			$data[$idx]['media.siteid'] = $siteid;
			$data[$idx]['media.url'] = $entry['media.url'] ?? null;
			$data[$idx]['media.preview'] = $entry['media.preview'] ?? null;
			$data[$idx]['slider.lists.siteid'] = $siteid;
		}

		$view->mediaData = $data;
		$view->mediaBody = '';

		foreach( $this->getSubClients() as $client ) {
			$view->mediaBody .= $client->create();
		}

		return $this->render( $view );
	}


	/**
	 * Deletes a resource
	 *
	 * @return string|null HTML output
	 */
	public function delete() : ?string
	{
		parent::delete();

		$item = $this->getView()->item;
		$this->deleteMediaItems( $item, $item->getListItems( 'media', null, null, false )->toArray() );

		return null;
	}


	/**
	 * Returns a single resource
	 *
	 * @return string|null HTML output
	 */
	public function get() : ?string
	{
		$view = $this->getObject()->addData( $this->getView() );
		$view->mediaData = $this->toArray( $view->item );
		$view->mediaBody = '';

		foreach( $this->getSubClients() as $client ) {
			$view->mediaBody .= $client->get();
		}

		return $this->render( $view );
	}


	/**
	 * Saves the data
	 *
	 * @return string|null HTML output
	 */
	public function save() : ?string
	{
		$view = $this->getView();

		$view->item = $this->fromArray( $view->item, $view->param( 'media', [] ) );
		$view->mediaBody = '';

		foreach( $this->getSubClients() as $client ) {
			$view->mediaBody .= $client->save();
		}

		return null;
	}


	/**
	 * Returns the sub-client given by its name.
	 *
	 * @param string $type Name of the client type
	 * @param string|null $name Name of the sub-client (Default if null)
	 * @return \Aimeos\Admin\JQAdm\Iface Sub-client object
	 */
	public function getSubClient( string $type, string $name = null ) : \Aimeos\Admin\JQAdm\Iface
	{
		/** admin/jqadm/slider/media/decorators/excludes
		 * Excludes decorators added by the "common" option from the slider JQAdm client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to remove a decorator added via
		 * "admin/jqadm/common/decorators/default" before they are wrapped
		 * around the JQAdm client.
		 *
		 *  admin/jqadm/slider/media/decorators/excludes = array( 'decorator1' )
		 *
		 * This would remove the decorator named "decorator1" from the list of
		 * common decorators ("\Aimeos\Admin\JQAdm\Common\Decorator\*") added via
		 * "admin/jqadm/common/decorators/default" to the JQAdm client.
		 *
		 * @param array List of decorator names
		 * @since 2017.07
		 * @category Developer
		 * @see admin/jqadm/common/decorators/default
		 * @see admin/jqadm/slider/media/decorators/global
		 * @see admin/jqadm/slider/media/decorators/local
		 */

		/** admin/jqadm/slider/media/decorators/global
		 * Adds a list of globally available decorators only to the slider JQAdm client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap global decorators
		 * ("\Aimeos\Admin\JQAdm\Common\Decorator\*") around the JQAdm client.
		 *
		 *  admin/jqadm/slider/media/decorators/global = array( 'decorator1' )
		 *
		 * This would add the decorator named "decorator1" defined by
		 * "\Aimeos\Admin\JQAdm\Common\Decorator\Decorator1" only to the JQAdm client.
		 *
		 * @param array List of decorator names
		 * @since 2017.07
		 * @category Developer
		 * @see admin/jqadm/common/decorators/default
		 * @see admin/jqadm/slider/media/decorators/excludes
		 * @see admin/jqadm/slider/media/decorators/local
		 */

		/** admin/jqadm/slider/media/decorators/local
		 * Adds a list of local decorators only to the slider JQAdm client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap local decorators
		 * ("\Aimeos\Admin\JQAdm\Slider\Decorator\*") around the JQAdm client.
		 *
		 *  admin/jqadm/slider/media/decorators/local = array( 'decorator2' )
		 *
		 * This would add the decorator named "decorator2" defined by
		 * "\Aimeos\Admin\JQAdm\Slider\Decorator\Decorator2" only to the JQAdm client.
		 *
		 * @param array List of decorator names
		 * @since 2017.07
		 * @category Developer
		 * @see admin/jqadm/common/decorators/default
		 * @see admin/jqadm/slider/media/decorators/excludes
		 * @see admin/jqadm/slider/media/decorators/global
		 */
		return $this->createSubClient( 'slider/media/' . $type, $name );
	}


	/**
	 * Removes the media reference and the media item if not shared
	 *
	 * @param \Aimeos\MShop\Slider\Item\Iface $item Slider item including media reference
	 * @param array $listItems Media list items to be removed
	 * @return \Aimeos\MShop\Slider\Item\Iface Modified slider item
	 */
	protected function deleteMediaItems( \Aimeos\MShop\Slider\Item\Iface $item, array $listItems )
	{
		$context = $this->getContext();
		$cntl = \Aimeos\Controller\Common\Media\Factory::create( $context );
		$manager = \Aimeos\MShop::create( $context, 'slider' );
		$search = $manager->createSearch();

		foreach( $listItems as $listItem )
		{
			$func = $search->createFunction( 'slider:has', ['media', $listItem->getType(), $listItem->getRefId()] );
			$search->setConditions( $search->compare( '!=', $func, null ) );
			$items = $manager->searchItems( $search );
			$refItem = null;

			if( count( $items ) === 1 && ( $refItem = $listItem->getRefItem() ) !== null ) {
				$cntl->delete( $refItem );
			}

			$item->deleteListItem( 'media', $listItem, $refItem );
		}

		return $item;
	}


	/**
	 * Returns the list of sub-client names configured for the client.
	 *
	 * @return array List of JQAdm client names
	 */
	protected function getSubClientNames() : array
	{
		/** admin/jqadm/slider/media/standard/subparts
		 * List of JQAdm sub-clients rendered within the slider media section
		 *
		 * The output of the frontend is composed of the code generated by the JQAdm
		 * clients. Each JQAdm client can consist of serveral (or none) sub-clients
		 * that are responsible for rendering certain sub-parts of the output. The
		 * sub-clients can contain JQAdm clients themselves and therefore a
		 * hierarchical tree of JQAdm clients is composed. Each JQAdm client creates
		 * the output that is placed inside the container of its parent.
		 *
		 * At first, always the JQAdm code generated by the parent is printed, then
		 * the JQAdm code of its sub-clients. The order of the JQAdm sub-clients
		 * determines the order of the output of these sub-clients inside the parent
		 * container. If the configured list of clients is
		 *
		 *  array( "subclient1", "subclient2" )
		 *
		 * you can easily change the order of the output by reordering the subparts:
		 *
		 *  admin/jqadm/<clients>/subparts = array( "subclient1", "subclient2" )
		 *
		 * You can also remove one or more parts if they shouldn't be rendered:
		 *
		 *  admin/jqadm/<clients>/subparts = array( "subclient1" )
		 *
		 * As the clients only generates structural JQAdm, the layout defined via CSS
		 * should support adding, removing or reordering content by a fluid like
		 * design.
		 *
		 * @param array List of sub-client names
		 * @since 2017.07
		 * @category Developer
		 */
		return $this->getContext()->getConfig()->get( 'admin/jqadm/slider/media/standard/subparts', [] );
	}


	/**
	 * Creates new and updates existing items using the data array
	 *
	 * @param \Aimeos\MShop\Slider\Item\Iface $item Slider item object without referenced domain items
	 * @param array $data Data array
	 * @return \Aimeos\MShop\Slider\Item\Iface Modified slider item
	 */
	protected function fromArray( \Aimeos\MShop\Slider\Item\Iface $item, array $data ) : \Aimeos\MShop\Slider\Item\Iface
	{
		$context = $this->getContext();

		$mediaManager = \Aimeos\MShop::create( $context, 'media' );
		$listManager = \Aimeos\MShop::create( $context, 'slider/lists' );
		$cntl = \Aimeos\Controller\Common\Media\Factory::create( $context );

		$listItems = $item->getListItems( 'media', null, null, false );
		$files = (array) $this->getView()->request()->getUploadedFiles();

		foreach( $data as $idx => $entry )
		{
			if( ( $listItem = $item->getListItem( 'media', $entry['slider.lists.type'], $entry['media.id'], false ) ) === null ) {
				$listItem = $listManager->createItem();
			}

			if( ( $refItem = $listItem->getRefItem() ) === null ) {
				$refItem = $mediaManager->createItem();
			}

			$refItem->fromArray( $entry, true );
			$file = $this->getValue( $files, 'media/' . $idx . '/file' );

			if( $file && $file->getError() !== UPLOAD_ERR_NO_FILE ) {
				$refItem = $cntl->add( $refItem, $file );
			} elseif( $refItem->getId() === null && $refItem->getUrl() !== '' ) {
				$refItem = $cntl->copy( $refItem );
			}

			$conf = [];
print_r($this->getValue( $entry, 'config', [] ));
			foreach( (array) $this->getValue( $entry, 'config', [] ) as $cfg )
			{
                echo $cfg['key']."***<br>";
				if( ( $key = trim( $cfg['key'] ?? '' ) ) !== '' ) {
					$conf[$key] = trim( $cfg['val'] ?? '' );
				}
			}

			$listItem->fromArray( $entry, true );
			$listItem->setPosition( $idx );
			$listItem->setConfig( $conf );

			$item->addListItem( 'media', $listItem, $refItem );

			unset( $listItems[$listItem->getId()] );
		}

		return $this->deleteMediaItems( $item, $listItems->toArray() );
	}


	/**
	 * Constructs the data array for the view from the given item
	 *
	 * @param \Aimeos\MShop\Slider\Item\Iface $item Slider item object including referenced domain items
	 * @param bool $copy True if items should be copied, false if not
	 * @return string[] Multi-dimensional associative list of item data
	 */
	protected function toArray( \Aimeos\MShop\Slider\Item\Iface $item, bool $copy = false ) : array
	{
		$data = [];
		$siteId = $this->getContext()->getLocale()->getSiteId();

		foreach( $item->getListItems( 'media', null, null, false ) as $listItem )
		{
			if( ( $refItem = $listItem->getRefItem() ) === null ) {
				continue;
			}

			$list = $listItem->toArray( true ) + $refItem->toArray( true );

			if( $copy === true )
			{
				$list['slider.lists.siteid'] = $siteId;
				$list['slider.lists.id'] = '';
				$list['media.siteid'] = $siteId;
				$list['media.id'] = null;
			}

			$list['slider.lists.datestart'] = str_replace( ' ', 'T', $list['slider.lists.datestart'] );
			$list['slider.lists.dateend'] = str_replace( ' ', 'T', $list['slider.lists.dateend'] );
			$list['config'] = [];

			foreach( $listItem->getConfig() as $key => $value ) {
				$list['config'][] = ['key' => $key, 'val' => $value];
			}

			$data[] = $list;
		}

		return $data;
	}


	/**
	 * Returns the rendered template including the view data
	 *
	 * @param \Aimeos\MW\View\Iface $view View object with data assigned
	 * @return string HTML output
	 */
	protected function render( \Aimeos\MW\View\Iface $view ) : string
	{
		/** admin/jqadm/slider/media/template-item
		 * Relative path to the HTML body template of the media subpart for sliders.
		 *
		 * The template file contains the HTML code and processing instructions
		 * to generate the result shown in the body of the frontend. The
		 * configuration string is the path to the template file relative
		 * to the templates directory (usually in admin/jqadm/templates).
		 *
		 * You can overwrite the template file configuration in extensions and
		 * provide alternative templates. These alternative templates should be
		 * named like the default one but with the string "default" replaced by
		 * an unique name. You may use the name of your project for this. If
		 * you've implemented an alternative client class as well, "default"
		 * should be replaced by the name of the new class.
		 *
		 * @param string Relative path to the template creating the HTML code
		 * @since 2017.07
		 * @category Developer
		 */
		$tplconf = 'admin/jqadm/slider/media/template-item';
		$default = 'slider/item-media-standard';

		return $view->render( $view->config( $tplconf, $default ) );
	}
}
