<?php get_header();
get_template_part('inc/template', 'title');
?>
<section id="productlist">
	<div class="container">
		<div class="row">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post();
				if (have_rows('galeria')) :
					$imgsGaleria = null;
					  while (have_rows('galeria')) : the_row();
					  $imgsGaleria .= get_sub_field('imagem_produto').","; 
					endwhile;
				endif; 

					$imageProduct = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())); ?>
					<div class="col-12 col-md-6 col-lg-4 inter product-item" id="product_<?php echo get_the_ID(); ?>" onclick="showModal('<?php echo get_the_ID(); ?>');" 
					data-title="<?php the_title(); ?>" 
					data-content="<?php the_field('ficha_do_produto'); ?>" 
					data-galeria="<?php echo $imgsGaleria; ?>" 
					data-ctatitulo="<?php the_field('cta_texto'); ?>" 
					data-ctalink="<?php the_field('cta_link'); ?>"
					data-destaque="<?php echo $imageProduct; ?>">
						<div class="parent">
							<div class="child">					
								<img src="<?php echo $imageProduct; ?>" alt="">
							</div>
						</div>
						
						<h3><?php the_title(); ?></h3>
						<p><?php the_field('resumo'); ?></p>
						<button class="btn" onclick="showModal('<?php echo get_the_ID(); ?>');">Saber mais</button>

					</div>
				<?php endwhile; ?>

				<?php paginacao(); ?>

			<?php else : ?>
				<div class="col-12 text-center">
					<h2>Nenhum produto encontrado</h2>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>



<?php
get_template_part('inc/product/template', 'script');
get_footer(); ?>