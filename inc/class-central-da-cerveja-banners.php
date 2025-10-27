<?php

/**
 * Central da Cerveja Banners Class
 */

// Verifica se o arquivo foi acessado diretamente
if (!defined('ABSPATH')) {
    exit;
}

// Verifica se a classe não existe
if (!class_exists('Central_Da_Cerveja_Banners')) {

    /**
     * Classe principal
     */
    final class Central_Da_Cerveja_Banners
    {
        public function __construct()
        {
            add_action('init', array($this, 'create_banners_post_types'));

            add_action('admin_menu', array($this, 'add_menu_page_banner'));

            add_action('add_meta_boxes', array($this, 'create_meta_box'));

            add_action( 'save_post', array($this, 'save_meta_box') );
            add_action( 'admin_head', array($this, 'remove_perma_link') );
        }

        public function add_menu_page_banner()
        {
            add_menu_page(
                __('Banners', 'central-da-cerveja'),
                __('Banners', 'central-da-cerveja'),
                'manage_options',
                'banners',
                null,
                'dashicons-images-alt2',
                2
            );
        }

        public function create_banners_post_types()
        {
            register_post_type('banners', array(
                'labels' => array(
                    'name' => __('Todos os Banners', 'central-da-cerveja'),
                    'singular_name' => 'Banner Principal'
                ),
                'supports' => array(
                    'title',
                    'thumbnail'
                ),
                'public' => true,
                'has_archive' => true,
                'menu_icon' => 'dashicons-images-alt2',
                'show_in_menu' => 'banners',
                'rewrite' => false
            ));
        }

        public function remove_perma_link()
        {
            ?>
                <style>
                    .post-type-banners #edit-slug-box {
                        display: none !important;
                    }
                </style>
            <?php
        }

        public function save_meta_box($post_id)
        {
            update_post_meta( $post_id, '_url_banner', $_POST['_url_banner'] );
        }


        public function content_banner($post) 
        {
           ?>
               <div style="padding-top: 30px; padding-bottom: 30px;">
                   <label for="url_banner">URL: </label>
                   <input type="text" style="width: 70%;" name="_url_banner" value="<?php echo get_post_meta( $post->ID, '_url_banner', true ) ?>" id="url_banner">
               </div>
           <?php
        }

        public function create_meta_box() 
        {
            add_meta_box('banners', 'Link do Banner', array($this, 'content_banner'), 'banners');
        }



    }
}

return new Central_Da_Cerveja_Banners();
