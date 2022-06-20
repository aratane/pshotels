<div class="ibox float-e-margins">

    <div class="ibox-title">
        <h5><?php echo $panel_title; ?></h5>

        <div class="ibox-tools">
            <span class="badge label-warning-light">
            	Total : <?php echo $total_count; ?>
           	</span>

        </div>
    </div>
			    
    <div class="ibox-content" style="min-height: 360px">
        
        <div>

			<?php if ( ! empty( $data )) foreach( $data as $d ): ?>

				<?php $user = $this->User->get_one( $d->user_id ); ?>

				<a href="<?php echo $be_url ."/comments/detail/" . $d->review_id; ?>">

					<div class="media mb-2 p-2" style="border-bottom: 1px solid #eee">

						<img class="mr-1" src="<?php echo img_url( $user->user_profile_photo ); ?>" alt="Generic placeholder image" width="60px">

						<div class="media-body">

							<p>
								<?php echo read_more( $d->review_desc, 55 ); ?>
								<br>
								<span class="text-muted"><?php echo $user->user_name; ?></span>
							</p>							

						</div>
					</div>

				</a>
			
			<?php endforeach; ?>

         </div>
         
    </div>
</div>