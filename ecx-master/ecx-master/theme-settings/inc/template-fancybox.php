
<!-- EXEMPLO 1 -->
<div class="row">
  <div class="col-12 box-galeria-fancy">
    
    <a data-fancybox="gallery" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/default.png" data-caption="Imagem default 1">
      <img thumbnail="gallery" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/default.png">
    </a>
    <a data-fancybox="gallery" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/default.png" data-caption="Imagem default 2">
      <img class="d-none" thumbnail="gallery" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/default.png">
    </a>
    <a data-fancybox="gallery" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/default.png" data-caption="Imagem default 3">
    </a>
    <a data-fancybox="gallery" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/default.png" data-caption="Imagem default 4">
    </a>

  </div>
</div>

<?php function fancybox(){ ?>
  <script type="text/javascript">
    console.log('oi');
    $('[data-fancybox="gallery"]').fancybox({
      thumbs : {
        autoStart : true,
        hideOnClose: true, // Hide thumbnail grid when closing animation starts
        axis: "y"  // Vertical (y) or horizontal (x) scrolling
      },
      
      // Transition effect between slides
      // Possible values:
      //   false            - disable
      //   "fade'
      //   "slide'
      //   "circular'
      //   "tube'
      //   "zoom-in-out'
      //   "rotate'
      //
      transitionEffect: "circular" ,
      buttons: [
        "zoom",
        "share",
        "slideShow",
        //"fullScreen",
        "download",
        "thumbs",
        "close"
      ]
    })
  </script>
<?php } 
add_action('wp_footer', 'fancybox', 100); ?>
<!-- FIM EXEMPLO 1 -->


<!-- EXEMPLO 2 -->
<div class="container">
  <div class="row">
    <div class="col-12 box-galeria-fancy">
      <!-- Galeria 1 -->
      <a data-fancybox="gallery" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/default.png" data-caption="Imagem default 1">
        <img thumbnail="gallery" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/default.png">
      </a>
      <a data-fancybox="gallery" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/default.png" data-caption="Imagem default 2">
        <img thumbnail="gallery" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/default.png">
      </a>
      <!-- Galeria 2 -->
      <a data-fancybox="gallery-2" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/default.png" data-caption="Imagem default 3">
        <img thumbnail="gallery-2" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/default.png">
      </a>
      <a data-fancybox="gallery-2" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/default.png" data-caption="Imagem default 4">
        <img thumbnail="gallery-2" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/default.png">
      </a>
    </div>
  </div>
</div>

<?php function fancybox(){ ?>
  <script type="text/javascript">
    $('[data-fancybox="gallery"]').fancybox({
      thumbs : {
        autoStart : true,
        hideOnClose: true, // Hide thumbnail grid when closing animation starts
        axis: "y"  // Vertical (y) or horizontal (x) scrolling
      },
      transitionEffect: "rotate" ,
      buttons: [
        "zoom",
        "share",
        "slideShow",
        //"fullScreen",
        "download",
        "thumbs",
        "close"
      ]
    })

    $('[data-fancybox="gallery-2"]').fancybox({
      thumbs : {
        autoStart : true,
        hideOnClose: true, // Hide thumbnail grid when closing animation starts
        axis: "x"  // Vertical (y) or horizontal (x) scrolling
      },
      transitionEffect: "tube" ,
      buttons: [
        "thumbs",
        "close"
      ]
    })
  </script>
<?php } 
add_action('wp_footer', 'fancybox', 100); ?>

<!-- FIM EXEMPLO 2 -->
