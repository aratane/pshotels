
<?php if ( isset( $rooms ) && !empty( $rooms )): ?>

<div class="room-list mb-4 ps-card-hover py-2">

	<?php foreach ( $rooms as $room ): ?>

		<?php $this->load->view( $template_path .'/components/hotel/room_info_card.php', array( 'room' => $room )); ?>

	<?php endforeach; ?>
	
</div>

<?php endif; ?>

<script type="text/javascript">
function room_list()
{
}
</script>