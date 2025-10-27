<?php
/*
 Template Name: Kits e Souvenirs
 */
?>

<?php
get_header();
?>

<div class="background-heighlitghs">
    <div class="container">
        <div class="row">
            <div class="col pt-3 font-heighlitghs">
                <h4>Kits e Souvenirs</h4>
            </div>
        </div>
    </div>
</div>

<?php
$not_beer = [];

$args = array(
    'taxonomy'   => "product_cat",
    'hide_empty' => false,
);

$product_categories = get_terms($args);
$exclude_categories = [];
foreach ($product_categories as $key => $cat) {
    if ($cat->term_id == 15) {
        unset($product_categories[$key]);
        array_push($exclude_categories, $cat->slug);
    }
}

$products = get_posts(array(
    'post_type' => 'product',
    'numberposts' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $exclude_categories,
            'operator' => 'NOT IN',
        )
    )
));



foreach ($products as $product) {
    $product_wc = wc_get_product($product->ID);
    $product_cat = get_the_terms($product->ID, 'product_cat', true)[0]->slug;

    if ($product_cat == 'kits' && $product_wc->is_type('bundle')) {

        foreach ($product_wc->bundle_data as $bundle_data) {
            $current_stock[] = get_post_meta($bundle_data['id'], '_stock_status', true);
            $certificate_validity[] = get_post_meta($bundle_data['id'], '_supplier_certificate_expired', true);
        }

        if (!in_array('outofstock', $current_stock) && !in_array(1, $certificate_validity)) {
            array_push($not_beer, [
                'product_id' => $product->ID,
                'date' => $product->post_modified
            ]);
        }
        $current_stock = null;
        $certificate_validity = null;
    }

    $args = array(
        'post_type' => 'cdc_ticket',
        'meta_query' => array(
            array(
                'key'     => 'ticket_products',
                'value'   => $product->ID,
                'compare' => 'LIKE',
            ),
            array(
                'key'     => 'ticket_status',
                'value'   => array(2, 4),
                'compare' => 'IN',
            ),
        ),
    );
    $by_approve_date = new WP_Query($args);

    foreach ($by_approve_date->posts as $ticket_post) {
        $ticket_product_id = json_decode(get_post_meta($ticket_post->ID, 'ticket_products', true));

        foreach ($ticket_product_id as $ticket_prod) {
            $commercialize_on_kit = get_post_meta($product->ID, '_commercialize_on_kit', true);
            $supplier_certificate_expired = get_post_meta($ticket_prod->product_id, '_supplier_certificate_expired', true);
            if ($product->ID == $ticket_prod->product_id && !$commercialize_on_kit && !$supplier_certificate_expired) {
                array_push($not_beer, [
                    'product_id' => $product->ID,
                    'date' => $ticket_post->post_modified
                ]);
            }
        }
    }
}

function compareByTimeStamp($time1, $time2)
{
    if (strtotime($time1['date']) < strtotime($time2['date']))
        return 1;
    else if (strtotime($time1['date']) > strtotime($time2['date']))
        return -1;
    else
        return 0;
}
usort($not_beer, "compareByTimeStamp");

$featured_ids = [];
foreach ($not_beer as $id) {
    array_push($featured_ids, $id['product_id']);
}

$featured_ids = array_unique($featured_ids);
?>
<div class="container">
    <div class="row">
        <div class="col-12 py-3 kits-list">
            <?php echo do_shortcode('[products ids="' . implode(',', $featured_ids) . '" per_page="12" columns="4" orderby="post__in" paginate="true"]'); ?>
        </div>
    </div>
</div>

<?php
get_footer();
?>