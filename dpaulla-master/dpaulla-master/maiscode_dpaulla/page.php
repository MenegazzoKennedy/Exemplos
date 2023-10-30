<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-12">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
					<h1><?php the_title(); ?></h1>
					<div class="entry">
						<?php the_content(); ?>
					</div>
				</div>
			<?php endwhile; endif; ?>	
		</div>
	</div>
</div>
<?php get_footer(); ?>
