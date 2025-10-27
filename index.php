<?php
get_header();

?>

<section class="main-content">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <div class="background-heighlitghs">
                <div class="container">
                    <div class="row">
                        <div class="col pt-3 px-3 px-md-0 font-heighlitghs">
                            <h4><?php the_title(); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container p-0">
                <div class="row">
                    <div class="col-12 my-5 p-0"><?php the_content(); ?></div>
                </div>
            </div>

            <?php wp_link_pages(); ?>
            <?php edit_post_link(); ?>

        <?php endwhile; ?>

        <?php
        if (get_next_posts_link()) {
            next_posts_link();
        }
        ?>
        <?php
        if (get_previous_posts_link()) {
            previous_posts_link();
        }
        ?>

    <?php else : ?>
        <p>No posts found.</p>
    <?php endif; ?>
</section>

<?php
get_footer();

?>