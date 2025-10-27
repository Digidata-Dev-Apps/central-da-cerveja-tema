<?php
/*
 Template Name: Blog
 */

get_header();

$template_directory_uri = get_template_directory_uri();

$slug_active = isset($_GET['columnist']) ? sanitize_text_field($_GET['columnist']) : '';

// Define os parâmetros desejados para a obtenção dos posts
$args = array(
    'post_type' => 'columnist',
    'orderby' => 'date',
    'order' => 'DESC',
    'posts_per_page' => -1 // Exibir todos os posts
);

// Obtem os posts com base nos parâmetros
$columnists = get_posts($args);

?>
<!-- begin: Title -->
<div class="background-heighlitghs">
    <div class="container">
        <div class="row">
            <div class="col pt-3 font-heighlitghs">
                <h4><?php echo the_title(); ?></h4>
            </div>
        </div>
    </div>
</div>
<!-- end: Title -->

<!-- begin: Content -->
<div class="container">
    <div class="row">
        <div class="col-12 col-md-9 order-md-first order-last">
            <div class="cdc-blog" id="post-list"></div>
            <div class="cdc-blog-loading" id="cdc-blog-loading">
                <div class="cdc-blog-loading__icon"></div>
                <span class="cdc-blog-loading__text">Carregando...</span>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="cdc-blog-columns">
                <div class="cdc-blog-columns__header">
                    Colunista
                </div>
                <div class="cdc-blog-columns__body">
                    <?php
                    // Exiba os posts
                    if ($columnists) {
                        foreach ($columnists as $columnist) {
                            setup_postdata($columnist);
                            $author_id = $columnist->post_author; // ID do autor do post
                            $author_name = get_the_author_meta('display_name', $author_id); // Nome do autor
                            $author_photo = get_avatar($author_id); // URL da foto do autor
                            $columnist_slug = get_post_field('post_name', $columnist->ID); // Slug do post
                            $biography = get_the_author_meta('description', $author_id);
                            $author_link = get_author_posts_url($author_id);

                    ?>
                            <div class="cdc-blog-columns__item <?php echo $slug_active == $columnist_slug ? "active" : ""; ?>" data-columnist="<?php echo $columnist->ID; ?>">
                                <div class="cdc-blog-columns__image">
                                    <?php echo $author_photo; ?>
                                </div>
                                <div class="cdc-blog-columns__description">
                                    <h4 class="cdc-blog-columns__title">
                                        <a href="?columnist=<?php echo $columnist_slug; ?>" class="text-truncate">
                                            <?php echo get_the_title($columnist->ID); ?>
                                        </a>
                                    </h4>
                                    <div class="cdc-blog-columns__author">
                                        <a href="<?php echo $author_link; ?>">
                                            <span><?php echo $author_name; ?></span>
                                        </a>
                                    </div>
                                </div>
                                <div class="cdc-blog-columns__popover">
                                    <i class="fa fa-info-circle"></i>
                                    <div class="cdc-blog-columns__popover-content">
                                        <div class="cdc-blog-columns__popover-author">
                                            <div class="cdc-blog-columns__popover-image">
                                                <?php echo $author_photo; ?>
                                            </div>
                                            <a href="<?php echo $author_link; ?>">
                                                <h3><?php echo $author_name; ?></h3>
                                            </a>
                                        </div>
                                        <div class="cdc-blog-columns__popover-biography">
                                            <?php echo $biography; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                        wp_reset_postdata();
                    } else {
                        // Caso não haja colunistas encontrados
                        echo 'Nenhum colunista encontrado.';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end: Content -->
<?php
get_footer();
?>