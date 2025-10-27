<?php
/*
 Template Name: Destaques
 */
?>

<?php
get_header();
?>

<div class="background-heighlitghs">
    <div class="container">
        <div class="row">
            <div class="col pt-3 font-heighlitghs">
                <h4>Todos os Destaques</h4>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12 py-4">
            <?php
            $tax_query[] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
                'operator' => 'IN',
            );
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
                'tax_query' => $tax_query,
                'fields' => 'ids',
            );

            $product_ids = get_posts($args);

            $product_ids = implode(",", $product_ids);
           
            echo do_shortcode('[products ids="' . $product_ids . '" per_page="12" columns="4" orderby="date" order="DESC"  paginate="true"]'); ?>
        </div>
    </div>
</div>

<?php
get_footer();
?>