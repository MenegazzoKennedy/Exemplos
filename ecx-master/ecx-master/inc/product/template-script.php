<div class="modal fade" id="modalProductShow" aria-hidden="true" aria-labelledby="modalProductShowLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i> </button>
      </div>
      <div class="modal-body">
      <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 modal-destaque-">
                <a href="#url" data-fancybox="gallery" class="imgPrincipal-link">  
                    <img class="imgPrincipal" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/Rectangle 5.png');">
                </a>
                  <div class="col-12">
                      <div class="row sliderAA">
                          <div class="col-2">
                              <a href="#"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/Rectangle 5.png');"></a>
                          </div>
                          <div class="col-2">
                              <a href="#"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/Rectangle 5.png');"></a>
                          </div>
                          <div class="col-2">
                              <a href="#"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/Rectangle 6.png');"></a>
                          </div>
                          <div class="col-2">
                              <a href="#"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/Rectangle 6.png');"></a>
                          </div>
                          <div class="col-2">
                              <a href="#"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/Rectangle 6.png');"></a>
                          </div>
                          <div class="col-2">
                              <a href="#"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/Rectangle 5.png');"></a>
                          </div>
                          <div class="col-2">
                              <a href="#"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/Rectangle 5.png');"></a>
                          </div>
                          <div class="col-2">
                              <a href="#"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/Rectangle 5.png');"></a>
                          </div>
                          <div class="col-2">
                              <a href="#"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/Rectangle 5.png');"></a>
                          </div>                          
                      </div>
                  </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6">
                    <h3 class="modal-id" id="modalProductShowLabel">Produto</h3>
                    <p class="modal-description"></p>
                    <a href="<?php //echo home_url('contato'); ?>" class="btn btn-primary modal-ctalink"></a>
                </div>
            </div>
        </div>
      </div>     
    </div>
  </div>
</div>






<div class="container d-none">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 modal-destaque-galeria">
                   
                
                <a href="http://dev.maiscode.com.br/novomillenium/wp-content/uploads/2021/09/produto-01-when.png" data-fancybox="gallery" data-caption="Caption #1">
                        <img src="http://dev.maiscode.com.br/novomillenium/wp-content/uploads/2021/09/produto-01-when.png" alt="" />
                    </a>

                    <a href="http://dev.maiscode.com.br/novomillenium/wp-content/uploads/2021/09/produto-02-ok.png"  data-fancybox="gallery" data-caption="Caption #2">
                        <img src="http://dev.maiscode.com.br/novomillenium/wp-content/uploads/2021/09/produto-02-ok.png" alt="" />
                    </a>
                </div>
               
            </div>
        </div>



<?php
function scriptModalProduto(){ ?>

<script type="text/javascript">
    var myModalProductShow = new bootstrap.Modal(document.getElementById('modalProductShow'), {
      keyboard: false
    });

    function startSlickModal(){
        $('.sliderAA').removeClass('slick-initialized');
        $('.sliderAA').removeClass('slick-slider');
        $('.sliderAA').slick({
        dots: false,
        arrows:true,
        prevArrow:"<i class='fas fa-chevron-left'></i>",
        nextArrow:"<i class='fas fa-chevron-right'></i>",
        infinite: false,
        speed: 150,
        variableWidth:true,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [
            {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                arrows:false,
                dots:true   
            }
            },
            {
            breakpoint: 600,
            settings: {
                arrows:false,
                dots: true,
                slidesToShow: 2,
                slidesToScroll: 2
            }
            },
            {
            breakpoint: 480,
            settings: {
                arrows:false,
                dots: true,
                slidesToShow: 1,
                slidesToScroll: 1
            }
            }
        ]  
        });
    }

    function showModal(IdProduto){      
        myModalProductShow.show();
        //$('#modalProductShow .modal-id').html("Produto ID: "+IdProduto);
        $('#modalProductShow .modal-id').html($( "#product_"+IdProduto ).data( "title" ));
        $('#modalProductShow .modal-description').html($( "#product_"+IdProduto ).data( "content" ));
        $('#modalProductShow .modal-ctalink').html($( "#product_"+IdProduto ).data( "ctatitulo" ));
        $('#modalProductShow .modal-ctalink').attr("href", $( "#product_"+IdProduto ).data( "ctalink" ));
        $('#modalProductShow .imgPrincipal').attr("src", $( "#product_"+IdProduto ).data( "destaque" ));
        $('#modalProductShow .imgPrincipal-link').attr("href", $( "#product_"+IdProduto ).data( "destaque" ));
        $('#modalProductShow .imgPrincipal-link').attr("data-fancybox", "gallery-"+IdProduto);

        var dataGaleria = $( "#product_"+IdProduto ).data( "galeria" );
        var linkImg = dataGaleria.split(',');        
        $('.sliderAA').slick('slickRemove', null, null, true);

        $.each( linkImg, function( index, value ) {
            if (value) {
                $('#modalProductShow .sliderAA').append('<div class="col-2"><a href="'+value+'" data-fancybox="gallery-'+IdProduto+'"><img src="'+value+'"></a></div>');
            }            
        });
        
        $('[data-fancybox]').fancybox({
            slideShow: {
                    autoStart: false,
                    speed: 3000
                },
            thumbs: {
                autoStart: true, // Display thumbnails on opening
                hideOnClose: true, // Hide thumbnail grid when closing animation starts
                parentEl: ".fancybox-container", // Container is injected into this element
                axis: "y" // Vertical (y) or horizontal (x) scrolling
            },
        });

        startSlickModal();        
        
        
        
        //console.log($( "#product_"+IdProduto ).data( "ctalink" ));
    }

    $(function() {
        console.log("funcionou");

        $('[data-fancybox]').fancybox({
            //fancybox
        });
    });

    $('.sliderAA').slick({});
</script>

<?php }
add_action('wp_footer', 'scriptModalProduto', '1001');