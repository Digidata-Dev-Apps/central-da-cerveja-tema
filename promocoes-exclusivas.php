<?php
/*
 Template Name: Promoções Exclusivas
 */
?>

<?php
get_header();
?>

<div class="background-heighlitghs">
    <div class="container">
        <div class="row">
            <div class="col pt-3 font-heighlitghs">
                <h4>Promoções Exclusivas</h4>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12 py-3">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => '_stock_status',
                        'value' => 'instock',
                    ),
                    array(
                        'key' => '_sale_price',
                        'value' => 0,
                        'compare' => '>'
                    ),
                    array(
                        array(
                            'key' => '_commercialize_on_kit',
                            'compare' => 'NOT EXISTS'
                        ),
                        'relation' => 'OR',
                        array(
                            'key' => '_commercialize_on_kit',
                            'value' => 1,
                            'compare' => '!='
                        ),
                    ),
                    array(
                        array(
                            'key' => '_supplier_certificate_expired',
                            'compare' => 'NOT EXISTS'
                        ),
                        'relation' => 'OR',
                        array(
                            'key' => '_supplier_certificate_expired',
                            'value' => 1,
                            'compare' => '!='
                        ),
                    )
                ),
                'fields' => 'ids',
            );

            $product_ids = get_posts($args);
            $product_ids = implode(",", $product_ids);

            echo do_shortcode('[products ids="' . $product_ids . '" limit="12" columns="4" orderby="price" order="desc" class="quick-sale" category="cerveja" paginate="true"]'); ?>
        </div>
    </div>
</div>

<?php
get_footer();
?>