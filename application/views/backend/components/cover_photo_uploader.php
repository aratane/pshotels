<?php if ( !empty( $img_parent_id ) && !empty( $img_type )): ?>

	<label><?php echo get_msg('cover_photo')?></label> 
	
	<div class="btn btn-sm btn-primary btn-upload pull-right" data-toggle="modal" data-target="#uploadImage">
		<?php echo get_msg('btn_replace_photo')?>
	</div>
	
	<hr/>
	
	<?php
		$conds = array( 'img_type' => $img_type, 'img_parent_id' => $img_parent_id );
		$images = $this->Image->get_all_by( $conds )->result();
	?>
		
	<?php if ( count($images) > 0 ): ?>
		
		<div class="row">

		<?php $i = 0; foreach ( $images as $img ) :?>

			<?php if ($i>0 && $i%3==0): ?>
					
			</div><div class='row'>
			
			<?php endif; ?>
				
			<div class="col-md-4" style="height:100">

				<div class="thumbnail">

					<img src="<?php echo $this->ps_image->upload_thumbnail_url . $img->img_path; ?>">

					<br/>
					
					<p class="text-center">
						
						<a data-toggle="modal" data-target="#deletePhoto" class="delete-img" id="<?php echo $img->img_id; ?>"   
							image="<?php echo $img->img_path; ?>">
							Remove
						</a>
					</p>

				</div>

			</div>

		<?php $i++; endforeach; ?>

		</div>
	
	<?php endif; ?>

<?php else: ?>

	<div class="form-group">
		
		<label><?php echo get_msg('cover_photo')?></label>

		<br/>

		<input class="btn btn-sm" type="file" name="images1">
	</div>

<?php endif; ?>