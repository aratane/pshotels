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

        <?php if ( ! empty( $data )) foreach( $data as $room ): ?>

            <a href="<?php echo $be_url ."/rooms/edit/" . $room->room_id; ?>">

                <div class="media mb-2" style="border-bottom: 1px solid #eee">

                    <img class="mr-2" src="<?php echo img_url( $this->ps_widget->get_default_photo( $room->room_id, 'room' )->img_path ); ?>" alt="Generic placeholder image" width="120px">

                    <div class="media-body">
                        <p>
                            <?php echo read_more( $room->room_name, 55 ); ?><br>

                            <span class="text-muted"><?php echo $this->Hotel->get_one( $room->hotel_id )->hotel_name; ?></span>

                            <br>

                            <span class="text-muted"><?php echo ago($room->added_date); ?></span>
                        </p>
                    </div>
                </div>

            </a>

        <?php endforeach; ?>
	</div>

</div>


