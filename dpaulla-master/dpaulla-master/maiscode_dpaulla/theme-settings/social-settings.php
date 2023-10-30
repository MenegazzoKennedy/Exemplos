<?php
/**
*Author: Mais Code Tecnologia - Equipe Gestão Ativa
*Tema: Modelo Padrao - WordPress Theme
*Produção: Mais Code - Revisão Rodolfo
*Arquivo: Arquivo de Redes Sociais
*@link http://www.maiscode.com.br
*@package WordPress Communicate English Theme
*@since: 21/02/2020
*/

add_action('admin_menu', 'create_menu');


function create_menu() {		

	add_menu_page(
		'Contato', 
		'Contato', 
		'manage_options', 
		'espaco-contato', 
		'settingsSobre_page', 
		'dashicons-share');

	add_submenu_page(
		'options-general.php',
		'Tag Manager',
		'Tag Manager',
		'manage_options',
		'tag-manager',
		'wp_tag_manager_submenu_page' );

	add_submenu_page( 
		'espaco-contato', 
		'Redes Sociais', 
		'Redes Sociais', 
		'manage_options',
		'redes-socias', 
		'settingsSocial_page'
	);
	
	/* Menu de opções para CPT-UI -> wp_servicospage()
	add_submenu_page(
		'edit.php?post_type=servicos',
		'Dados Serviços',
		'Dados Serviços',
		'manage_options',
		'servicos-manager',
		'wp_servicospage' );*/

		//call register settings function

	add_action( 'admin_init', 'register_mysettingsSobre' );
	add_action( 'admin_init', 'register_mysettingsTag' );
	add_action( 'admin_init', 'register_mysettingsRedes' );

	//add_action( 'admin_init', 'register_mysettingsServicos' );
}

function register_mysettingsSobre() {
	register_setting( 'settings-group-sobre', 'email' );
	register_setting( 'settings-group-sobre', 'telefone' );
	register_setting( 'settings-group-sobre', 'endereco' );
	register_setting( 'settings-group-sobre', 'texto_footer' );
	register_setting( 'settings-group-sobre', 'fotoFooter' );
}
function register_mysettingsTag() {
	register_setting( 'settings-group-tag', 'tag_head' );
	register_setting( 'settings-group-tag', 'tag_body' );
	register_setting( 'settings-group-tag', 'api_maps' );
}

/*function register_mysettingsServicos() {
	register_setting( 'settings-group-servicos', 'titulo_banner_servicos' );
	register_setting( 'settings-group-servicos', 'subtitulo_banner_servicos' );
	register_setting( 'settings-group-servicos', 'banner_servicos' );
	register_setting( 'settings-group-servicos', 'titulo_servicos' );
	register_setting( 'settings-group-servicos', 'subtitulo_servicos' );
}*/
function register_mysettingsRedes() {
	register_setting( 'settings-group-redes', 'facebook' );
	register_setting( 'settings-group-redes', 'facebookLogoFooter' );
	register_setting( 'settings-group-redes', 'facebookLogoPage' );
	register_setting( 'settings-group-redes', 'google' );
	register_setting( 'settings-group-redes', 'googleLogo' );
	register_setting( 'settings-group-redes', 'youtube' );
	register_setting( 'settings-group-redes', 'youtubeLogoFooter' );
	register_setting( 'settings-group-redes', 'youtubeLogoPage' );
	register_setting( 'settings-group-redes', 'instagram' );
	register_setting( 'settings-group-redes', 'instagramLogoFooter' );
	register_setting( 'settings-group-redes', 'instagramLogoPage' );
	register_setting( 'settings-group-redes', 'linkedin' );
	register_setting( 'settings-group-redes', 'linkedinLogoFooter' );
	register_setting( 'settings-group-redes', 'linkedinLogoPage' );
	register_setting( 'settings-group-redes', 'texto_redes_sociais' );	
}

