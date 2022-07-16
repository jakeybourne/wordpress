<?php 

get_header();

	$id = get_the_ID();
	
	$cats = get_the_terms($id,'capability_category');
	$tier_type = $cats[0]->slug;
	
	$tier_1_capabilities = array();
	
	if($tier_type == 'tier-1'){
		$about_section = get_field('about_section_t1',$id);
	}elseif($tier_type == 'tier-2'){
		$about_section = get_field('about_section_t2',$id);
	}
	
	$rs_sec = $about_section['rightside_section'];
	
	$heading = $rs_sec['heading'];
	$content = $rs_sec['content'];
	$button = $rs_sec['button'];
	$button2 = $rs_sec['button_2'];
	
	
?>
<!-- Largest Info -->
<section class="largest-info">
<?php		
		$use_imagevideo = $about_section['use_imagevideo'];
		
		if($use_imagevideo == 1){
			$left_image = $about_section['leftside_image'];
			
			if(empty($left_image)){
				$left_image = get_field('placeholder_image','option');
			}
			
			?>
				<div class="img-block">
					<img src="<?php echo $left_image['url']; ?>" alt="<?php echo $left_image['alt']; ?>" title="<?php echo $left_image['title']; ?>">
				</div>
			<?php 
			
		}else{
			$video_link = $about_section['leftside_video_link'];
			
			if($video_link){
			?>
				<div class="img-block video-block">
					<iframe width="752" height="432px" src="<?php echo $video_link; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
				</div>
	<?php } 
		}
		
	?>
		<div class="info-block">
			<div class="info-block-inner">
				<?php if($heading){ ?><h2><?php echo $heading; ?></h2> <?php } ?>
				<?php echo $content; 
				
					if( $button ){
						$link_url = $button['url'];
						$link_title = $button['title'];
						$link_target = $button['target'] ? $button['target'] : '_self';
				?>
					<a href="<?php echo $link_url; ?>" class="btn" target="<?php echo $link_target; ?>"><?php echo $link_title; ?></a>
				<?php }

				if( $button2 ){
						$link_url2 = $button2['url'];
						$link_title2 = $button2['title'];
						$link_target2 = $button2['target'] ? $button2['target'] : '_self';
				?>
					<a href="<?php echo $link_url2; ?>" class="btn" target="<?php echo $link_target2; ?>"><?php echo $link_title2; ?></a>
				<?php } ?>
			</div>
		</div>
</section>

<section  class="largest-info" style="width:100%; display:inline-block;">
	<?php the_content(); ?>
</section>
<!-- Services -->
<?php 

$cap_sec = get_field('capability_section');

$ca_show = $cap_sec['show_hide'];


