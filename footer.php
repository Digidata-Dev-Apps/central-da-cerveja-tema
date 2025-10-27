<footer>
    <div class="container">
        <!-- Bloco Pagamentos e Redes Sociais -->
        <div class="background-payments-social pb-4">
            <div class="row">
                <div class="col-12 col-md-8 d-flex align-items-center justify-content-center flex-column">
                    <div class="sizing-payments d-flex flex-column align-items-center justify-content-center">
                        <h4 class="payments">Pagamento Seguro</h4>
                        <div class="payment-methods d-flex gap-2">
                            <img class="visa" src="<?php echo get_template_directory_uri() . "/assets/img/Extract/visa.png" ?>" alt="Visa">
                            <img class="mastercard" src="<?php echo get_template_directory_uri() . "/assets/img/Extract/mastercard.png" ?>" alt="Mastercard">
                            <img class="amex" src="<?php echo get_template_directory_uri() . "/assets/img/Extract/amex.png" ?>" alt="Amex">
                            <img class="dinners_club" src="<?php echo get_template_directory_uri() . "/assets/img/Extract/dinners_club.png" ?>" alt="Dinners Club">
                            <img class="elo" src="<?php echo get_template_directory_uri() . "/assets/img/Extract/elo.png" ?>" alt="Elo">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 d-flex align-items-center justify-content-center flex-column">
                    <div class="sizing-payments social-media d-flex flex-column align-items-center justify-content-center">
                        <h4>Redes Sociais</h4>
                        <div>
                            <a href="https://www.facebook.com/acentraldacerveja"><img src="<?php echo get_template_directory_uri() . "/assets/img/Extract/facebook.png" ?>" alt="Facebook"></a>
                            <a href="https://mobile.twitter.com/CentralCerveja"><img src="<?php echo get_template_directory_uri() . "/assets/img/Extract/twitter.png" ?>" alt="Twitter"></a>
                            <a href="https://www.instagram.com/acentraldacerveja/"><img src="<?php echo get_template_directory_uri() . "/assets/img/Extract/instagram.png" ?>" alt="Instagram"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bloco de Links do Footer -->
        <div class="footer-background">
            <div class="row footer-fonts ps-5 pe-5 pt-5 pb-4">
                <div class="col-auto club">
                    <h6>CENTRAL DA CERVEJA</h6>
                    <a href="/">INÍCIO</a>
                    <a href="/quem-somos">QUEM SOMOS</a>
                    <a href="/contato">CONTATO</a>
                    <p>(41) 3019-9194</p>
                    <p class="contact-email">ATENDIMENTO@CENTRALDACERVEJA.COM.BR</p>
                    <p>SEG-SEX 10 ÀS 16</p>
                </div>
                <div class="col helper-and-support">
                    <h6>AJUDA E SUPORTE</h6>
                    <a href="/ajuda-e-suporte/#perguntas-frequentes">PERGUNTAS FREQUENTES</a>
                    <a href="/ajuda-e-suporte/#formas-de-pagamento">FORMAS DE PAGAMENTO</a>
                    <a href="/ajuda-e-suporte/#prazo-de-entrega">PRAZOS E TAXAS PARA ENTREGA</a>
                    <a href="/ajuda-e-suporte/#troca-e-devolucao">TROCA E DEVOLUÇÃO</a>
                    <a href="/ajuda-e-suporte/#privacidade">PRIVACIDADE</a>
                    <a href="/ajuda-e-suporte/#politica-de-frete">POL&Iacute;TICA DE FRETE</a>
                </div>
                <div class="col brand-card">
                    <h6>CERVEJAS</h6>
                    <a href="/por-perfil">POR PERFIL</a>
                    <a href="/por-estilo">POR ESTILO</a>
                    <a href="/por-pais">POR PAÍS</a>
                    <a href="/por-estado">POR ESTADO</a>
                    <a href="/por-cervejaria">POR CERVEJARIA</a>
                </div>
                <div class="col login">
                    <h6>LOGIN</h6>
                    <a href="/minha-conta">LOGIN OU CADASTRE-SE</a>
                    <a href="/cervejeira">CERVEJEIRA</a>
                    <a href="/wishlist">WISHLIST</a>
                    <a href="/meu-barril">MEU BARRIL</a>
                    <a href="/clube-do-assinante">CLUBE DO ASSINANTE</a>
                </div>
            </div>
        </div>

        <!-- Reservado -->
        <div class="reserved-footer" style="height: 40px;"></div>
    </div>
