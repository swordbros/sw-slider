<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2020
 */

$enc = $this->encoder();
$items =  $this->get( 'mediaData', []  );
foreach($items as $data_item_key=>$data_item){
    foreach(SwH::get_languages() as $language){
        if(isset($data_item['slider.lists.config'])){
            if(isset($data_item['slider.lists.config']['content-'.$language['langid']])){
                $content = $data_item['slider.lists.config']['content-'.$language['langid']];
            } else{
                $content = false;
            }
            if(isset($data_item['slider.lists.config']['url-'.$language['langid']])){
                $url = $data_item['slider.lists.config']['url-'.$language['langid']];
            } else{
                $url = false;
            }
        } else{
            $content = false;
            $url = false;
        }
        $data_item['slider.lists.config']['content-'.$language['langid']] = $content;
        $data_item['slider.lists.config']['url-'.$language['langid']] = $url;
        if($content === false){
            $data_item['config'][] = array('key'=>'content-'.$language['langid'], 'val'=>'' ); 
        }
        if($url === false){
            $data_item['config'][] = array('key'=>'url-'.$language['langid'], 'val'=>'' ); 
        }
        $items[$data_item_key] = $data_item;
    }
}

$data_items = $enc->attr( $items );

?>
<div id="media" class="item-media content-block tab-pane fade" role="tablist" aria-labelledby="media">

	<div id="item-media-group"
		data-items="<?= $data_items; ?>"
		data-siteid="<?= $this->site()->siteid() ?>"
		data-domain="slider" >

		<div class="group-list" role="tablist" aria-multiselectable="true">
			<div is="draggable" group="media" v-model="items" handle=".act-move">
				<div v-for="(item, idx) in items" v-bind:key="idx" class="group-item card">

					<div v-bind:id="'item-media-group-item-' + idx" v-bind:class="item['_show'] ? 'show' : 'collapsed'"
						v-bind:data-target="'#item-media-group-data-' + idx" data-toggle="collapse" role="tab" class="card-header header"
						v-bind:aria-controls="'item-media-group-data-' + idx" aria-expanded="false" v-on:click.self.stop="toggle('_show', idx)">
						<div class="card-tools-left">
							<div class="btn btn-card-header act-show fa" tabindex="<?= $this->get( 'tabindex' ); ?>"
								title="<?= $enc->attr( $this->translate( 'admin', 'Show/hide this entry' ) ); ?>">
							</div>
						</div>
						<span class="item-label header-label" v-html="label(idx)"></span>
						&nbsp;
						<div class="card-tools-right">
							<div v-if="item['slider.lists.siteid'] == siteid && !item['_nosort']"
								class="btn btn-card-header act-move fa" tabindex="<?= $this->get( 'tabindex' ); ?>"
								title="<?= $enc->attr( $this->translate( 'admin', 'Move this entry up/down' ) ); ?>">
							</div>
							<div
								class="btn btn-card-header act-delete fa" tabindex="<?= $this->get( 'tabindex' ); ?>"
								title="<?= $enc->attr( $this->translate( 'admin', 'Delete this entry' ) ); ?>"
								v-on:click.stop="remove(idx)">
							</div>
						</div>
					</div>

					<div v-bind:id="'item-media-group-data-' + idx" v-bind:class="item['_show'] ? 'show' : 'collapsed'"
						v-bind:aria-labelledby="'item-media-group-item-' + idx" role="tabpanel" class="card-block collapse row">

						<input type="hidden" v-model="item['media.id']"
							v-bind:name="'<?= $enc->attr( $this->formparam( ['media', '_idx_', 'media.id'] ) ); ?>'.replace('_idx_', idx)" />

						<div class="col-xl-6">

							<div class="form-group row media-preview">
								<input class="fileupload" type="file" tabindex="<?= $this->get( 'tabindex' ); ?>"
									v-bind:name="'media[_idx_][file]'.replace('_idx_', idx)"
									v-bind:readonly="item['media.siteid'] != siteid"
									v-on:change="files(idx, $event.target.files)" />
								<input class="item-url" type="hidden"
									v-bind:name="'<?= $enc->attr( $this->formparam( ['media', '_idx_', 'media.url'] ) ); ?>'.replace('_idx_', idx)"
									v-model="item['media.url']" />
								<img v-if="item['media.preview']" class="item-preview"
									v-bind:src="url('<?= $this->content( '/' ) ?>', item['media.preview'])"
									v-bind:alt="item['media.label']" />
								<p v-else class="item-preview">
									{{ item['media.label'] || '<?= $enc->html( $this->translate( 'admin', 'Select file' ) ) ?>' }}
								</p>
							</div>

						</div>

						<div class="col-xl-6">

							<div class="form-group row mandatory">
								<label class="col-sm-4 form-control-label"><?= $enc->html( $this->translate( 'admin', 'Status' ) ); ?></label>
								<div class="col-sm-8">
									<select class="form-control custom-select item-status" required="required" tabindex="<?= $this->get( 'tabindex' ); ?>"
										v-bind:name="'<?= $enc->attr( $this->formparam( ['media', '_idx_', 'media.status'] ) ); ?>'.replace('_idx_', idx)"
										v-bind:readonly="item['media.siteid'] != siteid"
										v-model="item['media.status']" >
										<option value=""><?= $enc->html( $this->translate( 'admin', 'Please select' ) ); ?></option>
										<option value="1" v-bind:selected="item['media.status'] == 1" >
											<?= $enc->html( $this->translate( 'mshop/code', 'status:1' ) ); ?>
										</option>
										<option value="0" v-bind:selected="item['media.status'] == 0" >
											<?= $enc->html( $this->translate( 'mshop/code', 'status:0' ) ); ?>
										</option>
										<option value="-1" v-bind:selected="item['media.status'] == -1" >
											<?= $enc->html( $this->translate( 'mshop/code', 'status:-1' ) ); ?>
										</option>
										<option value="-2" v-bind:selected="item['media.status'] == -2" >
											<?= $enc->html( $this->translate( 'mshop/code', 'status:-2' ) ); ?>
										</option>
									</select>
								</div>
							</div>
                        <?php if( ( $mediaTypes = $this->get( 'mediaTypes', map() ) )->count() ) :  ?>
								<div class="form-group row mandatory">
									<label class="col-sm-4 form-control-label help"><?= $enc->html( $this->translate( 'admin', 'Type' ) ); ?></label>
									<div class="col-sm-8">
										<select is="select-component" required class="form-control custom-select item-type" tabindex="<?= $this->get( 'tabindex' ); ?>"
											v-bind:items="JSON.parse('<?= $enc->attr( $mediaTypes->col( 'media.type.label', 'media.type.code' )->toArray() ) ?>')"
											v-bind:name="'<?= $enc->attr( $this->formparam( ['media', '_idx_', 'media.type'] ) ); ?>'.replace('_idx_', idx)"
											v-bind:text="'<?= $enc->html( $this->translate( 'admin', 'Please select' ) ); ?>'"
											v-bind:readonly="item['media.siteid'] != siteid"
											v-model="item['media.type']" >
										</select>
									</div>
									<div class="col-sm-12 form-text text-muted help-text">
										<?= $enc->html( $this->translate( 'admin', 'Types for additional images like icons' ) ); ?>
									</div>
								</div>
							<?php else : ?>
								<input class="item-type" type="hidden."
									v-bind:name="'<?= $enc->attr( $this->formparam( ['media', '_idx_', 'media.type'] ) ); ?>'.replace('_idx_', idx)"
									value="<?= $enc->attr( empty($mediaTypes->getCode()->first())?'standart':$mediaTypes->getCode()->first() ) ?>" />
							<?php endif; ?>

							<div class="form-group row mandatory">
									<label class="col-sm-4 form-control-label help"><?= $enc->html( $this->translate( 'admin', 'Title' ) ); ?></label>
								<div class="col-sm-8">
									<input class="form-control item-label" type="text" required="required" tabindex="<?= $this->get( 'tabindex' ); ?>"
										v-bind:name="'<?= $enc->attr( $this->formparam( ['media', '_idx_', 'media.label'] ) ); ?>'.replace('_idx_', idx)"
										placeholder="<?= $enc->attr( $this->translate( 'admin', 'Title' ) ); ?>"
										v-bind:readonly="item['media.siteid'] != siteid"
										v-model="item['media.label']" />
								</div>
								<div class="col-sm-12 form-text text-muted help-text">
									<?= $enc->html( $this->translate( 'admin', 'The media title is used for the title tag of the media on the web site' ) ); ?>
								</div>
							</div>

							<div class="form-group row optional">
								<label class="col-sm-4 form-control-label help"><?= $enc->html( $this->translate( 'admin', 'Language' ) ); ?></label>
								<div class="col-sm-8">
									<select is="select-component" class="form-control custom-select item-languageid" tabindex="<?= $this->get( 'tabindex' ); ?>"
										v-bind:items="JSON.parse('<?= $enc->attr( $this->get( 'pageLangItems', map() )->col( 'locale.language.label', 'locale.language.id' )->toArray() ) ?>')"
										v-bind:name="'<?= $enc->attr( $this->formparam( ['media', '_idx_', 'media.languageid'] ) ); ?>'.replace('_idx_', idx)"
										v-bind:text="'<?= $enc->html( $this->translate( 'admin', 'All' ) ); ?>'"
										v-bind:readonly="item['media.siteid'] != siteid"
										v-model="item['media.languageid']" >
									</select>
								</div>
								<div class="col-sm-12 form-text text-muted help-text">
									<?= $enc->html( $this->translate( 'admin', 'Images will only be shown for that language, useful if the media contains text or is language sepecific' ) ); ?>
								</div>
							</div>

						</div>


						<div v-on:click="toggle('_ext', idx)" class="col-xl-12 advanced" v-bind:class="{'collapsed': !item['_ext']}">
							<div class="card-tools-left">
								<div class="btn act-show fa" tabindex="<?= $this->get( 'tabindex' ); ?>"
									title="<?= $enc->attr( $this->translate( 'admin', 'Show/hide advanced data' ) ); ?>">
								</div>
							</div>
							<span class="header-label"><?= $enc->html( $this->translate( 'admin', 'Advanced' ) ); ?></span>
						</div>

						<div v-show="item['_ext']" class="col-xl-6 content-block secondary">
							<?php if( ( $listTypes = $this->get( 'mediaListTypes', map() ) )->count()  ) : ?>
								<div class="form-group row mandatory">
									<label class="col-sm-4 form-control-label help"><?= $enc->html( $this->translate( 'admin', 'List type' ) ); ?></label>
									<div class="col-sm-8">
										<select is="select-component" class="form-control custom-select listitem-type" tabindex="<?= $this->get( 'tabindex' ); ?>"
											v-bind:items="JSON.parse('<?= $enc->attr( $listTypes->col( 'slider.lists.type.label', 'slider.lists.type.code' )->toArray() ) ?>')"
											v-bind:name="'<?= $enc->attr( $this->formparam( ['media', '_idx_', 'slider.lists.type'] ) ); ?>'.replace('_idx_', idx)"
											v-bind:text="'<?= $enc->html( $this->translate( 'admin', 'Please select' ) ); ?>'"
											v-bind:readonly="item['slider.lists.siteid'] != siteid"
											v-model="item['slider.lists.type']" >
										</select>
									</div>
									<div class="col-sm-12 form-text text-muted help-text">
										<?= $enc->html( $this->translate( 'admin', 'Second level type for grouping items' ) ); ?>
									</div>
								</div>
							<?php else : ?>
								<input class="listitem-type" type="hidden"
									v-bind:name="'<?= $enc->attr( $this->formparam( ['media', '_idx_', 'slider.lists.type'] ) ); ?>'.replace('_idx_', idx)"
									value="<?= $enc->attr( empty($listTypes->getCode()->first())?'standart':$listTypes->getCode()->first() ) ?>" />
							<?php endif; ?>
							<div class="form-group row optional">
								<label class="col-sm-4 form-control-label help"><?= $enc->html( $this->translate( 'admin', 'Start date' ) ); ?></label>
								<div class="col-sm-8">
									<input class="form-control listitem-datestart" type="datetime-local" tabindex="<?= $this->get( 'tabindex' ); ?>"
										v-bind:name="'<?= $enc->attr( $this->formparam( ['media', '_idx_', 'slider.lists.datestart'] ) ); ?>'.replace('_idx_', idx)"
										placeholder="<?= $enc->attr( $this->translate( 'admin', 'YYYY-MM-DD hh:mm:ss (optional)' ) ); ?>"
										v-bind:readonly="item['slider.lists.siteid'] != siteid"
										v-model="item['slider.lists.datestart']" />
								</div>
								<div class="col-sm-12 form-text text-muted help-text">
									<?= $enc->html( $this->translate( 'admin', 'The item is only shown on the web site after that date and time' ) ); ?>
								</div>
							</div>
							<div class="form-group row optional">
								<label class="col-sm-4 form-control-label help"><?= $enc->html( $this->translate( 'admin', 'End date' ) ); ?></label>
								<div class="col-sm-8">
									<input class="form-control listitem-dateend" type="datetime-local" tabindex="<?= $this->get( 'tabindex' ); ?>"
										v-bind:name="'<?= $enc->attr( $this->formparam( ['media', '_idx_', 'slider.lists.dateend'] ) ); ?>'.replace('_idx_', idx)"
										placeholder="<?= $enc->attr( $this->translate( 'admin', 'YYYY-MM-DD hh:mm:ss (optional)' ) ); ?>"
										v-bind:readonly="item['slider.lists.siteid'] != siteid"
										v-model="item['slider.lists.dateend']" />
								</div>
								<div class="col-sm-12 form-text text-muted help-text">
									<?= $enc->html( $this->translate( 'admin', 'The item is only shown on the web site until that date and time' ) ); ?>
								</div>
							</div>
						</div>

						<div v-show="item['_ext']" class="col-xl-6 content-block secondary" v-bind:class="{readonly: item['slider.lists.siteid'] != siteid}">
							<config-table inline-template
								v-bind:index="idx" v-bind:readonly="item['slider.lists.siteid'] != siteid"
								v-bind:items="item['config']" v-on:update:config="item['config'] = $event">

								<table class="item-config table table-striped">
									<thead>
										<tr>
											<th class="config-row-key">
												<span class="help"><?= $enc->html( $this->translate( 'admin', 'Option' ) ); ?></span>
												<div class="form-text text-muted help-text">
													<?= $enc->html( $this->translate( 'admin', 'Configuration options, will be available as key/value pairs in the list item' ) ); ?>
												</div>
											</th>
											<th class="config-row-value"><?= $enc->html( $this->translate( 'admin', 'Value' ) ); ?></th>
											<th class="actions">
												<div v-if="!readonly" class="btn act-add fa" tabindex="<?= $this->get( 'tabindex' ); ?>" v-on:click="add()"
													title="<?= $enc->attr( $this->translate( 'admin', 'Insert new entry (Ctrl+I)' ) ); ?>"></div>
											</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(entry, pos) in items" v-bind:key="pos" class="config-item">
											<td class="config-row-key">
												<input is="auto-complete" required class="form-control" v-bind:readonly="readonly" tabindex="<?= $this->get( 'tabindex' ); ?>"
													v-bind:name="'<?= $enc->attr( $this->formparam( ['media', '_idx_', 'config', '_pos_', 'key'] ) ); ?>'.replace('_idx_', index).replace('_pos_', pos)"
													v-bind:keys="JSON.parse('<?= $enc->attr( $this->config( 'admin/jqadm/slider/item/media/config/suggest', [] ) ) ?>')"
													v-model="entry.key" />
											</td>
											<td class="config-row-value">
												<input class="form-control" v-bind:readonly="readonly" tabindex="<?= $this->get( 'tabindex' ); ?>"
													v-bind:name="'<?= $enc->attr( $this->formparam( ['media', '_idx_', 'config', '_pos_', 'val'] ) ); ?>'.replace('_idx_', index).replace('_pos_', pos)"
													v-model="entry.val" />
											</td>
											<td class="actions">
												<div v-if="!readonly" class="btn act-delete fa" tabindex="<?= $this->get( 'tabindex' ); ?>" v-on:click="remove(pos)"
													title="<?= $enc->attr( $this->translate( 'admin', 'Delete this entry' ) ); ?>"></div>
											</td>
										</tr>
									</tbody>
								</table>
							</config-table>
						</div>

						<?= $this->get( 'mediaBody' ); ?>

					</div>
				</div>
			</div>

			<div slot="footer" class="card-tools-more">
				<div class="btn btn-primary btn-card-more act-add fa" tabindex="<?= $this->get( 'tabindex' ); ?>"
					title="<?= $enc->attr( $this->translate( 'admin', 'Insert new entry (Ctrl+I)' ) ); ?>"
					v-on:click="add()" >
				</div>
			</div>
		</div>

	</div>
</div>
