<div class="ibox float-e-margins">

    <div class="ibox-title">
        <h5><?php echo $panel_title; ?></h5>

        <div class="ibox-tools">
            <span class="badge label-warning-light">
            	Total : <?php echo $total_count; ?>
           	</span>

        </div>
    </div>
			    
    <div class="ibox-content" style="min-height: 375px">
        
        <div>

			<?php if ( ! empty( $data )) foreach( $data as $d ): ?>

				<?php $user = $this->User->get_one( $d->user_id ); ?>

				<a href="<?php echo $be_url ."/inquires/detail/" . $d->inq_id; ?>">

					<div class="media mb-1" style="border-bottom: 1px solid #eee">

						<div class="media-body">
							<p>
								<?php echo read_more( $d->inq_desc, 55 ); ?><br>

								<?php if ( isset( $user->is_empty_object )): ?>
									<span class="text-muted">
										<?php echo $d->inq_user_name; ?> / 
										<?php echo ago( $d->added_date ); ?>
									</span>

								<?php else: ?>
									
									<span class="text-muted">
										<?php echo $user->user_name; ?> / 
										<?php echo ago( $d->added_date ); ?>
									</span>
								<?php endif; ?>
							</p>
						</div>
					</div>

				</a>

			<?php endforeach; ?>

         </div>
         
    </div>
</div>