if($tier_type == 'tier-1'){
	
	
	if($ca_show == 1){
	
	$cap_layout = $cap_sec['capabilities_tier2_layout'];
	
	if($cap_layout == 1){
?>
	<section class="services">
		<div class="container">
			<div class="row justify-content-center">
				<?php
					
					$cap_rel = $cap_sec['select_capabilities'];
				
					if(count($cap_rel) > 0){
						
						foreach($cap_rel as $capr){
							
							$cp_id = $capr->ID;
							$cp_title = $capr->post_title;
							$cp_url = get_the_permalink($cp_id);
						   
						    $vimg = get_field('vector_image',$cp_id);
							
							/* if($vimg){ */
							
								$cp_img = wp_get_attachment_image_src( $vimg, 'full' );
								
								$cp_img_alt = get_post_meta( $vimg, '_wp_attachment_image_alt', true );
								$cp_img_title = get_the_title($vimg);
								
								if(empty($cp_img[0])){
									$img_url = site_url().'/wp-content/themes/hii/assets/images/white-logo.svg';
								}else{
									$img_url = $cp_img[0];
								}
						?>		
								
								<div class="col-md-6 col-lg-4 service-item">
									<div class="img_wrapper">
										<img src="<?php echo $img_url; ?>" alt="<?php echo $cp_img_alt; ?>" title="<?php echo $cp_img_title; ?>">
									</div>
									<h2><?php echo $cp_title; ?></h2>
									<a href="<?php echo $cp_url; ?>" class="btn white-btn">LEARN MORE</a>
								</div>
						<?php	
							/* } */
						}
					}
				
				
					/* == Jayesh See More Button Comment Code == */
				
					/* $args = array(
						'post_type' => 'capabilities', 
						'post_status' => 'publish',
						'posts_per_page' => -1,
						'orderby' => 'post_date', 
						'order' => 'DESC',
						'meta_query'	=> array(
							array(
								'key'	  	=> 'is_the_flagship',
								'value'	  	=> '1',
								'compare' 	=> '==',
							),
						),
						'tax_query' => array(
							array(
								'taxonomy' => 'capability_category',
								'field' => 'slug',
								'terms' => 'tier-2'
							),
					   ),
					);
					$query = new WP_Query( $args );
					
					$total_posts = $query->found_posts;
					$mn_pages = $query->max_num_pages;
					
					if($query->have_posts() ) : 
						echo "<div class='mn_pages' style='display:none;'>".$mn_pages."</div>";
					
						while ( $query->have_posts() ) : 
						   $query->the_post(); 
						   
						   $cp_id = get_the_ID();
						   $cp_title = get_the_title();
						   $cp_url = get_the_permalink();
						   
						   $vimg = get_field('vector_image',$cid);
							
							if($vimg){
							
							$cp_img = wp_get_attachment_image_src( $vimg, 'full' );
							
							$cp_img_alt = get_post_meta( $vimg, '_wp_attachment_image_alt', true );
							$cp_img_title = get_the_title($vimg);
					?>
								<div class="col-md-6 col-lg-4 service-item">
									<div class="img_wrapper">
										<img src="<?php echo $cp_img[0]; ?>" alt="<?php echo $cp_img_alt; ?>" title="<?php echo $cp_img_title; ?>">
									</div>
									<h2><?php echo $cp_title; ?></h2>
									<a href="<?php echo $cp_url; ?>" class="btn white-btn">LEARN MORE</a>
								</div>
					<?php	
							}
						endwhile; 
					wp_reset_postdata(); 
				
				endif; */
				?>
			
			</div>
			
			<?php 
				if ( $total_posts > $mn_pages ){
			?>		
				<div class="col-md-12 btn-block">
					<a href="javascript:void(0);" class="btn white-btn" id="loadmore">SEE MORE</a>
				</div>
			<?php }  ?>
			<div class="gif text-center">
				<div class="gif-loader" style="display:none;"></div>
			</div>
		</div>
	</section>
<?php 
	}else{
		
		$ca_title = $cap_sec['capability_title'];
?>		
	<!-- Our Capabilities Two -->
	<section class="our-capabilities-two">
		<div class="container">
		<div class="solutions-items">
			<h2><?php echo $ca_title; ?></h2>
			<div class="row">
				<?php
				
					$cap_rel = $cap_sec['select_capabilities'];
				
					if(count($cap_rel) > 0){
						
						foreach($cap_rel as $capr){
							
							$cp_id = $capr->ID;
							$cp_title = $capr->post_title;
							$cp_url = get_the_permalink($cp_id);
						?>		
							<div class="col-sm-6 col-md-3">
								<a href="<?php echo $cp_url; ?>">
								<div class="info-box">
								  <h3><?php echo $cp_title; ?></h3>
								</div>
								</a>
							</div>
						<?php
						}
					}
				
					/* $args = array(
						'post_type' => 'capabilities', 
						'post_status' => 'publish',
						'posts_per_page' => 8,
						'orderby' => 'post_date', 
						'order' => 'DESC',
						'tax_query' => array(
							array(
								'taxonomy' => 'capability_category',
								'field' => 'slug',
								'terms' => array('tier-1','tier-2')
							),
						),
					);
					$query = new WP_Query( $args );
					
					if($query->have_posts() ) : 
						
						while ( $query->have_posts() ) : 
						   $query->the_post(); 
						   // content goes here
						   
						   $cp_id = get_the_ID();
						   $cp_title = get_the_title();
						   $cp_url = get_the_permalink();
						   
					?>
							<div class="col-sm-6 col-md-3">
								<a href="<?php echo $cp_url; ?>">
								<div class="info-box">
								  <h3><?php echo $cp_title; ?></h3>
								</div>
								</a>
							</div>
					<?php	
						endwhile; 
					wp_reset_postdata(); 
				
				endif; */
				?>
			</div>
		</div>
		</div>
	</section>
<?php		
	}
}
	
	$person_about_sec = get_field('person_about_section');
	
	$show = $person_about_sec['show__hide'];
	
	if($show == 1){
		$heading = $person_about_sec['heading'];
		$subheading = $person_about_sec['subheading'];
		$content = $person_about_sec['content'];
		/* $pe_button = $person_about_sec['button']; */
		$pe_buttons = $person_about_sec['buttons'];
		$per_image = $person_about_sec['leftside_image'];
?>
		<!-- Our Team -->
		<section class="our-team">
			<div class="container">
				<div class="team-info-box">
					<div class="row">
						<div class="col-md-7">
							<div class="team-info">
								<h2><?php echo $heading; ?></h2>
								<h4><?php echo $subheading; ?></h4>
								<?php echo $content; ?>
								<?php 
								if( $pe_buttons ){
								foreach($pe_buttons as $btns){
										$button = $btns['button'];
									
										$link_url = $button['url'];
										$link_title = $button['title'];
										$link_target = $button['target'] ? $button['target'] : '_self';
								?>
										<a href="<?php echo $link_url; ?>" class="btn white-btn" target="<?php echo $link_target; ?>"><?php echo $link_title; ?></a>
								<?php }
								}	
								
								?>
							</div>
						</div>
						<div class="col-md-5">
							<div class="team-img">
								<?php 
								
								if(empty($per_image)){
									$per_image = get_field('placeholder_image','option');
								}	
								
								/* if($per_image){	
									$cp_img = wp_get_attachment_image_src( $per_image, 'full' );
									$cp_img_alt = get_post_meta( $per_image, '_wp_attachment_image_alt', true );
									$cp_img_title = get_the_title($per_image); */
								
								?>
									<img src="<?php echo $per_image['url']; ?>" alt="<?php echo $per_image['alt']; ?>" title="<?php echo $per_image['title']; ?>">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

<?php	
	}
	
	$act_capb = get_field('capabilities_in_action');
	
	$acp_show = $act_capb['show__hide'];
	$acp_title = $act_capb['heading'];
	$acp_list = $act_capb['tier_3_capabilities'];

	if($acp_show){
		if(!empty($acp_title) && count($acp_list) != 0){
		?>

			<!-- Capabilities Action -->
			<section class="capabilities-action">
				<div class="container">
					<div class="white-box">
					<div class="row">
					  <div class="col-md-4 col-lg-3">
						<h3><?php echo $acp_title; ?></h3>
					  </div>
					  
					  <div class="col-md-8 col-lg-9">
					  <div class="row">
					  
					  <?php 
						foreach($acp_list as $cpl){
							
							$cpid = $cpl->ID;
							$cptitle = $cpl->post_title;
							
							$flagship = get_field('flagship',$cpid);
							
							if($flagship != 1){
									
								/* $th_img = get_field('grid_image',$cpid);  */
								
								$image = wp_get_attachment_image_src( get_post_thumbnail_id( $cpid ),'full');
								
								if(empty($image)){
									$image = get_field('placeholder_image','option');
									$img_url = $image['url'];
								}else{
									$img_url = $image[0];
								}	
								
						?>
							<div class="col-md-6 col-lg-3">
								<a href="<?php echo get_permalink($cpid); ?>" class="action-img"><img src="<?php echo $img_url; ?>" alt="<?php echo $cptitle; ?>" title="<?php echo $cptitle; ?>"></a>
								<h4><?php echo $cptitle; ?></h4>
								<span><a href="<?php echo site_url().'capabilities/sea/'; ?>">Sea</a></span>
								<span><a href="<?php echo site_url().'capabilities/defense/'; ?>">Defense</a></span>
								<span><a href="#0">TSD</a></span>
							</div>
						
					 <?php			
							}
							
						}
					  ?>
					  
					</div>
					</div>
					</div>
					</div>
				</div>
			</section>
		<?php 
		}
	}
	
	$media_section_tier1 = get_field('media_section_tier1');
	
	$me_1_show_hide = $media_section_tier1['show__hide'];
	
	if($me_1_show_hide == 1){
		
		$heading = $media_section_tier1['heading'];
		$media_gallery = $media_section_tier1['media_gallery'];
		$media_gallery_section = $media_section_tier1['media_gallery_section'];
?>
	<!-- Media Gallery -->
	<section class="media-gallery">
		<div class="container">
			<?php 
				if(!empty($heading)){ 
					echo '<h2>'.$heading.'</h2>'; 
				} 
			
			if(count($media_gallery_section) > 1){
			?>
				<div class="slider slider-for">
					<?php 
						foreach($media_gallery_section as $mgal){
							
							$type = $mgal['type'];
							$image = $mgal['image'];
							$video = $mgal['video'];
							
							if(!empty($image)){
								$url = $image['url'];
								$alt = $image['alt'];
								$title = $image['title'];
							}
							
					?>
						<div class="slider-banner-image">
							<?php 
							if($type == 'Image'){
							?>
								<img src="<?php echo $url; ?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>">
							<?php 
							}else{
							
								?>
								<div class="video-block">
									<iframe src="<?php echo $video; ?>" width="100%" height="610px" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
								</div>
							<?php } ?>
						</div>
					<?php
						}
					?>
				</div>
				<div class="slider slider-nav thumb-image">
					<?php 
					
						foreach($media_gallery_section as $mgal){
							
							$type = $mgal['type'];
							$image = $mgal['image'];
							
							$vclass = '';
							if($type == 'Image'){
								if(!empty($image)){
									$url = $image['url'];
									$alt = $image['alt'];
									$title = $image['title'];
								}
							}else{
								
								$url = grab_vimeo_thumbnail($video);
								$alt = 'HII Video';
								$title = 'HII Video';
								
								$vclass = 'video_thumb';
							}
							
					?>
						<div class="thumbnail-image">
							<div class="thumbImg <?php echo $vclass; ?>">
								<img src="<?php echo $url; ?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>">
							</div>
						</div>
					<?php
						}
					?>
				</div>
			<?php } ?>
		</div>
	</section>
<?php } 
	
}elseif($tier_type == 'tier-2'){
	
	$media_section = get_field('media_section');
	
	$show_hide = $media_section['show__hide'];
	
	if($show_hide == 1){
		
		$heading = $media_section['heading'];
		$media_gallery = $media_section['media_gallery'];
		$media_gallery_section = $media_section['media_gallery_section'];
?>
	<!-- Media Gallery -->
	<section class="media-gallery">
		<div class="container">
			<?php 
				if(!empty($heading)){ 
					echo '<h2>'.$heading.'</h2>'; 
				} 
			
			if(count($media_gallery_section) > 1){
			?>
				<div class="slider slider-for">
					<?php 
						foreach($media_gallery_section as $mgal){
							
							$type = $mgal['type'];
							$image = $mgal['image'];
							
							if(!empty($image)){
								$url = $image['url'];
								$alt = $image['alt'];
								$title = $image['title'];
							}
							
					?>
						<div class="slider-banner-image">
							<?php 
							if($type == 'Image'){
							?>
								<img src="<?php echo $url; ?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>">
							<?php 
							}else{
							$video = $mgal['video'];
								?>
								<div class="video-block">
									<iframe src="<?php echo $video; ?>" width="100%" height="610px" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
								</div>
							<?php } ?>
						</div>
					<?php
						}
					?>
				</div>
				<div class="slider slider-nav thumb-image">
					<?php 
					
						foreach($media_gallery_section as $mgal){
							
							$type = $mgal['type'];
							$image = $mgal['image'];
							
							$vclass = '';
							if($type == 'Image'){
								if(!empty($image)){
									$url = $image['url'];
									$alt = $image['alt'];
									$title = $image['title'];
								}
							}else{
								
								$url = grab_vimeo_thumbnail($video);
								
								$alt = 'HII Video';
								$title = 'HII Video';
								$vclass = 'video_thumb';
							}
							
					?>
						<div class="thumbnail-image">
							<div class="thumbImg <?php echo $vclass; ?>">
								<img src="<?php echo $url; ?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>">
							</div>
						</div>
					<?php
						}
					?>
				</div>
			<?php } ?>
		</div>
	</section>
<?php } 


$t2_act_capb = get_field('capabilities_in_action_t2');
 
$t2_acp_show = $t2_act_capb['show__hide'];
$t2_acp_title = $t2_act_capb['heading'];
$t2_acp_list = $t2_act_capb['tier_3_capabilities'];

if($t2_acp_show){
	if(!empty($t2_acp_title) && count($t2_acp_list) != 0){
	?>

		<!-- Capabilities Action -->
		<section class="capabilities-action">
			<div class="container">
				<div class="white-box">
				<div class="row">
				  <div class="col-md-4">
					<h3><?php echo $t2_acp_title; ?></h3>
				  </div>
				  
				  <div class="col-md-8">
				  <div class="row">
				  
				  <?php 
					foreach($t2_acp_list as $cpl){
						
						$cpid = $cpl->ID;
						$cptitle = $cpl->post_title;
						
						$flagship = get_field('flagship',$cpid);
						
						if($flagship != 1){
								
							/* $th_img = get_field('grid_image',$cpid);  */
							
							$image = wp_get_attachment_image_src( get_post_thumbnail_id( $cpid ),'full');
							
							if(empty($image)){
								$image = get_field('placeholder_image','option');
								$img_url = $image['url'];
							}else{
								$img_url = $image[0];
							}	
							
					?>
						<div class="col-md-3">
							<a href="<?php echo get_permalink($cpid); ?>"><img src="<?php echo $img_url; ?>" alt="<?php echo $cptitle; ?>" title="<?php echo $cptitle; ?>"></a>
							<h4><?php echo $cptitle; ?></h4>
							<span><a href="<?php echo site_url().'capabilities/sea/'; ?>">Sea</a></span>
							<span><a href="<?php echo site_url().'capabilities/defense/'; ?>">Defense</a></span>
							<span><a href="#0">TSD</a></span>
						</div>
				  <?php			
						}
					}
				  ?>
				</div>
				</div>
				</div>
				</div>
			</div>
		</section>
	<?php 
	}
}


$rel_cap = get_field('related_capabilities');

$show = $rel_cap['show__hide'];

if($show == 1){
	
	$heading = $rel_cap['heading'];
	/* $layout = $rel_cap['layout']; */
	$sel2_cap = $rel_cap['select_tier_2_capabilities'];
	
	/* if($layout == 1){ */
?>	
	<!-- Related Capabilities Option1 -->
	<section class="related-capabilities">
		<div class="container">
			<?php 
				if(!empty($heading)){
					echo '<h2>'.$heading.'</h2>';
				}
				
				if(count($sel2_cap) > 1){
			?>
					<div class="row">
						<?php 
							foreach($sel2_cap as $scap){
							
								$id = $scap->ID;
								
								$header = get_field('header_section_t2',$id);
								$title = $header['big_heading'];
								if(empty($title)){
									$title = $scap->post_title;
								}
								
								$cp_image = wp_get_attachment_image_src( get_post_thumbnail_id($id),'full');
								$img_url = $cp_image[0];
								
								if(empty($img_url)){
									$about_section = get_field('about_section_t2',$id);
									$left_image = $about_section['leftside_image'];
									
									if(empty($left_image)){
										$left_image = get_field('placeholder_image','option');
									}
									
									$img_url = $left_image['url'];
								}
						?>
							<div class="col-md-4">
								<a href="<?php echo get_the_permalink($id); ?>"><img src="<?php echo $img_url; ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>"></a>
								<h3><a href="<?php echo get_the_permalink($id); ?>"><?php echo $title; ?></a></h3>
							</div>
						<?php } ?>
					</div>
			<?php } ?>
		</div>
	</section>
<?php 
	/* }else{
?>	
	
	<!-- Related Capabilities Option2 -->
	<section class="capabilities-action">
		<div class="white-box">
			<div class="row">
			  <div class="col-md-4">
				<?php 
					if(!empty($heading)){
						echo '<h3>'.$heading.'</h3>';
					}
				?>
			  </div>
			  
			  <?php 
			  if(count($sel2_cap) > 1){
					foreach($sel2_cap as $scap){
							
						$id = $scap->ID;
						
						$header = get_field('header_section_t2',$id);
						$title = $header['big_heading'];
						if(empty($title)){
							$title = $scap->post_title;
						}
						
						$cp_image = wp_get_attachment_image_src( get_post_thumbnail_id($id),'full');
						
				?>
					<div class="col-md-2">
						<a href="<?php echo get_permalink($id); ?>"><img src="<?php echo $cp_image[0]; ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>"></a>
						<h4><?php echo $title; ?></h4>
						<span>Sea</span>
						<span>Defense</span>
						<span>TSD</span>
					</div>
				
			 <?php			
					}
				}
			  ?>
			  
			</div>
		</div>
	</section>
<?php
	} */
}

}
?>

<?php
	get_footer(); 
?>