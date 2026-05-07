<?php
/*
 Template Name: Contato
 */
?>

<?php
get_header();
?>

<div class="background-heighlitghs">
    <div class="container">
        <div class="row">
            <div class="col pt-3 font-heighlitghs">
                <h4>Fale Conosco</h4>
            </div>
        </div>
    </div>
</div>

<div class="container" style="min-height: 320px;">
    <div class="row">
        <div class="send-your-thoughts mt-3">
            <p>Envie para nós suas críticas, sugestões, elogios e reclamações.</p>
        </div>

        <div class="contact-us-div">
            <form id="contact-us-form">
                <div class="mb-3">
                    <label for="contact_us_name" class="form-label">Nome*</label>
                    <input type="text" name="contact_us_name" id="contact_us_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="contact_us_phone" class="form-label">Telefone*</label>
                    <input type="text" name="contact_us_phone" id="contact_us_phone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="contact_us_email" class="form-label">E-mail*</label>
                    <input type="email" name="contact_us_email" id="contact_us_email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="contact_us_subject" class="form-label">Assunto*</label>
                    <input type="text" name="contact_us_subject" id="contact_us_subject" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="contact_us_message" class="form-label">Mensagem*</label>
                    <textarea name="contact_us_message" id="contact_us_message" class="form-control" rows="5" required></textarea>
                </div>

                <input type="hidden" name="generate_token" id="generate_token">

                <div style="position:absolute; left:-10000px; top:auto; width:1px; height:1px; overflow:hidden;" aria-hidden="true">
                    <label for="contact_us_company">Empresa</label>
                    <input type="text" name="contact_us_company" id="contact_us_company" tabindex="-1" autocomplete="off">
                </div>

                <input type="hidden" name="logged_user" id="logged_user" value="<?php echo is_user_logged_in() ? get_current_user_id() : false; ?>">

                <?php wp_nonce_field('woocommerce-contact-us', 'woocommerce-contact-us-nonce'); ?>

                <div class="mb-3">
                    <button type="submit" class="btn contact-us-submit">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
get_footer();
?>