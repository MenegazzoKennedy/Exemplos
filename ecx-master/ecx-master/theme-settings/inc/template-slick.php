<!-- SLICK -->
<div class="container">
  <div class="position-relative pb-3 "> 
    <div class="box-arrow-slider">
        <img class="arrow-slider arrow-left" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/arrow-left.svg">
        <img class="arrow-slider arrow-right" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/arrow-right.svg">
    </div>
    <div class="slick-exemplo">
      <div class="rounded-lg position-relative box-slick">
        <div class="conteudo-slick" style="background-image:url('<?php echo esc_url( get_template_directory_uri() ); ?>/img/default.png')">
          <h2>Primeiro</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque tristique augue sed sem commodo pretium. Mauris nec nunc posuere erat euismod interdum. Aliquam quis eros vitae elit faucibus egestas a ultrices risus. Praesent libero ex, semper quis bibendum at, posuere eget velit...</p>
        </div>
      </div>
      <div class="rounded-lg position-relative box-slick">
        <div class="conteudo-slick" style="background-image:url('<?php echo esc_url( get_template_directory_uri() ); ?>/img/default.png')">
          <h2>Segundo</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque tristique augue sed sem commodo pretium. Mauris nec nunc posuere erat euismod interdum. Aliquam quis eros vitae elit faucibus egestas a ultrices risus. Praesent libero ex, semper quis bibendum at, posuere eget velit...</p>
        </div>
      </div>
      <div class="rounded-lg position-relative box-slick">
        <div class="conteudo-slick" style="background-image:url('<?php echo esc_url( get_template_directory_uri() ); ?>/img/default.png')">
          <h2>Terceiro</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque tristique augue sed sem commodo pretium. Mauris nec nunc posuere erat euismod interdum. Aliquam quis eros vitae elit faucibus egestas a ultrices risus. Praesent libero ex, semper quis bibendum at, posuere eget velit...</p>
        </div>
      </div>
    </div>
  </div>
</div>



<?php function slickSlider(){ ?>
  <script type="text/javascript">
    $(document).ready(function(){
      $('.slick-exemplo').slick({
        dots: true,
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: true,
        speed: 300,
        prevArrow: $('.box-arrow-slider .arrow-left'),
        nextArrow: $('.box-arrow-slider .arrow-right'),
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              infinite: true,
              dots: true
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
        ]
      });
    });


  </script>
<?php } 
add_action('wp_footer', 'slickSlider', 100); ?>