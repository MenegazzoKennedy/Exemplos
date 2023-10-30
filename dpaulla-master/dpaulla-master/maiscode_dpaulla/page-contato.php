<?php
/**
* Template Name: Página de Contato
*
* @package WordPress
* @author Mais Code Tecnologia
* @since First Version
*/
get_header(); ?>
<section id="sec_contato">
    <div class="sec_contato_img" style="background-image:url('<?php the_post_thumbnail_url()?>');"></div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-7 offset-md-5 sec_contato_titulo">
              <h1><?php echo get_field('subtitulo'); ?></h1>
            </div>
        </div>
    </div>
</section>
<section id="sec_contato_conteudo">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-12 sec_contato_conteudo_formulario">
        <div class="sec_contato_conteudo_formulario_interno">
          <?php $form = get_field("formulario_de_contato");

           $form = '[contact-form-7 id="'.$form[0].'" title="Formulário de contato"]';
          echo do_shortcode($form) ?>
        </div>
      </div>  
      <div class="col-lg-6 col-12 sec_contato_conteudo_informacao">
        <div class="sec_contato_conteudo_informacao_interno">
          <h1>Dados</h1>
          <div class="row">
            <?php
              if(get_field('icone_endereco')["url"] && get_field('endereco')){
            ?>
            <div class="col-1 sec_conteudo_contato_icones">
              <img class="socialFooter" src="<?php echo get_field('icone_endereco')["url"]; ?>">
            </div>
            <div class="col-11 nopadding">
              <h2><?php echo get_field('endereco'); ?></h2>
            </div>
            <?php
              }
            ?>
            <?php
              if(get_field('icone_e-mail')["url"] && get_field('e-mail')){
            ?>
            <div class="col-1 sec_conteudo_contato_icones">
              <img class="socialFooter" src="<?php echo get_field('icone_e-mail')["url"]; ?>">
            </div>
            <div class="col-11 nopadding">
              <h2><?php echo get_field('e-mail'); ?></h2>
            </div>
            <?php
              }
            ?>
            <?php
              if(get_field('icone_telefone')["url"] && get_field('telefone')){
            ?>
            <div class="col-1 sec_conteudo_contato_icones">
              <img class="socialFooter igFooter" src="<?php echo get_field('icone_telefone')["url"]; ?>">
            </div>
            <div class="col-11 nopadding">
              <h2><?php echo get_field('telefone'); ?></h2>
            </div>
            <?php
              }
            ?> 
          </div> 
        </div>
        <div class="sec_contato_conteudo_redes">
            <h1><?php echo get_option('texto_redes_sociais'); ?></h1>
            <?php
              if(get_option('facebook')){
            ?>
            <a href="<?php echo get_option('facebook'); ?>" target="_blank">
              <img class="socialFooter" src="<?php echo get_option('facebookLogoPage'); ?>">
            </a>
            <?php
              }
            ?>
            <?php
              if(get_option('instagram')){
            ?>
            <a href="<?php echo get_option('instagram'); ?>" target="_blank">
              <img class="socialFooter igFooter" src="<?php echo get_option('instagramLogoPage'); ?>">
            </a>
            <?php
              }
            ?>
            <?php
              if(get_option('linkedin')){
            ?>
            <a href="<?php echo get_option('linkedin'); ?>" target="_blank">
              <img class="socialFooter" src="<?php echo get_option('linkedinLogoPage'); ?>">
            </a>
            <?php
              }
            ?>
            <?php
              if(get_option('youtube')){
            ?>
            <a href="<?php echo get_option('youtube'); ?>" target="_blank">
              <img class="socialFooter socialFooter-yput" src="<?php echo get_option('youtubeLogoPage'); ?>">
            </a>
            <?php
              }
            ?>    
        </div>
        <div class="sec_contato_conteudo_mapa">
          <div id="map-canvas"></div>
        <?php 

          $idPaginaMapa = get_the_ID();
           $prop_mapaddress = get_field('mapa', $idPaginaMapa); 
              if(isset($prop_mapaddress)) {
                  $titulo = $prop_mapaddress['address'];
                  $latitude = $prop_mapaddress['lat'];
                  $longitude = $prop_mapaddress['lng']; 
        ?>       
                <script>        
                   var geocoder;       
                   var map;      
                   var lat = "<?php echo $latitude; ?>";     
                   var lng = "<?php echo $longitude;  ?>";
                   var titulo = "<?php echo $titulo; ?>";

                   function initialize() {       
                        geocoder = new google.maps.Geocoder();     
                        var latlng = new google.maps.LatLng(lat, lng); 
                        var mapOptions = {        
                          zoom: 18,        
                          center: latlng,        
                          mapTypeId: google.maps.MapTypeId.ROADMAP       
                      }        
                        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

                  var image = {
                         url: '<?php echo esc_url( get_template_directory_uri() ); ?>/img/logoMaps.png',
                         // This marker is 20 pixels wide by 32 pixels high.
                         size: new google.maps.Size(50, 50),
                         // The origin for this image is (0, 0).
                         origin: new google.maps.Point(0, 0),
                         // The anchor for this image is the base of the flagpole at (0, 32).
                         anchor: new google.maps.Point(0, 32)
                       };
                      
                        var shape = {
                          coords: [1, 1, 1, 20, 18, 20, 18, 1],
                          type: 'poly'
                          };

                      
                        var marker = new google.maps.Marker({
                          position: latlng,
                          map: map,
                          icon: image,
                          shape: shape,
                          title: titulo
                        });

                        
                        marker.setVisible(true);

                        var contentString = '<div class="janelaMapa">'+
                                            '<div class="txtMapa col-12">'+
                                              '<h6>'+titulo+'</h6>'+
                                            '</div>'+
                                          '</div>';

                        var infowindow = new google.maps.InfoWindow({
                          content: contentString
                        });
                        infowindow.open(map, marker);

                    } // map-convas would be id of div you want to show your map in  

                    google.maps.event.addDomListener(window, 'load', initialize);       
                </script>      
            <?php        
              }
           ?>
      </div>
        </div>
      </div>  
    </div>
  </div>
</section>    

<?php get_footer(); ?>