function mypage() { ?>

<?php }
// Setter
function settingsSobre_page() {
	?>
	<div class="wrap">
		<!--area exibida no painel no wordpress-->
		<form method="post" action="options.php" style="float:left; width:70%">
			<?php settings_fields( 'settings-group-sobre' ); ?>
			<fieldset style=" width:100%; padding:20px; margin:30px;">
				<h2 style="font-weight:bold; font-size:24px;">Contato</h2>

				<?php if (isset($_GET['settings-updated'])) : ?>
					<div class="notice notice-success is-dismissible"><p>Atualizado com sucesso.</p></div>
				<?php endif; ?>

				<div class="clear" style="margin-bottom:20px">
					<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">E-Mail</label>
					<input style="width:100%; background:#fff; border-radius:5px; height:40px" name="email" type="text" value="<?php echo get_option('email'); ?>" />
					<p style="color: #999999;font-size: 11px;margin: 5px 0 0 5px">Ex:contato@maiscode.com.br</p>
				</div>

				<div class="clear" style="margin-bottom:20px">
					<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Telefone</label>
					<input style="width:100%; background:#fff; border-radius:5px; height:40px" name="telefone" type="text" value="<?php echo get_option('telefone'); ?>" />
					<p style="color: #999999;font-size: 11px;margin: 5px 0 0 5px">Ex: (99) 9 9999-9999</p>
				</div>

				<h2 style="font-weight:bold; font-size:24px;">Endereço</h2>

				<div class="clear" style="margin-bottom:20px">
					<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Endereço</label>
					<input style="width:100%; background:#fff; border-radius:5px; height:40px" name="endereco" type="text" value="<?php echo get_option('endereco'); ?>" />
					<p style="color: #999999;font-size: 11px;margin: 5px 0 0 5px">Ex: Endereço</p>
				</div>
				<h2 style="font-weight:bold; font-size:24px;">Footer</h2>

					<div class="clear" style="margin-bottom:20px">
					<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Foto Footer</label>
					<?php 
					if(function_exists( 'wp_enqueue_media' )){
						wp_enqueue_media();
					}else{
						wp_enqueue_style('thickbox');
						wp_enqueue_script('media-upload');
						wp_enqueue_script('thickbox');
					} ?>
					<img class="fotoFooter" src="<?php echo get_option('fotoFooter'); ?>" height="100" width="250" style="margin-bottom: 10px;"/><br>
					<input class="fotoFooter_url" type="hidden" name="fotoFooter" size="60" value="<?php echo get_option('fotoFooter'); ?>">
					<a href="#" class="page-title-action fotoFooter_upload">Upload</a>
					<script>
						jQuery(document).ready(function($) {
							$('.fotoFooter_upload').click(function(e) {
								e.preventDefault();
								var custom_uploader = wp.media({
									title: 'Custom Image',
									button: {
										text: 'Upload Image'
									},
	                                    multiple: false  // Set this to true to allow multiple files to be selected
	                                })
								.on('select', function() {
									var attachment = custom_uploader.state().get('selection').first().toJSON();
									$('.fotoFooter').attr('src', attachment.url);
									$('.fotoFooter_url').val(attachment.url);
								})
								.open();
							});
						});
					</script>
				</div>
					<div class="clear" style="margin-bottom:20px">
						<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Texto footer</label>
						<textarea style="width:100%; background:#fff; border-radius:5px; height:100px" name="texto_footer" type="text"><?php echo get_option('texto_footer'); ?></textarea>
						<p style="color: #999999;font-size: 11px;margin: 5px 0 0 5px">Sobre a ABEIC</p>
					</div>


				<div style="clear:both"></div>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>

			</fieldset>		

		</form>
	</div>

	<?php };



