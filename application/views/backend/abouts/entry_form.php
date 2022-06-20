
<?php
$attributes = array('id' => 'about-form','enctype' => 'multipart/form-data');
echo form_open( '', $attributes);
?>

	<legend><?php echo get_msg('app_info_lable')?></legend>

	<div class="row">
		<div class="col-sm-8">
			<div class="form-group">
				<label><?php echo get_msg('about_title_label')?>
					<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_title_tooltips')?>">
						<span class='glyphicon glyphicon-info-sign menu-icon'>
					</a>
				</label>
				<?php 
					echo form_input( array(
						'type' => 'text',
						'name' => 'about_title',
						'id' => 'about_title',
						'class' => 'form-control',
						'placeholder' => 'Title',
						'value' => set_value( 'about_title', show_data( @$about->about_title ), false )
					));
				?>
			</div>
			
			<div class="form-group">
				<label><?php echo get_msg('description_label')?>
					<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_description_tooltips')?>">
						<span class='glyphicon glyphicon-info-sign menu-icon'>
					</a>
				</label>
				<textarea class="form-control" name="about_description" placeholder="Description" rows="9"><?php echo $about->about_description; ?></textarea>
			</div>

			<div class="form-group">
				<label><?php echo get_msg('about_email_label')?>
					<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_email_tooltips')?>">
						<span class='glyphicon glyphicon-info-sign menu-icon'>
					</a>
				</label>
				<?php 
					echo form_input( array(
						'type' => 'text',
						'name' => 'about_email',
						'id' => 'about_email',
						'class' => 'form-control',
						'placeholder' => 'Email',
						'value' => set_value( 'about_email', show_data( @$about->about_email ), false )
					));
				?>
			</div>

			<div class="form-group">
				<label><?php echo get_msg('about_phone_label')?>
					<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_phone_tooltips')?>">
						<span class='glyphicon glyphicon-info-sign menu-icon'>
					</a>
				</label>
				<?php 
					echo form_input( array(
						'type' => 'text',
						'name' => 'about_phone',
						'id' => 'about_phone',
						'class' => 'form-control',
						'placeholder' => 'Phone',
						'value' => set_value( 'about_phone', show_data( @$about->about_phone ), false )
					));
				?>
			</div>

			<div class="form-group">
				<label><?php echo get_msg('about_website_label')?>
					<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_website_tooltips')?>">
						<span class='glyphicon glyphicon-info-sign menu-icon'>
					</a>
				</label>
				<?php 
					echo form_input( array(
						'type' => 'text',
						'name' => 'about_website',
						'id' => 'about_website',
						'class' => 'form-control',
						'placeholder' => 'Website',
						'value' => set_value( 'about_website', show_data( @$about->about_website ), false )
					));
				?>
			</div>

			
			<hr>

			<legend><?php echo get_msg('about_seo_section')?></legend>

			<div class="form-group">
				<label><?php echo get_msg('about_seo_title_label')?>
					<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_seo_title_tooltips')?>">
						<span class='glyphicon glyphicon-info-sign menu-icon'>
					</a>
				</label>
				<?php 
					echo form_input( array(
						'type' => 'text',
						'name' => 'seo_title',
						'id' => 'seo_title',
						'class' => 'form-control',
						'placeholder' => 'SEO Title',
						'value' => set_value( 'seo_title', show_data( @$about->seo_title ), false )
					));
				?>
			</div>

			<div class="form-group">
				<label><?php echo get_msg('about_seo_desc_label')?>
					<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_seo_desc_tooltips')?>">
						<span class='glyphicon glyphicon-info-sign menu-icon'>
					</a>
				</label>
				<?php 
					echo form_input( array(
						'type' => 'text',
						'name' => 'seo_description',
						'id' => 'seo_description',
						'class' => 'form-control',
						'placeholder' => 'SEO Description',
						'value' => set_value( 'seo_description', show_data( @$about->seo_description ), false )
					));
				?>
			</div>

			<div class="form-group">
				<label><?php echo get_msg('about_seo_keywords_label')?>
					<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_seo_keywords_tooltips')?>">
						<span class='glyphicon glyphicon-info-sign menu-icon'>
					</a>
				</label>
				<?php 
					echo form_input( array(
						'type' => 'text',
						'name' => 'seo_keywords',
						'id' => 'seo_keywords',
						'class' => 'form-control',
						'placeholder' => 'SEO Keywords',
						'value' => set_value( 'seo_keywords', show_data( @$about->seo_keywords ), false )
					));
				?>
			</div>

			<hr>

			<legend><?php echo get_msg('about_ads_analyt')?></legend>

			<div class="form-group">
				<div class="form-check">
					<label class="form-check-label">
					
					<?php echo form_checkbox( array(
						'name' => 'ads_on',
						'id' => 'ads_on',
						'value' => 'accept',
						'checked' => set_checkbox('ads_on', 1, ( @$about->ads_on == 1 )? true: false ),
						'class' => 'form-check-input'
					));	?>

					<?php echo get_msg( 'about_ads_on' ); ?>

					</label>
				</div>
			</div>

			<div class="form-group">
				<label><?php echo get_msg('about_ads_client')?>
					<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_ads_client_tooltips')?>">
						<span class='glyphicon glyphicon-info-sign menu-icon'>
					</a>
				</label>
				<?php 
					echo form_input( array(
						'type' => 'text',
						'name' => 'ads_client',
						'id' => 'ads_client',
						'class' => 'form-control',
						'placeholder' => 'Ads Client',
						'value' => set_value( 'ads_client', show_data( @$about->ads_client ), false )
					));
				?>
			</div>

			<div class="form-group">
				<label><?php echo get_msg('about_ads_slot')?>
					<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_ads_slot_tooltips')?>">
						<span class='glyphicon glyphicon-info-sign menu-icon'>
					</a>
				</label>
				<?php 
					echo form_input( array(
						'type' => 'text',
						'name' => 'ads_slot',
						'id' => 'ads_slot',
						'class' => 'form-control',
						'placeholder' => 'Ads Slot',
						'value' => set_value( 'ads_slot', show_data( @$about->ads_slot ), false )
					));
				?>
			</div>

			<div class="form-group">
				<div class="form-check">
					<label class="form-check-label">
					
					<?php echo form_checkbox( array(
						'name' => 'analyt_on',
						'id' => 'analyt_on',
						'value' => 'accept',
						'checked' => set_checkbox('analyt_on', 1, ( @$about->analyt_on == 1 )? true: false ),
						'class' => 'form-check-input'
					));	?>

					<?php echo get_msg( 'about_analyt_on' ); ?>

					</label>
				</div>
			</div>

			<div class="form-group">
				<label><?php echo get_msg('about_analyt_track_id')?>
					<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_analyt_track_id_tooltips')?>">
						<span class='glyphicon glyphicon-info-sign menu-icon'>
					</a>
				</label>
				<?php 
					echo form_input( array(
						'type' => 'text',
						'name' => 'analyt_track_id',
						'id' => 'analyt_track_id',
						'class' => 'form-control',
						'placeholder' => 'Analytic Tracking Id',
						'value' => set_value( 'analyt_track_id', show_data( @$about->analyt_track_id ), false )
					));
				?>
			</div>

			<hr>

			<legend><?php echo get_msg('about_social_section')?></legend>

			<div class="form-group">
				<label><?php echo get_msg('about_facebook_label')?>
					<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_facebook_tooltips')?>">
						<span class='glyphicon glyphicon-info-sign menu-icon'>
					</a>
				</label>
				<?php 
					echo form_input( array(
						'type' => 'text',
						'name' => 'facebook',
						'id' => 'facebook',
						'class' => 'form-control',
						'placeholder' => 'Facebook',
						'value' => set_value( 'facebook', show_data( @$about->facebook ), false )
					));
				?>
			</div>

			<div class="form-group">
				<label><?php echo get_msg('about_gplus_label')?>
					<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_gplus_tooltips')?>">
						<span class='glyphicon glyphicon-info-sign menu-icon'>
					</a>
				</label>
				<?php 
					echo form_input( array(
						'type' => 'text',
						'name' => 'google_plus',
						'id' => 'google_plus',
						'class' => 'form-control',
						'placeholder' => 'Google+',
						'value' => set_value( 'google_plus', show_data( @$about->google_plus ), false )
					));
				?>
			</div>

			<div class="form-group">
				<label><?php echo get_msg('about_instagram_label')?>
					<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_instagram_tooltips')?>">
						<span class='glyphicon glyphicon-info-sign menu-icon'>
					</a>
				</label>
				<?php 
					echo form_input( array(
						'type' => 'text',
						'name' => 'instagram',
						'id' => 'instagram',
						'class' => 'form-control',
						'placeholder' => 'Instagram',
						'value' => set_value( 'instagram', show_data( @$about->instagram ), false )
					));
				?>
			</div>

			<div class="form-group">
				<label><?php echo get_msg('about_youtube_label')?>
					<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_instagram_tooltips')?>">
						<span class='glyphicon glyphicon-info-sign menu-icon'>
					</a>
				</label>
				<?php 
					echo form_input( array(
						'type' => 'text',
						'name' => 'youtube',
						'id' => 'youtube',
						'class' => 'form-control',
						'placeholder' => 'Youtube',
						'value' => set_value( 'youtube', show_data( @$about->youtube ), false )
					));
				?>
			</div>

			<div class="form-group">
				<label><?php echo get_msg('about_pinterest_label')?>
					<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_pinterest_tooltips')?>">
						<span class='glyphicon glyphicon-info-sign menu-icon'>
					</a>
				</label>
				<?php 
					echo form_input( array(
						'type' => 'text',
						'name' => 'pinterest',
						'id' => 'pinterest',
						'class' => 'form-control',
						'placeholder' => 'Pinterest',
						'value' => set_value( 'pinterest', show_data( @$about->pinterest ), false )
					));
				?>
			</div>

			<div class="form-group">
				<label><?php echo get_msg('about_twitter_label')?>
					<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_twitter_tooltips')?>">
						<span class='glyphicon glyphicon-info-sign menu-icon'>
					</a>
				</label>
				<?php 
					echo form_input( array(
						'type' => 'text',
						'name' => 'twitter',
						'id' => 'twitter',
						'class' => 'form-control',
						'placeholder' => 'Twitter',
						'value' => set_value( 'twitter', show_data( @$about->twitter ), false )
					));
				?>
			</div>

			<hr>

			<legend><?php echo get_msg('about_color_section')?></legend>

			<label>
				<?php echo get_msg('about_theme')?>
			</label>

			<select class="form-control" name="theme_style" id="theme_style">
				<option value="default"><?php echo get_msg('select_style')?></option>
				<?php
					$styles = $this->config->item( 'themes' );

					foreach($styles as $style){
						echo "<option value='". $style ."'";
						if ( $style == $about->theme_style ) echo " selected ";
						echo ">". $style ."</option>";										
					}
				?>
			</select>

			<legend><?php echo get_msg('about_currency_section')?></legend>

			<label><?php echo get_msg('currency_symbol')?></label>

			<?php 
				echo form_input( array(
					'type' => 'text',
					'name' => 'currency_symbol',
					'id' => 'currency_symbol',
					'class' => 'form-control',
					'placeholder' => '$',
					'value' => set_value( 'currency_symbol', show_data( @$about->currency_symbol ), false )
				));
			?>

			<label><?php echo get_msg('currency_short_form')?></label>

			<?php 
				echo form_input( array(
					'type' => 'text',
					'name' => 'currency_short_form',
					'id' => 'currency_short_form',
					'class' => 'form-control',
					'placeholder' => 'USD',
					'value' => set_value( 'currency_short_form', show_data( @$about->currency_short_form ), false )
				));
			?>

		</div>
	</div>

	<hr/>

	<button type="submit" name="save" class="btn btn-sm btn-primary">
		<?php echo get_msg('btn_save')?>
	</button>

	<button type="submit" name="gallery" class="btn btn-sm btn-primary">
		<?php echo get_msg('btn_save_gallery')?>
	</button>

	<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary">
		<?php echo get_msg('btn_cancel')?>
	</a>

<?php echo form_close(); ?>