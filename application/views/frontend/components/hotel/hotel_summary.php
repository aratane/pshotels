
<div class="container">

	<div class="row hotel-summary box-shadow mb-2 align-items-top">

		<div class="col-sm-12 col-md-6 padding-0-first p-3">
			
			<blockquote class="hotel-desc" style="min-height: 230px">
				<?php echo $hotel->hotel_desc; ?>
			</blockquote>

		</div>

		<div class="col-sm-12 col-md-6 padding-0 p-3" style="background-color: #e9e9e9">
			
			<div id="map" style="min-height: 430px"></div>
		
		</div>
	</div>

</div>


<div class="container">

	<div class="row hotel-summary box-shadow mb-2 align-items-top">

		<div class="col-sm-12 col-md-8 padding-0-first p-3">

			<?php if ( !empty( $hotel->features )): ?>
			
			<div class="row hotel-features mb-2">

				<?php foreach ( $hotel->features as $key => $feature ): ?>

				<div class="col-md-6 col-lg-4 mb-3">

					<h5 class="mb-3">

						<?php $img = $this->ps_widget->get_default_photo( $key, 'hinfo_grp' ); ?>

						<img src="<?php echo img_url( $img->img_path ); ?>" width="20" class="mr-1"/>
						
						<?php echo $this->HotelInfoGroup->get_one( $key )->hinfo_grp_name; ?>
					</h5>

					<?php foreach ( $feature as $info ): ?>

						<p class="">✓ <?php echo $this->HotelInfoType->get_one( $info )->hinfo_typ_name; ?></p>

					<?php endforeach; ?>

				</div>

				<?php endforeach; ?>

			</div>

			<?php endif; ?>		

		</div>

		<div class="col-sm-12 col-md-4 padding-0 p-3" style="background-color: #e9e9e9">

			<div class="hotel-info">
				<p><strong>Price per night</strong>: <?php echo $hotel->hotel_min_price .' ~ '. $hotel->hotel_max_price; ?></p>

				<p><strong>Check in/out time</strong> <?php echo $hotel->hotel_check_in .' ~ '. $hotel->hotel_check_out; ?></p>

				<p><strong>Contact Email:</strong> <?php echo $hotel->hotel_email; ?></p>

				<p><strong>Contact Phone:</strong> <?php echo $hotel->hotel_phone; ?></p>
			</div>	
		
		</div>
	</div>
</div>

<!-- openstreetmap leaflet js -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<!-- Load Esri Leaflet from CDN -->
<script src="https://unpkg.com/esri-leaflet"></script>

<!-- Esri Leaflet Geocoder -->
<link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder/dist/esri-leaflet-geocoder.css">
<script src="https://unpkg.com/esri-leaflet-geocoder"></script>
<script>

	//hotel map location
	var hotel_map = L.map('map').setView([<?php echo $hotel->hotel_lat;?>, <?php echo $hotel->hotel_lng;?>], 5);

    const hotel_attribution =
    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
    const hotel_tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    const hotel_tiles = L.tileLayer(hotel_tileUrl, { hotel_attribution });
    hotel_tiles.addTo(hotel_map);
   	<?php
   		$lat = $hotel->hotel_lat;
   		$lng = $hotel->hotel_lng;
   	?>
    var hotel_marker = new L.Marker(new L.LatLng(<?php echo $lat;?>, <?php echo $lng;?>));
    hotel_map.addLayer(hotel_marker);

</script>