function settingsSocial_page() {
		?>
		<div class="wrap">
			<!--area exibida no painel no wordpress-->
			<form method="post" action="options.php" style="float:left; width:70%">
				<?php settings_fields( 'settings-group-redes' ); ?>
				<fieldset style=" width:100%; padding:20px; margin:30px;">

					<h2 style="font-weight:bold; font-size:24px;">Configurações de Redes Sociais</h2>

					<?php if (isset($_GET['settings-updated'])) : ?>
						<div class="notice notice-success is-dismissible"><p>Atualizado com sucesso.</p></div>
					<?php endif; ?>

				
					<div class="clear" style="margin-bottom:20px">
						<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Facebook</label>
						<input style="width:100%; background:#fff; border-radius:5px; height:40px" name="facebook" type="text" value="<?php echo get_option('facebook'); ?>" />
						<p style="color: #999999;font-size: 11px;margin: 5px 0 0 5px">Ex: http://www.facebook.com/</p>
					</div>
					<div class="clear" style="margin-bottom:20px">
						<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Logo Facebook Footer</label>
						<?php 
						if(function_exists( 'wp_enqueue_media' )){
							wp_enqueue_media();
						}else{
							wp_enqueue_style('thickbox');
							wp_enqueue_script('media-upload');
							wp_enqueue_script('thickbox');
						} ?>
						<img class="facebookLogoFooter" src="<?php echo get_option('facebookLogoFooter'); ?>" height="50" width="50" style="margin-bottom: 10px;"/><br>
						<input class="facebookLogo_url_footer" type="hidden" name="facebookLogoFooter" size="60" value="<?php echo get_option('facebookLogoFooter'); ?>">
						<a href="#" class="page-title-action facebookLogo_upload_footer">Upload</a>
						<script>
							jQuery(document).ready(function($) {
								$('.facebookLogo_upload_footer').click(function(e) {
									e.preventDefault();
									var custom_uploader = wp.media({
										title: 'Custom Image',
										button: {
											text: 'Upload Image'
										},
                                    multiple: false  // Set this to true to allow multiple files to be selected
                                })
									.on('select', function() {
										var attachment = custom_uploader.state().get('selection').first().toJSON();
										$('.facebookLogoFooter').attr('src', attachment.url);
										$('.facebookLogo_url_footer').val(attachment.url);
									})
									.open();
								});
							});
						</script>
					</div>
					<div class="clear" style="margin-bottom:20px">
						<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Logo Facebook Page</label>
						<?php 
						if(function_exists( 'wp_enqueue_media' )){
							wp_enqueue_media();
						}else{
							wp_enqueue_style('thickbox');
							wp_enqueue_script('media-upload');
							wp_enqueue_script('thickbox');
						} ?>
						<img class="facebookLogoPage" src="<?php echo get_option('facebookLogoPage'); ?>" height="50" width="50" style="margin-bottom: 10px;"/><br>
						<input class="facebookLogo_url_page" type="hidden" name="facebookLogoPage" size="60" value="<?php echo get_option('facebookLogoPage'); ?>">
						<a href="#" class="page-title-action facebookLogo_upload_page">Upload</a>
						<script>
							jQuery(document).ready(function($) {
								$('.facebookLogo_upload_page').click(function(e) {
									e.preventDefault();
									var custom_uploader = wp.media({
										title: 'Custom Image Page',
										button: {
											text: 'Upload Image Page'
										},
                                    multiple: false  // Set this to true to allow multiple files to be selected
                                })
									.on('select', function() {
										var attachment = custom_uploader.state().get('selection').first().toJSON();
										$('.facebookLogoPage').attr('src', attachment.url);
										$('.facebookLogo_url_page').val(attachment.url);
									})
									.open();
								});
							});
						</script>
					</div>

					<div class="clear" style="margin-bottom:20px">
						<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Youtube</label>
						<input style="width:100%; background:#fff; border-radius:5px; height:40px" name="youtube" type="text" value="<?php echo get_option('youtube'); ?>" />
						<p style="color: #999999;font-size: 11px;margin: 5px 0 0 5px">Ex: http://www.youtube.com/</p>
					</div>
					<div class="clear" style="margin-bottom:20px">
						<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Logo Youtube Footer</label>
						<?php 
						if(function_exists( 'wp_enqueue_media' )){
							wp_enqueue_media();
						}else{
							wp_enqueue_style('thickbox');
							wp_enqueue_script('media-upload');
							wp_enqueue_script('thickbox');
						} ?>
						<img class="youtubeLogoFooter" src="<?php echo get_option('youtubeLogoFooter'); ?>" height="50" width="50" style="margin-bottom: 10px;"/><br>
						<input class="youtubeLogoFooter_url" type="hidden" name="youtubeLogoFooter" size="60" value="<?php echo get_option('youtubeLogoFooter'); ?>">
						<a href="#" class="page-title-action youtubeLogoFooter_upload">Upload</a>
						<script>
							jQuery(document).ready(function($) {
								$('.youtubeLogoFooter_upload').click(function(e) {
									e.preventDefault();
									var custom_uploader = wp.media({
										title: 'Custom Image',
										button: {
											text: 'Upload Image'
										},
                                    multiple: false  // Set this to true to allow multiple files to be selected
                                })
									.on('select', function() {
										var attachment = custom_uploader.state().get('selection').first().toJSON();
										$('.youtubeLogoFooter').attr('src', attachment.url);
										$('.youtubeLogoFooter_url').val(attachment.url);
									})
									.open();
								});
							});
						</script>
					</div>
					<div class="clear" style="margin-bottom:20px">
						<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Logo Youtube Page</label>
						<?php 
						if(function_exists( 'wp_enqueue_media' )){
							wp_enqueue_media();
						}else{
							wp_enqueue_style('thickbox');
							wp_enqueue_script('media-upload');
							wp_enqueue_script('thickbox');
						} ?>
						<img class="youtubeLogoPage" src="<?php echo get_option('youtubeLogoPage'); ?>" height="50" width="50" style="margin-bottom: 10px;"/><br>
						<input class="youtubeLogoPage_url" type="hidden" name="youtubeLogoPage" size="60" value="<?php echo get_option('youtubeLogoPage'); ?>">
						<a href="#" class="page-title-action youtubeLogoPage_upload">Upload</a>
						<script>
							jQuery(document).ready(function($) {
								$('.youtubeLogoPage_upload').click(function(e) {
									e.preventDefault();
									var custom_uploader = wp.media({
										title: 'Custom Image',
										button: {
											text: 'Upload Image'
										},
                                    multiple: false  // Set this to true to allow multiple files to be selected
                                })
									.on('select', function() {
										var attachment = custom_uploader.state().get('selection').first().toJSON();
										$('.youtubeLogoPage').attr('src', attachment.url);
										$('.youtubeLogoPage_url').val(attachment.url);
									})
									.open();
								});
							});
						</script>
					</div>
					<div class="clear" style="margin-bottom:20px">
						<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Instagram</label>
						<input style="width:100%; background:#fff; border-radius:5px; height:40px" name="instagram" type="text" value="<?php echo get_option('instagram'); ?>" />
						<p style="color: #999999;font-size: 11px;margin: 5px 0 0 5px">Ex: http://www.instagram.com/</p>
					</div>
					<div class="clear" style="margin-bottom:20px">
						<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Logo Instagram Footer</label>
						<?php 
						if(function_exists( 'wp_enqueue_media' )){
							wp_enqueue_media();
						}else{
							wp_enqueue_style('thickbox');
							wp_enqueue_script('media-upload');
							wp_enqueue_script('thickbox');
						} ?>
						<img class="instagramLogoFooter" src="<?php echo get_option('instagramLogoFooter'); ?>" height="50" width="50" style="margin-bottom: 10px;"/><br>
						<input class="instagramLogoFooter_url" type="hidden" name="instagramLogoFooter" size="60" value="<?php echo get_option('instagramLogoFooter'); ?>">
						<a href="#" class="page-title-action instagramLogoFooter_upload">Upload</a>
						<script>
							jQuery(document).ready(function($) {
								$('.instagramLogoFooter_upload').click(function(e) {
									e.preventDefault();
									var custom_uploader = wp.media({
										title: 'Custom Image',
										button: {
											text: 'Upload Image'
										},
                                    multiple: false  // Set this to true to allow multiple files to be selected
                                })
									.on('select', function() {
										var attachment = custom_uploader.state().get('selection').first().toJSON();
										$('.instagramLogoFooter').attr('src', attachment.url);
										$('.instagramLogoFooter_url').val(attachment.url);
									})
									.open();
								});
							});
						</script>
					</div>
					<div class="clear" style="margin-bottom:20px">
						<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Logo Instagram Page</label>
						<?php 
						if(function_exists( 'wp_enqueue_media' )){
							wp_enqueue_media();
						}else{
							wp_enqueue_style('thickbox');
							wp_enqueue_script('media-upload');
							wp_enqueue_script('thickbox');
						} ?>
						<img class="instagramLogoPage" src="<?php echo get_option('instagramLogoPage'); ?>" height="50" width="50" style="margin-bottom: 10px;"/><br>
						<input class="instagramLogoPage_url" type="hidden" name="instagramLogoPage" size="60" value="<?php echo get_option('instagramLogoPage'); ?>">
						<a href="#" class="page-title-action instagramLogoPage_upload">Upload</a>
						<script>
							jQuery(document).ready(function($) {
								$('.instagramLogoPage_upload').click(function(e) {
									e.preventDefault();
									var custom_uploader = wp.media({
										title: 'Custom Image',
										button: {
											text: 'Upload Image'
										},
                                    multiple: false  // Set this to true to allow multiple files to be selected
                                })
									.on('select', function() {
										var attachment = custom_uploader.state().get('selection').first().toJSON();
										$('.instagramLogoPage').attr('src', attachment.url);
										$('.instagramLogoPage_url').val(attachment.url);
									})
									.open();
								});
							});
						</script>
					</div>
					<div class="clear" style="margin-bottom:20px">
						<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">LinkedIn</label>
						<input style="width:100%; background:#fff; border-radius:5px; height:40px" name="linkedin" type="text" value="<?php echo get_option('linkedin'); ?>" />
						<p style="color: #999999;font-size: 11px;margin: 5px 0 0 5px">Ex: http://www.linkedin.com/</p>
					</div>
					<div class="clear" style="margin-bottom:20px">
						<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Logo Linkedin Footer</label>
						<?php 
						if(function_exists( 'wp_enqueue_media' )){
							wp_enqueue_media();
						}else{
							wp_enqueue_style('thickbox');
							wp_enqueue_script('media-upload');
							wp_enqueue_script('thickbox');
						} ?>
						<img class="linkedinLogoFooter" src="<?php echo get_option('linkedinLogoFooter'); ?>" height="50" width="50" style="margin-bottom: 10px;"/><br>
						<input class="linkedinLogoFooter_url" type="hidden" name="linkedinLogoFooter" size="60" value="<?php echo get_option('linkedinLogoFooter'); ?>">
						<a href="#" class="page-title-action linkedinLogoFooter_upload">Upload</a>
						<script>
							jQuery(document).ready(function($) {
							
								$('.linkedinLogoFooter_upload').click(function(e) {
									e.preventDefault();
									var custom_uploader = wp.media({
										title: 'Custom Image',
										button: {
											text: 'Upload Image'
										},
                                    multiple: false  // Set this to true to allow multiple files to be selected
                                })
									.on('select', function() {
										var attachment = custom_uploader.state().get('selection').first().toJSON();
										$('.linkedinLogoFooter').attr('src', attachment.url);
										$('.linkedinLogoFooter_url').val(attachment.url);
									})
									.open();
								});
							});
						</script>
					</div>
					<div class="clear" style="margin-bottom:20px">
						<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Logo Linkedin Page</label>
						<?php 
						if(function_exists( 'wp_enqueue_media' )){
							wp_enqueue_media();
						}else{
							wp_enqueue_style('thickbox');
							wp_enqueue_script('media-upload');
							wp_enqueue_script('thickbox');
						} ?>
						<img class="linkedinLogoPage" src="<?php echo get_option('linkedinLogoPage'); ?>" height="50" width="50" style="margin-bottom: 10px;"/><br>
						<input class="linkedinLogoPage_url" type="hidden" name="linkedinLogoPage" size="60" value="<?php echo get_option('linkedinLogoPage'); ?>">
						<a href="#" class="page-title-action linkedinLogoPage_upload">Upload</a>
						<script>
							jQuery(document).ready(function($) {
							
								$('.linkedinLogoPage_upload').click(function(e) {
									e.preventDefault();
									var custom_uploader = wp.media({
										title: 'Custom Image',
										button: {
											text: 'Upload Image'
										},
                                    multiple: false  // Set this to true to allow multiple files to be selected
                                })
									.on('select', function() {
										var attachment = custom_uploader.state().get('selection').first().toJSON();
										$('.linkedinLogoPage').attr('src', attachment.url);
										$('.linkedinLogoPage_url').val(attachment.url);
									})
									.open();
								});
							});
						</script>
					</div>

					<div class="clear" style="margin-bottom:20px">
						<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Texto redes sociais</label>
						<input style="width:100%; background:#fff; border-radius:5px; height:40px" name="texto_redes_sociais" type="text" value="<?php echo get_option('texto_redes_sociais'); ?>" />
						<p style="color: #999999;font-size: 11px;margin: 5px 0 0 5px">Ex: Encontre-me também nas redes sociais e fique por dentro de todas as novidades e conteúdos exclusivos de cada plataforma.</p>
					</div>



					<div style="clear:both"></div>
					<p class="submit">
						<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
					</p>
				</fieldset>		

			</form>
		</div>
		<?php };

	// Getter
		function redes_sociais(){
			$facebook = get_option('facebook'); 
			$facebook = get_option('facebook'); 
			$google = get_option('google');
			$youtube = get_option('youtube');
			$instagram = get_option('instagram');
			$linkedin = get_option('linkedin');
			echo "<ul class='list-inline list-unstyled' id='redes_sociais'>";
			if (!empty($facebook)) {
				echo "<a target='_blank' href='$facebook'><li><span class='fa fa-facebook-square'></span></li></a>";
			};
			if (!empty($google)) {
				echo "<li><a target='_blank' href='$google'><span class='fa fa-google'></span></a></li>";
			}
			if (!empty($instagram)) {
				echo "<a target='_blank' href='$instagram'><li><span class='fa fa-instagram'></span></li></a>";
			}
			if (!empty($linkedin)) {
				echo "<a target='_blank' href='$linkedin'><li><span class='fa fa-linkedin'></span></li></a>";
			}
			if (!empty($youtube)) {
				echo "<a target='_blank' href='$youtube'><li><span class='fa fa-youtube'></span></li></a>";
			}
			echo "</ul>";
		}

		class social_widget extends WP_Widget {

	    // constructor
			function social_widget() {
				parent::WP_Widget(false, $name = __('Links Redes Sociais', 'wp_widget_plugin') );
			}

	    // display widget
			function widget($args, $instance) {
				extract( $args );

				echo $before_widget; ?>

				<div class="widget-text social_widget_box">
					<?php redes_sociais(); ?>
				</div>

				<?php echo $after_widget;
			}
		}

