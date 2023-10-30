<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-12">
			<?php if (have_posts()) : ?>

				<h2> <?php echo get_theme_mod('titulo_search'); ?> </h2>

				<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>

				<?php while (have_posts()) : the_post(); ?>

					<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

						<a href="<?php the_permalink() ?>"><h2><?php the_title(); ?></h2>
							<?php include (TEMPLATEPATH . '/inc/meta.php' ); ?>
							<div class="entry">
								<?php the_excerpt(); ?>
							</div>
						</a>
					</div>
				<?php endwhile; ?>
				<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>
			<?php else : ?>
				<h2><?php echo get_theme_mod('titulo_nf_search'); ?></h2>
			<?php endif; ?>
		</div>
	</div>
</div> 
<?php get_footer(); ?>
