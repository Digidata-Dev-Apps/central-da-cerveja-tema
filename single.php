<?php
get_header();

if (have_posts()) :
    while (have_posts()) :
        the_post();

        // Informações do post
        $post_title = get_the_title();
        $post_date = get_the_date();
        $post_time = get_the_time();
        $post_author = get_the_author();
        $post_author_id = get_the_author_meta('ID');
        $author_avatar = get_avatar($post_author_id);

        // Informação da coluna
        $columnist_id = get_post_meta(get_the_ID(), '_columnist', true);
        $columnist_name = get_the_title($columnist_id);

?>

        <section class="main-content single-blog">
            <div class="background-heighlitghs">
                <div class="container">
                    <div class="row">
                        <div class="col pt-3 px-3 px-md-0 font-heighlitghs">
                            <h4><?php echo $columnist_name; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12 mt-5">
                        <h2><?php echo $post_title; ?></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 my-3 content"><?php the_content(); ?></div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
                        <div class="cdc-post-author">
                            <div class="cdc-post-author__image">
                                <?php echo $author_avatar; ?>
                            </div>
                            <div class="cdc-post-author__info">
                                <span class="cdc-post-author__name"><?php echo $post_author;?></span>
                                <span class="cdc-post-author__publish"><?php echo $post_date; ?> às <?php echo $post_time; ?></span>
                            </div>
                        </div>
                        <a href="javascript:history.back();" class="text-dark" style="font-size: 1.3rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                            Voltar
                        </a>
                    </div>
                </div>
            </div>
        </section>

    <?php
    endwhile;
else :
    ?>
    <section class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="text-center">Nenhum resultado encontrado</p>
                </div>
            </div>
        </div>
    <?php
endif;
get_footer();

    ?>