/* Google Tag Manager
/---------------------------------------------------------------------------- */

function wp_tag_manager_submenu_page() { ?>
<div class="wrap">
	<div id="icon-tools" class="icon32"></div>
	<form method="post" action="options.php" style="float:left; width:70%">
		<?php settings_fields( 'settings-group-tag' ); ?>
		<fieldset style=" width:100%; padding:20px; margin:30px;">
			<h2 style="font-weight:bold; font-size:24px;">Google Tag Manager</h2>

			<?php if (isset($_GET['settings-updated'])) : ?>
				<div class="notice notice-success is-dismissible"><p>Atualizado com sucesso.</p></div>
			<?php endif; ?>

			<div class="clear" style="margin-bottom:20px">
				<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Script Tag Manager HEAD</label>
				<textarea style="width:100%; background:#fff; border-radius:5px; height:100px" name="tag_head" type="text"><?php echo get_option('tag_head'); ?></textarea>
			</div>

			<div class="clear" style="margin-bottom:20px">
				<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Script Tag Manager BODY</label>
				<textarea  style="width:100%; background:#fff; border-radius:5px; height:100px" name="tag_body"><?php echo get_option('tag_body'); ?></textarea>
			</div>

			<div class="clear" style="margin-bottom:20px">
				<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">API Google Maps</label>
				<input style="width:100%; background:#fff; border-radius:5px; height:40px" name="api_maps" type="text" value="<?php echo get_option('api_maps'); ?>" />

			</div>

			<div style="clear:both"></div>
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>

		</fieldset>		

	</form>
</div>
<?php
}


