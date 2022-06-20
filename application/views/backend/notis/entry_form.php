<?php echo form_open( $module_site_url . '/push_message', array( 'id' => 'gcm-form' ));

?>

<div class="row">
	<div class="col-sm-6">
				
		<div class="form-group">
			<label>
				<?php 
					if($this->Noti->count_all() > 0) {
						
						echo get_msg( 'total_label' );

						echo $this->Noti->count_all();
						
						if($this->Noti->count_all() == 1) {
							echo get_msg( 'device_label' );
						} else {
							echo get_msg( 'device_label' );
						}

						echo get_msg( 'registered_label' );
					}
					?> 
			</label>
			<br>
			
			<label>
				<?php echo get_msg('noti_message_label') ?> 
				<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('noti_message_tooltips')?>">
					<span class='glyphicon glyphicon-info-sign menu-icon'>
				</a>
			</label>
			
			<textarea class="form-control" name="message" placeholder="<?php echo get_msg('noti_message_label')?>" rows="8"></textarea>
		</div>
	
		<hr/>
		<?php 
			if($this->Noti->count_all() > 0) {
		?>
		  
		<button type="submit" class="btn btn-primary"><?php echo get_msg('noti_send_btn')?></button>
		
		<?php 
			} else {
				echo get_msg('sorry_no_device');
			}
		?>
			
		
	</div>
</div>

<?php echo form_close();?>

