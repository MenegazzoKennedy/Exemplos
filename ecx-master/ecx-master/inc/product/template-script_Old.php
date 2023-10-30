<div class="modal fade" id="modalProductShow" aria-hidden="true" aria-labelledby="modalProductShowLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-id" id="modalProductShowLabel">Modal 2</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i> </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 modal-destaque-">
                  <img class="imgPrincipal" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/Rectangle 5.png');">
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
                    <h3 class="modal-title" id="modalProductShowLabel">Titulo Produto</h3>
                    <p class="modal-description"></p>
                    <a href="<?php echo home_url('contato'); ?>" class="btn btn-primary">Entre em contato</a>
                </div>
            </div>
        </div>
      </div>     
    </div>
  </div>
</div>




<div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 modal-destaque-galeria">
                    <a href="http://dev.maiscode.com.br/novomillenium/wp-content/uploads/2021/09/produto-01-when.png" data-fancybox="gallery" data-caption="Caption #1">
                        <img src="http://dev.maiscode.com.br/novomillenium/wp-content/uploads/2021/09/produto-01-when.png" alt="" />
                    </a>

                    <a href="http://dev.maiscode.com.br/novomillenium/wp-content/uploads/2021/09/produto-02-ok.png"  data-fancybox="gallery" data-caption="Caption #2">
                        <img src="http://dev.maiscode.com.br/novomillenium/wp-content/uploads/2021/09/produto-02-ok.png" alt="" />
                    </a>
                </div>
                <div class="col-12 col-sm-12 col-md-6">
                    <h3 class="modal-title" id="modalProductShowLabel">Titulo Produto</h3>
                    <p class="modal-description"></p>
                    <a href="<?php echo home_url('contato'); ?>" class="btn btn-primary">Entre em contato</a>
                </div>
            </div>
        </div>


<style type="text/css">
    .paginacao{
        text-align: center;
    }
    .paginacao ul{
        display: inline-flex;
    }
    .paginacao ul a{
        margin: 0 6px;
    }
    .modal-destaque- .imgPrincipal {
        width: 100%;
    }
    .sliderAA{
        display: contents;
    }
    .sliderAA img{
        max-height: 40px;
        margin-top: 10px;
        margin-right: 10px;
        border: 1px solid #000;
        border-radius: .3rem;
    }
    .slick-arrow{
        position: absolute;
        width: 36px;
        top: 88%;
    }
    .fa-chevron-left{
        left: -1%;
    }
    .fa-chevron-right{
        right: 48%;
    }

</style>

<?php
function scriptModalProduto(){ ?>

<script type="text/javascript">
    var myModalProductShow = new bootstrap.Modal(document.getElementById('modalProductShow'), {
      keyboard: false
    })

    function showModal(IdProduto){      
        myModalProductShow.show();
        $('#modalProductShow .modal-id').html("Produto ID: "+IdProduto);
        $('#modalProductShow .modal-title').html($( "#product_"+IdProduto ).data( "title" ));
        $('#modalProductShow .modal-description').html($( "#product_"+IdProduto ).data( "content" ));
        //$('#modalProductShow .modal-destaque').html('<img src="'+$( "#product_"+IdProduto ).data( "extra" )+'" class="modal-destaque">');
        
        //console.log($( "#product_"+IdProduto ).data( "extra" ));
    }

    $(function() {
        console.log("funcionou");

        $('[data-fancybox]').fancybox({
            //fancybox
        });
    });
    $('.sliderAA').slick({
      dots: false,
      arrows:true,
      prevArrow:"<i class='fas fa-chevron-left'></i>",
      nextArrow:"<i class='fas fa-chevron-right'></i>",
      infinite: true,
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
            infinite: true,
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
</script>

<?php }
add_action('wp_footer', 'scriptModalProduto', '1001');