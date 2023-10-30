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


	//add_action( 'admin_init', 'register_mysettingsServicos' );
}

function register_mysettingsSobre() {
	register_setting( 'settings-group-sobre', 'email' );
	register_setting( 'settings-group-sobre', 'telefone' );
	register_setting( 'settings-group-sobre', 'endereco' );
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


				<div style="clear:both"></div>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>

			</fieldset>		

		</form>
	</div>

	<?php };





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




