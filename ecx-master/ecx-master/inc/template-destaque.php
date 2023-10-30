<section id="sec-destaque">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12 order-lg-1 order-2 destaque-conteudo">
                <div>
                    <h1><?php the_field("texto_chamada"); ?></h1>
                    <p><?php the_field("conteudo_chamada"); ?></p>
                    <div>
                        <?php 
                            $btns = get_field("cta_destaque"); 
                            foreach($btns as $btn){
                                if(get_field('exibir_contato') == 'exibir'){?>
                                    <a href="<?php echo $btn['cta_destaque_link']; ?>" onclick="showItensContact(<?php echo $btn['cta_destaque_acao']; ?>, 1)"><?php echo $btn['cta_destaque_texto']; ?></a>    
                            <?php }else{ ?>
                                    <a href="<?php echo $btn['cta_destaque_link']; ?>"><?php echo $btn['cta_destaque_texto']; ?></a>   
                                <?php }
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12 order-lg-2 order-1 destaque-img">
                <div>
                    <h4><?php the_field("background_fundo_destaque_texto"); ?></h4>
                </div>
            </div>
        </div>
    </div>    
</section>

<style type="text/css">
    #sec-destaque{
        background-image: url("<?php the_field('background_fundo'); ?>");
    }
    #sec-destaque .destaque-img::before{
        content: '';
        background-image: url("<?php the_field('background_fundo_destaque'); ?>");
    }
</style>