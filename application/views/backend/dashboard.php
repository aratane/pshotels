
<h2 class="page-header mb-4">
	Welcome, <?php echo $this->ps_auth->get_user_info()->user_name;?>!
</h2>
			
<?php flash_msg(); ?>
			
<div class="wrapper wrapper-content animated fadeInRight">
		 	
	<div class="row mb-1">

  		<div class="col-6 col-sm-3">
  			
  			<?php 

	  			$data = array(
	  				'url' => 'users' ,
	  				'total_count' => $this->User->count_all(),
	  				'label' => get_msg( 'total_users_count_label'),
	  				'icon' => "fa fa-group"
	  			);

	  			$this->load->view( $template_path .'/components/badge_count', $data ); 
  			?>

  		</div>
	
		<div class="col-6 col-sm-3">
  			
  			<?php 

	  			$data = array(
	  				'url' => 'users' ,
	  				'total_count' => $this->Like->count_all(),
	  				'label' => get_msg('total_reviews_count_label'),
	  				'icon' => "fa fa-pencil-square"
	  			);

	  			$this->load->view( $template_path .'/components/badge_count', $data ); 
  			?>

  		</div>

  		<div class="col-6 col-sm-3">
  			
  			<?php 

	  			$data = array(
	  				'url' => 'users' ,
	  				'total_count' => $this->Favourite->count_all(),
	  				'label' => get_msg('total_favs_count_label'),
	  				'icon' => "fa fa-heart"
	  			);

	  			$this->load->view( $template_path .'/components/badge_count', $data ); 
  			?>

  		</div>

  		<div class="col-6 col-sm-3">
  			
  			<?php 

	  			$data = array(
	  				'url' => 'users' ,
	  				'total_count' => $this->Comment->count_all(),
	  				'label' => get_msg('total_comments_count_label'),
	  				'icon' => "fa fa-comments"
	  			);

	  			$this->load->view( $template_path .'/components/badge_count', $data ); 
  			?>

  		</div>
	  	
  	</div>

	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	
	<?php $this->load->view( $template_path .'/components/popular_hotels_analytic' ); ?>
		
	<?php //$this->load->view( $template_path .'/components/popular_rooms_analytic' ); ?>
				
	<div class="row">
		           
		<div class="col-4">

			<?php 

	  			$data = array(
	  				'panel_title' => get_msg('review_panel_title'),
	  				'module_name' => 'reviews' ,
	  				'total_count' => $this->Review->count_all(),
	  				'data' => $this->Review->get_all(4,0)->result()
	  			);

	  			$this->load->view( $template_path .'/components/summary_review_panel', $data ); 
  			?>

		</div>

		<div class="col-4">

			<?php 

	  			$data = array(
	  				'panel_title' => get_msg('inquiry_panel_title'),
	  				'module_name' => 'inquiries' ,
	  				'total_count' => $this->Inquiry->count_all(),
	  				'data' => $this->Inquiry->get_all(5,0)->result()
	  			);

	  			$this->load->view( $template_path .'/components/summary_inquiry_panel', $data ); 
  			?>

		</div>

		<div class="col-4">

			<?php 

				$data = array(
					'panel_title' => get_msg('recent_room_panel_title'),
					'module_name' => 'rooms' ,
					'total_count' => $this->Room->count_all(),
					'data' => $this->Room->get_all(3,0)->result()
				);

				$this->load->view( $template_path .'/components/recent_rooms_panel', $data ); 
			?>

		</div>
	</div>

</div>

