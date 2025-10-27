<?php
/*
 Template Name: Lançamentos
 */
?>

<?php
get_header();
?>

<div class="background-heighlitghs">
    <div class="container">
        <div class="row">
            <div class="col pt-3 font-heighlitghs">
                <h4><?php echo __('LANÇAMENTOS', 'central-da-cerveja'); ?></h4>
            </div>
        </div>
    </div>
</div>

<?php

$releases = $central_da_cerveja->woocommerce->get_active_ticket_products('releases', 60);

?>
<div class="container">
    <div class="row">
        <div class="col-12 mt-5">
            <?php
            if (count($releases) > 0) {
            ?>
                <div class="cdc-grid">
                    <?php
                    foreach ($releases as $product) {
                    ?>
                        <div class="cdc-grid__item">
                            <?php
                            echo $central_da_cerveja->woocommerce->render_partial(
                                get_template_directory() . '/partials/product_card.php',
                                [
                                    'id'                => $product['id'],
                                    'name'              => $product['name'],
                                    'slug'              => $product['slug'],
                                    'supplier_id'       => $product['supplier_id'],
                                    'supplier_name'     => $product['supplier_name'],
                                    'supplier_image'    => $central_da_cerveja->woocommerce->add_image_size_suffix($product['supplier_image'], '100x100'),
                                    'supplier_slug'     => $product['supplier_slug'],
                                    'sku'               => $product['sku'],
                                    'type'              => $product['type'],
                                    'price'             => $product['price'] ?? 0,
                                    'sale_price'        => $product['sale_price'] ?? 0,
                                    'image'             => '/wp-content/uploads/' . $central_da_cerveja->woocommerce->add_image_size_suffix($product['image'], '300x300'),
                                    'country_icon'      => '/wp-content/themes/central-da-cerveja/assets/img/icons/' . strtolower($product['country'] ?? 'brasil') . '.png',
                                    'country'           => $product['country'],
                                    'alcoholic_dosage'  => $product['alcoholic_dosage'] ?? '--',
                                    'excerpt'           => $product['excerpt'] ?? '--',
                                    'volume'            => $product['volume'] ?? '--',
                                    'style'             => $product['style'] ?? '--',
                                    'remaining_stock'   => $product['remaining_stock'] ?? 0,
                                ]
                            );
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            <?php
            } else {
            ?>
                <p class="text-muted text-center"><?php echo __('Nenhum resultado encontrado!'); ?></p>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<?php
get_footer();
?>