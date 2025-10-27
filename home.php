<?php

get_header();
?>

<section class="banners">
    <div class="background-header pt-3 pb-5">
        <div class="container banner-home-primary">
            <div class="row">
                <div class="col-12">
                    <?php echo do_shortcode('[cdc_banner type="main" interval="4000" class="custom-class"]'); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="background-information">

    <div class="container font-colors-information p-4">
        <div class="row">
            <div class="col-3">
                <a href="/kits-e-souvenirs">
                    <div class="row">
                        <div class="col-4">
                            <img id="wishlist_engradado" src="<?php echo get_template_directory_uri() . "/assets/img/Extract/wishlist_bar.png" ?>">
                        </div>
                        <div class="col-6 pt-3 ps-5 color-fonts-information wishlist_engradado">
                            <p class="fs-3 ps-3 text-nowrap text-center"><?php echo __('KITS E', 'central-da-cerveja'); ?></p>
                            <p class="ps-2 text-center fs-1"><?php echo __('SOUVENIRS', 'central-da-cerveja'); ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-3">
                <a href="javascript:void(0)" id="my-barrel" data-bs-toggle="modal" data-bs-target="#confirm-my_barrel">
                    <div class="row">
                        <div class="col-4">
                            <img id="barril_bar" src="<?php echo get_template_directory_uri() . "/assets/img/Extract/barril_bar.png" ?>">
                        </div>
                        <div class="col-6 ms-2 pt-3 color-fonts-information barril_bar">
                            <p class="fs-3 ps-2 text-center"><?php echo __('COMPRE O', 'central-da-cerveja'); ?></p>
                            <p class="ps-3 text-nowrap text-center fs-1"><?php echo __('SEU BARRIL', 'central-da-cerveja'); ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-3">
                <!-- Link - /promocoes -->
                <a href="/promocoes-exclusivas/">
                    <div class="row">
                        <div class="col-4">
                            <img id="promocao_bar" src="<?php echo get_template_directory_uri() . "/assets/img/Extract/promocao_bar.png" ?>">
                        </div>
                        <div class="col-6 pt-3 color-fonts-information promocao_bar">
                            <p class="fs-3 ps-4 text-center"><?php echo __('PROMOÇÕES', 'central-da-cerveja'); ?></p>
                            <p class="text-center ps-3 fs-1"><?php echo __('EXCLUSIVAS', 'central-da-cerveja'); ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-3">
                <a href="/clube-do-assinante">
                    <div class="row">
                        <div class="col-4">
                            <img id="clube_bar" src="<?php echo get_template_directory_uri() . "/assets/img/Extract/clube_bar.png" ?>">
                        </div>
                        <div class="col-6 pt-3 color-fonts-information clube_bar">
                            <p class="fs-3 ps-5 text-center text-nowrap"><?php echo __('CLUBE DO', 'central-da-cerveja'); ?></p>
                            <p class="text-center ps-4 fs-1"><?php echo __('ASSINANTE', 'central-da-cerveja'); ?></p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

</section>

<div class="d-block w-100">
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

    $releases = $central_da_cerveja->woocommerce->get_active_ticket_products('releases', 12);

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
</div>

<div class="cdc-more">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a href="/lancamentos" class="btn btn-see-more mt-0">VER MAIS</a>
            </div>
        </div>
    </div>
</div>

<div class="banner-secondary">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <?php echo do_shortcode('[cdc_banner type="secondary" interval="4000" class="custom-class"]'); ?>
            </div>
        </div>
    </div>
</div>

<div class="d-block w-100">
    <div class="background-heighlitghs">
        <div class="container">
            <div class="row">
                <div class="col pt-3 font-heighlitghs">
                    <h4><?php echo __('PROMOÇÕES', 'central-da-cerveja'); ?></h4>
                </div>
            </div>
        </div>
    </div>

    <?php

    $sales = $central_da_cerveja->woocommerce->get_active_ticket_products('sales', 8, array_column($releases, 'id'));

    ?>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5">
                <?php
                if (count($sales) > 0) {
                ?>
                    <div class="cdc-grid">
                        <?php
                        foreach ($sales as $product) {
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
</div>

<div class="cdc-more">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a href="/promocoes-exclusivas" class="btn btn-see-more mt-0">VER MAIS</a>
            </div>
        </div>
    </div>
</div>

<div class="d-block w-100">
    <div class="background-heighlitghs">
        <div class="container">
            <div class="row">
                <div class="col pt-3 font-heighlitghs">
                    <h4><?php echo __('DESTAQUES', 'central-da-cerveja'); ?></h4>
                </div>
            </div>
        </div>
    </div>

    <?php

    $featured = $central_da_cerveja->woocommerce->get_active_ticket_products('featured', 8, array_column($sales, 'id'));

    ?>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5">
                <?php
                if (count($featured) > 0) {
                ?>
                    <div class="cdc-grid">
                        <?php
                        foreach ($featured as $product) {
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
</div>

<div class="cdc-more">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a href="/destaques" class="btn btn-see-more mt-0">VER MAIS</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade popup-age" id="confirm-age" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body d-flex align-items-center flex-column justify-content-center">
                <div>
                    <h3 class="text-center">Seja Bem-Vindo</h3>
                    <h3 class="text-center">À Central da Cerveja</h3>
                </div>
                <div>
                    <h4 class="text-center">Você tem 18 anos ou mais?</h4>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col"><button class="btn check-true btn-primary float-end">Sim</button></div>
                        <div class="col">
                            <a href="https://www.google.com/">
                                <button class="btn check-false btn-primary">Não</button>
                            </a>
                        </div>
                    </div>

                </div>
                <div class="pt-3 d-flex flex-row align-items-center check-confirm-age">
                    <input type="checkbox" value="" id="check" checked>
                    <label class="ms-2" for="check">Lembrar de mim?</label>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include(get_template_directory(__DIR__) . "/partials/accept_modal_barreal_rules.php");
?>

<?php
wp_footer();
get_footer();
?>