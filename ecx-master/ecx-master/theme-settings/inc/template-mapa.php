<section id="box_mapa">
	<div class="container">
		<div class="row">
			<div class="col-12">
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
		                     url: '<?php echo esc_url( get_template_directory_uri() ); ?>/img/googleTag.png',
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
</section>
