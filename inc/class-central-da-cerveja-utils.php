<?php

/**
 * Central da Cerveja Class
 */

// Verifica se o arquivo foi acessado diretamente
if (!defined('ABSPATH')) {
    exit;
}

// Verifica se a classe não existe
if (!class_exists('Central_Da_Cerveja_Utils')) {

    /**
     * Classe principal
     */
    final class Central_Da_Cerveja_Utils
    {

        public function get_logo()
        {
            $custom_logo_id = get_theme_mod('custom_logo');
            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');

            if (has_custom_logo()) {
                echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" class="cdc-logo__img">';
            } else {
                echo '<img src="' . get_template_directory_uri() . "/assets/img/logo.png" . '" alt="' . get_bloginfo('name') . '" class="cdc-logo__img">';
            }
        }
    }
}

return new Central_Da_Cerveja_Utils();
