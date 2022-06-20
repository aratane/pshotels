<ul class="metismenu nav flex-column" id="side-menu">
    <?php $logged_in_user = $this->ps_auth->get_user_info(); ?>

	<?php if ( !empty( $module_groups )): ?>

		<?php foreach ( $module_groups as $group ):
			if($logged_in_user->user_is_sys_admin == 1) {
		?>

			<li class='nav-item group'>

				<a class="nav-link has-arrow" href="#" aria-expanded="false">

					<span class="fa fa-fw <?php echo $group->group_icon; ?>"></span>
					
					<?php echo $group->group_name; ?>

				</a>

				<ul class="nav nav-second-level" aria-expanded="false">

					<?php if (!empty( $allowed_modules )): ?>

						<?php foreach ( $allowed_modules as $module ): ?>

							<?php if ( $module->is_show_on_menu == 1 && $module->module_id != 3 && $module->group_id == $group->group_id ): ?>

							<li class='dropdown-item module'>

								<a class="nav-link" href="<?php echo $be_url .'/'. strtolower( $module->module_name ); ?>">

									<span class='fa fa-angle-right'></span>
									<?php echo $module->module_desc; ?>

								</a>

							</li>

							<?php endif; ?>

						<?php endforeach; ?>
	
					<?php endif; ?>

				</ul>

			</li>
			<?php  } else if($logged_in_user->is_hotel_admin == 1){ ?>
				<li class='nav-item group'>

				<a class="nav-link has-arrow" href="#" aria-expanded="false">

					<span class="fa fa-fw <?php echo $group->group_icon; ?>"></span>
					
					<?php echo $group->group_name; ?>

				</a>

				<ul class="nav nav-second-level" aria-expanded="false">

					<?php if (!empty( $allowed_modules )): ?>

						<?php foreach ( $allowed_modules as $module ): ?>

							<?php if ( $module->is_show_on_menu == 1 &&
								$module->group_id == $group->group_id ): ?>

							<li class='dropdown-item module'>

								<a class="nav-link" href="<?php echo $be_url .'/'. strtolower( $module->module_name ); ?>">

									<span class='fa fa-angle-right'></span>
									<?php echo $module->module_desc; ?>

								</a>

							</li>

							<?php endif; ?>

						<?php endforeach; ?>
	
					<?php endif; ?>

				</ul>

			</li>
			<?php } ?>
		<?php endforeach; ?>

	<?php endif; ?>

</ul>