
	<div id="footer">
		<div class="container footer_container">
			<div class="row footer_row">
		        <div class="col-md-4 col-12 footer_col footer_col1">
		            <p>
						<?php echo get_option('texto_footer'); ?>
					</p>
		        </div>
				<div class="col-md-4 col-12 footer_col footer_col2">
					<img class="abeicFooter" src="<?php echo get_option('fotoFooter'); ?>">
				</div>
		        <div class="col-md-4 col-12 footer_col footer_col3">
		        	<div class="footer_links">
						<?php
							if(get_option('facebook')){
						?>
						<a href="<?php echo get_option('facebook'); ?>" target="_blank">
							<img class="socialFooter" src="<?php echo get_option('facebookLogoFooter'); ?>">
						</a>
						<?php
							}
						?>
						<?php
							if(get_option('instagram')){
						?>
						<a href="<?php echo get_option('instagram'); ?>" target="_blank">
							<img class="socialFooter igFooter" src="<?php echo get_option('instagramLogoFooter'); ?>">
						</a>
						<?php
							}
						?>
						<?php
							if(get_option('linkedin')){
						?>
						<a href="<?php echo get_option('linkedin'); ?>" target="_blank">
							<img class="socialFooter" src="<?php echo get_option('linkedinLogoFooter'); ?>">
						</a>
						<?php
							}
						?>
						<?php
							if(get_option('youtube')){
						?>
						<a href="<?php echo get_option('youtube'); ?>" target="_blank">
							<img class="socialFooter socialFooter-yput" src="<?php echo get_option('youtubeLogoFooter'); ?>">
						</a>
						<?php
							}
						?>		
					</div>	
				</div>
			</div>
		</div>
	</div> 

	<?php wp_footer(); ?>		
</body>
</html> 