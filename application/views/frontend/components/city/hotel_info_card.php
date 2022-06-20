<div class="card mb-2">

	<div class="card-body">

		<a href='<?php echo site_url( 'hotel/'. $hotel->hotel_id ); ?>'>

			<div class="row align-items-top">

				<div class="col-4 hotel-image">
					
					<img class="mr-3 ps-img-hover w-100" src="<?php echo img_url( $hotel->default_photo->img_path ); ?>" alt="Generic placeholder image">

				</div>

				<div class="col-5 hotel-info">
					
					<h5 class="hotel-title mt-0 mb-1"><?php echo $hotel->hotel_name; ?></h5>

					<p class="mb-3 text-muted"><?php echo $city->city_name .', '. $city->country->country_name; ?></p>

					<?php $features = $this->HotelInfo->get_all_by( array( 'hotel_id' => $hotel->hotel_id ))->result(); ?>

					<?php if ( isset( $features[0] )): ?>
					
					<p class="my-1">
						<span class="text-primary mr-1">Offers:</span>
						<span class="text-success"><?php echo $this->HotelInfoType->get_one( $features[0]->hinfo_typ_id )->hinfo_typ_name; ?></span>
					</p>

					<?php endif; ?>

					<?php if ( isset( $features[1] )): ?>

					<p class="my-1">
						<span class="text-primary mr-1">Options:</span>
						<span class="text-success"><?php echo $this->HotelInfoType->get_one( $features[1]->hinfo_typ_id )->hinfo_typ_name; ?></span>
					</p>

					<?php endif; ?>

				</div>

				<div class="col-3 hotel-social">

				<?php if ( isset( $hotel->final_rating )): ?>

					<div class="raty" id="<?php echo $hotel->hotel_id; ?>"></div>
					
					<span class="badge badge-info mb-2">
						<?php echo $hotel->rating_text .' - '. get_rating_number( $hotel->final_rating ); ?>
					</span>

				<?php endif; ?>

				<?php if ( isset( $hotel->promotion )): ?>

					<br>

					<span class="badge badge-success mb-2"><?php echo $hotel->promotion->promo_percent; ?>% Promotion!</span>

				<?php endif; ?>

				<?php if ( isset( $hotel->hotel_min_price ) && !empty( $hotel->hotel_min_price )): ?>

					<p class="text-danger">
						<?php echo $hotel->hotel_min_price .' ~ '. $hotel->hotel_max_price; ?>
							

						<?php echo get_app_config( 'currency_symbol' ); ?>
					</p>

				<?php endif; ?>

				</div>

				<?php if ( !empty( $hotel->hotel_lat ) && !empty( $hotel->hotel_lng )): ?>
							
					<input class="point" type="hidden" value='{"lat":<?php echo $hotel->hotel_lat; ?>,"lng":<?php echo $hotel->hotel_lng; ?>,"title":"<?php echo $hotel->hotel_name; ?>","url":"<?php echo site_url( 'hotel/'. $hotel->hotel_id ); ?>"}'/>

				<?php endif; ?>

			</div>
		</a>
	</div>
</div>