/*function wp_servicospage(){ ?>
	<div class="wrap">
		<div id="icon-tools" class="icon32"></div>
		<form method="post" action="options.php" style="float:left; width:70%">
			<?php settings_fields( 'settings-group-servicos' ); ?>
			<fieldset style=" width:100%; padding:20px; margin:30px;">
				<h2 style="font-weight:bold; font-size:24px;">Dados Serviços</h2>

				<?php if (isset($_GET['settings-updated'])) : ?>
					<div class="notice notice-success is-dismissible"><p>Atualizado com sucesso.</p></div>
				<?php endif; ?>


				<div class="clear" style="margin-bottom:20px">
						<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Título Banner</label>
						<input style="width:100%; background:#fff; border-radius:5px; height:40px" name="titulo_banner_servicos" type="text" value="<?php echo get_option('titulo_banner_servicos'); ?>" />
						<p style="color: #999999;font-size: 13px;margin: 5px 0 0 5px">Ex: Serviços</p>
					</div>

					<div class="clear" style="margin-bottom:20px">
						<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Subtitulo Banner</label>
						<input style="width:100%; background:#fff; border-radius:5px; height:40px" name="subtitulo_banner_servicos" type="text" value="<?php echo get_option('subtitulo_banner_servicos'); ?>" />
						<p style="color: #999999;font-size: 13px;margin: 5px 0 0 5px">Ex: Conheça nosso método</p>
					</div>


					<div class="clear" style="margin-bottom:20px">
						<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Banner</label>
						<?php 
						if(function_exists( 'wp_enqueue_media' )){
							wp_enqueue_media();
						}else{
							wp_enqueue_style('thickbox');
							wp_enqueue_script('media-upload');
							wp_enqueue_script('thickbox');
						} ?>
						<img class="banner_servicos" src="<?php echo get_option('banner_servicos'); ?>" height="100" width="250" style="margin-bottom: 10px;"/><br>
						<input class="banner_servicos_url" type="hidden" name="banner_servicos" size="60" value="<?php echo get_option('banner_servicos'); ?>">
						<a href="#" class="page-title-action banner_servicos_upload">Upload</a>
						<script>
							jQuery(document).ready(function($) {
								$('.banner_servicos_upload').click(function(e) {
									e.preventDefault();
									var custom_uploader = wp.media({
										title: 'Custom Image',
										button: {
											text: 'Upload Image'
										},
	                                    multiple: false  // Set this to true to allow multiple files to be selected
	                                })
									.on('select', function() {
										var attachment = custom_uploader.state().get('selection').first().toJSON();
										$('.banner_servicos').attr('src', attachment.url);
										$('.banner_servicos_url').val(attachment.url);
									})
									.open();
								});
							});
						</script>

					</div>

					<div class="clear" style="margin-bottom:20px">
						<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Título</label>
						<input style="width:100%; background:#fff; border-radius:5px; height:40px" name="titulo_servicos" type="text" value="<?php echo get_option('titulo_servicos'); ?>" />
						<p style="color: #999999;font-size: 13px;margin: 5px 0 0 5px">Ex: Conheça nosso método</p>
					</div>

					<div class="clear" style="margin-bottom:20px">
						<label style="font-weight:bold; color:#173C69; margin: 10px 0 3px 0; display:block; font-size:16px;">Subtitulo</label>
						<input style="width:100%; background:#fff; border-radius:5px; height:40px" name="subtitulo_servicos" type="text" value="<?php echo get_option('subtitulo_servicos'); ?>" />
						<p style="color: #999999;font-size: 13px;margin: 5px 0 0 5px">Ex: Conheça nosso método</p>
					</div>


				<div style="clear:both"></div>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>

			</fieldset>		

		</form>
	</div>
<?php 
}*/ 