</footer>

<?php
$popups = new WP_Query(array(
    'post_type' => 'banners-popup',
    'post_status' => 'publish',
    'posts_per_page' => 3,
    'order' => 'DESC',
    'orderby' => 'ID',
    'meta_query' => array(
        'meta_value' => array(
            'key' => 'supplier_id_banner',
            'compare' => 'NOT EXISTS'
        )
    )
));

if (!empty($popups->posts)) {
    foreach ($popups->posts as $popup) {
?>
        <!-- Modal -->
        <div class="modal fade popup-shipping" id="popup_<?php echo $popup->ID; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body d-flex align-items-center flex-column justify-content-center p-2">
                        <?php
                        $popup_link = get_post_meta($popup->ID, 'popup_link', true);
                        $target = get_post_meta($popup->ID, 'target', true);
                        ?>
                        <a href="<?php echo (!empty($popup_link)) ? $popup_link : 'javascript:void(0);' ?>" <?php if (!empty($popup_link)) { ?>target="<?php echo $target; ?>" <?php } ?>>
                            <?php
                            $post_thumbnail_id = get_post_thumbnail_id($popup->ID);
                            $image = "";
                            if (!empty($post_thumbnail_id)) {
                                $image = wp_get_attachment_image_src($post_thumbnail_id, 'full')[0];
                            }
                            ?>
                            <img src="<?php echo $image; ?>" class="img-fluid" alt="<?php echo $popup->post_title ?>" title="<?php echo $popup->post_title ?>">
                        </a>
                        <button class="btn-close" id="close_popup_<?php echo $popup->ID; ?>" style="background-image: url('<?php echo get_template_directory_uri() . "/assets/img/close.png"; ?>');"></button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            jQuery(function() {
                jQuery('#close_popup_<?php echo $popup->ID; ?>').on('click', function() {
                    window.localStorage.setItem('popup_<?php echo $popup->ID; ?>', 1);
                    jQuery('#popup_<?php echo $popup->ID; ?>').modal('hide');
                });
                <?php
                $access = get_post_meta($popup->ID, 'view_type', true);
                if ($access == 'first_access') {
                ?>
                    if (!window.localStorage.getItem('popup_<?php echo $popup->ID; ?>')) {
                        jQuery('#popup_<?php echo $popup->ID; ?>').modal('show');
                    }
                <?php
                } else {
                ?>
                    jQuery('#popup_<?php echo $popup->ID; ?>').modal('show');
                <?php
                }
                ?>
            });
        </script>
<?php
    }
}
?>
<button id="scrollToTopButton" class="scroll-to-top-button" title="Voltar ao topo">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-box-arrow-in-up" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M3.5 10a.5.5 0 0 1-.5-.5v-8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 0 0 1h2A1.5 1.5 0 0 0 14 9.5v-8A1.5 1.5 0 0 0 12.5 0h-9A1.5 1.5 0 0 0 2 1.5v8A1.5 1.5 0 0 0 3.5 11h2a.5.5 0 0 0 0-1h-2z" />
        <path fill-rule="evenodd" d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3z" />
    </svg>
</button>
<?php wp_footer() ?>

<script>
    window.addEventListener('scroll', function() {
        var scrollToTopButton = document.getElementById('scrollToTopButton');
        if (window.scrollY > 0) {
            scrollToTopButton.style.display = 'block';
        } else {
            scrollToTopButton.style.display = 'none';
        }
    });

    document.getElementById('scrollToTopButton').addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>
</body>

</html>