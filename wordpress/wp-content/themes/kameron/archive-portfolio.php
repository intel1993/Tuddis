<?php
maybe_get_header();

$enable_gallery = Village::is_enabled( 'gallery_enable', true );
$enable_description = Village::is_enabled( 'portfolio_enable_desc', true );

$background_image = Village::get_theme_mod( 'portfolio_background_image' );
$background_color = Village::get_theme_mod( 'portfolio_background_color' );

$stage = array(
	'id' => 'stage',
	'class' => array( 'stage' ),
	'style' => array(),
);

if ( !empty( $background_image['url'] ) ) {
	$stage['style']['background-image'] = "url('$background_image[url]');";
}

if ( $background_color ) {
	$stage['style']['background-color'] = "$background_color";
}

if ( $enable_gallery ) {
	$stage['class'][] = 'has-gallery';
}

$stage['class'][] = Village::get_theme_mod('portfolio_description_text_preset', 'dark-font');


?>
	<div<?php Village::render_attributes( $stage ); ?>>
			<div class="js__scroll--horizontal scroll--horizontal js__winsize">
			<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

			<?php

				$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), "portfolio_tall_thumbnail" );
				$thumb_width = $thumbnail[1];

				$container = array(
					'class' => array( 'hscol', 'pfentry', 'js__hscol', 'js__pfentry' ),
					'data' => array(
						'entry-width' => $thumb_width,
					),
					'style' => array(
						'width' => $thumb_width . 'px',
					),
				);

				$the_content = get_the_content();
				if ( empty( $the_content ) ) {
					$container['class'][] = 'no-content';
				}

				?>

			<div<?php Village::render_attributes( $container ); ?>>

				<div id="gallery-<?php the_ID();?>" data-gallery-id="<?php the_ID();?>" class="pfentry__image">
					<?php the_post_thumbnail( 'portfolio_tall_thumbnail' ); ?>
				</div>


				<?php if ( $enable_description ): ?>
				<div class="pfentry__info">
					<div class="pfentry__info__wrapper">


						<?php if ( $the_content ): ?>
							<div class="js__scroll">
						<?php endif ?>

							<h2 class="pfentry__title">
								<?php if ( $enable_gallery ): ?>
								<a href="<?php the_permalink(); ?>" class="js__link">
									<?php the_title() ?>
								</a>
								<?php else: ?>
									<?php the_title(); ?>
								<?php endif; ?>
							</h2>

							<div class="pfentry__content">
							<?php
								// I already have the content
								// Don't have to re-run the_content() function
								echo $the_content;
							?>
							</div>

						<?php if ( $the_content ): ?>
							</div> <!-- .js_scroll -->
						<?php endif ?>

					</div>

					<div class="pfentry__toggle close js__close">
						<i class="ion-ios7-close-empty"></i>
					</div>

				</div> <!-- .pfentry -->

				<div class="pfentry__toggle open js__open">
					<i class="ion-ios7-information-outline"></i>
				</div>
				<?php endif; ?>

			</div> <?php // end <div$container> ?>

			<?php endwhile; ?>

				<?php village_paging_nav(); ?>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>

			</div> <!-- .js__scroll -->

	</div> <!-- #stage -->
<?php maybe_get_footer(); ?>
