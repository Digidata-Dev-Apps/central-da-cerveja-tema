<?php

/**
 * Central da Cerveja Class
 */

// Verifica se o arquivo foi acessado diretamente
if (!defined('ABSPATH')) {
    exit;
}

// Verifica se a classe não existe
if (!class_exists('Central_Da_Cerveja')) {

    /**
     * Classe principal
     */
    final class Central_Da_Cerveja
    {

        /**
         * Configurações
         */
        public function __construct()
        {
            // Adiciona os suportes ao tema
            add_action('after_setup_theme', array($this, 'setup'));

            // Carrega os scripts do tema
            add_action('wp_enqueue_scripts', array($this, 'scripts'), 40); // Aplica depois que o WooCommerce já carregou

            // Carrega os scritps da tela de login
            add_action('login_enqueue_scripts', array($this, 'login_scripts'), 20);

            // Altara a logo do login
            add_action('login_enqueue_scripts', array($this, 'login_logo'));

            // Altera a URL da logo
            add_filter('login_headerurl', array($this, 'login_logo_url'));

            add_action('after_setup_theme', array($this, 'create_states_table'));

            add_action('after_setup_theme', array($this, 'create_table_rules_barrel'));

            add_action('after_setup_theme', array($this, 'create_cities_table'));

            add_action('after_setup_theme', array($this, 'create_subscription_user_notification_table'));

            add_action('after_setup_theme', array($this, 'update_smtp_log_recipient_column_size'));

            add_action('add_meta_boxes', array($this, 'cdc_register_meta_boxes'));

            add_action('save_post', array($this, 'cdc_save_post'));
        }


        /**
         * Define os padrões do tema e registra suporte para vários recursos do WordPress.
         *
         * @return void
         */
        public function setup()
        {
            /**
             * Carrega os arquivos de tradução do tema
             */
            load_theme_textdomain('central-da-cerveja', get_template_directory() . '/languages');

            /**
             * Habilite o suporte para postar miniaturas em postagens e páginas.
             *
             * @link https://developer.wordpress.org/reference/functions/add_theme_support/#Post_Thumbnails
             */
            add_theme_support('post-thumbnails');

            /**
             * Habilita suporte a logo
             */
            add_theme_support(
                'custom-logo',
                apply_filters(
                    'central_da_cerveja_custom_logo_args',
                    array(
                        'height' => 512,
                        'width'  => 512,
                        'flex-width'  => true,
                        'flex-height' => true,
                    )
                )
            );

            /**
             * Registra os Menus Utilizadados
             */
            register_nav_menus([
                'principal_menu' => 'Menu Principal',
                'helper_and_support' => 'Ajuda e Suporte',
                'promotion' => 'Promoção',
                'menu_banner' => 'Menu Banners'
            ]);

            /**
             * Alterne a marcação de núcleo padrão para formulário de pesquisa, formulário de comentário, comentários, galerias, legendas e widgets para gerar HTML5 válido.
             */
            add_theme_support(
                'html5',
                apply_filters(
                    'central_da_cerveja_html5_args',
                    array(
                        'search-form',
                        'comment-form',
                        'comment-list',
                        'gallery',
                        'caption',
                        'widgets',
                        'style',
                        'script',
                    )
                )
            );

            /**
             * Habilita suporte para o recurso título.
             */
            add_theme_support('title-tag');

            /**
             * Habilita suporte para atualização seletiva de widgets.
             */
            add_theme_support('customize-selective-refresh-widgets');

            /**
             * Habilita suporte para CSS de bloco.
             */
            add_theme_support('wp-block-styles');

            /**
             * Habilita suporte para alinhamento total e amplo.
             */
            add_theme_support('align-wide');

            /**
             * Habilita suporte para conteúdo incorporado responsivo.
             */
            add_theme_support('responsive-embeds');

            /**
             * Habilita suporte com o WooCommerce
             */
            add_theme_support('woocommerce');

            /**
             * Habilita suporte para widgets.
             */
            add_theme_support('widgets');

            /**
             * Habilita o suporte para criar post types
             */
            add_theme_support('create_post_types');
        }

        public function scripts()
        {
            global $central_da_cerveja_version;

            /**
             * Fonts
             */
            wp_enqueue_style('central-da-cerveja-gotham', get_template_directory_uri() . '/assets/css/gotham.css', array(), $central_da_cerveja_version, 'all');
            wp_enqueue_style('central-da-cerveja-bebas', get_template_directory_uri() . '/assets/css/bebas_neue.css', array(), $central_da_cerveja_version, 'all');

            /**
             * Styles
             */
            wp_enqueue_style('thickbox');
            wp_enqueue_style('central-da-cerveja-bootstrap', get_template_directory_uri() . '/assets/vendors/bootstrap-5.1.3/dist/css/bootstrap.min.css', array('thickbox'), $central_da_cerveja_version, 'all');
            wp_enqueue_style('central-da-cerveja-fontawesome', get_template_directory_uri() . '/assets/vendors/fontawesome/css/all.min.css', array(), $central_da_cerveja_version, 'all');
            wp_enqueue_style('central-da-cerveja-selectwo', get_template_directory_uri() . '/assets/vendors/selecttwo/css/select2.min.css', array(), $central_da_cerveja_version, 'all');
            wp_enqueue_style('central-da-cerveja-selectwo-bootstrap', get_template_directory_uri() . '/assets/vendors/selecttwo/css/select2-bootstrap/select2-bootstrap-5-theme.min.css', array(), $central_da_cerveja_version, 'all');
            wp_enqueue_style('central-da-cerveja-style', get_template_directory_uri() . '/assets/css/custom.css', array(
                'central-da-cerveja-gotham',
                'central-da-cerveja-bebas',
                'central-da-cerveja-bootstrap',
                'central-da-cerveja-fontawesome'
            ), $central_da_cerveja_version, 'all');

            /**
             * Scripts
             */
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
            wp_enqueue_script('central-da-cerveja-bootstrap', get_template_directory_uri() . '/assets/vendors/bootstrap-5.1.3/dist/js/bootstrap.min.js', array('jquery', 'media-upload', 'thickbox'), $central_da_cerveja_version, true);
            wp_enqueue_script('central-da-cerveja-validate', get_template_directory_uri() . '/assets/vendors/jquery-validation/dist/jquery.validate.min.js', array('jquery'), $central_da_cerveja_version, true);
            wp_enqueue_script('central-da-cerveja-methods', get_template_directory_uri() . '/assets/vendors/jquery-validation/dist/additional-methods.min.js', array('jquery'), $central_da_cerveja_version, true);
            wp_enqueue_script('central-da-cerveja-locale', get_template_directory_uri() . '/assets/vendors/jquery-validation/dist/localization/messages_pt_BR.min.js', array('jquery'), $central_da_cerveja_version, true);
            wp_enqueue_script('central-da-cerveja-mask', get_template_directory_uri() . '/assets/vendors/jquery-mask/dist/jquery.mask.min.js', array('jquery'), $central_da_cerveja_version, true);
            wp_enqueue_script('central-da-cerveja-selecttwo', get_template_directory_uri() . '/assets/vendors/selecttwo/js/select2.js', array('jquery'), $central_da_cerveja_version, true);
            wp_enqueue_script('central-da-cerveja-user', get_template_directory_uri() . '/assets/js/cdc-user.js', array('jquery'), time(), true);
            wp_enqueue_script('central-da-cerveja-script', get_template_directory_uri() . '/assets/js/index.js', array('jquery'), time(), true);
            wp_enqueue_script('central-da-cerveja-blog', get_template_directory_uri() . '/assets/js/blog.js', array('jquery'), time(), true);
            wp_enqueue_script('central-da-cerveja-alpine', get_template_directory_uri() . '/assets/vendors/alpinejs/alpinejs-3.14.8.min.js', array('jquery'), '3.14.8', false);
            wp_enqueue_script( 'wc-cart-fragments' );
            /**
             * AJAX
             */
            wp_localize_script('central-da-cerveja-user', 'cdc_user', array(
                'ajax_url' => admin_url('admin-ajax.php')
            ));
        }


        public function login_scripts()
        {
            global $central_da_cerveja_version;

            wp_enqueue_style('central-da-cerveja-login', get_stylesheet_directory_uri() . '/assets/css/admin_login.css', array(), $central_da_cerveja_version, 'all');
        }

        public function login_logo_url()
        {
            return home_url();
        }

        public function login_logo()
        {
?>
            <style type="text/css">
                #login h1 a,
                .login h1 a {
                    background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/img/af_marca_escuro.png");
                    width: 320px;
                    min-height: 208px;
                    background-size: 380px;
                    background-repeat: no-repeat;
                    padding-bottom: 30px;
                }
            </style>
<?php
        }

        public function create_states_table()
        {
            global $wpdb;

            $current_url = home_url($_SERVER['REQUEST_URI']);
            $url_slug = explode('/', $current_url);

            if ($url_slug[3] == 'meu-barril') {
                $table_state = $wpdb->prefix . 'cdc_states';

                if ($wpdb->has_cap('collation')) {
                    $collate = $wpdb->get_charset_collate();
                }

                $get_states = "SELECT id FROM " . $table_state;

                $get_states = $wpdb->get_results($get_states);
                if (empty($get_states)) {

                    $states_insert = file_get_contents(get_template_directory() . "/sql/states.sql");

                    $sql = "CREATE TABLE IF NOT EXISTS " . $table_state . " (
                    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                    `uuid` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `initials` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `created_at` timestamp NULL DEFAULT NULL,
                    `updated_at` timestamp NULL DEFAULT NULL,
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `states_uuid_unique` (`uuid`)
                ) " . $collate . ";";

                    $wpdb->query($sql);

                    // Insere todos os estados do Brasil no banco de dados
                    // O states_insert vem do /sql/states.sql
                    $sql = "INSERT INTO " . $table_state . $states_insert;
                    $wpdb->query($sql);
                }
            }
        }

        public function create_table_rules_barrel()
        {
            global $wpdb;
            $current_url = home_url($_SERVER['REQUEST_URI']);
            $url_slug = explode('/', $current_url);

            if ($url_slug[3] == 'meu-barril') {
                $table_barrel = $wpdb->prefix . 'cdc_barrel';

                if ($wpdb->has_cap('collation')) {
                    $collate = $wpdb->get_charset_collate();
                }

                $get_barrel = "SELECT id FROM " . $table_barrel;

                $get_barrel = $wpdb->get_results($get_barrel);
                if (empty($get_barrel)) {
                    $wpdb->show_errors();
                    $sql = "CREATE TABLE IF NOT EXISTS  {$table_barrel} (
                            `Id` BIGINT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
                            `Name` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `Uuid` VARCHAR(36) DEFAULT (uuid()),
                            `Phone` VARCHAR(20) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `Email` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `Date` DATETIME COLLATE utf8mb4_unicode_ci NOT NULL,
                            `Liters` VARCHAR(150) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `Style` VARCHAR(150) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `SupplierName` VARCHAR(3000) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `State` VARCHAR(150) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `City` VARCHAR(150) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `AdditionalInformation` VARCHAR(3000) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `CreatedAt` DATETIME DEFAULT CURRENT_TIMESTAMP,
                            `UpdatedAt` DATETIME ON UPDATE CURRENT_TIMESTAMP
                        ) {$collate};";
                    $wpdb->query($sql);
                }
            }
        }


        public function create_cities_table()
        {
            global $wpdb;

            $current_url = home_url($_SERVER['REQUEST_URI']);
            $url_slug = explode('/', $current_url);

            if ($url_slug[3] == 'meu-barril') {
                $table_city = $wpdb->prefix . 'cdc_cities';

                if ($wpdb->has_cap('collation')) {
                    $collate = $wpdb->get_charset_collate();
                }

                $get_cities = "SELECT id FROM " . $table_city;

                $get_cities = $wpdb->get_results($get_cities);
                if (empty($get_cities)) {

                    $cities_insert = file_get_contents(get_template_directory() . "/sql/cities.sql");

                    $sql = "CREATE TABLE IF NOT EXISTS " . $table_city . " (
                    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                    `state_id` bigint unsigned NOT NULL,
                    `uuid` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `created_at` timestamp NULL DEFAULT NULL,
                    `updated_at` timestamp NULL DEFAULT NULL,
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `cities_uuid_unique` (`uuid`),
                    KEY `cities_state_id_foreign` (`state_id`),
                    CONSTRAINT `cities_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES " . $wpdb->prefix . "cdc_states (`id`)
                ) " . $collate . ";";

                    $wpdb->query($sql);

                    // Insere todas as cidades do Brasil relacionando seus respectivos estados no banco de dados
                    // O cities_insert vem do /sql/cities.sql
                    $sql = "INSERT INTO " . $table_city . $cities_insert;

                    $wpdb->query($sql);
                }
            }
        }

        public function create_subscription_user_notification_table()
        {
            global $wpdb;

            if (get_option('created_subscription_user_notification_table') == 'yes') return;

            if ($wpdb->has_cap('collation')) {
                $collate = $wpdb->get_charset_collate();
            }

            $table = $wpdb->prefix . 'cdc_subscription_user_notification';

            $sql = "CREATE TABLE IF NOT EXISTS " . $table . " (
                `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
                `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
                `phone` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
                `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) " . $collate . ";";

            $wpdb->query($sql);

            update_option('created_subscription_user_notification_table', 'yes');
        }

        public function update_smtp_log_recipient_column_size()
        {
            global $central_da_cerveja_version;
            if (get_option('smtp_log_recipient_column_updated') == 'yes' || version_compare($central_da_cerveja_version, '1.16.1', '!=')) return;
            global $wpdb;

            $sql = "ALTER TABLE {$wpdb->prefix}wpsmtp_logs MODIFY COLUMN `to` VARCHAR(500) NOT NULL DEFAULT '0'";
            $wpdb->query($sql);

            update_option('smtp_log_recipient_column_updated', 'yes');
        }

        public function cdc_register_meta_boxes()
        {
            add_meta_box(
                'banner_page',
                'Banner',
                array($this, 'banner_meta_box'),
                'page',
                'side',
                'default'
            );
        }

        public function banner_meta_box($post)
        {
            $desktop = get_post_meta($post->ID, '_banner_desktop', true) ?? null;
            $mobile = get_post_meta($post->ID, '_banner_mobile', true) ?? null;

            echo "<p>Defina uma imagem para ser exibida após o título da página.</p>";
            echo '<p style="font-family: \'Gotham bold\';"><strong>Desktop:</strong><p>';
            echo '<input type="text" name="banner_page_desktop" id="banner_page_desktop" style="width: 100%;" value="' . $desktop . '">';
            echo '<button type="button" class="button" style="margin-top: 10px;" id="banner_page_desktop_button">Buscar</button>';
            echo "<br>";
            echo '<p style="font-family: \'Gotham bold\';"><strong>Mobile:</strong><p>';
            echo '<input type="text" name="banner_page_mobile" id="banner_page_mobile" style="width: 100%;" value="' . $mobile . '">';
            echo '<button type="button" class="button" style="margin-top: 10px;" id="banner_page_mobile_button">Buscar</button>';
            echo '
            <script>
                let image_file_frame_dektop;
                let input_image_desktop = document.getElementById("banner_page_desktop_button");
                input_image_desktop.addEventListener("click", function (event) {
                    event.preventDefault();
            
                    if (image_file_frame_dektop) {
                        image_file_frame_dektop.open();
                        return;
                    }
            
                    image_file_frame_dektop = wp.media.frames.file_frame = wp.media({
                        library: { type: "image/*" },
                        multiple: false
                    });
            
                    image_file_frame_dektop.on("select", function () {
                        var media_attachment = image_file_frame_dektop.state().get("selection").first().toJSON();
                        document.getElementById("banner_page_desktop").value = media_attachment.url;
                    });
            
                    image_file_frame_dektop.open();
            
                });

                let image_file_frame_mobile;
                let input_image_mobile = document.getElementById("banner_page_mobile_button");
                input_image_mobile.addEventListener("click", function (event) {
                    event.preventDefault();
            
                    if (image_file_frame_mobile) {
                        image_file_frame_mobile.open();
                        return;
                    }
            
                    image_file_frame_mobile = wp.media.frames.file_frame = wp.media({
                        library: { type: "image/*" },
                        multiple: false
                    });
            
                    image_file_frame_mobile.on("select", function () {
                        var media_attachment = image_file_frame_mobile.state().get("selection").first().toJSON();
                        document.getElementById("banner_page_mobile").value = media_attachment.url;
                    });
            
                    image_file_frame_mobile.open();
            
                });
            </script>';
        }

        public function cdc_save_post($post_id)
        {
            if (isset($_POST['banner_page_desktop'])) {
                update_post_meta($post_id, '_banner_desktop',$_POST['banner_page_desktop']);
            }
            if (isset($_POST['banner_page_mobile'])) {
                update_post_meta($post_id, '_banner_mobile',$_POST['banner_page_mobile']);
            }
        }

        /**
         * Obtém fornecedores com produtos em estoque.
         *
         * @param int $limit Número máximo de fornecedores a serem recuperados.
         * @return array|null Retorna um array de objetos com informações de fornecedores ou null em caso de erro.
         */
        public function get_suppliers_with_products_stock($limit = 30)
        {
            global $wpdb;

            // Verifica se o cache externo (como Redis) está ativado
            if (wp_using_ext_object_cache()) {
                // Tenta obter os dados em cache
                $cache_key = '_suppliers_with_products_stock_' . $limit;
                $cached_data = wp_cache_get($cache_key);

                if ($cached_data !== false) {
                    // Retorna os dados em cache se disponíveis
                    return $cached_data;
                }
            }



            // Consulta SQL para recuperar fornecedores com produtos em estoque
            $sql = "SELECT DISTINCT s.ID, s.post_title AS name, (
                SELECT  
                    COUNT(product.id)
                FROM {$wpdb->prefix}cdc_products AS product
                LEFT JOIN {$wpdb->prefix}postmeta AS stock ON (
                    (stock.post_id = product.id) AND 
                    (stock.meta_key = '_stock_status' AND stock.meta_value = 'instock')
                )
                LEFT JOIN {$wpdb->prefix}postmeta AS certificate ON (certificate.post_id = product.id AND certificate.meta_key = '_supplier_certificate_expired')
                WHERE product.supplier_id = s.ID AND product.status = 'publish' 
                AND (certificate.meta_value <> '1' OR certificate.meta_value IS NULL)
            ) AS total_products,
            s.post_name AS slug
            FROM {$wpdb->prefix}posts AS s
            WHERE s.post_type = 'dwcc_supplier' AND s.post_status = 'publish' HAVING total_products > 0
            ORDER BY s.post_title ASC LIMIT {$limit}";

            // Executa a consulta SQL
            $results = $wpdb->get_results($sql);

            if (wp_using_ext_object_cache()) {
                // Armazena os resultados em cache por 10 hora (36000 segundos)
                wp_cache_set($cache_key, $results, '', 36000);
            }

            return $results;
        }
    }
}

return new Central_Da_Cerveja();
