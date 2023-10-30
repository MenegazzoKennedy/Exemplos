<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12">
                <div class="row">
                    <div class="col-xl-2 col-lg-3 col-12">
                        <a href="">
                        	<img src="<?php the_field('logo_rodape'); ?>" class="img-fluid footer-logo">
                        </a>
                    </div>
                    <div class="col-xl-10 col-lg-9 col-12 footer-text">
                        <?php
                            $arrayCta = get_field('cta_rodape');
                            foreach($arrayCta as $cta){?>
                                <a href="<?php echo $cta['link_cta_rodape']?>" target="_blank"><?php echo $cta['texto_cta_rodape']; ?></a> 
                                <label></label>
                            <?php }
                        ?>
                    </div>
                </div>

            </div>

            <div class="col-lg-3 col-12 footer-lateral">

                <div class="footer-icone-fora">

                    <div class="footer-icone">
                        <?php
                            $arraySocial = get_field('social_rodape');
                            foreach($arraySocial as $Social){?>
                                <a href = "<?php echo $Social['link_social_rodape']; ?>" target="_blank">
                                    <img src="<?php echo $Social['icone_social_rodape']; ?>" class="img-fluid">
                                </a>
                            <?php }
                        ?>
                    </div>

                </div>

                <div class="footer-ecxcard">
                    <p><span>/</span><?php the_field('texto_social_rodape'); ?></p>
                </div>

            </div>
        </div>
    </div>
</div>