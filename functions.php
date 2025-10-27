<?php
// Armazena a versão do tema a uma variavel
$theme              = wp_get_theme('central-da-cerveja');
$central_da_cerveja_version = $theme['Version'];

$central_da_cerveja = (object) array(
    'version' => $central_da_cerveja_version,
    
    //Inicializa todos as classes e recursos do tema
    'main'              => require_once 'inc/class-central-da-cerveja.php',
    'utils'             => require_once 'inc/class-central-da-cerveja-utils.php',
    'woocommerce'       => require_once 'inc/class-central-da-cerveja-woocommerce.php',
    'shipping_policies' => require_once 'inc/class-central-da-cerveja-shipping-policies.php',
);

// Desabilita a atualização automatica dos plugins
add_filter( 'auto_update_plugin', '__return_false' );


// Bloqueio de RSS Feed
function wp_disable_feeds() {
    wp_die( __('Access Denied') );
}

add_action('do_feed', 'wp_disable_feeds', 1);
add_action('do_feed_rdf', 'wp_disable_feeds', 1);
add_action('do_feed_rss', 'wp_disable_feeds', 1);
add_action('do_feed_rss2', 'wp_disable_feeds', 1);
add_action('do_feed_atom', 'wp_disable_feeds', 1);
add_action('do_feed_rss2_comments', 'wp_disable_feeds', 1);
add_action('do_feed_atom_comments', 'wp_disable_feeds', 1);
