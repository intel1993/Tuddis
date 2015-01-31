<article id="post-<?php the_ID(); ?>" <?php post_class(array("content__inner", "entry--single" ) ); ?>>
	
	<header class="entry__header">	
		<h1 class="entry__title">
				<?php the_title() ?>
		</h1>

		<div class="entry__meta">
			<i class="icon ion-ios7-calendar"></i>
			<?php the_post_date(); ?>
			
			
			<?php if ( Village::is_enabled("display_post_categories", true ) ): ?>
				&nbsp;&nbsp;&nbsp;
				<i class="icon ion-folder"></i>
				<?php the_category(", "); ?>
			<?php endif ?>

			<?php if ( Village::is_enabled("display_post_categories", false) ): ?>
				&nbsp;&nbsp;&nbsp;
				<i class="icon ion-pricetag"></i>
				<?php the_tags( "", ", " ); ?>
			<?php endif; ?>

			<?php if ( comments_open() ): ?>
				&nbsp;&nbsp;&nbsp;
				<a href="<?php comments_link(); ?>" class="comment-count">
					<i class="icon ion-chatbubble"></i>
					<?php echo get_comments_number(); ?>
				</a>
			<?php endif; ?>
		</div>

	</header>

	<div class="entry__content">

	<?php if ( has_post_thumbnail() ): ?>
		<?php if ( ! is_single() ): ?>
		<a class="post-thumbnail" href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail(); ?>
		</a>
		<?php elseif( Village::is_enabled('show_featured_image_in_post') ): ?>
			<?php the_post_thumbnail(); ?>
		<?php endif; ?>

	<?php endif; ?>
	
		
	<?php the_content(); ?>
	<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'camilla' ),
			'after'  => '</div>',
		) );
	?>

	</div>

</article><!-- #post-## -->