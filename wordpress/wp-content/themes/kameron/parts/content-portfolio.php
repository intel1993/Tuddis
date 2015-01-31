<?php 
$thumb_key = 'portfolio_mini_thumbnail';

$gallery_classes = parse_gallery_cookies();
$gallery_descriptions = false;

$enable_thumbnails = Village::is_enabled('gallery_enable_thumbnails');

?>

<article id="post-<?php the_ID(); ?>" <?php post_class("entry-item"); ?>>

		<header class="entry-header">
			<h1 class="entry-title">
					<?php the_title() ?>
			</h1>
		</header>


		<?php if( have_rows( Village::$key . 'gallery') ) : ?>
			<?php while( have_rows( Village::$key . 'gallery') ):
				the_row();

				$image = get_sub_field( 'image');
				$caption = get_sub_field( 'title');
				$description = get_sub_field( 'description');
				$video = get_sub_field( 'video_url');

				# If there is at least one description - utilize that
				if( $description != "" ) {
					$gallery_descriptions = true;
				}
				
				# If no video, set to false instead of empty string
				if( empty( $video ) ) {
					$video = false;
				}

				$item = array(
					'image' => $image['url'],
					'caption' => $caption,
					'desc' => wp_kses_post( balanceTags( $description ) ),
					'video' => $video,
				);

				if( $enable_thumbnails ) {

					$item['thumb'] = $image['sizes'][ $thumb_key ];
					$item['thumbwidth'] = $image['sizes'][ $thumb_key . '-width' ];
					$item['thumbheight'] = $image['sizes'][ $thumb_key . '-height' ];

				}


				if( !empty( $item['image']) || !empty( $item['video'] ) ) {
					$images[] = $item;
				}
			?>
			<?php endwhile; ?>

			<?php 
				# No Descriptions === No sidebar
				if( $gallery_descriptions === false ){
					array_push($gallery_classes, 'no-sidebar');
					array_push($gallery_classes, 'is-full');
				} 
			?>
		<?php endif; ?>
	
		<div id="gallery"<?php Village::render_class($gallery_classes);?>>
			
			<!-- Sidebar -->
			<div id="gallery__sidebar">
				<div id="gallery__sidebar__close" class="gallery__button">
					<i class="icon ion-ios7-close-empty"></i>
				</div>
				<h3 class="title"><?php echo $images[0]['caption'] ?></h3>
				<div class="desc"><?php echo $images[0]['desc'] ?></div>
			</div> <!-- .gallery__sidebar -->

			<!-- Stage for Fotorama -->
			<div id="gallery__stage"></div>

			<!-- Gallery Data -->
			<div id="gallery-data" data-gallery='<?php
				echo htmlspecialchars( json_encode( $images ), ENT_QUOTES, 'UTF-8' );
			?>'></div>

			<!-- Buttons -->
			<div id="gallery__close" class="gallery__button">
				<i class="icon ion-ios7-close-empty"></i>
			</div>
			

			<div class="gallery__interaction">			
				
			<?php if ( $enable_thumbnails ): ?>
				<div id="gallery__thumbs__toggle" class="button">
					<i class="thumbs__close icon ion-ios7-arrow-down"></i>
					<i class="thumbs__show icon ion-ios7-arrow-up"></i>
				</div>
			<?php endif ?>


				<?php 
				$gallery_sharing = array_filter( array_values( (array) Village::get_theme_mod('gallery_sharing') ) );
				if ( !empty( $gallery_sharing ) ): ?>
				<div id="gallery__share" class="button">
					<div class="share-toggle">
						<i class="icon ion-share"></i>
					</div>

					<div class="share__networks">
						<i class="share__networks__arrow"></i>
						<div class="sharrre">

						</div>
					</div>
				</div>
				<?php endif ?>

				<div id="gallery__sidebar__open" class="button">
					<i class="icon ion-more"></i>
				</div>


			</div> <!-- .gallery__interaction -->
			
		</div> <!-- #gallery-000 -->

		<?php if( ! is_pjax() ): ?>
		
		<noscript>
			<?php foreach ($images as $image): ?>
			<div class="nojs-img">
				<a href="<?php echo $image['image'] ?>">
					<img src="<?php echo ( $enable_thumbnails ) ? $image['thumb'] : $image['image']; ?>"/>
				</a>

				<?php if ( $image['caption'] ): ?>
					<h3 class="title"><?php echo $image['caption'] ?></h3>
				<?php endif; ?>				

				<?php if ( $image['desc'] ): ?>
					<p class="desc"><?php echo $image['desc'] ?></p>
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
		</noscript>
		<?php endif; ?>

		
		<?php the_content(); ?>


	

</article><!-- #post-## -->
