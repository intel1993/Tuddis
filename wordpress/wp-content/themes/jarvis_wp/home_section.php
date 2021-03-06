<!--BEGIN HOME SECTION -->
<?php global $smof_data; 

if($smof_data['rnr_home_type']=="Video") { ?>

<div class="video_slide">
    <div style="z-index: -99; width: 100%; height: 100%">
          
    <?php if($smof_data['rnr_home_video_type']=="youtube") { 
          echo '<iframe class="full_slide" "width="960" height="540" src="http://www.youtube.com/embed/'.$smof_data['rnr_home_video_id'].'?autoplay=1&amp;loop=1&playlist='.$smof_data['rnr_home_video_id'].'&amp;controls=0&amp;showinfo=0&amp;autohide=1&amp;rel=0&amp;hd=1"></iframe>';
           } else if($smof_data['rnr_home_video_type']=="vimeo") { 
          echo '<iframe class="full_slide" src="http://player.vimeo.com/video/'.$smof_data['rnr_home_video_id'].'?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff&amp;autoplay=1&amp;loop=1" width="960" height="540" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
           } ?>            
    </div>
</div>
       
            
 <?php } ?>

<div class="home-text-wrapper">

<?php 

  if ( ( $test_locations = get_nav_menu_locations() ) && $test_locations['main-menu'] ) {
	  
      $test_menu = wp_get_nav_menu_object( $test_locations['main-menu'] );
      $test_menu_items = wp_get_nav_menu_items($test_menu->term_id);
	  $k = 0;
      foreach($test_menu_items as $test_key => $test_item) {
		  
          if($test_item->object == 'page'){
			  			  
			    $test_varpost = get_post($test_item->object_id);    
				$test_post_name = $test_varpost->post_name;            
                $test_separate_page = get_post_meta($test_item->object_id, "rnr_separate_page", true);
                $test_disable_menu = get_post_meta($test_item->object_id, "rnr_disable_section_from_menu", true);
				
				if ( $test_separate_page != true ) // && $test_disable_menu != true
				  {
					if ($k==1) {
					  $home_link = "#" . $test_post_name;
					  break; // breaks foreach loop
					}
					$k++;					
				  } // ends if block "separate page"	
				  	
		  } // ends if block "is_page"         
		  		  
      } // ends foreach loop
	  
  } // ends if block "menu locations"
  
  

 if($smof_data['rnr_enable_home_logo']!= false) { ?>

  <?php      
  
  if(!empty($smof_data['rnr_home_logo_url'])){ ?>
    <div class="home-logo">
        <a href="<?php echo $home_link; ?>">
         <img src="<?php echo $smof_data['rnr_home_logo_url']; ?>" 
              alt="<?php $home_link; ?>"
          />
       </a>
    </div>
    <?php } else { ?>
      <div class="home-logo-text <?php if($smof_data['rnr_home_logo_text_type']== '0') { echo 'light'; } ?>">
        <a href="<?php echo $home_link; ?>"><?php  echo $smof_data['rnr_home_logo_text']; ?></a>
      </div>  
    <?php } ?>
 <?php } ?>
      
<?php 



  if($smof_data['rnr_home_type']=="Revolution Slider") { ?>
      
       <div class="home-slider">
          <?php if (get_post_meta( get_the_ID(), 'rnr_revolutionslider', true ) != '0') { ?>
          
              <?php if(class_exists('RevSlider')){ putRevSlider(get_post_meta( get_the_ID(), 'rnr_revolutionslider', true )); } ?>
          
          <?php } /* end slidertype = revslider */ ?>
      </div>	  

 <?php }
  else if($smof_data['rnr_home_type']=="FullScreen Slider") { ?>
      
        <div class="slider-text clearfix">
        <div class="container">
				
				<div class="sixteen columns">
					<div id="slidecaption"></div>
				</div>
				
				<div class="sixteen columns">
					<a id="prevslide" class="load-item"></a>
					<a id="nextslide" class="load-item"></a>
				</div>
			</div>
            </div>	  

 <?php } 
  else if($smof_data['rnr_home_type']=="Boxed Content") { ?>

        <div class="container">
				
				<div class="sixteen columns">
                  <?php   the_content(); ?>
				</div>
		</div>
 

 <?php } else {
	 
	 the_content();
 }?>      
</div><!-- END HOME TEXT WRAPPER -->
