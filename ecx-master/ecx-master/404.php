<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-12 box_404 text-center">
			<img src="<?php  echo get_theme_mod('imagem_404' ); ?>">
			<h2><?php echo get_theme_mod('titulo_404' ); ?></h2>
			
			<a class="btn_404" href="<?php echo get_theme_mod('link_404' ) ?>" title="<?php echo get_theme_mod('titulo_btn_404' ) ?>"><?php echo get_theme_mod('titulo_btn_404' ) ?></a>
		</div>
	</div>
</div>
<?php get_footer(); ?>
