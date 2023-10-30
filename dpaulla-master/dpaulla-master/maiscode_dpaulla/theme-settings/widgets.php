<?php
/**
*Author: Mais Code Tecnologia - Equipe Gestão Ativa
*Tema: Modelo Padrao - WordPress Theme
*Produção: Mais Code - Revisão Rodolfo
*Arquivo: Arquivo de Redes Sociais
*@link http://www.maiscode.com.br
*@package WordPress Communicate English Theme
*@since: 26/02/2020
*/      

class RedeSocial extends WP_Widget {

    function __construct() {
        parent::__construct(
            'redeSocial_site', // Base ID
            esc_html__( 'Redes Sociais', 'text_domain' ), // Name
            array( 'description' => esc_html__( 'Bloco da Rede Social', 'text_domain' ), ) // Args

        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget']; ?>
        <div class="col-xs-12 redeSocialSite">
            <div class="social">
                <?php redes_sociais(); ?>
            </div>
        </div>
        <?php           
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
    <?php 
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        
        return $instance;
    }
}

function register_foo_widget_RedeSocial() {
    register_widget( 'RedeSocial' );
}
add_action( 'widgets_init', 'register_foo_widget_RedeSocial' ); 
