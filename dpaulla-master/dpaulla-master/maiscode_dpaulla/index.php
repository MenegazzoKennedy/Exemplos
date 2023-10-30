<?php get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-12 col-sm-8 teste">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
					<a href="<?php the_permalink() ?>"><h1><?php the_title(); ?></h1></a>

					<?php /*include (TEMPLATEPATH . '/inc/meta.php' );*/ ?>

					<div class="entry">
						<?php the_excerpt(); ?>
					</div>

					<div class="postmetadata">
						<?php the_tags('Tags: ', ', ', '<br />'); ?>
					</div>
					<hr class="space"/>
				</div>

			<?php endwhile; ?>

			<?php /* include (TEMPLATEPATH . '/inc/nav.php' );*/ ?>

		<?php else : ?>

			<h2>Nada Encontrado</h2>

		<?php endif; ?>	
	</div>
	<div class="col-12 col-sm-4">
		<?php get_sidebar(); ?>
	</div>
</div>
</div>
<?php get_footer(); ?>
