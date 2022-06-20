
<?php
	$attributes = array('id' => 'user-form');
	echo form_open( '', $attributes );
?>
	<h5><?php echo get_msg('user_info')?></h5>

	<div id="perm_err" class="alert alert-danger fade in" style="display: none">
		<label for="permissions[]" class="error"></label>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	</div>
		
	<div class="row">
		<div class="col-6">
				<div class="form-group">
					<label><?php echo get_msg('user_name')?></label>

					<?php echo form_input(array(
						'name' => 'user_name',
						'value' => set_value( 'user_name', show_data( @$user->user_name ), false ),
						'class' => 'form-control form-control-sm',
						'placeholder' => 'Name',
						'id' => 'name'
					)); ?>

				</div>
				
				<div class="form-group">
					<label><?php echo get_msg('user_email')?></label>

					<?php echo form_input(array(
						'name' => 'user_email',
						'value' => set_value( 'user_email', show_data( @$user->user_email ), false ),
						'class' => 'form-control form-control-sm',
						'placeholder' => 'Email',
						'id' => 'user_email'
					)); ?>

				</div>
				
				<?php if ( @$user->user_is_sys_admin == false ): ?>

				<div class="form-group">
					<label><?php echo get_msg('user_password')?></label>

					<?php echo form_input(array(
						'type' => 'password',
						'name' => 'user_password',
						'value' => set_value( 'user_password' ),
						'class' => 'form-control form-control-sm',
						'placeholder' => 'Password',
						'id' => 'user_password'
					)); ?>
				</div>
							
				<div class="form-group">
					<label><?php echo get_msg('conf_password')?></label>
					
					<?php echo form_input(array(
						'type' => 'password',
						'name' => 'conf_password',
						'value' => set_value( 'conf_password' ),
						'class' => 'form-control form-control-sm',
						'placeholder' => 'Confirm Password',
						'id' => 'conf_password'
					)); ?>
				</div>
				
				<div class="form-group">
					<label><?php echo get_msg('role')?></label>

					<?php 
						$options = array();
						foreach($this->Role->get_all()->result() as $role) {
							$options[$role->role_id] = $role->role_desc;
						}

						echo form_dropdown(
							'role_id',
							$options,
							set_value( 'role_id', @$user->role_id ),
							'class="form-control form-control-sm" id="role_id" disabled'
						);
					?>
				</div>

				<div class="form-group">
					<label><?php echo get_msg('select_hotel_label')?></label>

					<select class="form-control select2" multiple="multiple" id="userhotel" style="width: 100%;">
						<?php
							$hotels = $this->Hotel->get_all()->result();

							$i=1;

							foreach ($hotels as $hotel) {

								//get hotel_id
								if($hotel->hotel_id != "") {
									$conds['hotel_id'] = $hotel->hotel_id;
								} else {
									$conds['hotel_id'] = '0';
								}

								//get user_id
								if(isset($user->user_id)) {
									$conds['user_id'] = $user->user_id;
								} else {
									$conds['user_id'] = '0';
								}

								$user_hotel_id = $this->User_hotel->get_one_by($conds)->user_id;

								//for selected value
								$selected_value = "";
								if($user_hotel_id == "" ) {
									$selected_value = "";
								} else {
									$selected_value = "selected";
								}
								echo $selected_value . $i;
								echo '<option ' .$selected_value.' name="'.$hotel->hotel_name.'" value="'.$hotel->hotel_id.'">'.$hotel->hotel_name.'</option>';

								$i++;
							}

							if($hotel->hotel_id != "") {
								$conds1['hotel_id'] = $hotel->hotel_id;
							} else {
								$conds1['hotel_id'] = 0;
							}

							$existing_hotel_ids = $this->User_hotel->get_all_by($conds1)->result();
							$existing_hotel_ids = "";

							foreach ($existing_hotel_ids as $exist_hotel) {
								$existing_hotel_ids .= $exist_hotel->hotel_id .",";
							}

						?>
						<input type="hidden"  id="hotelselect" name="hotelselect">
						<input type="hidden"  id="existing_hotelselect" name="existing_hotelselect" value="<?php echo $existing_hotel_ids; ?>">
					</select>
				</div>

				<?php endif; ?>
		</div>
		
		<?php if ( @$user->user_is_sys_admin == false ): ?>

		<div class="col-6">
			<div class="form-group">
				<label> <span style="font-size: 17px; color: red;">*</span>
					<?php echo get_msg('allowed_modules')?></label>
				
				<?php foreach($this->Module->get_all_module()->result() as $module): 
					if( $module->module_id != 3 && $module->module_id != 8 && $module->module_id != 9 ) {
				?>

					<div class="form-check" id="mycheck">
						<label class="form-check-label">
						
						<?php echo form_checkbox('permissions[]', $module->module_id, set_checkbox('permissions', $module->module_id, $this->User->has_permission( $module->module_name, @$user->user_id )),'checked'); ?>

						<?php echo $module->module_desc; ?>
						
						</label>
						<input type="hidden" name="permissions[]" value="<?php echo $module->module_id;?>">
					</div>
				<?php } ?>
				<?php endforeach; ?>
				
			</div>
		</div>

		<?php endif; ?>

	</div>
	
	<div class="my-3">
		<button type="submit" class="btn btn-sm btn-primary"><?php echo get_msg('btn_save')?></button>
		<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary"><?php echo get_msg('btn_cancel')?></a>
	</div>

<?php echo form_close(); ?>