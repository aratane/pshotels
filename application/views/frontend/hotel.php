
<?php $this->load->view( $template_path .'/components/hotel/hotel_hero_text.php' ); ?>

<div class="container">

	<div class="row mb-1">

		<a href="<?php echo site_url( 'city/'. $hotel->city->city_id ); ?>" class="btn btn-link"> 

			<span class="badge badge-info">
			<i class="fa fa-arrow-circle-left"></i> Back to Hotel List from <?php echo $hotel->city->city_name; ?>
			</span>
		</a>
				
	</div>

</div>

<?php $this->load->view( $template_path .'/components/hotel/hotel_summary.php' ); ?>

<div class="container box-shadow" style="background-color: white;">

	<?php $this->load->view( $template_path .'/components/hotel/room_list.php' ); ?>

</div>

<?php $this->load->view( $template_path .'/components/hotel/gallery_modal.php', array( 'hotel_id' => $hotel->hotel_id )); ?>

<?php $this->load->view( $template_path .'/components/hotel/review_modal.php', array( 'hotel_id' => $hotel->hotel_id )); ?>