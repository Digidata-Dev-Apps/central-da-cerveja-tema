<?php
/*
Template Name: Por Perfil
*/
?>

<?php
get_header();
?>

<div class="background-heighlitghs">
    <div class="container">
        <div class="row">
            <div class="col pt-3 font-heighlitghs">
                <h4><?php echo __('Perfis', 'central-da-cerveja'); ?></h4>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="dcdc-wrapper">
        <div class="dcdc-list">
            <?php
            $profile = get_terms(array(
                'taxonomy'      => 'pa_por-perfil',
                'hide_empty'    => true,
                'orderby'       => 'name',
                'order'         => 'ASC',
            ));

            if (!empty($profile)) :
                foreach ($profile as $profile) :
            ?>
                    <div class="dcdc-item-wrapper">
                        <div class="dcdc-item">
                            <div class="dcdc-item-info">
                                <div class="dcdc-info__title">
                                    <h4 class="dcdc-title text-truncate"><?php echo $profile->name; ?></h4>
                                </div>
                                <div class="dcdc-info__tools">
                                    <a href="<?php echo esc_url(get_term_link($profile->slug, 'pa_por-perfil')); ?>" class="btn dcdc-btn"  target="<?php echo !wp_is_mobile() ? '_blank' : '' ?>"><?php echo __('Ver', 'central-da-cerveja'); ?></a>
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

<?php
get_footer();
?>