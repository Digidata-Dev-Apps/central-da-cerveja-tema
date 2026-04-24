<?php
/*
Template Name: Por Estilo
*/
?>

<?php get_header(); ?>

<div class="background-heighlitghs">
    <div class="container">
        <div class="row">
            <div class="col pt-3 font-heighlitghs">
                <h4><?php echo __('Estilos', 'central-da-cerveja'); ?></h4>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="dcdc-wrapper">
        <div class="dcdc-list">
            <?php
            $terms = get_terms(array(
                'taxonomy'   => 'pa_por-estilo',
                'hide_empty' => false,
            ));

            if (!empty($terms) && !is_wp_error($terms)) :
                $processed_styles = [];

                foreach ($terms as $style) {
                    $args = [
                        'post_type'      => 'product',
                        'post_status'    => 'publish',
                        'posts_per_page' => -1,
                        'fields'         => 'ids',
                        'tax_query'      => [
                            'relation' => 'AND',
                            [
                                'taxonomy' => 'pa_por-estilo',
                                'field'    => 'term_id',
                                'terms'    => $style->term_id,
                            ],
                            [
                                'taxonomy' => 'product_visibility',
                                'field'    => 'slug',
                                'terms'    => array('exclude-from-catalog'),
                                'operator' => 'NOT IN',
                            ],
                        ],
                        'meta_query' => [
                            'relation' => 'AND',
                            [
                                'key'     => '_stock_status',
                                'value'   => 'outofstock',
                                'compare' => 'NOT IN'
                            ],
                            [
                                'relation' => 'OR',
                                ['key' => '_commercialize_on_kit', 'compare' => 'NOT EXISTS'],
                                ['key' => '_commercialize_on_kit', 'value' => 1, 'compare' => '!=']
                            ],
                            [
                                'relation' => 'OR',
                                ['key' => '_supplier_certificate_expired', 'compare' => 'NOT EXISTS'],
                                ['key' => '_supplier_certificate_expired', 'value' => 1, 'compare' => '!=']
                            ],
                        ]
                    ];

                    $style_query = new WP_Query($args);
                    $count = $style_query->found_posts;

                    if ($count > 0) {
                        $style->real_count = $count;
                        $processed_styles[] = $style;
                    }
                }

                usort($processed_styles, function($a, $b) {
                    return $b->real_count <=> $a->real_count;
                });

                foreach ($processed_styles as $style) :
            ?>
                    <div class="dcdc-item-wrapper">
                        <div class="dcdc-item" style="display:initial;">
                            <div class="dcdc-item-info" style="width:initial;">
                                <div class="dcdc-info__title">
                                    <h4 class="dcdc-title text-truncate" title="<?php echo $style->name; ?> (<?php echo $style->real_count; ?>)">
                                        <?php echo $style->name; ?> (<?php echo $style->real_count; ?>)
                                    </h4>
                                </div>
                                <div class="dcdc-info__tools" style="width: calc(100% - (100px + 1rem));">
                                    <a href="<?php echo esc_url(get_term_link($style)); ?>" 
                                       class="btn dcdc-btn" 
                                       target="<?php echo !wp_is_mobile() ? '_blank' : '' ?>">
                                       <?php echo __('Ver', 'central-da-cerveja'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>