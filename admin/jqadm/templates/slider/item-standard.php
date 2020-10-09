<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2020
 */

$selected = function( $key, $code ) {
	return ( $key == $code ? 'selected="selected"' : '' );
};

$enc = $this->encoder();


$target = $this->config( 'admin/jqadm/url/save/target' );
$cntl = $this->config( 'admin/jqadm/url/save/controller', 'Jqadm' );
$action = $this->config( 'admin/jqadm/url/save/action', 'save' );
$config = $this->config( 'admin/jqadm/url/save/config', [] );

$starget = $this->config( 'admin/jqadm/url/search/target' );
$scntl = $this->config( 'admin/jqadm/url/search/controller', 'Jqadm' );
$saction = $this->config( 'admin/jqadm/url/search/action', 'search' );
$sconfig = $this->config( 'admin/jqadm/url/search/config', [] );

$params = $this->get( 'pageParams', [] );


?>
<?php $this->block()->start( 'jqadm_content' ); ?>

<form class="item item-slider form-horizontal" method="POST" enctype="multipart/form-data" action="<?= $enc->attr( $this->url( $target, $cntl, $action, $params, [], $config ) ); ?>">
	<input id="item-id" type="hidden" name="<?= $enc->attr( $this->formparam( array( 'item', 'slider.id' ) ) ); ?>" value="<?= $enc->attr( $this->get( 'itemData/slider.id' ) ); ?>" />
	<input id="item-next" type="hidden" name="<?= $enc->attr( $this->formparam( array( 'next' ) ) ); ?>" value="get" />
	<?= $this->csrf()->formfield(); ?>

	<nav class="main-navbar">
		<h1 class="navbar-brand">
			<span class="navbar-title"><?= $enc->html( $this->translate( 'admin', 'Slider' ) ); ?></span>
			<span class="navbar-id"><?= $enc->html( $this->get( 'itemData/slider.id' ) ); ?></span>
			<span class="navbar-label"><?= $enc->html( $this->get( 'itemData/slider.label' ) ?: $this->translate( 'admin', 'New' ) ); ?></span>
			<span class="navbar-site"><?= $enc->html( $this->site()->match( $this->get( 'itemData/slider.siteid' ) ) ); ?></span>
		</h1>
		<div class="item-actions">
			<?= $this->partial( $this->config( 'admin/jqadm/partial/itemactions', 'common/partials/itemactions-standard' ), ['params' => $params] ); ?>
		</div>
	</nav>

	<div class="row item-container">

		<div class="col-md-3 item-navbar">
			<div class="navbar-content">
				<ul class="nav nav-tabs flex-md-column flex-wrap d-flex justify-content-between" role="tablist">

					<li class="nav-item basic">
						<a class="nav-link active" href="#basic" data-toggle="tab" role="tab" aria-expanded="true" aria-controls="basic">
							<?= $enc->html( $this->translate( 'admin', 'Basic' ) ); ?>
						</a>
					</li>

					<?php foreach( array_values( $this->get( 'itemSubparts', [] ) ) as $idx => $subpart ) : ?>
						<li class="nav-item <?= $enc->attr( $subpart ); ?>">
							<a class="nav-link" href="#<?= $enc->attr( $subpart ); ?>" data-toggle="tab" role="tab" tabindex="<?= ++$idx + 1; ?>">
								<?= $enc->html( $this->translate( 'admin', $subpart ) ); ?>
							</a>
						</li>
					<?php endforeach; ?>

				</ul>

				<div class="item-meta text-muted">
					<small>
						<?= $enc->html( $this->translate( 'admin', 'Modified' ) ); ?>:
						<span class="meta-value"><?= $enc->html( $this->get( 'itemData/slider.mtime' ) ); ?></span>
					</small>
					<small>
						<?= $enc->html( $this->translate( 'admin', 'Created' ) ); ?>:
						<span class="meta-value"><?= $enc->html( $this->get( 'itemData/slider.ctime' ) ); ?></span>
					</small>
					<small>
						<?= $enc->html( $this->translate( 'admin', 'Editor' ) ); ?>:
						<span class="meta-value"><?= $enc->html( $this->get( 'itemData/slider.editor' ) ); ?></span>
					</small>
				</div>
			</div>
		</div>

		<div class="col-md-9 item-content tab-content">

			<div id="basic" class="row item-basic tab-pane fade show active" role="tabpanel" aria-labelledby="basic">

				<div class="col-xl-6 content-block <?= $this->site()->readonly( $this->get( 'itemData/slider.siteid' ) ); ?>">
					<div class="form-group row mandatory">
						<label class="col-sm-4 form-control-label"><?= $enc->html( $this->translate( 'admin', 'Domain' ) ); ?></label>
						<div class="col-sm-8">
							<select class="form-control custom-select item-domain" required="required" tabindex="1"
								name="<?= $enc->attr( $this->formparam( array( 'item', 'slider.domain' ) ) ); ?>"
								<?= $this->site()->readonly( $this->get( 'itemData/slider.siteid' ) ); ?> >

								<?php foreach( ['product', 'media', 'text', 'catalog'] as $domain ) : ?>
									<option value="<?= $enc->attr( $domain ); ?>" <?= $selected( $this->get( 'itemData/slider.domain', 'product' ), $domain ); ?> >
										<?= $enc->html( $this->translate( 'admin', $domain ) ); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group row mandatory">
						<label class="col-sm-4 form-control-label"><?= $enc->html( $this->translate( 'admin', 'Status' ) ); ?></label>
						<div class="col-sm-8">
							<select class="form-control custom-select item-status" required="required" tabindex="1"
								name="<?= $enc->attr( $this->formparam( array( 'item', 'slider.status' ) ) ); ?>"
								<?= $this->site()->readonly( $this->get( 'itemData/slider.siteid' ) ); ?> >
								<option value="">
									<?= $enc->html( $this->translate( 'admin', 'Please select' ) ); ?>
								</option>
								<option value="1" <?= $selected( $this->get( 'itemData/slider.status', 1 ), 1 ); ?> >
									<?= $enc->html( $this->translate( 'mshop/code', 'status:1' ) ); ?>
								</option>
								<option value="0" <?= $selected( $this->get( 'itemData/slider.status', 1 ), 0 ); ?> >
									<?= $enc->html( $this->translate( 'mshop/code', 'status:0' ) ); ?>
								</option>
								<option value="-1" <?= $selected( $this->get( 'itemData/slider.status', 1 ), -1 ); ?> >
									<?= $enc->html( $this->translate( 'mshop/code', 'status:-1' ) ); ?>
								</option>
								<option value="-2" <?= $selected( $this->get( 'itemData/slider.status', 1 ), -2 ); ?> >
									<?= $enc->html( $this->translate( 'mshop/code', 'status:-2' ) ); ?>
								</option>
							</select>
						</div>
					</div>
					<div class="form-group row mandatory">
						<label class="col-sm-4 form-control-label"><?= $enc->html( $this->translate( 'admin', 'Type' ) ); ?></label>
						<div class="col-sm-8">
							<table>
								<tr>
									<td class="input-group">
										<select class="form-control custom-select item-type" required="required" tabindex="1"
											name="<?= $enc->attr( $this->formparam( array( 'item', 'slider.type' ) ) ); ?>"
											<?= $this->site()->readonly( $this->get( 'itemData/slider.siteid' ) ); ?> >
											<option value="">
												<?= $enc->html( $this->translate( 'admin', 'Please select' ) ); ?>
											</option>

											<?php foreach( $this->get( 'itemTypes', [] ) as $item ) : ?>
												<option value="<?= $enc->attr( $item->getCode() ); ?>" <?= $selected( $this->get( 'itemData/slider.type' ), $item->getCode() ); ?> >
													<?= $enc->html( $item->getLabel() ); ?>
												</option>
											<?php endforeach; ?>
										</select>
									</td>
									<td class="actions">
										<a class="btn act-add fa" tabindex="1" target="_blank"
											title="<?= $enc->attr( $this->translate( 'admin', 'Go to the list of slider types' ) ); ?>"
											href="<?= $enc->attr( $this->url( $starget, $scntl, $saction, ['resource' => 'type/slider'] + $params, [], $sconfig ) ); ?>">
										</a>
									</td>
								</tr>
							</table>

						</div>
					</div>
				</div><!--

				--><div class="col-xl-6 content-block <?= $this->site()->readonly( $this->get( 'itemData/slider.siteid' ) ); ?>">
					<div class="form-group row mandatory">
						<label class="col-sm-4 form-control-label help"><?= $enc->html( $this->translate( 'admin', 'Code' ) ); ?></label>
						<div class="col-sm-8">
							<input class="form-control item-code" type="text" required="required" tabindex="1"
								name="<?= $enc->attr( $this->formparam( array( 'item', 'slider.code' ) ) ); ?>"
								placeholder="<?= $enc->attr( $this->translate( 'admin', 'Unique slider code (required)' ) ); ?>"
								value="<?= $enc->attr( $this->get( 'itemData/slider.code' ) ); ?>"
								<?= $this->site()->readonly( $this->get( 'itemData/slider.siteid' ) ); ?> />
						</div>
						<div class="col-sm-12 form-text text-muted help-text">
							<?= $enc->html( $this->translate( 'admin', 'Unique slider code, e.g. "green" for sliders of type "color"' ) ); ?>
						</div>
					</div>
					<div class="form-group row mandatory">
						<label class="col-sm-4 form-control-label help"><?= $enc->html( $this->translate( 'admin', 'Label' ) ); ?></label>
						<div class="col-sm-8">
							<input class="form-control item-label" type="text" required="required" tabindex="1"
								name="<?= $this->formparam( array( 'item', 'slider.label' ) ); ?>"
								placeholder="<?= $enc->attr( $this->translate( 'admin', 'Internal name (required)' ) ); ?>"
								value="<?= $enc->attr( $this->get( 'itemData/slider.label' ) ); ?>"
								<?= $this->site()->readonly( $this->get( 'itemData/slider.siteid' ) ); ?> />
						</div>
						<div class="col-sm-12 form-text text-muted help-text">
							<?= $enc->html( $this->translate( 'admin', 'Internal slider name, will be used on the web site if no name for the language is available' ) ); ?>
						</div>
					</div>
					<div class="form-group row optional">
						<label class="col-sm-4 form-control-label help"><?= $enc->html( $this->translate( 'admin', 'Position' ) ); ?></label>
						<div class="col-sm-8">
							<input class="form-control item-position" type="text" tabindex="1"
								name="<?= $this->formparam( array( 'item', 'slider.position' ) ); ?>"
								placeholder="<?= $enc->attr( $this->translate( 'admin', 'Slider position (optional)' ) ); ?>"
								value="<?= $enc->attr( $this->get( 'itemData/slider.position' ) ); ?>"
								<?= $this->site()->readonly( $this->get( 'itemData/slider.siteid' ) ); ?> />
						</div>
						<div class="col-sm-12 form-text text-muted help-text">
							<?= $enc->html( $this->translate( 'admin', 'Sorting of the sliders within the same slider type' ) ); ?>
						</div>
					</div>
				</div>

			</div>

			<?= $this->get( 'itemBody' ); ?>

		</div>

		<div class="item-actions">
			<?= $this->partial( $this->config( 'admin/jqadm/partial/itemactions', 'common/partials/itemactions-standard' ), ['params' => $params] ); ?>
		</div>
	</div>
</form>

<?php $this->block()->stop(); ?>


<?= $this->render( $this->config( 'admin/jqadm/template/page', 'common/page-standard' ) ); ?>
