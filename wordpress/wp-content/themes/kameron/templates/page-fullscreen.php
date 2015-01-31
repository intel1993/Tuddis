<?php
/*
Template Name: Fullscreen Welcome Page
 */
maybe_get_header( 'fullscreen' );

if ( have_posts() ): the_post();
?>
<?php 
//-----------------------------------*/
// Get the Slider Images
//-----------------------------------*/
    
$images = array();
if( have_rows( 'slider_images') ) {
	
	// This may look like crap for what it's used
	// But provides easy future extendability
	while( have_rows( 'slider_images' ) ) {
	
		the_row();

		$image = get_sub_field( 'image' );

		$item = array(
			'image' => $image['url'],
		);

		$images[] = $item;
	}
}

$overlay_image = get_field('overlay_image');
$background_color = sanitize_hex_color( get_field('background_color') );


// Enter Site: Image
$es_image = get_field('enter_site_image');
if( $es_image && !empty( $es_image['url'] ) ) {
	$enter_site_image = esc_url_raw( $es_image['url'] );
} else {
	$enter_site_image = false;
}

// Enter Site: Text
$es_text = get_field('enter_site_text');
if( $es_text ) {
	$enter_site_text = $es_text;
} else {
	$enter_site_text = __('Enter Site', 'village');
}
// Sanitize Enter Site Text
$enter_site_text = wp_kses( $enter_site_text, array(
	    'strong' => array(),
) );

// Enter Site: URL
$es_url = get_field('enter_site_link'); 

if( $es_url ) {
	$enter_site_link = esc_url_raw( $es_url );
} else {
	$enter_site_link = custom_home_url();
}



?>
<div id="stage" <?php village_background('fs') ?>>
		<?php //var_dump($images); die(); ?>
	<?php if ( count( $images ) > 0 ): ?>
		<div id="fullscreen-gallery">
			<div class="slides-container">
				<?php foreach ($images as $img): ?>
					<img src="<?php echo $img['image'] ?>">
				<?php endforeach ?>
			</div>
		</div>
	<?php endif ?>
	
	<div class="fs__overlay">
		
	<?php if ( $overlay_image): ?>
		<div class="fs__overlay__logo">
			<img src="<?php echo $overlay_image['url'] ?>" alt="<?php wp_title() ?>" class="overlay__image">
		</div>
	<?php endif ?>		

	<div class="fs__overlay__link">
		<a id="enter-site" href="<?php echo $enter_site_link;?>" class="no-pjax"><?php
		if( $enter_site_image ) {
			echo '<img src="' . $enter_site_image . '" alt="' . $enter_site_text . '">';
		} else {
			echo $enter_site_text;
		}

		 ?></a>
		
	</div>
	
	</div> <!-- .fs__overlay -->


</div> <!-- #stage -->

<?php else: ?>
    <?php get_template_part( '404' ); ?>
<?php endif; ?>
<?php maybe_get_footer(); ?>
