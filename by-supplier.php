<?php
/*
Template Name: Por Cervejaria
*/
?>

<?php
get_header();
?>

<div class="background-heighlitghs">
    <div class="container">
        <div class="row">
            <div class="col pt-3 font-heighlitghs">
                <h4><?php echo __('Cervejarias', 'central-da-cerveja'); ?></h4>
            </div>
        </div>
    </div>
</div>

<div class="container p-0">
    <div class="dcdc-wrapper">
        <div class="dcdc-list">
            <?php
            $args = array(
                'post_status' => 'publish',
                'post_type'   => 'dwcc_supplier',
                'orderby'     => 'title',
                'order'       => 'ASC',
                'nopaging'    => true,
                'per_page'    => -1
            );
            $query = new WP_Query($args);

            if (!empty($query->posts)) {
                foreach ($query->posts as $key => $value) {
                    $params = array(
                        'post_type'     => 'product',
                        'post_status'   => 'publish',
                        'meta_query'    => array(
                            array(
                                'key' => '_supplier_id',
                                'value' => $value->ID,
                                'compare' => '=',
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
                        'nopaging' => true,
                        'fields' => 'ids'
                    );
                    $wc_query = new WP_Query($params);

                    if (empty($wc_query->posts)) {
                        unset($query->posts[$key]);
                    }
                }
                $query->posts = array_values($query->posts);
            }

            if (!empty($query->posts)) :
                foreach ($query->posts as $post) {
                    $image = get_the_post_thumbnail_url($post->ID, 'full');
                    if (empty($image)) {
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');

                        if (has_custom_logo()) {
                            $image = esc_url($logo[0]);
                        } else {
                            $image = get_template_directory_uri();
                        }
                    }
            ?>
                    <div class="dcdc-item-wrapper">
                        <div class="dcdc-item">
                            <div class="dcdc-item-logo" style="background: url('<?php echo $image; ?>');"></div>
                            <div class="dcdc-item-info">
                                <div class="dcdc-info__title">
                                    <h4 class="dcdc-title text-truncate"><?php echo $post->post_title; ?></h4>
                                </div>
                                <div class="dcdc-info__tools">
                                    <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="btn dcdc-btn"  target="<?php echo !wp_is_mobile() ? '_blank' : '' ?>"><?php echo __('Ver', 'central-da-cerveja'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                };
            else :
                ?>
                <p class="woocommerce-info fw-bold"><?php esc_html_e('No products were found matching your selection.', 'woocommerce'); ?></p>
            <?php
            endif;
            ?>
        </div>
    </div>
</div>

<?php
get_footer();
?>