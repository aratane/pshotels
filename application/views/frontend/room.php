
<?php $this->load->view( $template_path .'/components/room/room_hero_text.php' ); ?>
					
<div class="container">
	
	<div class="row mb-1">
		
		<a href="<?php echo site_url( 'hotel/'. $room->hotel->hotel_id ); ?>" class="btn btn-link">
			
			<span class="badge badge-info">
				<i class="fa fa-arrow-circle-left"></i> 
				Back to <?php echo $room->hotel->hotel_name; ?>
			</span>
		</a>
	</div>
</div>

<div class="container box-shadow" style="background-color: white;">

	<div class="row mb-3">
		<div class="col-sm-12 col-md-6 padding-0-first p-3">

			<?php $this->load->view( $template_path .'/components/room/room_info.php'); ?>
			
		</div>
		<div class="col-sm-12 col-md-6 padding-0 p-3" style="background-color: #e9e9e9">

			<?php $this->load->view( $template_path .'/components/room/room_features.php' ); ?>
			
		</div>
	</div>

</div>

<div class="container box-shadow mb-3" style="background-color: white;">

	<div class="row">
		<div class="col-md-12 col-lg-6 padding-0-first p-3">

			<?php $this->load->view( $template_path .'/components/room/room_gallery.php'); ?>

			
		</div>
		<div class="col-md-12 col-lg-6 p-3" style="background-color: #e9e9e9">

			<?php $this->ps_widget->reviews( $room->room_id ); ?>
			
		</div>
	</div>
</div>

<?php $this->load->view( $template_path .'/components/room/review_modal.php', array( 'room_id' => $room->room_id )); ?>

<script type="text/javascript">
function room()
{
	$('#roomGallery').carousel();
}
</script>