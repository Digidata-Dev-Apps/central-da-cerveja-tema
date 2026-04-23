<?php
get_header('shop');


$product_categories = get_terms($args);

$exclude_categories = [];
foreach ($product_categories as $key => $cat) {
  if ($cat->term_id == 330) {
    unset($product_categories[$key]);
    array_push($exclude_categories, $cat->slug);
  }
}




?>

<div class="background-heighlitghs">
  <div class="container">
    <div class="row">
      <div class="col pt-3 font-heighlitghs">
        <h4><?php the_title(); ?></h4>
      </div>
    </div>
  </div>
</div>

<div class="woocomerce-home">
  <?php if (!empty(get_post_meta(get_the_ID(), 'dwcc_banner', true))): ?>
    <div class="row">
      <div class="container pt-4 d-flex justify-content-center">
        <article class="last_call_products">
          <img class="img-fluid" src="<?php echo array_shift(get_post_meta(get_the_ID(), 'dwcc_banner', true)) ?>" alt="">
        </article>
      </div>
    </div>
  <?php endif; ?>
  <div class="container supplier-products">
    <div class="row">
      <div class="col-12 py-3 px-0">
        <?php
        $params = array(
          'post_type' => 'product',
          'post_status'         => 'publish',
          'meta_query' => array(
            array(
              array(
                'key' => '_supplier_id',
                'value' => get_the_ID(),
                'compare' => '=',
              ),
              'relation' => 'OR',
              array(
                'key' => '_supplier',
                'value' => get_the_ID(),
                'compare' => '=',
              ),
            ),
            array(
              'key' => '_stock_status',
              'value' => 'instock'
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
          'tax_query' => array(
            array(
              'taxonomy' => 'product_cat',
              'field'    => 'slug',
              'terms'    => $exclude_categories,
              'operator' => 'NOT IN',
            ),

          ),
          'nopaging' => true,
          'fields' => 'ids'
        );

        $wc_query = new WP_Query($params);

        if (!empty($wc_query->posts)) {
          echo do_shortcode('[products ids="' . implode(",", $wc_query->posts) . '" per_page="12" columns="4" order="asc" orderby="name" paginate="true"]');
        } else {
        ?>
          <p class="woocommerce-info fw-bold"><?php esc_html_e('No products were found matching your selection.', 'woocommerce'); ?></p>
        <?php
        }
        wp_reset_postdata();
        ?>
      </div>
    </div>
  </div>
</div>

<?php
get_footer('shop');
?>