

<!-- Carousel usando img -->
<div class="container">
  <div id="carouselExample" class="carousel slide" data-keyboard="true" data-interval="3000" data-pause="hover" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExample" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExample" data-slide-to="1"></li>
        <li data-target="#carouselExample" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="d-block w-100 mx-auto" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/default-2.png" alt="Second slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100 mx-auto" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/default-2.png" alt="Second slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100 mx-auto" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/default-2.png" alt="Third slide">
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
      <img class="arrow-left" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/arrow-left.svg">
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
        <img class="arrow-right" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/arrow-right.svg">
        <span class="sr-only">Next</span>
    </a>
  </div>
</div>


<!-- OBS: testar um de cada vez, e trocar o css no stylesheet na parte "Carousel" -->
<!-- Carousel usando background-img -->
<div class="container">
  <div id="carouselExample" class="carousel slide" data-keyboard="true" data-interval="3000" data-pause="hover" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExample" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExample" data-slide-to="1"></li>
        <li data-target="#carouselExample" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active bg-carousel" style="background-image: url('<?php echo esc_url( get_template_directory_uri() ); ?>/img/default-2.png');">
        <div class="carousel-caption">
            <h5>My Caption Title (1st Image)</h5>
            <p>The whole caption will only show up if the screen is at least medium size.</p>
        </div>
      </div>
      <div class="carousel-item bg-carousel" style="background-image: url('<?php echo esc_url( get_template_directory_uri() ); ?>/img/default-2.png');">
        <div class="carousel-caption">
            <h5>My Caption Title (1st Image)</h5>
            <p>The whole caption will only show up if the screen is at least medium size.</p>
        </div>
      </div>
      <div class="carousel-item bg-carousel" style="background-image: url('<?php echo esc_url( get_template_directory_uri() ); ?>/img/default-2.png');">
        <div class="carousel-caption">
            <h5>My Caption Title (1st Image)</h5>
            <p>The whole caption will only show up if the screen is at least medium size.</p>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
      <img class="arrow-left" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/arrow-left.svg">
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
        <img class="arrow-right" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/arrow-right.svg">
        <span class="sr-only">Next</span>
    </a>
  </div>
</div>
