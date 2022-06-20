
<blockquote>
	<?php echo $room->room_desc; ?></p>
</blockquote> 

<div class="room-info">
	<p class="mt-3">
		<img class="mr-2" src="<?php echo base_url( 'assets/img/icons/room-limit.png' ); ?>"/>
		<?php echo $room->capacity; ?>
	</p>
	<p class="mt-3">
		<img class="mr-2" src="<?php echo base_url( 'assets/img/icons/room-size.png' ); ?>"/>
		<?php echo $room->room_size; ?>
	</p>
	<p class="mt-3">
		<img class="mr-2" src="<?php echo base_url( 'assets/img/icons/room-beds.png' ); ?>"/>
		<?php echo $room->room_no_of_beds; ?> beds
	</p>

</div>