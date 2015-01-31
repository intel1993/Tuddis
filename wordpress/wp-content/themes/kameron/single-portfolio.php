<?php maybe_get_header(); ?>

	<div id="stage" class="stage--gallery">
		<?php if ( have_posts() ) : ?>
			
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'parts/content', 'portfolio' ); ?>
			<?php endwhile; ?>

			<?php if ( comments_open() || '0' != get_comments_number() ) : ?>
				<?php comments_template(); ?>
			<?php endif; ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>				
	</div><!-- #stage -->

<?php maybe_get_footer(); ?>
