<?php 
$has_thumbnail = has_post_thumbnail();
$post_class = array("content__inner", "entry");

if( $has_thumbnail ) {
	$post_class[] = "has-thumbnail";
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>
	
	<?php if ( has_post_thumbnail() ): ?>
		<a class="entry__thumbnail" href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail("large"); ?>
		</a>
	<?php endif; ?>

	<div class="entry__excerpt">
	
		<header class="entry__header">	
			<h1 class="entry__title">
				<a class="js__items--link" href="<?php the_permalink(); ?>">
					<?php the_title() ?>
				</a>
			</h1>

			<div class="entry__meta">
				<i class="icon ion-ios7-calendar"></i>
				<?php the_post_date(); ?>
				&nbsp;&nbsp;&nbsp;
				<i class="icon ion-folder"></i>
				<?php the_category(", "); ?>

				<?php if ( comments_open() ): ?>
				&nbsp;&nbsp;&nbsp;
				<a href="<?php comments_link(); ?>" class="comment-count">
					<i class="icon ion-chatbubble"></i>
					<?php echo get_comments_number(); ?>
				</a>
				<?php endif; ?>

			</div>

		</header>
		
			
		<?php
		if ( Village::get_theme_mod( 'use_excerpts', true ) ): 
		?>
			
			<?php  the_excerpt(false);  ?>
	 		<a href="<?php the_permalink(); ?>" class="readmore">
				<?php _e("Continue Reading &rarr;", "village"); ?>
			</a>
		
		<?php else: ?>
			<?php the_content(__("Continue Reading &rarr;", "village")); ?>
		<?php endif;
		?>
	
	</div>

</article><!-- #post-## -->