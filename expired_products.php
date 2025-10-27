<?php
/*
 Template Name: Produtos a vencer
 */
?>

<?php
get_header();
?>

<div class="background-heighlitghs">
    <div class="container">
        <div class="row">
            <div class="col pt-3 font-heighlitghs">
                <h4><?php echo get_the_title( ) ?></h4>
            </div>
        </div>
    </div>
</div>

<?php

$ids = $central_da_cerveja->woocommerce->get_all_expired_products_ids_ordered_by_approve();
?>
<div class="container woocomerce-home">
    <div class="row">
        <div class="container pt-4 d-flex justify-content-center">
            <article class="last_call_products"> 
                <img class="img-fluid" src="<?php echo get_post_meta( get_the_ID(), '_banner_desktop', true) ?>" alt="">
            </article>
        </div>
    </div>
    <div class="row">
        <div class="col-12 py-3 kits-list">
            
            <?php 
                if(empty($ids)){
                ?>
                    <p class="text-center">Nenhum produto encontrado!</p>
                <?php
                }else{
                    echo do_shortcode('[products ids="' . implode(',', $ids) . '" per_page="12" columns="4" orderby="modified" paginate="true"]');
                } 
            ?>
        </div>
    </div>
</div>

<?php
get_footer();
?>