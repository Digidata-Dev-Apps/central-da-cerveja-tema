<?php
/*
 Template Name: Meu Barril
 */
?>

<?php
get_header();
global $wpdb;
?>

<div class="background-heighlitghs">
    <div class="container">
        <div class="row">
            <div class="col pt-3 font-heighlitghs">
                <h4>Meu Barril</h4>
            </div>
        </div>
    </div>
</div>

<?php if (!is_user_logged_in()) : ?>
    <div class="container" style="min-height: 420px;">
        <div class="row">
            <div class="send-your-thoughts mt-3">
                <p>Por favor, realize <a href="/minha-conta" class="barrel_request_not_logged_user">login ou cadastre-se</a> para solicitar o seu barril!</p>
            </div>
        </div>
    </div>

<?php
else :
    $current_user = wp_get_current_user();

    $states = "SELECT * FROM {$wpdb->prefix}cdc_states";
    $states = $wpdb->get_results($states);

    $sql = "SELECT * FROM {$wpdb->prefix}posts AS post
     INNER JOIN {$wpdb->prefix}postmeta AS postmeta ON (postmeta.post_id = post.ID AND postmeta.meta_key = 'supplier_type' AND postmeta.meta_value LIKE '%\"2\"%') WHERE post_type = 'dwcc_supplier'
    AND post.post_status = 'publish' ORDER BY post.post_title ASC";
    $suppliers = $wpdb->get_results($sql);
    $terms = get_terms([
        'taxonomy' => 'pa_por-estilo',
        'order' => 'ASC',
        'hide_empty' => false,
        'orderby' => 'name',
        'number' => false
    ]);
?>

    <div class="container" style="min-height: 320px;">
        <div class="row">
            <div class="request-your-barrel mt-3">
                <p>Peça o seu barril! Nossa equipe irá buscar uma cervejaria na sua região.</p>
            </div>
            <div class="barrel-request-div">
                <form id="barrel-request-form">
                    <div class="mb-3">
                        <label for="my_barrel_name" class="form-label">Nome*</label>
                        <input type="text" name="my_barrel_name" id="my_barrel_name" class="form-control" value="<?php echo $current_user->user_firstname . " " . $current_user->user_lastname; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="my_barrel_phone" class="form-label">Telefone*</label>
                        <input type="text" name="my_barrel_phone" id="my_barrel_phone" class="form-control" value="<?php echo get_user_meta($current_user->ID, 'billing_phone', true) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="my_barrel_email" class="form-label">E-mail*</label>
                        <input type="email" name="my_barrel_email" id="my_barrel_email" class="form-control" value="<?php echo $current_user->user_email ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="my_barrel_delivery_date" class="form-label">Data Limite para Entrega*</label>
                        <input type="date" name="my_barrel_delivery_date" id="my_barrel_delivery_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-sm-9 col-md-4">
                                <label for="my_barrel_liters" class="form-label">Quantidade de Litros*</label>
                                <select name="my_barrel_liters" class="form-select" id="my_barrel_liters">
                                    <option value="">Selecione</option>
                                    <option value="30">30 Litros</option>
                                    <option value="60">60 Litros</option>
                                    <option value="90">90 Litros</option>
                                    <option value="120">120 Litros</option>
                                    <option value="150">150 Litros</option>
                                </select>
                            </div>
                            <div class="col-sm-9 col-md-4">
                                <label for="my_barrel_chop-style" class="form-label">Estilo do Chopp</label>
                                <select name="my_barrel_chop-style" class="form-select" id="my_barrel_chop-style">
                                    <option value="">Selecione</option>
                                    terms
                                    <?php foreach($terms as $term): ?>
                                        <option value="<?php echo $term->name ?>"><?php echo $term->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-sm-9 col-md-4">
                                <label for="my_barrel_prefer-supplier" class="form-label">Cervejarias de Preferência</label>
                                <select name="my_barrel_prefer-supplier" class="form-select" id="my_barrel_prefer-supplier" multiple>
                                    <option value="">Selecione</option>
                                    <?php foreach($suppliers as $supplier): ?>
                                        <option value="<?php echo $supplier->post_title ?>"><?php echo $supplier->post_title ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                    <div class="mb-3">
                        <label for="my_barrel_state" class="form-label">Estado*</label>
                        <select name="my_barrel_state" id="my_barrel_state" class="form-control" required>
                            <option value="">Selecione</option>
                            <?php foreach ($states as $state) : ?>
                                <option value="<?php echo $state->name; ?>"><?php echo $state->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="my_barrel_city" class="form-label">Município*</label>
                        <select name="my_barrel_city" id="my_barrel_city" class="form-control" required>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="my_barrel_request_info" class="form-label">Informações da Solicitação*</label>
                        <textarea name="my_barrel_request_info" id="my_barrel_request_info" class="form-control" rows="5" required></textarea>
                    </div>

                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $current_user->ID ?>">

                    <?php wp_nonce_field('woocommerce-barrel-request', 'woocommerce-barrel-request-nonce'); ?>

                    <div class="mb-3">
                        <button type="submit" class="btn barrel-request-submit">Solicitar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php 
include get_template_directory(__DIR__)."/partials/accept_modal_barreal_rules.php";
endif; ?>
<?php
get_footer();
?>