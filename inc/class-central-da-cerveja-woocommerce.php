<?php

/**
 * Central da Cerveja Class
 */

// Verifica se o arquivo foi acessado diretamente
if (!defined('ABSPATH')) {
    exit;
}

// Verifica se a classe não existe
if (!class_exists('Central_Da_Cerveja_WooCommerce')) {

    /**
     * Classe principal
     */
    final class Central_Da_Cerveja_WooCommerce
    {
        private $conn;
        private $cached_shipping_methods = null;
        private $tax_card = 0;

        public function __construct()
        {
            global $wpdb;
            $this->conn = $wpdb;
            $this->tax_card = get_option('wc_cutom_tax_per_product', 0);


            add_action('card_product_quantity_button', array($this, 'card_product_quantity_button'));

            add_filter('woocommerce_breadcrumb_defaults', array($this, 'change_breadcrumb_delimiter'));

            add_action('woocommerce_admin_order_data_after_order_details', array($this, 'is_refrigerate_product_admin'));

            add_action('product-country-flag', array($this, 'get_country_icon_by_product'));

            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 33);

            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 6);

            add_filter('woocommerce_cart_totals_order_total_html', array($this, 'cart_totals_order_total_html'));

            add_action('wp_ajax_nopriv_user_email_check', array($this, 'user_email_check'));
            add_action('wp_ajax_nopriv_user_register', array($this, 'user_register'));

            add_action('wp_ajax_nopriv_check_for_registered_cpf', array($this, 'check_for_registered_cpf'));

            add_filter('posts_join', array($this, 'search_join'));
            add_filter('posts_where', array($this, 'search_where'));
            add_filter('posts_distinct', array($this, 'search_distinct'));

            add_action('woocommerce_single_product_summary', array($this, 'single_product_atributes'), 31);
            add_filter('woocommerce_account_menu_items', array($this, 'remove_downloads_my_account'), 999);

            add_filter('woocommerce_get_script_data', array($this, 'change_view_cart_text'), 10, 6);

            add_filter('gettext', array($this, 'custom_cart_updated_message'), 10, 2);
            add_filter('wc_add_to_cart_message', array($this, 'wc_add_to_cart_message_filter'), 10, 2);

            add_action('woocommerce_order_status_changed', array($this, 'send_mail_to_more_recipient'), 10, 3);

            add_filter('woocommerce_general_settings', array($this, 'cart_time'));

            add_filter('woocommerce_general_settings', array($this, 'maintenance_mode'), 20);

            add_filter('woocommerce_get_settings_shipping', array($this, 'shipping_options_field'), 10, 2);

            add_filter('woocommerce_product_tabs', array($this, 'remove_single_product_tabs'));

            add_filter('woocommerce_add_to_cart', array($this, 'when_added_to_cart'));

            add_action('init', array($this, 'clear_logged_cart'));
            add_filter('wc_session_expiring', array($this, 'filter_ExtendSessionExpiring'));

            add_filter('wc_session_expiration', array($this, 'filter_ExtendSessionExpired'));

            add_action('wp_ajax_nopriv_check_shipping', array($this, 'check_shipping'));
            add_action('wp_ajax_check_shipping', array($this, 'check_shipping'));

            add_filter('woocommerce_checkout_update_order_review', array($this, 'remove_refrigerated_before_checkout'));

            add_action('woocommerce_thankyou', array($this, 'dont_save_discount'), 10, 2);
            add_action('woocommerce_admin_order_totals_after_discount', array($this, 'update_product_coupon_table'), 999, 3);
            add_action('woocommerce_saved_order_items', array($this, 'update_product_coupon_table'), 999, 3);

            add_action('woocommerce_after_shop_loop_item_title', array($this, 'add_product_attributes_on_product_card'), 1);

            add_action('wp_ajax_nopriv_cdc_contact_us', array($this, 'cdc_contact_us'));
            add_action('wp_ajax_cdc_contact_us', array($this, 'cdc_contact_us'));

            add_action('wp_ajax_nopriv_barrel_request', array($this, 'barrel_request'));
            add_action('wp_ajax_barrel_request', array($this, 'barrel_request'));

            add_action('wp_ajax_nopriv_list_cities_my_barrel_form', array($this, 'list_cities_my_barrel_form'));
            add_action('wp_ajax_list_cities_my_barrel_form', array($this, 'list_cities_my_barrel_form'));

            add_filter('woocommerce_shipping_fields', array($this, 'checkout_shipping_field_cpf'), 10);

            add_action('template_redirect', array($this, 'add_refrigerated_back_to_cart'));

            add_filter('woocommerce_package_rates', array($this, 'shipping_discount'), 20, 2);
            add_filter('woocommerce_cart_shipping_method_full_label', array($this, 'shipping_discount_label'), 20, 2);
            add_action('woocommerce_before_order_itemmeta', [$this, 'show_details_shipping_meta_data'], 10, 3);

            add_action('wp_ajax_nopriv_cart_timer', array($this, 'cart_timer'));
            add_action('wp_ajax_cart_timer', array($this, 'cart_timer'));

            add_action('wp_ajax_nopriv_logged_user', array($this, 'logged_user'));
            add_action('wp_ajax_logged_user', array($this, 'logged_user'));

            add_action('valid_date_cart_action', array($this, 'valid_date_cart_action'));

            add_action('woocommerce_admin_order_item_headers', array($this, 'admin_order_item_header_valid_date'), 999, 1);
            add_action('woocommerce_admin_order_item_values', array($this, 'admin_order_item_value_valid_date'), 999, 3);
            add_action('woocommerce_admin_order_item_values', array($this, 'admin_order_item_value_line_total'), 999, 3);

            add_action('woocommerce_new_order', array($this, 'save_order_value'), 10, 2);

            add_action('woocommerce_admin_order_totals_after_discount', array($this, 'custom_admin_totals'), 10, 1);

            add_action('admin_head', array($this, 'remove_shipping'), 10, 1);

            add_filter('woocommerce_persistent_cart_enabled', '__return_false');

            if (wp_is_mobile()) {
                add_theme_support('wc-product-gallery-lightbox');
                add_action('login_init', array($this, 'redirect_if_is_mobile'), 10, 1);
                add_action('admin_init',  array($this, 'redirect_if_is_mobile'));
            }

            add_action('woocommerce_billing_fields', array($this, 'required_filds_checkout_billing'), 10, 1);
            add_action('woocommerce_shipping_fields', array($this, 'required_filds_checkout_shipping'), 10, 1);

            add_filter('woocommerce_add_to_cart_fragments', array($this, 'woocommerce_header_cart_qty'));

            add_action('wp_ajax_search_products_by_name', array($this, 'search_products_by_name'));
            add_action('wp_ajax_nopriv_search_products_by_name', array($this, 'search_products_by_name'));

            add_filter('woocommerce_product_loop_title_classes', array($this, 'add_class_woocommerce_product_loop'));

            add_filter('woocommerce_get_price_html', array($this, 'bundle_sale_price'), 20, 2);

            add_filter('berocket_the_lmp_script', array($this, 'replace_autoload_image'), 11, 1);

            if (is_admin() && isset($_GET['post']) && get_post_type($_GET['post']) == 'product') {
                add_filter('sanitize_file_name', array($this, 'rename_images_before_upload'));
            }

            add_action('init', array($this, 'rename_uploaded_product_image_name'));

            add_filter('woocommerce_calculated_total', array($this, 'calculate_tax_mercado_pago'), 10, 2);

            add_filter('password_hint', array($this, 'change_password_hint'));

            add_action('woocommerce_after_checkout_validation', array($this, 'checkout_form_additional_validations'), 10, 2);

            add_action('pre_get_posts', array($this, 'product_search_conditions'));

            add_action('woocommerce_order_status_changed', array($this, 'send_cancelled_order_to_warehouse'), 10, 3);
            add_action('woocommerce_order_status_changed', array($this, 'send_cancelled_order_to_shipping'), 10, 3);

            add_action('woocommerce_cart_totals_before_shipping', array($this, 'cart_fast_delivery_warning'));
            add_action('woocommerce_cart_totals_before_shipping', array($this, 'metropolitan_48h_shipping_warning'));

            add_filter('woocommerce_checkout_fields', array($this, 'checkout_gift_order'), 10, 1);

            add_action('woocommerce_product_query', array($this, 'filter_products_on_shop_page'), 10, 1);

            add_action('woocommerce_checkout_order_created', array($this, 'woocommerce_change_payment_order_notification'), 20);
            add_filter('woocommerce_available_payment_gateways', array($this, 'woocommerce_change_payment_order'));

            add_action('wp_ajax_nopriv_cdc_subscription_email_notification', array($this, 'cdc_subscription_email_notification'));
            add_action('wp_ajax_cdc_subscription_email_notification', array($this, 'cdc_subscription_email_notification'));

            //add_filter('woocommerce_add_to_cart_redirect', array($this, 'redirect_subscription_to_cart'));
            add_filter('woocommerce_add_to_cart_validation', array($this, 'mixed_checkout_validation'), 1, 5);

            add_action('woocommerce_before_shop_loop', array($this, 'price_filter_on_shop_page'));

            add_shortcode('cdc_price_filter', array($this, 'cdc_price_filter'));

            add_filter('woocommerce_account_menu_items', array($this, 'add_payment_method_to_my_account'));
            add_filter('gettext', array($this, 'change_subscription_payment_method_text'), 999, 3);
            add_filter('woocommerce_is_sold_individually', array($this, 'remove_quantity_button_for_subscription'), 10, 2);

            if (is_cart() || is_checkout()) {
                add_action('wp_ajax_nopriv_check_value_for_free_shipping', array($this, 'check_value_for_free_shipping'));
                add_action('wp_ajax_check_value_for_free_shipping', array($this, 'check_value_for_free_shipping'));
            }


            add_filter('woocommerce_customer_meta_fields', array($this, 'remove_cellphone_from_profile'), 999);

            add_action('wp_footer', array($this, 'add_confirmation_modal_when_is_subscription'));

            add_filter('woocommerce_hpos_enable_sync_on_read', '__return_false');

            add_action('init', array($this, 'init_start_session'));

            add_action('woocommerce_cart_calculate_fees', array($this, 'remove_coupon_subscriptions'), 80);

            add_filter('upload_mimes', array($this, 'restrict_upload_mimes'), 100);

            add_action('init', array($this, 'set_payment_to_test_mode'));
            add_action('admin_init', array($this, 'set_payment_to_test_mode'));
            add_filter('themes_auto_update_enabled', '__return_false', 10, 1);
            add_action('wp_enqueue_scripts', array($this, 'remover_scripts_mp'), 100);

            add_action('wp', array($this, 'remove_from_session_payments_gateway'));

            add_action('woocommerce_checkout_process', array($this, 'check_stock_products_checkout'));

            add_filter('gettext', array($this, 'custom_translate_woocommerce_strings'), 999, 3);

            add_action('woocommerce_customer_save_address', array($this, 'save_subscription_address'), 10, 2);

            add_action('woocommerce_view_order', array($this, 'get_order_tracking'), 10, 1);
        }

        private function get_wc_shipping_methods()
        {
            global $wpdb;

            $table_name = $wpdb->prefix . 'woocommerce_shipping_zone_methods';
            $sql = "SELECT DISTINCT `method_id` FROM `{$table_name}` WHERE `is_enabled` = 1;";
            $results = $wpdb->get_col($sql);
            return $results;
        }

        private function match_prefix_and_suffix(string $haystack, array $needles): ?array
        {
            foreach ($needles as $needle) {
                if (substr($haystack, 0, strlen($needle)) === $needle) {
                    $suffix = substr($haystack, strlen($needle));
                    return [
                        'match'  => $needle,
                        'suffix' => $suffix,
                    ];
                }
            }
            return null;
        }

        public function remove_from_session_payments_gateway()
        {
            if (!is_admin() && (is_shop() || is_product() || is_product_category() || is_product_tag() || is_cart() || is_account_page())) {


                WC()->session->set('has_payment_error', 0);
                $_SESSION['error_payment_methods'] = null;
            }
        }


        function remover_scripts_mp()
        {

            if (is_wc_endpoint_url('order-pay')) {
                wp_dequeue_script('wc_mercadopago_ticket_checkout');
                $_SESSION['error_payment_methods'] = null;
            }
        }

        public function set_payment_to_test_mode()
        {
            $allowed_hosts = ['www.centraldacerveja.com.br', 'centraldacerveja.com.br'];
            $site_host = parse_url(get_site_url(), PHP_URL_HOST);

            if (in_array($site_host, $allowed_hosts, true)) {
                return;
            }

            $stripe_settings = get_option('woocommerce_stripe_settings');
            $mp_settings = get_option('checkbox_checkout_test_mode');

            if (!empty($stripe_settings) && ($stripe_settings['testmode'] ?? 'no') == 'no') {
                $stripe_settings['testmode'] = 'yes';
                update_option('woocommerce_stripe_settings', $stripe_settings);
            }

            if ($mp_settings == 'no') {
                update_option('checkbox_checkout_test_mode', 'yes');
            }
        }


        public function restrict_upload_mimes($mimes)
        {
            $mimes = [];

            $mimes['jpg|jpeg|jpe'] = 'image/jpeg';
            $mimes['gif'] = 'image/gif';
            $mimes['png'] = 'image/png';
            $mimes['bmp'] = 'image/bmp';

            return $mimes;
        }

        public function init_start_session()
        {
            if (!isset($_SESSION)) {
                session_start();
            }
        }

        public function add_confirmation_modal_when_is_subscription()
        {
            if (is_checkout()) {
                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

                    if ($_product && $_product->is_type('subscription')) {
?>
                        <div class="modal fade popup-confirm-subscription" id="confirm_subscription" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirm_subscription_title"><?php echo __('Contrato de Assinatura', 'central-da-cerveja'); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body d-flex align-items-start flex-column justify-content-start p-2 pt-3 ms-4 me-4">
                                        <div class="content-height-overflow">
                                            <div class="ms-3">
                                                <p>
                                                    Contrato de Adesão de Assinatura do Clube da Central da Cerveja
                                                </p>
                                                <p>
                                                    São partes deste contrato o “CLIENTE” ou “CONTRATANTE” que aderir ao plano de assinatura do Clube Central da Cerveja, SOMA QUADROS TH COMÉRCIO ELETRÔNICO DE BEBIDAS LTDA., pessoa jurídica de direito privado regularmente inscrita no CNPJ sob nº41.679.000/0001-47 adiante denominada “CENTRAL” ou “CONTRATADA”, ficando desde já certo e ajustado entre as partes as cláusulas e condições a seguir expostas.
                                                </p>
                                            </div>
                                            <div>
                                                <ul>
                                                    <li>1. Objeto</li>
                                                    <li>O presente instrumento tem por objeto a comercialização do produto assinatura Clube Central da Cerveja, na forma de pagamento mensal, ao CLIENTE mediante acesso e aceite, no site da CONTRATADA, do presente contrato:</li>
                                                    <li>1.1. Para adesão o CLIENTE deverá ler atentamente todo o conteúdo do contrato, e, caso concorde com todas as cláusulas, aceitar irrestritamente o termo clicando no campo “Concordo com as condições.”;</li>
                                                    <li>1.1.1. Cabe integralmente ao CLIENTE a responsabilidade pela integridade e atualização do cadastro, fornecendo corretamente todos os dados para realização do mesmo.</li>
                                                    <li>1.1.2. É de inteira responsabilidade do CLIENTE manter o ambiente de seu computador, celular ou tablet seguro, com o uso de ferramentas disponíveis como antivírus e firewall, entre outras, de modo a contribuir na prevenção de riscos eletrônicos e, ainda, utilizar-se de softwares atualizados e eficientes.</li>
                                                    <li>1.1.3. A senha cadastrada pelo CLIENTE é de uso pessoal e intransferível, sendo o CLIENTE o único responsável em caso de utilização indevida por terceiros. A senha pode ser alterada a qualquer momento pelo CLIENTE.</li>
                                                    <li>1.2. Central da Cerveja será ofertado para qualquer pessoa física ou jurídica, podendo o CLIENTE optar por adquirir uma ou todas as modalidades à época, na quantidade que desejar.</li>
                                                    <li>1.2.1. A CENTRAL reserva-se o direito de enviar uma seleção alternativa à contratada pelo CLIENTE caso não seja possível, por motivo de força maior, enviar a seleção prevista, sem que haja necessidade de prévia ciência do CLIENTE.</li>
                                                </ul>
                                                <ul>
                                                    <li>2. Benefícios de Assinantes do Central da Cerveja</li>
                                                    <li>2.1. Todo sócio do Clube Central da Cerveja faz parte do Central Prime, o clube de benefícios da Central.</li>
                                                    <li>2.2. Para o CLIENTE que assina 1 (uma) opção de Plano será concedido o desconto de 10% (dez por cento) em todas as compras de lançamentos no prazo de 48hs, a contar da entrada do produto no site, realizadas na loja Central (centraldacerveja.com.br). O desconto será automaticamente aplicado aos produtos na hora do fechamento do pedido, antes do pagamento desde que este produto já não esteja em promoção concedida pelo expositor.</li>
                                                    <li>2.3. O CLIENTE terá acesso a ofertas e promoções exclusivas.</li>
                                                    <li>2.4. O CLIENTE desfruta do frete inteligente que permite fazer infinitas compras no site ao longo do mês para que estas cervejas sejam entregues juntamente com a sua seleção, desde que o cliente faça essa opção no momento em que for finalizar a sua compra.</li>
                                                </ul>
                                                <ul>
                                                    <li>3. Vigência</li>
                                                    <li>3.1. A assinatura estará vigente a partir do aceite dos termos do contrato pelo cliente.</li>
                                                    <li>3.2. Considerando que a entrega das cervejas ocorre a partir do dia 15 de cada mês, assinaturas realizadas após o dia 10 somente receberão a seleção no mês seguinte ao da contratação.</li>
                                                    <li>3.3. O Clube de Assinatura da Central da Cerveja possui renovação automática, assim como o presente instrumento.</li>
                                                    <li>3.4. A Central se reserva ao direito de reajustar, a cada exercício, no mês de janeiro, o valor da assinatura, assim como dos valores de frete, considerando as ofertas vigentes.</li>
                                                    <li>3.5. Caso o CLIENTE não tenha interesse em renovar seu plano, optando pelo CANCELAMENTO ou ALTERAÇÃO no plano contratado, deverá entrar em contato com a Central após o recebimento de todas as seleções contempladas na assinatura, comunicando sobre a solicitação desejada.</li>
                                                </ul>
                                                <ul>
                                                    <li>4. Cancelamento</li>
                                                    <li>4.1. O cancelamento da assinatura acarretará a perda imediata de todos os benefícios oferecidos ao CLIENTE assinante.</li>
                                                    <li>4.2. A solicitação de cancelamento deverá ser realizada em até 5 (cinco) dias úteis antes da data de cobrança. Cumprido esse prazo, o cancelamento será imediato e, quando aplicável, o reembolso será realizado em até 30 (trinta) dias corridos.</li>
                                                    <li>4.3. Conforme Art. 49 do Código de Defesa do Consumidor (CDC), solicitações de cancelamento realizadas até 7 (sete) dias após a data de assinatura do contrato, serão prontamente acatadas e o valor restituído.</li>
                                                </ul>
                                                <ul>
                                                    <li>5. Cobranças</li>
                                                    <li>5.1. As cobranças são realizadas automaticamente uma vez por mês através do cartão de crédito escolhido pelo CLIENTE para adquirir o Clube.</li>
                                                    <li>5.2. Se a cobrança não tiver êxito, o CLIENTE não receberá a seleção de cervejas do próximo período.</li>
                                                </ul>
                                                <ul>
                                                    <li>6. Disposições Gerais</li>
                                                    <li>6.1. A venda é permitida apenas para maiores de 18 (dezoito) anos.</li>
                                                    <li>6.2. Os preços dos planos poderão sofrer reajustes, bem como a política de taxa de entrega, sendo o CLIENTE informado previamente.</li>
                                                    <li>6.3. O prazo de entrega é contabilizado em dias úteis. As entregas são realizadas de segunda a sexta-feira das 08h às 18h. Excepcionalmente, algumas entregas podem ocorrer aos sábados, domingos e feriados.</li>
                                                    <li>6.4. A partir da contratação, o CLIENTE declara estar ciente de que suas informações de cadastro irão constar no banco de dados da CENTRAL DA CERVEJA.</li>
                                                    <li>6.5. A CENTRAL DA CERVEJA assegura a inviolabilidade e o sigilo dos dados, garante que dados pessoais e cadastrais do CLIENTE não são disponibilizados a terceiros.</li>
                                                    <li>6.6. O CLIENTE autoriza a CENTRAL DA CERVEJA a contatá-lo através de todas as formas possíveis (e-mail, telefone, SMS, WhatsApp e Push), podendo, inclusive, enviar e-mails de promoções e propagandas.</li>
                                                    <li>6.6.1. O CLIENTE se declara ciente e aceita que pode receber comunicações ou promoções segmentadas de acordo com o seu perfil transacional ou comportamental. Ou seja, cada CLIENTE pode receber, ou deixar de receber, comunicações da marca, já que são enviadas de forma distinta e adequada para o seu perfil mapeado.</li>
                                                    <li>6.7. A contratação da presente assinatura não gerará ao CLIENTE nenhum outro direito ou vantagem que não esteja expressamente previsto neste regulamento.</li>
                                                    <li>6.8. Se qualquer previsão do presente contrato for considerada inválida, inexequível ou nula, as demais disposições permanecerão válidas.</li>
                                                    <li>6.9. A CENTRAL DA CERVEJA se reserva no direito de, a qualquer momento, suspender ou cancelar a conta do CLIENTE que descumprir quaisquer dispositivos contidos no presente instrumento ou que praticar atos fraudulentos. Em caso de suspeita de fraude, os pedidos serão bloqueados e os valores pagos serão estornados ao CLIENTE.</li>
                                                    <li>6.10. O presente regulamento poderá ser alterado a qualquer momento pela CENTRAL DA CERVEJA, a seu exclusivo critério. Neste caso, todas as modificações serão devidamente publicadas no site </li>
                                                    <li>6.11. A CENTRAL DA CERVEJA não será considerada em mora ou inadimplente em relação a qualquer direito ou obrigação previstos neste regulamento se o motivo ou descumprimento decorrer de caso fortuito ou força maior, na forma estabelecida pelo Código Civil Brasileiro.</li>
                                                    <li>6.12. O domicílio do cliente será o foro competente para dirimir eventuais divergências sobre este instrumento.</li>
                                                    <li>6.13. Não serão aceitas participações por quaisquer outros meios que não pelos previstos neste regulamento.</li>
                                                    <li>6.14. Os descontos estabelecidos não são cumulativos com as demais promoções da CENTRAL DA CERVEJA, salvo quando autorizados pontual e expressamente pela CENTRAL DA CERVEJA, a seu exclusivo critério.</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <p>Tendo em vista estes aspectos, você se declara ciente e de acordo com estas condições?</p>
                                            <p><input type="checkbox" id="checkbox_confirm_subscription"><label for="checkbox_confirm_subscription" id="subscription_accept_conditions">&nbsp;Concordo com as condições.</label></p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo __('FECHAR', 'central-da-cerveja'); ?></button>
                                        <a href="javascript:void(0)" type="button" id="confirm_purchase" class="btn btn-access"><?php echo __('CONFIRMAR COMPRA', 'central-da-cerveja'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php
                    }
                }
            }
        }

        public function remove_cellphone_from_profile($fields)
        {
            unset($fields['billing']['fields']['billing_cellphone']);

            return $fields;
        }

        public function remove_quantity_button_for_subscription($return, $product)
        {
            if ($product->is_type('subscription')) return true;
            return false;
        }

        function change_subscription_payment_method_text($translation, $text, $domain)
        {
            if ($text == 'Update the Payment Method used for all of my active subscriptions.') {
                $translation = 'Atualizar método de pagamento utilizado para todas as assinaturas ativas.';
            }
            return $translation;
        }

        function add_payment_method_to_my_account($items)
        {
            $logout = $items['customer-logout'];
            $edit_account = $items['edit-account'];
            unset($items['customer-logout']);
            unset($items['edit-account']);
            $items['payment-methods'] = "Métodos de pagamento";
            $items['edit-account'] = $edit_account;
            $items['customer-logout'] = $logout;
            return $items;
        }

        function price_filter_on_shop_page()
        {
            if (is_shop() && isset($_GET['s'])) return;
            echo do_shortcode('[cdc_price_filter page="/loja"]');
        }

        function cdc_price_filter($atts)
        {
            $page = $atts['page'];
            $show_filter = isset($_GET['filter']) && $_GET['filter'] == 'price' ? 'display:block;' : 'display:none;';
            $html = '<div class="container">
                        <div class="col">
                        <div class="toggle-price-filter">
                                <span id="toggle_price_filter">Exibir filtro por preço</span>
                        </div>
                            <div class="col">
                        <div class="filter-by-price-wrapper" style="' . $show_filter . '">
                            <form method="get">
                                <div class="filter-by-price">
                                    <div class="filter-by-price-range">
                                        <input type="text" id="min_price" name="min_price" value="" placeholder="Mín.">
                                        <input type="text" id="max_price" name="max_price" value="" placeholder="Máx.">
                                    </div>
                                    <div>
                                        <button class="button btn filter-by-price-button mt-1" type="submit">Filtrar</button>
                                    </div>
                                </div>
                            </form>
                            <div class="filter-by-price-values mt-2">
                                <div>
                                    <a href="' . $page . '?min_price=0&max_price=10" class="price_range"> De 0 a 10</a>
                                </div>
                                <div>
                                    <a href="' . $page . '?min_price=10&max_price=20" class="price_range"> De 10 a 20</a>
                                </div>
                                <div>
                                    <a href="' . $page . '?min_price=20&max_price=30" class="price_range"> De 20 a 30</a>
                                </div>
                                <div>
                                    <a href="' . $page . '?min_price=30&max_price=40" class="price_range"> De 30 a 40</a>
                                </div>
                                <div>
                                    <a href="' . $page . '?min_price=40&max_price=50" class="price_range"> De 40 a 50</a>
                                </div>
                                <div>
                                    <a href="' . $page . '?min_price=50&max_price=100" class="price_range"> De 50 a 100</a>
                                </div>
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>';

            return $html;
        }

        function filter_products_on_shop_page($query)
        {

            if (!is_shop() || isset($_GET['s'])) return;

            $product_categories = get_terms();

            $exclude_categories = [];
            foreach ($product_categories as $key => $cat) {
                if ($cat->slug == "subscription") {
                    unset($product_categories[$key]);
                    array_push($exclude_categories, $cat->slug);
                }
            }
            $tax_query = $query->get('tax_query');
            $tax_query[] = array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    =>  $exclude_categories,
                'operator' => 'NOT IN'
            );

            $min_price_query = '';
            $max_price_query = '';

            if (isset($_GET['min_price'])) {
                $min_price = str_contains($_GET['min_price'], ',') ? str_replace(',', '.', $_GET['min_price']) : $_GET['min_price'];

                $min_price_query = array(
                    'key'     => '_price',
                    'value'   => $min_price,
                    'type'    => 'numeric',
                    'compare' => '>=',
                );
            }
            if (isset($_GET['max_price'])) {
                $max_price = str_contains($_GET['max_price'], ',') ? str_replace(',', '.', $_GET['max_price']) : $_GET['max_price'];

                $max_price_query = array(
                    'key'     => '_price',
                    'value'   => $max_price,
                    'type'    => 'numeric',
                    'compare' => '<=',
                );
            }

            $meta_query = array(
                $min_price_query,
                $max_price_query,
                array(
                    array(
                        'key' => '_supplier_certificate_expired',
                        'compare' => 'NOT EXISTS'
                    ),
                    'relation' => 'OR',
                    array(
                        'key' => '_supplier_certificate_expired',
                        'value' => 1,
                        'compare' => '!='
                    ),
                )
            );

            $query->set('meta_query', $meta_query);
            $query->set('tax_query', $tax_query);
        }


        /**
         * Retorna os Ids
         */
        public function get_all_expired_products_ids_ordered_by_approve()
        {
            try {
                $days_to_expire = get_option('days_to_expire', 10);
                $ids = array();
                $current_date = new DateTime("now", new DateTimeZone('America/Sao_Paulo'));
                $current_date = $current_date->format('Y-m-d');

                $future_date = new DateTime("now", new DateTimeZone('America/Sao_Paulo'));
                $future_date->modify('+' . $days_to_expire . 'day');
                $future_date = $future_date->format('Y-m-d');

                $results = $this->conn->get_results("
                    SELECT DISTINCT `product_id` AS `id`, `ticket_id` FROM `{$this->conn->prefix}cdc_ticket_products`
                    INNER JOIN `{$this->conn->prefix}postmeta` ON (product_id = `{$this->conn->prefix}postmeta`.post_id AND ( `meta_key` = '_stock_status' AND `meta_value` = 'instock'))
                    WHERE `date` IS NOT NULL AND `date` BETWEEN '{$current_date}' AND '{$future_date}';", ARRAY_A);

                if (!empty($results)) {
                    foreach ($results as $result) {
                        $valid_ticket_id = $this->oldest_ticket_in_stock($result['id']);
                        if ($result['ticket_id'] == $valid_ticket_id) array_push($ids, $result['id']);
                    }
                }
                return $ids;
            } catch (Exception $ex) {
                error_log('Falha ao buscar os ids dos produtos a vencer: ' . $ex->getMessage());
                return array();
            }
        }

        public function checkout_gift_order($fields)
        {
            $fields['shipping']['shipping_gift_order'] = array(
                'required'  => false,
                'clear'     => true,
                'type'      => 'hidden',
                'class'     => 'checkout-gift-order'
            );

            $fields['shipping']['shipping_gift_from'] = array(
                'required'  => false,
                'clear'     => true,
                'type'      => 'hidden',
                'class'     => 'checkout-gift-order'
            );

            $fields['shipping']['shipping_gift_to'] = array(
                'required'  => false,
                'clear'     => true,
                'type'      => 'hidden',
                'class'     => 'checkout-gift-order'
            );

            $fields['shipping']['shipping_gift_message'] = array(
                'required'  => false,
                'clear'     => true,
                'type'      => 'hidden',
                'class'     => 'checkout-gift-order'
            );

            return $fields;
        }


        public function cart_fast_delivery_warning()
        {
            $shipping_method = WC()->session->get('chosen_shipping_methods')[0];
            if (empty($shipping_method)) return;
            $fast_delivery_time_limit = get_option('fast_delivery_limit_time');
            $date = new DateTime("now", new DateTimeZone('America/Sao_Paulo'));

            if (strtotime($fast_delivery_time_limit) < strtotime($date->format('H:i')) && $shipping_method == str_starts_with($shipping_method, 'gold-fast')) {
                echo "<span class='fast-time-limit'>Pedidos realizados depois das {$fast_delivery_time_limit}, serão entregues no dia seguinte.</span>";
            }
        }

        public function metropolitan_48h_shipping_warning()
        {
            $shipping_method = WC()->session->get('chosen_shipping_methods')[0];
            if (empty($shipping_method)) return;
            $metropolitan_48h_shipping_limit = get_option('metropolitan_48h_shipping_limit', 18);

            if ($shipping_method == str_starts_with($shipping_method, 'metropolitan-48h-shipping')) {
                echo "<p class='fast-time-limit'>Pedidos feitos até as {$metropolitan_48h_shipping_limit} serão entregues no dia seguinte.</p>";
                echo "<p class='fast-time-limit'>Pedidos após as {$metropolitan_48h_shipping_limit} serão entregues no dia seguinte + 1.</p>";
            }
        }

        public function send_cancelled_order_to_shipping($order_id, $old_status, $new_status)
        {

            if ($new_status != 'cancelled') return;

            $cancelled_settings = get_option('woocommerce_cdc_shipping_order_cancelled_settings');

            if (!isset($cancelled_settings['enabled']) && $cancelled_settings['enabled'] != 'yes') return;

            $headers[] = 'Content-Type: text/html; charset=UTF-8';
            $headers[] = 'From: Central da Cerveja <noreply@centraldacerveja.com.br> ' . "\r\n";

            $subject_shipping = !empty($cancelled_settings['subject']) ? $cancelled_settings['subject'] : __('Pedido Cancelado', 'central-da-cerveja');

            preg_match_all('/\\{(.*?)\\}/', $subject_shipping, $matches, PREG_SET_ORDER);

            $order = wc_get_order($order_id);
            $values = [
                'order_date' => wc_format_datetime($order->get_date_created()),
                'order_number' => $order_id,
                'order_billing_full_name' => $order->get_formatted_billing_full_name()
            ];

            if (!empty($matches)) {
                $subject_shipping = $this->replace_email_subject($matches, $values, $subject_shipping);
            }

            $emails = preg_split('/\s*,\s*/', $cancelled_settings['recipient'], -1, PREG_SPLIT_DELIM_CAPTURE);
            $to = array_filter($emails, function ($email) {
                return filter_var($email, FILTER_VALIDATE_EMAIL);
            });
            $this->send_mail($to, $subject_shipping, $headers, $order_id, 'shipping-cancelled-order');
        }

        private function replace_email_subject($matches, $values, $subject)
        {
            foreach ($matches as $match) {
                $subject = str_replace($match[0], $values[$match[1]], $subject);
            }

            return $subject;
        }

        public function send_cancelled_order_to_warehouse($order_id, $old_status, $new_status)
        {

            if ($new_status != 'cancelled') return;

            $cancelled_settings = get_option('woocommerce_cdc_werehouse_order_cancelled_settings');
            if (!isset($cancelled_settings['enabled']) && $cancelled_settings['enabled'] != 'yes') return;

            $headers[] = 'Content-Type: text/html; charset=UTF-8';
            $headers[] = 'From: Central da Cerveja <noreply@centraldacerveja.com.br> ' . "\r\n";

            $subject_werehouse = !empty($cancelled_settings['subject']) ? $cancelled_settings['subject'] : __('Pedido Cancelado', 'central-da-cerveja');

            preg_match_all('/\\{(.*?)\\}/', $subject_werehouse, $matches, PREG_SET_ORDER);

            $order = wc_get_order($order_id);
            $values = [
                'order_date' => wc_format_datetime($order->get_date_created()),
                'order_number' => $order_id,
                'order_billing_full_name' => $order->get_formatted_billing_full_name()
            ];

            if (!empty($matches)) {
                $subject_werehouse = $this->replace_email_subject($matches, $values, $subject_werehouse);
            }

            $emails = preg_split('/\s*,\s*/', $cancelled_settings['recipient'], -1, PREG_SPLIT_DELIM_CAPTURE);
            $to = array_filter($emails, function ($email) {
                return filter_var($email, FILTER_VALIDATE_EMAIL);
            });
            $this->send_mail($to, $subject_werehouse, $headers, $order_id, 'warehouse-cancelled-order');
        }

        public function product_search_conditions($query)
        {
            if (is_archive()) {
                $taxonomy = isset($query->queried_object->taxonomy) ? $query->queried_object->taxonomy : null;

                if ($query->is_main_query() && str_starts_with($taxonomy, 'pa_por-') && $taxonomy != 'pa_por-cervejaria') {
                    $query->set(
                        'meta_query',
                        array(
                            array(
                                'key' => '_stock_status',
                                'value' => 'outofstock',
                                'compare' => 'NOT IN'
                            ),
                            'relation' => 'AND',
                            array(
                                array(
                                    'key' => '_commercialize_on_kit',
                                    'compare' => 'NOT EXISTS'
                                ),
                                'relation' => 'OR',
                                array(
                                    'key' => '_commercialize_on_kit',
                                    'value' => 1,
                                    'compare' => '!='
                                ),
                            ),
                            array(
                                array(
                                    'key' => '_supplier_certificate_expired',
                                    'compare' => 'NOT EXISTS'
                                ),
                                'relation' => 'OR',
                                array(
                                    'key' => '_supplier_certificate_expired',
                                    'value' => 1,
                                    'compare' => '!='
                                ),
                            )
                        )
                    );
                }
            }
        }

        public function calculate_tax_mercado_pago($total, $cart)
        {
            // Apenas no frontend
            if (is_admin()) {
                return $total;
            }

            // Pega os valores atuais do carrinho
            $subtotal = $cart->get_subtotal();
            $totals = $cart->get_totals();
            $discount_total = isset($totals['discount_total']) ? $totals['discount_total'] : 0;

            // Desconto por carteira
            $wallet_discount = WC()->session->get('wallet_discount') == null
                ? 0
                : WC()->session->get('discount_amount_wallet');

            // Taxas adicionadas via add_fee
            $fees_total = 0;
            foreach ($cart->get_fees() as $fee) {
                $fees_total += $fee->amount;
            }

            // Obtém o método de envio selecionado
            $chosen_methods = WC()->session->get('chosen_shipping_methods');
            $chosen_shipping = is_array($chosen_methods) ? reset($chosen_methods) : null;

            // Recupera o valor de frete com taxa correspondente
            $shipping_tax = 0;
            if ($chosen_shipping) {
                $free = WC()->session->get("cart_shipping_free_{$chosen_shipping}", 0);
                if (!$free) {
                    $shipping_tax = WC()->session->get("cart_shipping_with_tax_{$chosen_shipping}", 0);
                }
            }

            // Novo total: subtotal - descontos + taxas + frete com taxa
            $calculated_total = ($subtotal - $discount_total - $wallet_discount) + $fees_total + $shipping_tax;

            return $calculated_total;
        }



        function replace_autoload_image(array $autoload_settings): array
        {
            $image = '<div class="lmp_products_loading text-center">';
            $image .= '<img src="' . get_template_directory_uri() . '/assets/img/CentralDaCerveja-Logo.png" class="img-fluid heartbeat" width="40">';
            $image .= '<span class="ms-3 autoload-span">' . __('Carregando...', 'central-da-cerveja') . '</span>';
            $image .= '</div>';
            $autoload_settings['load_image'] = $image;
            return $autoload_settings;
        }

        function bundle_sale_price($price_html, $product)
        {
            if (!$product->is_type('bundle')) return $price_html;

            if ($product->is_type('bundle')) {
                $sum = 0;
                foreach ($product->bundle_data as $bundle) {
                    $sum += $bundle['original_price'] >= $bundle['price_shop'] ? $bundle['original_price'] * $bundle['quantity'] : $bundle['price_shop'] * $bundle['quantity'];
                }

                if (wc_price($sum) == $price_html) {
                    return $price_html;
                }

                $price_html = wc_format_sale_price(wc_price($sum), wc_get_price_to_display($product, array('price' => $product->get_regular_price()))) . $product->get_price_suffix();
            }
            return $price_html;
        }

        private function filter_products_or_entity($filter)
        {
            global $wpdb;

            $filter = sanitize_text_field($filter);

            $suppliers = $wpdb->get_col($wpdb->prepare("
                SELECT ID
                FROM {$wpdb->posts}
                WHERE post_title LIKE %s
                AND post_type = 'dwcc_supplier'
                LIMIT 20
            ", '%' . $wpdb->esc_like($filter) . '%'));

            if (empty($suppliers)) {
                $suppliers = [0];
            }

            $like = '%' . $wpdb->esc_like($filter) . '%';

            $sql = $wpdb->prepare("
                SELECT 
                    p.id,
                    p.name,
                    p.slug,
                    p.supplier_id,
                    p.approved_date_product,
                    p.image
                FROM vludavcbertkv_cdc_products AS p
                WHERE (
                        p.name LIKE %s OR
                        p.slug LIKE %s OR
                        p.excerpt LIKE %s OR
                        p.description LIKE %s OR
                        p.supplier_id IN (" . implode(',', array_map('intval', $suppliers)) . ")
                )
                AND p.status = 'publish'
                AND (p.commercialize_on_kit IS NULL OR p.commercialize_on_kit != 1)
                ORDER BY p.name ASC
                LIMIT 10
            ", $like, $like, $like, $like);

            $products = $wpdb->get_results($sql, ARRAY_A);
            if (empty($products)) return [];


            $ids = array_column($products, 'id');
            $ids_str = implode(',', array_map('intval', $ids));

            $wp_meta = $wpdb->get_results("
                SELECT 
                    post.ID,
                    pm_sale.meta_value AS sale_price,
                    pm_regular.meta_value AS regular_price,
                    pm_thumbnail.meta_value AS thumbnail_id,
                    pm_image.meta_value AS image,
                    pm_kit.meta_value AS kit_full_price,
                    pm_approved.meta_value AS approved_date,
                    pm_supplier.meta_value AS supplier_id_real,
                    pm_ipi.meta_value AS ipi
                FROM {$wpdb->posts} AS post
                LEFT JOIN {$wpdb->postmeta} AS pm_sale 
                    ON pm_sale.post_id = post.ID AND pm_sale.meta_key = '_sale_price'
                LEFT JOIN {$wpdb->postmeta} AS pm_regular 
                    ON pm_regular.post_id = post.ID AND pm_regular.meta_key = '_regular_price'
                LEFT JOIN {$wpdb->postmeta} AS pm_thumbnail 
                    ON pm_thumbnail.post_id = post.ID AND pm_thumbnail.meta_key = '_thumbnail_id'
                LEFT JOIN {$wpdb->postmeta} AS pm_image 
                    ON pm_image.post_id = pm_thumbnail.meta_value AND pm_image.meta_key = '_wp_attached_file'
                LEFT JOIN {$wpdb->postmeta} AS pm_kit
                    ON pm_kit.post_id = post.ID AND pm_kit.meta_key = '_kit_full_price'
                LEFT JOIN {$wpdb->postmeta} AS pm_approved
                    ON pm_approved.post_id = post.ID AND pm_approved.meta_key = '_approved_date_product'
                LEFT JOIN {$wpdb->postmeta} AS pm_supplier
                    ON pm_supplier.post_id = post.ID AND pm_supplier.meta_key = '_supplier_id'
                LEFT JOIN {$wpdb->postmeta} AS pm_ipi
                    ON pm_ipi.post_id = pm_supplier.meta_value AND pm_ipi.meta_key = '_ipi_tax'
                WHERE post.ID IN ($ids_str)
                AND post.post_type = 'product'
                LIMIT 100
            ", ARRAY_A);


            $suppliers_data = [];
            if (!empty($suppliers)) {
                $supplier_rows = $wpdb->get_results("
                    SELECT ID, post_title
                    FROM {$wpdb->posts}
                    WHERE ID IN (" . implode(',', array_map('intval', $suppliers)) . ")
                ", ARRAY_A);

                foreach ($supplier_rows as $s) {
                    $suppliers_data[$s['ID']] = $s['post_title'];
                }
            }

            $response = [];

            foreach ($products as $p) {
                $id = $p['id'];
                $meta = $wp_meta[$id] ?? null;

                $supplier_id = $meta['supplier_id_real'] ?? $p['supplier_id'];
                $supplier_name = $suppliers_data[$supplier_id] ?? null;

                $response[] = [
                    "ID"            => (string)$id,
                    "post_title"    => $p['name'],
                    "post_name"     => $p['slug'],
                    "sale_price"    => $meta['sale_price'] ?? 0,
                    "regular_price" => $meta['regular_price'] ?? 0,
                    "image"         => $meta['image'] ?? $p['image'],
                    "kit_full_price" => $meta['kit_full_price'] ?? 0,
                    "approved_date" => $meta['approved_date'] ?? $p['approved_date_product'],
                    "supplier_name" => $supplier_name,
                    "ipi"           => $meta['ipi'] ?? "0",
                ];
            }

            return $response;
        }


        private function is_valid_product_discount_subscription($product)
        {

            if (function_exists('wcs_user_has_subscription') && !wcs_user_has_subscription(get_current_user_id(), '', 'active')) return false;

            $discount_value = get_option('discount_percentage_subscription', 0);
            $valid_hours = get_option('discount_hours_subscription', 0);
            if ($discount_value == 0) return false;
            if ($valid_hours == 0) return false;

            $product_approved_date =  get_post_meta($product['ID'], '_approved_date_product', true);

            if (empty($product_approved_date)) return false;

            $newDate = strtotime($product_approved_date);

            $date_now = new DateTime(date('Y-m-d H:i'));
            $date_time = new DateTime(date('Y-m-d H:i', $newDate));
            $diff = $date_now->diff($date_time);

            if (!(($diff->h + ($diff->days * 24)) <= $valid_hours)) return false;

            return $discount_value;
        }

        private function calculate_discount($discount, $product_value)
        {
            if ($discount == false) return 0;
            $discount = $product_value - ($product_value / (100 / (float)str_replace(',', '.', $discount)));
            return $discount;
        }

        public function search_products_by_name()
        {
            $response = $this->filter_products_or_entity($_POST['filter']);
            if (empty($response)) {
                return wp_send_json([
                    'response' => 'Produto Não Encontrado',
                ], 404);
            }

            foreach ($response as $key => $product) {
                $price = $product['sale_price'] != null ? $product['sale_price'] : $product['regular_price'];
                $discount = $this->calculate_discount($this->is_valid_product_discount_subscription($product), $price);
                $response[$key]['regular_price'] = $price;
                $response[$key]['sale_price'] = $discount;
            }

            return wp_send_json([
                'response' => $response
            ], 200);
        }

        function woocommerce_header_cart_qty($fragments)
        {
            ob_start();
            $cart_product_qty = WC()->cart->get_cart_contents_count();
            ?>
            <div class="hide-counter-if-cart-empty" style="<?php echo $cart_product_qty > 0 ? '' : 'display:none;'; ?>">
                <div id="cart_header_qty_background"></div>
                <span class="cart_icon_product_qty">
                    <?php

                    echo $cart_product_qty > 0 ? $cart_product_qty : '';
                    ?>
                </span>
            </div>
        <?php
            $fragments['div.hide-counter-if-cart-empty'] = ob_get_clean();
            return $fragments;
        }

        public function required_filds_checkout_shipping($fields)
        {
            $fields['shipping_neighborhood']['required'] = true;
            return $fields;
        }

        public function required_filds_checkout_billing($fields)
        {
            $fields['billing_neighborhood']['required'] = true;
            $fields['billing_phone']['label'] = __('Celular');

            return $fields;
        }

        public function redirect_if_is_mobile()
        {
            $admin_page = get_site_url() . '/painel/';
            $wp_admin_url = get_admin_url();
            $current_url = home_url($_SERVER['REQUEST_URI']);

            if ($admin_page == $current_url || $wp_admin_url == $current_url) {
                wp_redirect('/login-nao-permitido');
            }
        }


        public function logged_user()
        {
            if (isset($_SESSION['is_avaible_shipping_method']) && !empty($_SESSION['is_avaible_shipping_method'])) {
                wp_send_json([
                    'is_avaible' => true,
                    'is_logged' => is_user_logged_in(),
                ]);
            }
            wp_send_json([
                'is_avaible' => false,
                'is_logged' => is_user_logged_in(),
            ]);
        }

        public function remove_shipping($order)
        {
            echo "<style>
                    .wc-order-totals > tbody tr:nth-child(3n+6) {
                        display: none !important;
                    }
                </style>";
        }

        public function custom_admin_totals($order_id)
        {
            $order = wc_get_order($order_id);
            $shipping_total = $order->get_shipping_total();
            $shipping_value_total = $order->get_meta('shipping_total_value', true);
            $shipping_total_value = !empty($shipping_value_total) ? $shipping_value_total : $shipping_total;

            $shipping_without_tax = $order->get_meta('shipping_value', true);
            $shipping_without_tax = !empty($shipping_without_tax) ? number_format($shipping_without_tax, 2) : $shipping_total_value;
            $shipping_with_tax = $order->get_meta('shipping_total_value', true) ?? 0;


            $has_free_shipping = $order->get_meta('shipping_free', true) ?? 0;

            $shipping_price_difference = floatval($shipping_with_tax) - floatval($shipping_without_tax);
            $paid_shipping = ($has_free_shipping) ? wc_price(0) : wc_price($shipping_total_value) . " ( " . wc_price($shipping_price_difference) . " )";
            $free_shipping = ($has_free_shipping) ? "Sim" : "Não";

            $coupon_applied = wc_get_order($order_id)->discount_total > 0 ? true : false;
            $insert_tr = $coupon_applied ? "" : "<tr></tr>";
            echo "<tr>
                    <td class='label'>Frete Transportadora:</td>
                    <td width='1%'></td>
                    <td style='width: 160px !important;' class='total'>
                       " . wc_price($shipping_without_tax) . "
    				</td>
                </tr>
                <tr>
                    <td class='label'>Frete Pago:</td>
                    <td width='1%'></td>
                    <td title='Valor da Taxa' style='width: 160px !important;' class='total'>
                       $paid_shipping
    				</td>
                </tr>
                <tr>
                    <td class='label'>Frete Grátis:</td>
                    <td width='1%'></td>
                    <td style='width: 160px !important;' class='total'>
                       $free_shipping
    				</td>
                </tr>
                $insert_tr";
        }

        function checkout_shipping_field_cpf($fields)
        {

            $fields['shipping_cpf']   = array(
                'label'     => __('CPF', 'central-da-cerveja'),
                'required'  => true,
                'class'     => array('form-row-wide'),
                'clear'     => true,
                'priority'  => 20,
            );

            return $fields;
        }

        public function save_order_value($order_id, $order)
        {
            if (is_admin() || !WC()->session) {
                return;
            }

            $order = wc_get_order($order_id);

            // Obtém o método de envio selecionado
            $chosen_methods = WC()->session->get('chosen_shipping_methods');
            $chosen_shipping = is_array($chosen_methods) ? reset($chosen_methods) : null;

            if ($chosen_shipping) {
                // Recupera valores da sessão baseados no método selecionado
                $shipping_value = WC()->session->get("cart_shipping_without_tax_{$chosen_shipping}", 0);
                $shipping_total_value = WC()->session->get("cart_shipping_with_tax_{$chosen_shipping}", 0);
                $original = WC()->session->get("cart_shipping_original_cost_{$chosen_shipping}", 0);
                $shipping_free = WC()->session->get("cart_shipping_free_{$chosen_shipping}", 0);
                $shipping_fee_additional_percentage = WC()->session->get("cart_shipping_fee_additional_percentage_{$chosen_shipping}", 0);
                $shipping_fee_additional = WC()->session->get("cart_shipping_fee_additional_{$chosen_shipping}", 0);


                // Valor total do pedido (bruto + desconto)
                $value = $order->get_total() + $order->get_discount_total();

                // Salva valores no pedido
                $order->update_meta_data('_shipping_cost', $original);
                $order->update_meta_data('shipping_value', $shipping_value);
                $order->update_meta_data('shipping_total_value', $shipping_total_value);
                $order->update_meta_data('order_value', $value);
                $order->update_meta_data('shipping_free', $shipping_free);
                $order->update_meta_data('shipping_fee_additional_percentage', $shipping_fee_additional_percentage);
                $order->update_meta_data('shipping_fee_additional', $shipping_fee_additional);

                $order->save();
            }
        }

        function cart_timer()
        {
            $_SESSION['added_to_cart'] = (new DateTime)->getTimeStamp() + (60 * get_option('cart_time', 5));

            wp_send_json(array(
                'status' => true,
                'date' => date('Y/m/d H:i:s', $_SESSION['added_to_cart'])
            ));
        }

        function add_refrigerated_back_to_cart()
        {

            $ids = WC()->session->get('refrigerated_product_id');
            $qty = WC()->session->get('refrigerated_product_qty');
            $isRemoved = WC()->session->get('removed_on_checkout');

            if (is_cart()) {
                if (isset($ids) && isset($isRemoved)) {

                    foreach ($ids as $key => $add_again) {

                        WC()->cart->add_to_cart($add_again, $qty[$key]);
                    }
                    WC()->session->set('refrigerated_product_id', null);
                    WC()->session->set('refrigerated_product_qty', null);
                    WC()->session->set('removed_on_checkout', null);
                }
            }

            if (is_wc_endpoint_url('order-received')) {
                WC()->session->set('refrigerated_product_id', null);
                WC()->session->set('refrigerated_product_qty', null);
            }
        }

        /**
         * Ajusta dinamicamente os valores dos métodos de envio no carrinho e checkout.
         *
         * Este método atua como callback do filtro `woocommerce_package_rates`, permitindo
         * modificar os custos de frete antes de serem exibidos ao cliente. Ele aplica lógica
         * de desconto de frete (inclusive frete grátis) com base no subtotal do carrinho,
         * cupons aplicados e configurações personalizadas de frete.
         *
         * Fluxo da lógica:
         *  - Verifica se o carrinho está ativo e não vazio.
         *  - Calcula o subtotal líquido do carrinho, considerando cupons de desconto aplicados.
         *  - Itera sobre as opções de frete disponíveis.
         *  - Obtém as configurações de cada método de envio (cache local por ID de método).
         *  - Salva valores originais (sem taxa) em sessão para referência futura.
         *  - Aplica cálculo adicional de taxa caso configurado em `$this->tax_card`.
         *  - Se atingir a regra de frete grátis definida nas configurações, zera o custo.
         *  - Caso contrário, aplica o custo original acrescido da taxa.
         *  - Adiciona metadados úteis ao método de envio (valor original, com/sem taxa, frete grátis).
         *
         * @hooked woocommerce_package_rates
         *
         * @param array $rates   Lista de objetos `WC_Shipping_Rate` representando os métodos de envio
         *                       disponíveis no carrinho/checkout.
         * @param array $package Pacote de envio do WooCommerce, contendo dados dos itens do carrinho
         *                       agrupados para cálculo de frete.
         *
         * @return array Lista de métodos de envio atualizada, com valores ajustados e metadados
         *               adicionais para uso em templates e outros hooks.
         *
         * Exemplo de registro:
         * add_filter(
         *     'woocommerce_package_rates',
         *     [$this, 'shipping_discount'],
         *     20,
         *     2
         * );
         */
        public function shipping_discount($rates, $package)
        {
            // Verifica se o carrinho está disponível
            if (is_admin() && !defined('DOING_AJAX')) {
                return $rates;
            }

            // Verifica se o carrinho está vazio
            if (WC()->cart->is_empty()) {
                return $rates;
            }

            $has_coupon = WC()->cart->get_applied_coupons();
            $discount_coupon = 0;

            if (count($has_coupon) > 0) {
                $discount_coupon = WC()->cart->get_cart_discount_total();
            }

            $subtotal = WC()->cart->get_subtotal();
            $subtotal = max(0, ($subtotal - $discount_coupon));

            // Cache local das configurações de cada método de frete
            $shipping_settings_cache = [];
            $tax_card = $this->tax_card ?? 0;
            $fee_additional_percentage = 0;
            $fee_additional = 0;
            foreach ($rates as $rate_key => $rate) {
                // Reseta sessões
                WC()->session->set("cart_shipping_free_{$rate_key}", 0);
                WC()->session->set("cart_shipping_without_tax_{$rate_key}", null);
                WC()->session->set("cart_shipping_with_tax_{$rate_key}", null);
                WC()->session->set("cart_shipping_tax_card_{$rate_key}", null);
                WC()->session->set("cart_shipping_fee_additional_{$rate_key}", null);
                WC()->session->set("cart_shipping_fee_additional_percentage_{$rate_key}", null);

                // Identificador único do método
                if (!isset($package['rates'][$rate_key])) {
                    continue;
                }

                $method_id = $package['rates'][$rate_key]->get_id();

                // Cache das configurações
                if (!isset($shipping_settings_cache[$method_id])) {
                    $shipping_settings_cache[$method_id] = $this->get_shipping_options($method_id);
                }

                $settings = $shipping_settings_cache[$method_id];

                // Salva o valor original
                $original_cost = $rate->cost;

                // Detecta tipo do método
                $is_subscription = str_contains($rate_key, 'subscription-shipping');

                // Salva valor sem taxa
                WC()->session->set("cart_shipping_tax_card_{$rate_key}", $this->tax_card);
                WC()->session->set("cart_shipping_original_cost_{$rate_key}", $original_cost);

                // Calcula a taxa adicional se aplicável
                if (isset($settings['fee_additional']) && !empty($settings['fee_additional']) && $settings['fee_additional'] > 0) {
                    $fee_additional_percentage = $settings['fee_additional'];
                    $fee_additional = (!$is_subscription) ? ($original_cost * ($fee_additional_percentage / 100)) : 0;
                }

                // Calcula a taxa de cartão se aplicável
                $tax_amount = (!$is_subscription && $tax_card > 0) ? (($original_cost + $fee_additional) * ($tax_card / 100)) : 0;

                // Valor com taxa
                $shipping_with_tax = $original_cost + $tax_amount + $fee_additional;
                WC()->session->set("cart_shipping_without_tax_{$rate_key}", ($original_cost + $fee_additional));
                WC()->session->set("cart_shipping_with_tax_{$rate_key}", $shipping_with_tax);
                WC()->session->set("cart_shipping_fee_additional_{$rate_key}", $fee_additional);
                WC()->session->set("cart_shipping_fee_additional_percentage_{$rate_key}", $fee_additional_percentage);

                // Verifica se o frete grátis está ativo
                if (isset($settings['free_shipping']) && $settings['free_shipping'] > 0 && $settings['free_shipping'] < $subtotal) {
                    WC()->session->set("cart_shipping_free_{$rate_key}", 1);
                    $rates[$rate_key]->set_cost(0);
                    $free = 1;
                } else {
                    $rates[$rate_key]->set_cost($shipping_with_tax);
                    $free = 0;
                }

                // Adiciona metadados ao método de frete
                $rates[$rate_key]->add_meta_data('original_cost', $original_cost);
                $rates[$rate_key]->add_meta_data('shipping_without_tax', ($original_cost + $fee_additional));
                $rates[$rate_key]->add_meta_data('shipping_with_tax', $shipping_with_tax);
                $rates[$rate_key]->add_meta_data('shipping_tax_card', $this->tax_card);
                $rates[$rate_key]->add_meta_data('shipping_fee_additional', $fee_additional);
                $rates[$rate_key]->add_meta_data('shipping_fee_additional_percentage', $fee_additional_percentage);
                $rates[$rate_key]->add_meta_data('shipping_free', $free);
            }

            return $rates;
        }


        /**
         * Customiza o rótulo exibido para métodos de envio no carrinho e checkout.
         *
         * Este método é usado como callback do filtro `woocommerce_cart_shipping_method_full_label`.
         * Ele verifica os metadados do método de envio, e se encontrar a chave `shipping_free`
         * marcada como verdadeira, adiciona o texto "Frete Grátis" ao lado do rótulo original.
         *
         * @param string          $label  Texto atual do rótulo do método de envio (ex: "PAC – R$ 20,00").
         * @param WC_Shipping_Rate $method Objeto da classe WooCommerce contendo os dados do método de envio,
         *                                 incluindo ID, custo e metadados adicionados dinamicamente por plugins
         *                                 ou pela própria lógica de negócio.
         *
         * @return string Rótulo do método de envio, possivelmente modificado para incluir a indicação de frete grátis.
         *
         * Exemplo de uso:
         * add_filter(
         *     'woocommerce_cart_shipping_method_full_label',
         *     [$this, 'shipping_discount_label'],
         *     10,
         *     2
         * );
         */
        public function shipping_discount_label($label, $method)
        {
            $meta = $method->get_meta_data();

            // Se não houver metadados, retorna o rótulo original
            if (!$meta) {
                return $label;
            }

            // Verifica se o frete grátis está marcado nos metadados
            if (isset($meta['shipping_free']) && $meta['shipping_free']) {
                $label .= '&nbsp;<span class="text-danger">Frete Grátis</span>';
            }

            return $label;
        }


        public function show_details_shipping_meta_data($item_id, $item, $product)
        {
            if (!is_admin() || $item->get_type() !== 'shipping') {
                return;
            }

            $keys = [
                'delivery_time'                       => 'Prazo de Entrega',
                'original_cost'                       => 'Frete Original',
                'shipping_without_tax'                => 'Frete Original + Adic.',
                'shipping_with_tax'                   => 'Frete com T. Cartão e Adic.',
                'shipping_tax_card'                   => 'Taxa de Cartão (%)',
                'shipping_fee_additional_percentage'  => 'Taxa adicional (%)',
                'shipping_fee_additional'             => 'Taxa adicional'
            ];
            echo '<div class="view">
            <table cellspacing="0" class="display_meta">
                <tbody>';

            foreach ($keys as $key => $label) {
                $value = $item->get_meta($key);
                if ($value !== '' && $value !== null) {
                    echo '<tr>
                    <th style="font-size: .8rem; width: 240px;">' . esc_html($label) . ':</th>
                    <td><p style="font-size: .8rem">' .
                        (is_numeric($value) && $key != 'delivery_time' && $key != 'shipping_fee_additional_percentage' && $key != 'shipping_tax_card' ?
                            wc_price((float) $value) : esc_html($value)) .
                        '</p></td>
                </tr>';
                }
            }

            $frete_gratis = $item->get_meta('shipping_free', true) ?? 0;
            if ($frete_gratis) {
                echo '<tr>
                <td colspan="2">
                    <p style="color: #FF0000; font-family: gotham bold;">Frete Grátis</p>
                </td>
              </tr>';
            }

            echo '</tbody></table></div>';

            echo "<script>
            jQuery(document).ready(function($) {
                setTimeout(function() {
                    $('.shipping td.name > .view').last().hide();
                }, 300); // Espera o carregamento da DOM + scripts do Woo
            });
            </script>";
        }

        private function get_shipping_options($method)
        {
            if (empty($this->cached_shipping_methods)) {
                $this->cached_shipping_methods = $this->get_wc_shipping_methods();
            }

            $instance = $this->match_prefix_and_suffix($method, $this->cached_shipping_methods);

            $instance = $instance['match'] . "_" . $instance['suffix'];

            $option_settings_name = 'woocommerce_' . $instance . '_settings';

            $settings = get_option($option_settings_name, true);
            return $settings;
        }

        public function logger($name, $data)
        {
            $log = new WC_Logger();
            $log_entry = print_r($data, true);
            $log->log($name, $log_entry);
        }

        public function update_product_coupon($order_id, $old_status, $new_status)
        {
            if (!is_admin()) return;
            $order = wc_get_order($order_id);

            $used_coupons = $order->get_used_coupons();

            $total_discount = 0;

            if (!empty($used_coupons)) {
                foreach ($used_coupons as $coupon_apply) {
                    $coupon = new WC_Coupon($coupon_apply);
                    if ($coupon->get_discount_type() == 'percent') {
                        $total_discount += (($order->get_subtotal() / 100) * $coupon->get_amount());
                    } else {
                        $total_discount += $coupon->get_amount();
                    }
                }
            }

            if ($total_discount >= $order->get_subtotal()) {
                $total_discount = $order->get_subtotal();
            }

            $order->set_discount_total($total_discount);
            $order->set_total(($order->get_subtotal() -  $total_discount) + $order->get_shipping_total());
            $order->save();
        }

        public function update_product_coupon_table($order_id)
        {
            $order = wc_get_order($order_id);

            $items = $order->get_items('line_item');
            $order_coupons = $order->get_items('coupon');
            $used_coupons = $order->get_used_coupons();

            $total_discount = 0;

            if (!empty($used_coupons)) {
                foreach ($used_coupons as $coupon_apply) {
                    foreach ($order_coupons as $order_coupon) {
                        if ($coupon_apply == $order_coupon->get_code()) {
                            $total_discount += floatval($order_coupon->get_discount());
                        }
                    }
                }

                foreach ($items as $item) {


                    if (!$item->get_meta('_cartstamp') && !empty($item->get_meta('_original_price'))) {
                        $set_item_subtotal = $item->get_meta('_original_price') * $item->get_quantity();
                        $item->set_subtotal($set_item_subtotal);
                        $item->save();
                    }
                }
            }

            if ($total_discount >= $order->get_subtotal()) {
                $total_discount = $order->get_subtotal();
            }

            $fee = 0;
            foreach ($order->get_fees() as $fee) {
                $fee = +$fee->get_total();
            }

            $free = $order->get_meta('shipping_free', true) ?? 0;
            $shipping_total_value = $order->get_meta('shipping_total_value', true) ?? 0;
            $shipping_total = 0;
            if (!$free && $shipping_total_value > 0) {
                $shipping_total = $order->get_meta('shipping_total_value', true) ?? 0;
            }

            $order->set_discount_total($total_discount);
            $order->set_total(($order->get_subtotal() - $total_discount) + $shipping_total + $fee);
            $order->save();
        }

        public function dont_save_discount($order_id)
        {
            $order = wc_get_order($order_id);

            foreach ($order->get_items() as $item_id => $item) {
                $item->set_total($item->get_subtotal());
            }
            $order->save();
        }

        /**
         * Efetua a limpeza do carrinho ao se logar.
         *
         * @return void
         */
        function clear_logged_cart()
        {
            global $woocommerce;

            if (($woocommerce->cart != null) && (isset($_SESSION['added_to_cart']) && ($_SESSION['added_to_cart'] <  (new DateTime)->getTimeStamp()))) {
                $woocommerce->cart->empty_cart();
            }
        }

        function when_added_to_cart()
        {
            $_SESSION['added_to_cart'] = (new DateTime)->getTimeStamp() + (60 * get_option('cart_time', 5));
        }

        static function filter_ExtendSessionExpiring($seconds)
        {
            return (60 * get_option('cart_time', 5));
        }
        static function filter_ExtendSessionExpired($seconds)
        {
            return (60 * get_option('cart_time', 5));
        }

        public function cart_time($settings)
        {
            $settings[] = array(
                'name'     => __('Tempo de Espera no carrinho', 'central-da-cerveja'),
                'desc_tip' => __('Tempo que o produto irá permanecer no carrinho, em minutos', 'central-da-cerveja'),
                'id'       => 'cart_time',
                'type'     => 'number',
            );

            $sections[] = array('type' => 'sectionend', 'id' => 'store_address');

            return $settings;
        }

        public function maintenance_mode($settings)
        {
            $settings[] = array(
                'name'     => __('Modo manutenção', 'central-da-cerveja'),
                'id'       => 'maintenance_mode',
                'type'     => 'title',
            );
            $settings[] = array(
                'name'     => __('Término da Manutenção', 'central-da-cerveja'),
                'id'       => 'maintenance_time',
                'type'     => 'text',
            );
            $settings[] = array('type' => 'sectionend', 'id' => 'maintenance');
            return $settings;
        }

        public function shipping_options_field($settings, $current_section)
        {

            if ($current_section == 'options') {
                $settings[] = array(
                    'name'     => __('Frete Rápido', 'central-da-cerveja'),
                    'id'       => 'fast_delivery_limit',
                    'type'     => 'title',
                );
                $settings[] = array(
                    'name'     => __('Limite de horário para o frete rápido', 'central-da-cerveja'),
                    'id'       => 'fast_delivery_limit_time',
                    'type'     => 'text',
                );
                $settings[] = array(
                    'name'     => __('Limite de horário para a entrega de até 48h na região metropolitana de SP', 'central-da-cerveja'),
                    'id'       => 'metropolitan_48h_shipping_limit',
                    'type'     => 'text',
                );
                $settings[] = array(
                    'name'     => __('Valores para São Paulo - Capital', 'central-da-cerveja'),
                    'id'       => 'fast_delivery_limit_capital',
                    'desc'     => 'Até 2 volumes',
                    'type'     => 'text',
                );
                $settings[] = array(
                    'name'     => __('Valores para Região Metropolitana de São Paulo', 'central-da-cerveja'),
                    'id'       => 'fast_delivery_limit_rm',
                    'desc'     => 'Até 2 volumes',
                    'type'     => 'text',
                );
                $settings[] = array(
                    'name'     => __('Valor do volume adicional (por volume)', 'central-da-cerveja'),
                    'id'       => 'fast_delivery_limit_additional',
                    'desc'     => 'Acima de 2 volumes',
                    'type'     => 'text',
                );
                $settings[] = array(
                    'name'     => __('Valor da entrega de até 48h na região metropolitana de SP', 'central-da-cerveja'),
                    'id'       => 'metropolitan_48h_shipping_value',
                    'type'     => 'text',
                );
                $settings[] = array('type' => 'sectionend', 'id' => 'fast_delivery_limit_end');

                $settings[] = array(
                    'name'     => __('Produtos Refrigerados', 'central-da-cerveja'),
                    'id'       => 'refrigerated_products_title',
                    'type'     => 'title',
                );
                $settings[] = array(
                    'name'     => __('Limitação de transporte', 'central-da-cerveja'),
                    'id'       => 'transport_limit',
                    'type'     => 'checkbox',
                    'desc'     => 'Ativar limitação de transporte',
                );
                $settings[] = array(
                    'name'     => __('Limite de dias para transporte', 'central-da-cerveja'),
                    'id'       => 'days_limit',
                    'type'     => 'number',
                );
                $settings[] = array('type' => 'sectionend', 'id' => 'refrigerated_products');
                return $settings;
            }
            return $settings;
        }


        public function filter_emails_suppliers($order_details)
        {
            $supplier_emails = [];
            foreach ($order_details->get_items() as $key => $items) {
                $supplier_filters = [];
                $supplier_id = get_post_meta($items->get_product_id(), '_supplier_id', true);
                $email = get_post_meta($supplier_id, 'supplier_details', true)['email'];
                $supplier_filters['email'] = $email;
                $supplier_filters['supplier_id'] = $supplier_id;
                array_push($supplier_emails, $supplier_filters);
            }

            if (filter_var_array($supplier_emails, FILTER_SANITIZE_EMAIL)) {
                return array_unique($supplier_emails, SORT_REGULAR);
            }
            return null;
        }

        public function send_mail_to_more_recipient($order_id, $old_status, $new_status)
        {

            if ($new_status != 'processing') return;

            $order_details = wc_get_order($order_id);

            //$supplier_filters_data = $this->filter_emails_suppliers($order_details );

            $shipping_method = $order_details->get_shipping_method();
            // Pega os e-mails dos destinatarios
            $emails = preg_split('/\s*,\s*/', get_option('woocommerce_cdc_werehouse_order_approved_settings')['recipient'], -1, PREG_SPLIT_DELIM_CAPTURE);

            // Configura o cabeçalho da requisição
            $headers[] = 'Content-Type: text/html; charset=UTF-8';
            $headers[] = 'From: Central da Cerveja <noreply@centraldacerveja.com.br> ' . "\r\n";

            // Define um assunto
            $subject_werehouse = !empty(get_option('woocommerce_cdc_werehouse_order_approved_settings')['subject']) ? get_option('woocommerce_cdc_werehouse_order_approved_settings')['subject'] : __('Pedido Está sendo Processado', 'central-da-cerveja');

            preg_match_all('/\\{(.*?)\\}/', $subject_werehouse, $matches, PREG_SET_ORDER);

            $values = [
                'order_date' => wc_format_datetime($order_details->get_date_created()),
                'order_number' => $order_id,
                'order_billing_full_name' => $order_details->get_formatted_billing_full_name()
            ];

            if (!empty($matches)) {
                $subject_werehouse = $this->replace_email_subject($matches, $values, $subject_werehouse);
            }

            if (!empty($emails) && get_option('woocommerce_cdc_werehouse_order_approved_settings')['enabled'] == 'yes') {
                $to = array();

                // Percorre os e-mail a serem enviados e os valida.
                foreach ($emails as $email) {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        array_push($to, $email);
                    }
                }

                // Efetua o envio
                $this->send_mail($to, $subject_werehouse, $headers, $order_id, 'werehouse-processing-order');
            }

            $emails = preg_split('/\s*,\s*/', get_option('woocommerce_cdc_shipping_order_approved_settings')['recipient'], -1, PREG_SPLIT_DELIM_CAPTURE);
            $subject_shipping = !empty(get_option('woocommerce_cdc_shipping_order_approved_settings')['subject']) ? get_option('woocommerce_cdc_shipping_order_approved_settings')['subject'] : __('Pedido Está sendo Processado', 'central-da-cerveja');

            preg_match_all('/\\{(.*?)\\}/', $subject_shipping, $matches, PREG_SET_ORDER);

            if (!empty($matches)) {
                $subject_shipping = $this->replace_email_subject($matches, $values, $subject_shipping);
            }

            if (!empty($emails) && get_option('woocommerce_cdc_shipping_order_approved_settings')['enabled'] == 'yes') {
                $to = array();

                // Percorre os e-mail a serem enviados e os valida.
                foreach ($emails as $email) {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        array_push($to, $email);
                    }
                }

                // Efetua o envio
                $this->send_mail($to, $subject_shipping, $headers, $order_id, 'shipping-processing-order');
            }

            //if ($supplier_filters_data != null) {
            //    foreach ($supplier_filters_data as $supplier_emails) {
            //        $this->send_mail($supplier_emails['email'], $subject, $headers, $order, 'supplier-new-order', $supplier_emails['supplier_id']);
            //    }
            //}
        }


        private function filter_order_product($order, $supplier_id = null)
        {
            if ($supplier_id == null) return $order;
            $products = [];

            foreach ($order->get_items() as $items) {
                if (get_post_meta($items->get_product_id(), '_supplier_id', true) == $supplier_id) {
                    array_push($products, $items);
                }
            }
            return $products;
        }


        private function mont_data_nfe($nfe)
        {
            $xml = isset($nfe['url_xml']) && !empty($nfe['url_xml']) ? file_get_contents($nfe['url_xml']) : '';
            $pdf = isset($nfe['url_danfe']) && !empty($nfe['url_danfe']) ? file_get_contents($nfe['url_danfe']) : '';
            $attachment = [];
            $folder = get_template_directory() . "/temp";

            if (!file_exists($folder)) {
                mkdir($folder);
            }

            // XML
            if (!empty($xml)) {
                $file_xml = $folder . "/" . $nfe['chave_acesso'] . ".xml";
                if (file_put_contents($file_xml, $xml)) {
                    // array_push($attachment, $file_xml);
                    $attachment[] = $file_xml;
                }
            }
            // PDF
            if (!empty($pdf)) {
                $file_pdf = $folder . "/" . $nfe['chave_acesso'] . ".pdf";
                if (file_put_contents($file_pdf, $pdf)) {
                    // array_push($attachment, $file_pdf);
                    $attachment[] = $file_pdf;
                }
            }

            return $attachment;
        }

        private function filter_nfes($nfes, $supplier_id = null)
        {
            if (empty($nfes)) return null;
            $attachment = [];
            if ($supplier_id == null) {
                foreach ($nfes as $nfe) {
                    array_push($attachment, $this->mont_data_nfe($nfe));
                }
                return array_reduce($attachment, 'array_merge', []);
            }

            foreach ($nfes as $nfe) {
                if ($supplier_id == $nfe['supplier_id']) {
                    array_push($attachment, $this->mont_data_nfe($nfe));
                }
            }
            return array_reduce($attachment, 'array_merge', []);
        }

        private function send_mail($to, $subject, $headers, $order_id, $file, $supplier_id = null)
        {
            $attachment = array();
            $nfes = apply_filters('get_nfes', $order_id);

            $attachment = $this->filter_nfes($nfes, $supplier_id);

            ob_start();
            $order = new WC_Order($order_id);
            $order_products = $this->filter_order_product($order, $supplier_id);
            include get_template_directory() . "/woocommerce/emails/{$file}.php";
            $tamplate = ob_get_contents();
            ob_end_clean();

            wp_mail($to, $subject, $tamplate, $headers, $attachment);

            foreach ($attachment as $file) {
                unlink($file);
            }

            return;
        }

        public function card_product_quantity_button()
        {
            global $product;
            $outofstock = $this->bundle_product_out_of_stock($product);
            $shipping_shop_limit = get_option('sold_individually_with_restriction', 0);

            if (($product->is_type('subscription') && $shipping_shop_limit) && !$outofstock) {
                echo "";
                return;
            }

            if ($product->is_in_stock() && !$outofstock) {
                echo "<div class='input-group plus-minus-input d-flex justify-content-center'>
                        <div class='input-group-button'>
                        <button type='button' class='button hollow circle disabled' data-quantity='minus' data-field='quantity'>
                            <i class='fa fa-minus click-area' aria-hidden='true'></i>
                        </button>
                        </div>
                        <input class='input-group-field' type='number' readonly='readonly' name='quantity' min='1' max='{$product->get_stock_quantity()}' value='1'>
                        <div class='input-group-button'>
                        <button type='button' class='button hollow circle' data-quantity='plus' data-field='quantity'>
                            <i class='fa fa-plus click-area' aria-hidden='true'></i>
                        </button>
                        </div>
                    </div>";
            } else if (!$product->is_in_stock() || ($product->is_type('bundle') && $outofstock)) {
                echo "<div class='input-group plus-minus-input d-flex justify-content-center align-middle'>
                        <p class='text-danger fw-bold input-group-button product-out-of-stock'>Fora de Estoque</p>
                    </div>";
            }
        }

        private function bundle_product_out_of_stock($product)
        {
            $outofstock = false;
            if ($product->bundle_data) {
                foreach ($product->bundle_data as $bundle_data) {
                    $stock_status = get_post_meta($bundle_data['id'], '_stock_status', true);
                    $outofstock = false;
                    if ($stock_status == 'outofstock') {
                        $outofstock = true;
                        break;
                    }
                }
            }
            return $outofstock;
        }

        public function change_breadcrumb_delimiter($defaults)
        {
            $defaults['delimiter'] = ' &gt; ';
            return $defaults;
        }

        public function is_refrigerate_product_admin($order)
        {
            if ($order) {
                foreach ($order->get_items() as $item) {
                    if (get_post_meta($item->get_product_id(), '_transport_type', true) == 1) {
                        echo "<p style='color: red; font-size: 1rem; margin-top: 200px;'><strong>" . __('Transporte refrigerado obrigatório.', 'central-da-cerveja') . "</strong></p>";
                        return;
                    }
                }
            }
        }

        private function bundle_has_refrigerated_product($bundle_products)
        {
            foreach ($bundle_products as $product) {
                if (get_post_meta($product['product_id'], '_transport_type', true) == 1) {
                    return true;
                }
            }
            return false;
        }

        public function check_shipping()
        {
            global $woocommerce;
            global $wpdb;

            $shipping_method = !empty($_POST['shipping_method']) ? $_POST['shipping_method'] : WC()->session->get('chosen_shipping_methods')[0];
            $shipping_method = empty($shipping_method) ? WC()->session->get('chosen_shipping_methods_only')[0] : $shipping_method;

            $postcode =  !empty($_POST['postal_code']) ? preg_replace('([^0-9])', '', sanitize_text_field($_POST['postal_code'])) : '';
            WC()->session->set('chosen_shipping_methods', [$shipping_method]);
            $city = !empty($_POST['city']) ? $_POST['city'] : WC()->customer->get_shipping_city();
            $city = strtoupper($this->str_filter($city));
            $transport_limit = get_option('transport_limit');
            $days_limit = get_option('days_limit');
            $ids = array();

            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['city'] = $city;
            $message = "";

            $refrigerated_on_bundle = false;
            foreach ($woocommerce->cart->get_cart() as $value) {
                $is_bundle = $value['cartstamp'] ? 1 : 0;

                if ($is_bundle) {
                    $refrigerated_on_bundle = $this->bundle_has_refrigerated_product($value['cartstamp']);
                }

                if ((get_post_meta($value['product_id'], '_transport_type', true) == 1 || $is_bundle) || ($value['bundled_by'] && $refrigerated_on_bundle) && ($shipping_method != 0)) {
                    array_push($ids, $value['product_id']);

                    if ($shipping_method == str_starts_with($shipping_method, 'gold-rodoviario')) {
                        $road = "SELECT delivery_time FROM `{$wpdb->prefix}wgs_road` WHERE ('{$postcode}' BETWEEN zipcode_start AND zipcode_end)";
                        $delivery_road = $wpdb->get_row($road, ARRAY_A);
                        $delivery_road = !empty($delivery_road) ? $delivery_road['delivery_time'] + 1 : '';
                    }


                    if ($shipping_method == str_starts_with($shipping_method, 'anjun-correios')) {
                        $correios = "SELECT delivery_time FROM `{$wpdb->prefix}anjun_correios` WHERE ('{$postcode}' BETWEEN zipcode_start AND zipcode_end)";
                        $delivery_correios = $wpdb->get_row($correios, ARRAY_A);
                        $delivery_correios = !empty($delivery_correios) ? $delivery_correios['delivery_time'] + 1 : '';
                    }

                    if ($shipping_method == str_starts_with($shipping_method, 'gold-aereo')) {
                        $air = "SELECT delivery_time FROM `{$wpdb->prefix}wgs_air_destiny` WHERE city = '{$city}'";
                        $delivery_air = $wpdb->get_row($air, ARRAY_A);
                        $delivery_air = !empty($delivery_air) ? $delivery_air['delivery_time'] + 1 : '';
                    }

                    if ($shipping_method == str_starts_with($shipping_method, 'anjun-aereo')) {
                        $delivery_type = $shipping_method == str_starts_with($shipping_method, 'anjun-aereo-rapido') ? 4 : 5;
                        $anjun_air = "SELECT delivery_time FROM `{$wpdb->prefix}anjun_air` WHERE ('{$postcode}' BETWEEN zipcode_start AND zipcode_end) AND type = '{$delivery_type}'";
                        $delivery_anjun_air = $wpdb->get_row($anjun_air, ARRAY_A);
                        $delivery_anjun_air = !empty($delivery_anjun_air) ? $delivery_anjun_air['delivery_time'] + 1 : '';
                    }

                    if (
                        ($shipping_method == str_starts_with($shipping_method, 'gold-rodoviario') && ($transport_limit == 'yes' && $delivery_road > intval($days_limit)))
                        || ($shipping_method == str_starts_with($shipping_method, 'gold-aereo') && ($transport_limit == 'yes' && $delivery_air > intval($days_limit)))
                        || ($shipping_method == str_starts_with($shipping_method, 'anjun-aereo') && ($transport_limit == 'yes' && $delivery_anjun_air > intval($days_limit)))
                        || ($shipping_method == str_starts_with($shipping_method, 'anjun-correios') && ($transport_limit == 'yes' && $delivery_correios > intval($days_limit)))
                    ) {
                        $message = "<p class='warning-refrigerate' style='color: red; font-size: 1rem; text-align: justify;'><strong>" . __('Existem produtos refrigerados em sua cervejeira. O tempo de transporte excede o prazo estipulado. Tente utilizar outro método de envio. Caso prossiga, estes produtos serão removidos.', 'central-da-cerveja') . "</strong></p>";
                    }
                }
            }
            wp_send_json(array(
                'status' => true,
                'message' => $message,
                'id_refrigerated' => $ids
            ));
        }

        public function get_country_icon_by_product()
        {
            global $post;
            $country_flag = "brasil";
            $terms = get_the_terms($post->ID, 'pa_por-pais');
            if (!empty($terms)) {
                $country_flag = array_shift($terms)->slug;
            }

            $img = get_template_directory_uri() . "/assets/img/icons/{$country_flag}.png";
            echo "<div class='img-country-container'><img src='$img' class='img-size-country'></div>";
        }

        public function cart_totals_order_total_html()
        {
            global $woocommerce;
            echo wc_price($woocommerce->cart->total);
        }

        /**
         * Verifica se o e-mail já está sendo utilizado
         *
         */
        public function user_email_check()
        {
            if (isset($_POST['email']) && !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $exists = (email_exists($_POST['email'])) ? true : false;
                $message = null;

                if ($exists) {
                    $message = '<div class="woocommerce-info">' . __('O e-mail informado já existe.', 'central-da-cerveja') . '</div>';
                }

                wp_send_json(array(
                    'status'    => true,
                    'exists'    => $exists,
                    'message'   => $message
                ));
            } else {
                wp_send_json(array(
                    'status'    => false,
                    'message'   => '<div class="woocommerce-error">' . __('Por favor, informe um e-mail válido.', 'central-da-cerveja') . '</div>',
                ));
            }
        }

        public function check_for_registered_cpf()
        {

            $cpf_registered = $this->is_cpf_registered($_POST['cpf']);

            wp_send_json(array(
                'status' => true,
                'cpf_registered' => $cpf_registered,
            ));
        }

        /**
         * Manipula o registro de um novo usuário WooCommerce via AJAX.
         * Retorna JSON com status e mensagem detalhada.
         */
        public function user_register()
        {
            // Verifica nonce de segurança
            if (empty($_POST['woocommerce_nonce']) || !wp_verify_nonce($_POST['woocommerce_nonce'], 'woocommerce-register')) {
                wp_send_json_error([
                    'status'  => false,
                    'message' => __('Falha na verificação de segurança. Atualize a página e tente novamente.', 'central-da-cerveja')
                ], 400);
            }

            // Campos obrigatórios
            $required_fields = ['email', 'password', 'first_name', 'last_name', 'address', 'city', 'state', 'postcode', 'phone'];
            foreach ($required_fields as $field) {
                if (empty($_POST[$field])) {
                    wp_send_json_error([
                        'status'  => false,
                        'message' => sprintf(__('O campo "%s" é obrigatório.', 'central-da-cerveja'), $field)
                    ], 422);
                }
            }

            $base_username = sanitize_user(explode('@', $email)[0]);
            $random_suffix = strtolower(substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 4));

            $email    = sanitize_email($_POST['email']);
            $password = sanitize_text_field($_POST['password']);
            $username = $base_username . '_' . $random_suffix;
            $first    = sanitize_text_field($_POST['first_name']);
            $last     = sanitize_text_field($_POST['last_name']);

            // Verifica se já existe usuário com o e-mail informado
            if (email_exists($email)) {
                wp_send_json_error([
                    'status'  => false,
                    'message' => __('Este e-mail já está cadastrado. Faça login ou use outro endereço.', 'central-da-cerveja')
                ], 409);
            }

            // Cria o usuário WooCommerce
            $user_id = wc_create_new_customer($email, $username, $password);

            if (is_wp_error($user_id)) {
                wp_send_json_error([
                    'status'  => false,
                    'message' => __('Não foi possível criar sua conta. Detalhe: ', 'central-da-cerveja') . $user_id->get_error_message()
                ], 500);
            }

            // Atualiza metadados (billing e shipping)
            $meta_fields = [
                'nickname'              => preg_replace("/\s+/", "", strtolower($first)),
                'first_name'            => $first,
                'last_name'             => $last,
                'billing_first_name'    => $first,
                'billing_last_name'     => $last,
                'billing_address_1'     => sanitize_text_field($_POST['address']),
                'billing_number'        => sanitize_text_field($_POST['number'] ?? ''),
                'billing_address_2'     => sanitize_text_field($_POST['complement'] ?? ''),
                'billing_neighborhood'  => sanitize_text_field($_POST['county'] ?? ''),
                'billing_postcode'      => sanitize_text_field($_POST['postcode']),
                'billing_country'       => 'BR',
                'billing_city'          => sanitize_text_field($_POST['city']),
                'billing_state'         => sanitize_text_field($_POST['state']),
                'billing_email'         => $email,
                'billing_phone'         => sanitize_text_field($_POST['phone']),
                'billing_cellphone'     => sanitize_text_field($_POST['mobile'] ?? ''),
                'billing_cpf'           => sanitize_text_field($_POST['cpf'] ?? ''),
            ];

            foreach ($meta_fields as $key => $value) {
                update_user_meta($user_id, $key, $value);

                // Atualiza também o shipping equivalente, se aplicável
                if (str_starts_with($key, 'billing_')) {
                    $shipping_key = str_replace('billing_', 'shipping_', $key);
                    update_user_meta($user_id, $shipping_key, $value);
                }
            }

            // Autentica o usuário recém-criado
            $user = wp_signon([
                'user_login'    => $email,
                'user_password' => $password,
                'remember'      => true
            ], false);

            if (is_wp_error($user)) {
                wp_send_json_error([
                    'status'  => false,
                    'message' => __('Conta criada, mas não foi possível autenticar. Faça login manualmente.', 'central-da-cerveja')
                ], 200);
            }

            wp_send_json_success([
                'status'  => true,
                'message' => __('Conta criada e login realizado com sucesso!', 'central-da-cerveja'),
                'user_id' => $user_id,
            ]);
        }



        /************************
         *      SEARCH
         ************************/
        public function search_join($join)
        {
            global $wpdb;

            if (isset($_GET['post_type']) && 'product' == $_GET['post_type']) {
                if (is_search() && get_search_query()) {
                    $join .= ' LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
                    $join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
                    $join .= " LEFT JOIN {$wpdb->postmeta} pm ON {$wpdb->posts}.ID = pm.meta_value AND {$wpdb->posts}.ID = pm.post_id";
                    $join .= " LEFT JOIN {$wpdb->postmeta} pm_commercialize_on_kit ON {$wpdb->posts}.ID = pm_commercialize_on_kit.post_id AND pm_commercialize_on_kit.meta_key = '_commercialize_on_kit'";
                    $join .= " LEFT JOIN {$wpdb->postmeta} pm_instock ON {$wpdb->posts}.ID = pm_instock.post_id AND pm_instock.meta_key = '_stock_status'";
                    $join .= " LEFT JOIN {$wpdb->postmeta} pm_certificate_expired ON {$wpdb->posts}.ID = pm_certificate_expired.post_id AND pm_certificate_expired.meta_key = '_supplier_certificate_expired'";
                }
            }

            return $join;
        }

        public function search_where($where)
        {
            global $wpdb;


            if (isset($_GET['post_type']) && 'product' == $_GET['post_type']) {
                if (is_search() && get_search_query()) {

                    $where = preg_replace(
                        "/\(\s*" . $wpdb->posts . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
                        "((" . $wpdb->posts . ".post_title LIKE $1) OR (" . $wpdb->postmeta . ".meta_value LIKE $1) OR ((t.name LIKE '%" . get_search_query() . "%') AND {$wpdb->posts}.post_status = 'publish')) AND t.slug = 'cerveja' AND (pm_commercialize_on_kit.meta_value != 1 OR pm_commercialize_on_kit.meta_value IS NULL) AND pm_instock.meta_value = 'instock' AND (pm_certificate_expired.meta_value != 1 OR pm_certificate_expired.meta_value IS NULL)",
                        $where
                    );
                }
            }

            return $where;
        }

        public function search_distinct($where)
        {

            if (isset($_GET['post_type']) && 'product' == $_GET['post_type']) {
                if (is_search()) {
                    return "DISTINCT";
                }
            }
            return $where;
        }

        public function single_product_atributes()
        {
            global $product;
            $attributes = $product->get_attributes();
            $attributeQty = count($attributes);
            $numOfCols = 2;
            $rowCount = 0;


            $valid_date = $this->product_valid_date($product->get_id());

            $close_to_expiring = $this->expiring_range(strtotime($valid_date));

            $valid_date = !empty($valid_date) ? date('d/m/Y', strtotime($valid_date)) : '--';

            if (!$attributes) {
                return;
            }

            $display_result = '<div class="container">';
            $display_result .= '<div class="row">';

            foreach ($attributes as $key => $attribute) {

                if ($attribute->get_variation()) {
                    continue;
                }

                $name = $attribute->get_name();

                if ($attribute->is_taxonomy()) {

                    $terms = wp_get_post_terms($product->get_id(), $name, 'all');

                    $cwtax = !empty($terms) && isset($terms[0]->taxonomy) ? $terms[0]->taxonomy : '';

                    $cw_object_taxonomy = get_taxonomy($cwtax);

                    if (isset($cw_object_taxonomy->labels->singular_name)) {

                        $tax_label = $cw_object_taxonomy->labels->singular_name;
                    } elseif (isset($cw_object_taxonomy->label)) {

                        $tax_label = $cw_object_taxonomy->label;

                        if (0 === strpos($tax_label, 'Product ')) {
                            $tax_label = substr($tax_label, 8);
                        }
                    }

                    $rowCount++;

                    $tax_terms = array();

                    foreach ($terms as $term) {

                        $single_term = esc_html($term->name);
                        array_push($tax_terms, $single_term);
                    }

                    if (!empty($tax_terms)) {
                        $display_result .= '<div class="col-6 pa">
                        <span class="product-attributes">' . $tax_label . ': </span>';

                        $display_result .= '<span class="attributes-value">' . implode(', ', $tax_terms) . '</span>
                                        </div>';
                    }

                    if (array_key_last($attributes) == $key && $rowCount % $numOfCols != 0) {
                        if ($attributeQty == $rowCount) {
                            $ideal_temperature = get_post_meta($product->get_id(), '_ideal_temperature', true);
                            $between = get_post_meta($product->get_id(), '_between', true);

                            if (!empty($ideal_temperature)) {
                                $between = empty($between) ? $ideal_temperature : $between;
                                $span_between = $ideal_temperature == $between ? "<span class='attributes-value'>{$ideal_temperature}</span>" : "<span class='attributes-value'>Entre {$ideal_temperature} E {$between}</span>";
                                $display_result .= "<div class='col-6 pa'><span class='product-attributes'>Temperatura Ideal: </span>{$span_between}</div>";
                            }

                            $package = get_post_meta($product->get_id(), '_package', true);
                            if (!empty($package)) {
                                $package = $package == 1 ? 'Garrafa' : 'Lata';
                                $display_result .= "<div class='col-6 pa'><span class='product-attributes'>Embalagem: </span><span class='attributes-value'>{$package}</span></div>";
                            }

                            $volume = get_post_meta($product->get_id(), '_volume', true);
                            if (!empty($volume)) {
                                $display_result .= "<div class='col-6 pa'><span class='product-attributes'>Volume: </span><span class='attributes-value'>{$volume}</span></div>";
                            }

                            $alcoholic_dosage = get_post_meta($product->get_id(), '_alcoholic_dosage', true);
                            if (!empty($alcoholic_dosage)) {
                                $alcoholic_dosage_length = explode(',', $alcoholic_dosage);
                                $alcoholic_dosage_length = substr($alcoholic_dosage_length[1], 0, -1);

                                if (strlen($alcoholic_dosage_length) >= 2) {
                                    $alcoholic_dosage = substr($alcoholic_dosage, 0, -2);
                                    $alcoholic_dosage .= '%';
                                }
                                $display_result .= "<div class='col-6 pa'><span class='product-attributes'>Dosagem Alcoólica: </span><span class='attributes-value'>{$alcoholic_dosage}</span></div>";
                            }

                            $ibu = get_post_meta($product->get_id(), '_ibu', true);
                            if (!empty($ibu)) {
                                $display_result .= "<div class='col-6 pa'><span class='product-attributes'>IBU: </span><span class='attributes-value'>{$ibu}</span></div>";
                            }

                            $harmonizing_suggestion = get_post_meta($product->get_id(), '_harmonizing_suggestion', true);
                            if (!empty($harmonizing_suggestion)) {
                                $display_result .= "<div class='col-6 pa'><span class='product-attributes'>Sugestão de Harmonização: </span><span class='attributes-value'>{$harmonizing_suggestion}</span></div>";
                            }

                            if (!empty($valid_date) && !$product->is_type('bundle')) {
                                $display_result .= "<div class='col-6 pa'><span class='product-attributes'>Data de validade: </span><span class='attributes-value {$close_to_expiring}'>{$valid_date}</span></div>";
                            }
                        }
                    }

                    if ($rowCount % $numOfCols == 0) {
                        if ($attributeQty == $rowCount) {
                            $ideal_temperature = get_post_meta($product->get_id(), '_ideal_temperature', true);
                            $between = get_post_meta($product->get_id(), '_between', true);

                            if (!empty($ideal_temperature)) {
                                $between = empty($between) ? $ideal_temperature : $between;
                                $span_between = $ideal_temperature == $between ? "<span class='attributes-value'>{$ideal_temperature}</span>" : "<span class='attributes-value'>Entre {$ideal_temperature} E {$between}</span>";
                                $display_result .= "<div class='col-6 pa'><span class='product-attributes'>Temperatura Ideal: </span>{$span_between}</div>";
                            }

                            $package = get_post_meta($product->get_id(), '_package', true);
                            if (!empty($package)) {
                                $package = $package == 1 ? 'Garrafa' : 'Lata';
                                $display_result .= "<div class='col-6 pa'><span class='product-attributes'>Embalagem: </span><span class='attributes-value'>{$package}</span></div>";
                            }

                            $volume = get_post_meta($product->get_id(), '_volume', true);
                            if (!empty($volume)) {
                                $display_result .= "<div class='col-6 pa'><span class='product-attributes'>Volume: </span><span class='attributes-value'>{$volume}</span></div>";
                            }

                            $alcoholic_dosage = get_post_meta($product->get_id(), '_alcoholic_dosage', true);
                            if (!empty($alcoholic_dosage)) {
                                $alcoholic_dosage_length = explode(',', $alcoholic_dosage);
                                $alcoholic_dosage_length = substr($alcoholic_dosage_length[1], 0, -1);

                                if (strlen($alcoholic_dosage_length) >= 2) {
                                    $alcoholic_dosage = substr($alcoholic_dosage, 0, -2);
                                    $alcoholic_dosage .= '%';
                                }
                                $display_result .= "<div class='col-6 pa'><span class='product-attributes'>Dosagem Alcoólica: </span><span class='attributes-value'>{$alcoholic_dosage}</span></div>";
                            }

                            $ibu = get_post_meta($product->get_id(), '_ibu', true);
                            if (!empty($ibu)) {
                                $display_result .= "<div class='col-6 pa'><span class='product-attributes'>IBU: </span><span class='attributes-value'>{$ibu}</span></div>";
                            }

                            $harmonizing_suggestion = get_post_meta($product->get_id(), '_harmonizing_suggestion', true);
                            if (!empty($harmonizing_suggestion)) {
                                $display_result .= "<div class='col-6 pa'><span class='product-attributes'>Sugestão de Harmonização: </span><span class='attributes-value'>{$harmonizing_suggestion}</span></div>";
                            }

                            if (!empty($valid_date) && !$product->is_type('bundle')) {
                                $display_result .= "<div class='col-6 pa'><span class='product-attributes'>Data de validade: </span><span class='attributes-value {$close_to_expiring}'>{$valid_date}</span></div>";
                            }
                        }
                    }
                } else {

                    $display_result .= $name . ': ';
                    $display_result .= esc_html(implode(', ', $attribute->get_options())) . '<br />';
                }
            }
            $display_result .= '</div>';
            $display_result .= '</div>';
            echo $display_result;
        }

        public function expiring_range($valid_date)
        {
            $date = date('Y-m-d');
            $date = strtotime($date);
            $days = empty(get_option('days_to_expire')) && get_option('days_to_expire') == '' ? 30 : get_option('days_to_expire');
            $expire_date = strtotime("+" . $days . " day", $date);

            $close_to_expiring = '';
            if ($valid_date >= strtotime(date('Y-m-d')) && $valid_date <= $expire_date) {
                $close_to_expiring = 'close_to_expiring';
            }

            return $close_to_expiring;
        }

        public function remove_downloads_my_account($items)
        {
            unset($items['downloads']);
            return $items;
        }

        public function change_view_cart_text($params, $handle)
        {
            switch ($handle) {
                case 'wc-add-to-cart':
                    $params['i18n_view_cart'] = "Ver cervejeira";
                    break;
            }
            return $params;
        }

        public function custom_cart_updated_message($translation, $text)
        {
            if ($text == 'Cart updated.') {
                $translation = 'Cervejeira atualizada.';
            }

            if ($text == 'View cart') {
                $translation = 'Ver cervejeira';
            }

            if ($text === 'You cannot add that amount to the cart &mdash; we have %1$s in stock and you already have %2$s in your cart.') {
                $translation = __('Você não pode adicionar esta quantidade à sua cervejeira, temos em estoque %1$s e você já tem em sua cervejeira  %2$s.');
            }

            if ($text == 'Your cart is currently empty.') {
                $translation = __('Sua cervejeira está vazia.');
            }

            if ($text == 'A password reset email has been sent to the email address on file for your account, but may take several minutes to show up in your inbox. Please wait at least 10 minutes before attempting another reset.') {
                $translation = __('Um e-mail de redefinição de senha foi enviado para o endereço de e-mail da sua conta, mas pode levar alguns minutos para aparecer na sua caixa de entrada. Aguarde pelo menos 10 minutos antes de tentar novamente ou verifique sua caixa de spam.');
            }

            if ($text == 'Your payment was declined. You can try again.') {
                $translation = __('Ocorreu algum problema no processo. Alteramos a processadora de pagamentos. Clique aqui e tente novamente.');
            }

            return $translation;
        }

        public function wc_add_to_cart_message_filter($message, $product_id = null)
        {
            if (!isset($_GET['type'])) {

                $titles[] = get_the_title($product_id);

                $titles = array_filter($titles);
                $added_text = sprintf(_n('“%s” foi adicionado à sua cervejeira.', '%s foi adicionado à sua cervejeira.', sizeof($titles), 'woocommerce'), wc_format_list_of_items($titles));
                $message   = sprintf('<a href="%s" class="button wc-forward">%s</a> %s', esc_url(wc_get_page_permalink('cart')), esc_html__('View cart', 'woocommerce'), esc_html($added_text));
                return $message;
            }
        }

        public function remove_single_product_tabs($tabs)
        {
            unset($tabs['description']);
            unset($tabs['additional_information']);

            return $tabs;
        }

        private function remove_kit_refrigerated($cart, $key)
        {

            if (!$cart['data']->is_type('bundle')) return null;

            foreach ($cart['data'] as $bundled_item_key => $item) {
                foreach ($item as $product) {
                    if (get_post_meta($product['id'], '_transport_type', true) == 1) {
                        return [
                            'product_id' => $product['id'],
                            'key' => $key
                        ];
                    }
                }
            }
        }

        public function remove_refrigerated_before_checkout()
        {
            global $wpdb;

            if (is_checkout()) {

                $postcode =  preg_replace('([^0-9])', '', sanitize_text_field($_POST['postcode']));
                $shipping_postcode = preg_replace('([^0-9])', '', sanitize_text_field($_POST['s_postcode']));

                $postcode = $postcode == $shipping_postcode ? $postcode : $shipping_postcode;

                $transport_limit = get_option('transport_limit');
                $days_limit = get_option('days_limit');
                $shipping_method = isset($_POST['shipping_method']) ? $_POST['shipping_method'][0] : '';
                $city = isset($_SESSION) ? $_SESSION['city'] : strtoupper($this->str_filter($_POST['city']));
                $ids = array();
                $refrigerated_qty = array();

                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {

                    $product_bundle = $this->remove_kit_refrigerated($cart_item, $cart_item_key);
                    $is_bundle = !empty($product_bundle) ? 1 : 0;
                    $product_id = $cart_item['product_id'];
                    $key = $cart_item_key;
                    if ((get_post_meta($cart_item['product_id'], '_transport_type', true) == 1 || $is_bundle) && !$cart_item['bundled_by']) {
                        array_push($ids, $product_id);
                        array_push($refrigerated_qty, $cart_item['quantity']);

                        if ($shipping_method == str_starts_with($shipping_method, 'gold-rodoviario')) {
                            $road = "SELECT delivery_time FROM `{$wpdb->prefix}wgs_road` WHERE ({$postcode} BETWEEN zipcode_start AND zipcode_end)";
                            $delivery_road = $wpdb->get_row($road, ARRAY_A);
                            $delivery_road = $delivery_road['delivery_time'] + 1;


                            if ($transport_limit == 'yes' && $delivery_road > intval($days_limit)) {
                                WC()->cart->remove_cart_item($key);
                                WC()->session->set('removed_on_checkout', 'yes');
                            }
                        }

                        if ($shipping_method == str_starts_with($shipping_method, 'gold-aereo')) {
                            $air = "SELECT delivery_time FROM `{$wpdb->prefix}wgs_air_destiny` WHERE city = '{$city}'";
                            $delivery_air = $wpdb->get_row($air, ARRAY_A);
                            $delivery_air = $delivery_air['delivery_time'] + 1;

                            if ($transport_limit == 'yes' && $delivery_air > intval($days_limit)) {
                                WC()->cart->remove_cart_item($key);
                                WC()->session->set('removed_on_checkout', 'yes');
                            }
                        }

                        if ($shipping_method == str_starts_with($shipping_method, 'anjun-aereo')) {
                            $delivery_type = $shipping_method == str_starts_with($shipping_method, 'anjun-aereo-rapido') ? 4 : 5;
                            $anjun_air = "SELECT delivery_time FROM `{$wpdb->prefix}anjun_air` WHERE ('{$postcode}' BETWEEN zipcode_start AND zipcode_end) AND type = '{$delivery_type}'";
                            $delivery_anjun_air = $wpdb->get_row($anjun_air, ARRAY_A);
                            $delivery_anjun_air = !empty($delivery_anjun_air) ? $delivery_anjun_air['delivery_time'] + 1 : '';

                            if ($transport_limit == 'yes' && $delivery_anjun_air > intval($days_limit)) {
                                WC()->cart->remove_cart_item($key);
                                WC()->session->set('removed_on_checkout', 'yes');
                            }
                        }

                        if ($shipping_method == str_starts_with($shipping_method, 'anjun-correios')) {
                            $correios = "SELECT delivery_time FROM `{$wpdb->prefix}anjun_correios` WHERE ({$postcode} BETWEEN zipcode_start AND zipcode_end)";
                            $delivery_correios = $wpdb->get_row($correios, ARRAY_A);
                            $delivery_correios = $delivery_correios['delivery_time'] + 1;


                            if ($transport_limit == 'yes' && $delivery_correios > intval($days_limit)) {
                                WC()->cart->remove_cart_item($key);
                                WC()->session->set('removed_on_checkout', 'yes');
                            }
                        }
                    }
                }

                if (!empty($ids)) {
                    WC()->session->set('refrigerated_product_id', $ids);
                    WC()->session->set('refrigerated_product_qty', $refrigerated_qty);
                }

                if (WC()->cart->is_empty() && !empty($ids)) {
                    wp_send_json(
                        array(
                            'reload'    => true,
                        )
                    );
                }
            }
        }

        function str_filter($value)
        {
            $from = "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ";
            $to = "aaaaeeiooouucAAAAEEIOOOUUC";

            $keys = array();
            $values = array();
            preg_match_all('/./u', $from, $keys);
            preg_match_all('/./u', $to, $values);
            $mapping = array_combine($keys[0], $values[0]);
            $value = strtr($value, $mapping);

            return $value;
        }

        function add_product_attributes_on_product_card()
        {

            global $product;


            if ($product->is_type('subscription')) {
                $short_description = get_post_meta($product->get_id(), '_short_description', true);
                echo "<div style='' class='not-beer card-attributes subscription-products'>
                        <p class='card_by_style' style='margin-bottom: 0px; font-size: 12px;'>
                            <span class='line-clamp-3' style='color:#808080; font-family: gotham bold;'>
                                {$short_description}
                            </span>
                        </p>
                    </div>";
                return;
            }

            if (!$product->is_type('bundle')) {
                $by_style = $product->get_attribute('pa_por-estilo');
                $volume = get_post_meta($product->get_id(), '_volume', true);
                $alcoholic_dosage = get_post_meta($product->get_id(), '_alcoholic_dosage', true);

                $product_cat = get_the_terms($product->get_id(), 'product_cat', true)[0]->slug;
                if ($product_cat == 'cerveja') {
                    echo '<div class="card-attributes">
                        	<p title="' . $by_style . '" class="card_by_style text-truncate" style="margin-bottom: 0px;"><span style="color: #535353; font-family: gotham bold;">Estilo: </span><span style="color:#808080; font-family: gotham bold;">' . $by_style . '</span></p>
                    	<p class="card_alcoholic_dosage" style="margin-bottom: 0px;"><span style="color: #535353; font-family: gotham bold;">Dosagem Alcoólica: </span><span style="color:#808080; font-family: gotham bold;">' . $alcoholic_dosage . '</span></p>
                    	<p class="card_volume" style="margin-bottom: 0px;"><span style="color: #535353; font-family: gotham bold;">Volume: </span><span style="color:#808080; font-family: gotham bold;">' . $volume . '</span></p>
                	</div>';
                } else {
                    echo "<div style='height: 72px' class='not-beer card-attributes'></div>";
                }
                return;
            }

            $lineclamp = $_SERVER['REQUEST_URI'] == '/kits-e-souvenirs/' ? 'line-clamp-3' : 'line-clamp-2';


            $short_description = get_post_meta($product->get_id(), '_short_description', true);
            echo '<div style="" class="not-beer card-attributes bundle-products"><p class="card_by_style" style="margin-bottom: 0px; font-size: 16px;"><span style="color: #535353; font-family: gotham bold;">Descrição: </span><span class="' . $lineclamp . '" style="color:#808080; font-family: gotham bold;">' .  $short_description . '</span></p></div>';
            return;
        }

        function cdc_contact_us()
        {
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $secret = '6Lf1vDceAAAAAF595UQkxmhyjl94xDWv_A7-nCtb';
            $response = $_POST['token'];

            $request = file_get_contents($url . '?secret=' . $secret . '&response=' . $response);

            $result = json_decode($request);
            if ($result->success == false) {
                wp_send_json(array(
                    'status' => false,
                ));
            }

            if (!wp_verify_nonce($_POST['woocommerce_nonce'], 'woocommerce-contact-us')) {
                wp_send_json(array(
                    'status' => false,
                ));
            }

            $headers[] = 'Content-Type: text/html; charset=UTF-8';
            $headers[] = 'From: Central da Cerveja <noreply@centraldacerveja.com.br>';
            $headers[] = 'Bcc: ' . esc_attr($_POST['name']) . ' <' . esc_attr($_POST['email']) . '>';
            $headers[] = 'Reply-To: ' . esc_attr($_POST['name']) . ' <' . esc_attr($_POST['email']) . '>';

            $subject = $_POST['subject'];

            $emails = preg_split('/\s*,\s*/', get_option('woocommerce_cdc_contact_us_settings')['recipient'], -1, PREG_SPLIT_DELIM_CAPTURE);

            if (!empty($emails)) {
                $to = array();

                foreach ($emails as $email) {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        array_push($to, $email);
                    }
                }

                ob_start();
                include get_template_directory() . "/woocommerce/emails/contact-us.php";
                $template = ob_get_contents();
                ob_end_clean();
            }

            do_action('mail_contact_us', [
                'post' => $_POST,
                'emails' => $emails,
            ]);

            if (wp_mail($to, $subject, $template, $headers) && get_option('woocommerce_cdc_contact_us_settings')['enabled'] == 'yes') {
                wp_send_json(array(
                    'status' => true,
                ));
            } else {
                wp_send_json(array(
                    'status' => false,
                ));
            }
        }

        private function prepare_data_barrel_request($data)
        {
            return [
                'Name' => $data['name'],
                'Phone' => $data['phone'],
                'Email' => $data['email'],
                'Date' => $data['delivery_date'],
                'State' => $data['state'],
                'City' => $data['city'],
                'AdditionalInformation' => $data['request_info'],
                'SupplierName' => !empty($data['suppliers']) ? implode(', ', $data['suppliers']) : '--',
                'Liters' => $data['liters'],
                'Style' => $data['style']
            ];
        }

        function barrel_request()
        {
            global $wpdb;
            $table = $wpdb->prefix . 'cdc_barrel';
            if (!wp_verify_nonce($_POST['woocommerce_nonce'], 'woocommerce-barrel-request')) {
                wp_send_json(array(
                    'status' => false,
                ));
            }

            $headers[] = 'Content-Type: text/html; charset=UTF-8';
            $headers[] = 'From:' . $_POST['email'] . "\r\n";

            $subject = !empty(get_option('woocommerce_cdc_barrel_request_settings')['subject']) ? get_option('woocommerce_cdc_barrel_request_settings')['subject'] : 'Central da Cerveja - Solicitação de Barril';

            $emails = preg_split('/\s*,\s*/', get_option('woocommerce_cdc_barrel_request_settings')['recipient'], -1, PREG_SPLIT_DELIM_CAPTURE);

            if (!empty($emails)) {
                $to = array();

                foreach ($emails as $email) {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        array_push($to, $email);
                    }
                }

                ob_start();
                include get_template_directory() . "/woocommerce/emails/barrel-request.php";
                $template = ob_get_contents();
                ob_end_clean();
            }

            do_action('mail_barrel_data', ['to' => $to, 'subject' => $subject, 'post' => $this->prepare_data_barrel_request($_POST)]);
            if (wp_mail($to, $subject, $template, $headers) && get_option('woocommerce_cdc_barrel_request_settings')['enabled'] == 'yes') {

                $wpdb->insert($table, $this->prepare_data_barrel_request($_POST));
                wp_send_json(array(
                    'status' => true,
                ));
            } else {
                wp_send_json(array(
                    'status' => false,
                ));
            }
        }

        function list_cities_my_barrel_form()
        {
            try {
                global $wpdb;
                $table_states = $wpdb->prefix . 'cdc_states';
                $table_cities = $wpdb->prefix . 'cdc_cities';

                $state = $_POST['state'];

                $sql = "SELECT cities.name FROM {$table_states} AS state
                    INNER JOIN {$table_cities} cities ON state.id = cities.state_id
                    WHERE state.name = '{$state}'";

                $cities = $wpdb->get_results($sql);

                if (!empty($cities)) {
                    wp_send_json(array(
                        'status' => true,
                        'cities' => $cities
                    ));
                }
            } catch (Exception $exception) {
                wp_send_json(array(
                    'status' => false,
                    'message' => $exception->getMessage(),
                ));
            }
        }

        function product_valid_date_admin($product_id)
        {
            global $wpdb;

            if (isset($_GET['page']) && $_GET['page'] == 'wc-orders') {
                $post = $_GET['id'];

                if (!empty($product_id)) {
                    $result = $wpdb->get_row("
                    SELECT valid_date FROM {$wpdb->prefix}cdc_stock_control WHERE order_id = {$post} AND product_id = {$product_id} ORDER BY DATE
                ", ARRAY_A);

                    return $result['valid_date'];
                }
            }
        }

        function product_valid_date($product_id)
        {
            global $wpdb;
            if (!empty($product_id)) {
                $result = $wpdb->get_row("
                    SELECT date FROM {$wpdb->prefix}cdc_ticket_products WHERE product_id = {$product_id} AND status = 'ativo' ORDER BY DATE;
                ", ARRAY_A);

                return $result['date'] ?? '';
            }
        }

        function get_orders_ids_by_product_id($product_id, $order_status = array('wc-completed'), $date_from)
        {
            global $wpdb;
            $date_to = date('Y-m-d H:i:s');

            $results = $wpdb->get_col("
                SELECT order_items.order_id
                FROM {$wpdb->prefix}woocommerce_order_items as order_items
                LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
                LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as oim ON order_items.order_item_id = oim.order_item_id 
                LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
                WHERE posts.post_type = 'shop_order'
                AND posts.post_status IN ( '" . implode("','", $order_status) . "' )
                AND  posts.post_date >= '{$date_from}'
                AND  posts.post_date <= '{$date_to}'
                AND order_items.order_item_type = 'line_item'
                AND order_item_meta.meta_key = '_product_id'
                AND order_item_meta.meta_value = '$product_id'
                AND oim.meta_key = '_reduced_stock'
			    AND oim.meta_value > 0
                ORDER BY order_items.order_id ASC
            ");

            return $results;
        }

        function valid_date_cart_action($product_id, $is_order_admin = false)
        {
            $product_cat = get_the_terms($product_id, 'product_cat', true)[0]->slug;
            $valid_date = $is_order_admin ? $this->product_valid_date_admin($product_id) : $this->product_valid_date($product_id);
            $valid_date = !empty($valid_date) && $product_cat == 'cerveja' ? date('d/m/Y', strtotime($valid_date)) : '--';

            echo $valid_date;
        }

        function get_sold_quantity($date_from, $order_id, $product_id)
        {
            global $wpdb;
            $date_to = date('Y-m-d H:i:s');
            $num_items_sold = array();
            foreach ($order_id as $order) {
                $num_items_sold[] = $wpdb->get_var($wpdb->prepare("
                SELECT     oim.meta_value
                FROM       {$wpdb->prefix}woocommerce_order_itemmeta as oim
                INNER JOIN {$wpdb->prefix}woocommerce_order_items as oi
                    ON     oim.order_item_id = oi.order_item_id
                INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item
                    ON order_item.order_item_id = oi.order_item_id
                    AND     order_item.meta_key = '_product_id' AND order_item.meta_value = {$product_id}
                INNER JOIN {$wpdb->prefix}posts as p
                    ON     oi.order_id = p.ID
                WHERE      oim.meta_key = '_qty'
                    AND    p.ID = %d
                    AND    p.post_status IN ('wc-completed', 'wc-processing', 'wc-on-hold', 'wc-in-preparation', 'wc-arrival-shipment', 'wc-refunded', 'wc-failed')
                    AND    p.post_date >= '{$date_from}'
                    AND    p.post_date <= '{$date_to}'
            ", $order, $date_from, $date_to));
            }

            return $num_items_sold;
        }

        function admin_order_item_header_valid_date($order)
        {
        ?>
            <th class="item_valid_date sortable" data-sort="date">
                Data de Validade
            </th>
        <?php
        }

        function admin_order_item_value_valid_date($product, $item, $item_id)
        {
        ?>
            <td class="item_valid_date">
                <?php
                if (!empty($product->id)) {
                    $this->valid_date_cart_action($product->id, true);
                } else {
                    echo '--';
                }
                ?>
            </td>
<?php
        }

        /**
         * Adiciona a classe css para efetuar o clamp do titulo do produto na listagem das grids
         *
         * line-clamp-1  = 1 linha
         * line-clamp-2  = 2 linhas
         * ...
         * line-clamp-5  = 5 linhas
         * 
         * @param string $class
         * @return string
         */
        public function add_class_woocommerce_product_loop(string $class): string
        {
            $line_clamp = (is_page_template('kits-and-souvenirs.php')) ? "line-clamp-2" : "line-clamp-2 woocommerce-loop-product__title_truncate";

            return $class . " " . $line_clamp;
        }

        public function rename_images_before_upload($filename)
        {
            if (empty($filename)) {
                return;
            }

            $path_extension = pathinfo($filename, PATHINFO_EXTENSION);
            $allowed_extensions = ['jpg', 'jpeg', 'png'];
            if (in_array($path_extension, $allowed_extensions)) {
                $ext  = '.' . $path_extension;
                return uniqid() . $ext;
            }
        }

        public function rename_uploaded_product_image_name()
        {
            try {
                if (get_option('product_images_renamed') == 'yes') return;

                if (!function_exists('wp_generate_attachment_metadata ')) {
                    include(ABSPATH . 'wp-admin/includes/image.php');
                }

                $args = array(
                    'post_type' => 'product',
                    'fields' => 'ids',
                    'posts_per_page' => -1,
                    'post_status' => 'publish'
                );

                $query = new WP_Query($args);

                foreach ($query->posts as $product) {
                    $newfilename = uniqid();
                    $attachment_id = get_post_thumbnail_id($product);

                    $file = get_attached_file($attachment_id);
                    $file_metadata = wp_get_attachment_metadata($attachment_id);

                    if (!empty($file) && file_exists($file)) {
                        $path = pathinfo($file);

                        $newfile = $path['dirname'] . "/" . $newfilename . "." . $path['extension'];
                        if (rename($file, $newfile)) update_attached_file($attachment_id, $newfile);
                    }

                    if (!empty($file_metadata)) {
                        $explode_file_name = explode('/wp-content/uploads/', $file);
                        foreach ($file_metadata['sizes'] as $key => $metadata) {

                            $explode_metadata = explode('-', $file_metadata['sizes'][$key]['file']);

                            $old_metadata_path =  $path['dirname'] . "/" . $file_metadata['sizes'][$key]['file'];
                            $new_metadata_file_name = $path['dirname'] . "/" . $newfilename . '-' . end($explode_metadata);

                            $file_metadata['sizes'][$key]['file'] = $newfilename . '-' . end($explode_metadata);

                            if (file_exists($old_metadata_path)) rename($old_metadata_path, $new_metadata_file_name);
                        }

                        $file_metadata['file'] = end($explode_file_name);
                    }
                    wp_update_attachment_metadata($attachment_id, $file_metadata);
                }

                update_option('product_images_renamed', 'yes');
            } catch (Exception $exception) {
                $this->logger('Falha ao renomear arquivo', $exception->getMessage());
            }
        }

        public function change_password_hint($hint)
        {
            $hint = 'Dica: A senha deve ter pelo menos oito caracteres. Para torná-la mais forte, use letras maiúsculas e minúsculas, números e símbolos como ! " ? $ % ^ & ).';
            return $hint;
        }

        public function checkout_form_additional_validations($fields, $errors)
        {
            $password = $fields['account_password'];

            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);

            $phone_regex = '/^(?:(?:\+|00)?(55)\s?)?(?:\(?([1-9][0-9])\)?\s?)?(?:((?:9\d|[2-9])\d{3})\-?(\d{4}))$/';
            $phone_is_valid = preg_match($phone_regex, $fields['billing_phone']);

            if (!empty($fields['billing_cpf'])) {
                $cpf_registered = $this->is_cpf_registered($fields['billing_cpf']);
                if ($cpf_registered) {
                    $invalid_cpf = '<li><b>CPF</b> já cadastrado.</li>';
                    $errors->add('validation', $invalid_cpf);
                }
            }

            if (!empty($fields['billing_phone'])) {
                if (!$phone_is_valid) {
                    $invalid_phone = '<li><b>O campo "Celular" do endereço de faturamento</b> é um campo inválido.</li>';
                    $errors->add('validation', $invalid_phone);
                }
            }

            if (!empty($fields['account_password'])) {
                if (!is_user_logged_in()) {
                    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                        $invalid_password = '<li><b>Senha inválida</b>. Por favor inserir pelo menos oito caracteres, contendo pelo menos uma letra maiúscula, pelo menos uma letra minúscula, pelo menos um símbolo e pelo menos um número.</li>';
                        $errors->add('validation', $invalid_password);
                    }
                }
            }
        }

        public function is_cpf_registered($cpf)
        {
            $get_user = get_users(array(
                'meta_key' => 'billing_cpf',
                'meta_value' => $cpf
            ));

            if (empty($get_user) || $get_user[0]->ID == get_current_user_id()) return false;

            return true;
        }

        public function admin_order_item_value_line_total($product, $item, $item_id)
        {
            if (!empty($item->get_meta('_price_with_discount'))) {
                $item['line_total'] = $item->get_meta('_price_with_discount') * $item->get_quantity();
                $item['subtotal'] = $item->get_meta('_original_price') * $item['quantity'];
            }
        }



        public function woocommerce_change_payment_order_notification($order)
        {

            $order_id =  $order->get_id();
            if (!$order_id && is_wc_endpoint_url('order-pay') || (isset($_GET['pay_for_order']) && $_GET['pay_for_order'] == 'true')) return;

            $order_status = $order->get_status();

            if (($order_status == 'failed') &&  !is_cart() && $order->get_payment_method() == 'woo-mercado-pago-custom') {

                $url =  esc_url($order->get_checkout_payment_url());
                $button = __('Click to try again', 'woocommerce-mercadopago');

                $msg = "<div class='container'>
                            <div class='row'>
                                <div class='col-12 px-3 px-md-0'>
                                    <ul class='woocommerce-error' role='alert'>
                                        <li>
                                            <p>Ocorreu algum problema no processo. Alteramos a processadora de pagamentos. Clique aqui e tente novamente.</p><br>
                                            <p>
                                            
                                                <a id='mp_failed_payment_button' class='button' style='color: #333;' href='{$url}'>
                                                    {$button}
                                                </a>
                                                
                                            </p>
                                            
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>";
                echo wp_json_encode([
                    'messages' => $msg,
                    'refresh' => false,
                    'reload' => false,
                    'result' => "failure"
                ]);
                exit();
            }
        }

        private function is_subscription($payload)
        {
            $flag = false;
            foreach ($payload as $item) {

                if ($item->is_type('subscription')) {
                    $flag = true;
                };
            }

            return $flag;
        }


        public function woocommerce_change_payment_order($available_gateways)
        {

            if (is_admin()) return $available_gateways;

            $all_gateways = WC()->payment_gateways()->payment_gateways();
            $hidden_mode = get_option('pagamentos_para_woocommerce_com_appmax_settings')['gateway']['hidden_mode'];

            if (is_wc_endpoint_url('order-pay')) {
                $order = wc_get_order(absint(get_query_var('order-pay')));

                if (is_a($order, 'WC_Order') && ($order->has_status('pending') || $order->has_status('failed'))) {
                    unset($available_gateways['woo-mercado-pago-custom']);
                    unset($available_gateways['woo-mercado-pago-pix']);
                    unset($available_gateways['cdc_payment_pix_gateway_appmax']);
                    unset($available_gateways['cdc_payment_gateway_appmax']);
                    $available_gateways['stripe'] = $all_gateways['stripe'];
                } else {
                    unset($available_gateways['stripe']);
                }
            } else if (is_account_page()) {
                return $available_gateways;
            } else {
                $cart = WC()->cart;
                $isValid = ($cart && !empty(array_shift($cart->get_cart())['data'])) ? array_shift($cart->get_cart())['data']->is_type('subscription') : false;
                if ($isValid) return $available_gateways;

                unset($available_gateways['woo-mercado-pago-custom']);
                unset($available_gateways['woo-mercado-pago-pix']);
                unset($available_gateways['stripe']);
            }
            // return $available_gateways;

            if (isset($_POST['post_data'])) {
                parse_str($_POST['post_data'], $data);
            }

            if ($hidden_mode == 0 || (current_user_can('administrator') && $hidden_mode == 1)) {
                unset($available_gateways['woo-mercado-pago-custom']);
                unset($available_gateways['woo-mercado-pago-pix']);
            }

            $has_error = WC()->session && WC()->session->get('has_payment_error') ? WC()->session->get('has_payment_error') : 0;
            // || count($_SESSION['error_payment_methods'] ?? []) > 0
            if ($has_error) {

                $error_payment_methods = [
                    'cdc_payment_gateway_appmax',
                    'cdc_payment_pix_gateway_appmax',
                ];
                $_SESSION['error_payment_methods'] = $error_payment_methods;

                foreach ($error_payment_methods as $key => $error_payment_method) {
                    if (isset($available_gateways[$error_payment_method])) {
                        unset($available_gateways[$error_payment_method]);
                    }
                }

                if (strlen(get_query_var('order-pay')) == 0) {
                    $available_gateways['woo-mercado-pago-custom'] = $all_gateways['woo-mercado-pago-custom'];
                    $available_gateways['woo-mercado-pago-pix'] = $all_gateways['woo-mercado-pago-pix'];
                }
            }

            return $available_gateways;
        }

        private function oldest_ticket_in_stock($product_id)
        {
            global $wpdb;
            if (!empty($product_id)) {
                $query = $wpdb->get_results("
                SELECT DISTINCT ticket_id, date FROM {$wpdb->prefix}cdc_stock_manager WHERE ticket_id IS NOT NULL AND qty_added IS NOT NULL and product_id = '{$product_id}'
            ");

                $statuses = array('wc-completed', 'wc-processing', 'wc-on-hold', 'wc-in-preparation', 'wc-arrival-shipment', 'wc-refunded', 'wc-failed');

                foreach ($query as $post) {
                    $order_id = $this->get_orders_ids_by_product_id($product_id, $statuses, $post->date);

                    $product_sold_qty = $this->get_sold_quantity($post->date, $order_id, $product_id);
                    $product_sold_qty = !empty($product_sold_qty) ? array_sum($product_sold_qty) : '';

                    $ticket_sold_meta = json_decode(get_post_meta($post->ticket_id, 'ticket_products', true));

                    if (!empty($post)) {
                        $result_qty_removed = $wpdb->get_row("
                        SELECT sum(qty_removed) as qty FROM {$wpdb->prefix}cdc_stock_manager WHERE product_id = '{$product_id}'
                        AND (date >= '{$post->date}')
                        AND reason > 0
                        AND ticket_id = {$post->ticket_id}
                    ", ARRAY_A);
                    }

                    $ticket_quantity = !empty($result_qty_removed['qty']) ? $result_qty_removed['qty'] : 0;
                    $product_ticket_qty = intval($ticket_quantity) + intval($product_sold_qty);

                    if (!empty($ticket_sold_meta)) {
                        foreach ($ticket_sold_meta as $sold_meta) {

                            $sum_ticket_quantity = 0;
                            foreach ($ticket_sold_meta as $key => $value) {
                                if ($value->product_id == $sold_meta->product_id) {
                                    $sum_ticket_quantity += ((isset($value->real_quantity) && !empty($value->real_quantity)) && intval($value->real_quantity) > 0) ? intval($value->real_quantity) : intval($value->quantity);
                                }
                            }
                            if ($product_id == $sold_meta->product_id && $product_ticket_qty < $sum_ticket_quantity && strtotime($sold_meta->date) > strtotime(date('Y-m-d'))) {

                                return $post->ticket_id;
                            }
                        }
                    }
                }
            }
        }

        public function cdc_subscription_email_notification()
        {
            global $wpdb;

            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $secret = '6Lf1vDceAAAAAF595UQkxmhyjl94xDWv_A7-nCtb';
            $response = $_POST['token'];

            $request = file_get_contents($url . '?secret=' . $secret . '&response=' . $response);

            $result = json_decode($request);
            if ($result->success == false) {
                wp_send_json(array(
                    'status' => false,
                ));
            }

            if (!wp_verify_nonce($_POST['woocommerce_nonce'], 'woocommerce-cdc-email-subscription-notification')) {
                wp_send_json(array(
                    'status' => false,
                ));
            }

            $table = $wpdb->prefix . 'cdc_subscription_user_notification';

            $data = [
                'name' => $_POST['name'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
            ];

            if ($wpdb->insert($table, $data)) {
                wp_send_json(array(
                    'status' => true,
                ));
            } else {
                wp_send_json(array(
                    'status' => false,
                ));
            }
        }

        public function redirect_subscription_to_cart($url)
        {
            if (isset($_GET['type']) && $_GET['type'] == 'subscription') {
                $url = wc_get_cart_url();
                wp_redirect($url);
            }

            return $url;
        }

        public function mixed_checkout_validation($valid, $product_id, $quantity, $variation_id = '', $variations = array())
        {
            $mixed_checkout = get_option('woocommerce_subscriptions_multiple_purchase');
            $is_subscription = get_post_meta($product_id, '_subscription_price', true);

            if ($mixed_checkout == 'no') {
                foreach (WC()->cart->get_cart() as $cart_key => $cart_item) {
                    if (!$is_subscription && $cart_item['data']->is_type('subscription')) {
                        WC()->cart->remove_cart_item($cart_key);
                    }
                }
            }

            return $valid;
        }

        public function check_value_for_free_shipping()
        {
            $shipping_method = !empty($_POST['shipping_method']) ? $_POST['shipping_method'] : WC()->session->get('chosen_shipping_methods')[0];
            $cart_subtotal = WC()->cart->get_totals()['subtotal'];
            $has_coupon = (WC()->cart->get_applied_coupons());
            $discount_coupon = 0;
            if (count($has_coupon) > 0) {
                $discount_coupon = WC()->cart->get_cart_discount_total();
            }

            $settings = $this->get_shipping_options($shipping_method);

            $send_with_subscription = WC()->session->get('send_product_with_subscription');

            if (isset($settings['free_shipping']) && $settings['free_shipping'] > ($cart_subtotal - $discount_coupon) && $send_with_subscription == 0) {
                $value = floatval($settings['free_shipping']) - (floatval($cart_subtotal) - floatval($discount_coupon));
                $value = wc_price($value);
                $message = "Faltam {$value} para que você tenha frete grátis para sua compra";

                wp_send_json(array(
                    'status' => true,
                    'message' => $message
                ));
            }

            wp_send_json(array(
                'status' => false
            ));
        }

        /**
         * Retorna uma lista de produtos, incluindo detalhes do fornecedor.
         *
         * @param int $limit Limite de produtos a serem recuperados (padrão: 24).
         * @return array Uma matriz de produtos, organizados em blocos de 8, ou uma matriz vazia se nenhum produto for encontrado.
         */
        public function get_featured_products($limit = 24)
        {
            // Executa a consulta e armazena os resultados em $products.
            $products = $this->get_products($limit);

            // Verifica se existe produtos
            if (empty($products)) {
                return [];
            }


            // Extrai os IDs exclusivos dos fornecedores dos produtos em destaque.
            $supplier_ids = implode(',', array_unique(array_filter(array_map(function ($item) {
                return isset($item->supplier_id) && $item->supplier_id !== '' ? $item->supplier_id : null;
            }, $products))));

            // Executa a consulta e armazena os resultados em $supplier_lookup, um array associativo indexado pelo ID do fornecedor.
            $supplier_lookup = array_column($this->get_suppliers_from_product_card($products), null, 'id');

            // Associa as informações do fornecedor aos produtos em destaque.
            foreach ($products as $key => $value) {
                // Utiliza o $supplier_lookup para obter informações do fornecedor com base no supplier_id do produto em destaque.
                $supplier_id = $products[$key]->supplier_id;
                if (isset($supplier_lookup[$supplier_id])) {
                    $products[$key]->supplier_name = $supplier_lookup[$supplier_id]->supplier_name;
                    $products[$key]->supplier_slug = $supplier_lookup[$supplier_id]->supplier_slug;
                    $products[$key]->supplier_image = $supplier_lookup[$supplier_id]->supplier_image;
                }
            }

            if (!empty($products)) {
                // Separa os produtos em blocos de 8.
                $products = array_chunk($products, 8);
            }

            // Retorna a matriz de produtos em destaque.
            return $products;
        }

        private function get_products($limit = 24)
        {
            global $wpdb;

            // Verifica se o cache externo (como Redis) está ativado
            if (wp_using_ext_object_cache()) {
                // Tenta obter os dados em cache
                $cache_key = '_get_products' . $limit;
                $cached_data = wp_cache_get($cache_key);

                if ($cached_data !== false) {
                    // Retorna os dados em cache se disponíveis
                    return $cached_data;
                }
            }

            // Consulta SQL para recuperar produtos.
            $sql = "SELECT p.*, 
                MAX(CASE WHEN pm.meta_key = '_regular_price' THEN pm.meta_value END) AS regular_price,
                MAX(CASE WHEN pm.meta_key = '_sale_price' THEN pm.meta_value END) AS sale_price,
                MAX(CASE WHEN pm.meta_key = '_stock' THEN pm.meta_value END) AS stock,
                MAX(CASE WHEN pm.meta_key = '_stock_status' THEN pm.meta_value END) AS stock_status
            FROM {$wpdb->prefix}cdc_products AS p
            INNER JOIN {$wpdb->prefix}postmeta AS pm ON (p.id = pm.post_id)
            GROUP BY p.id ORDER BY p.created_at DESC LIMIT $limit";

            // Executa a consulta SQL
            $results = $wpdb->get_results($sql);

            if (wp_using_ext_object_cache()) {
                // Armazena os resultados em cache por 1 hora (3600 segundos)
                wp_cache_set($cache_key, $results, '', 3600);
            }

            return $results;
        }

        private function get_suppliers_from_product_card(array $products)
        {
            global $wpdb;

            // Verifica se o cache externo (como Redis) está ativado
            if (wp_using_ext_object_cache()) {
                // Tenta obter os dados em cache
                $cache_key = '_get_suppliers_from_product_card';
                $cached_data = wp_cache_get($cache_key);

                if ($cached_data !== false) {
                    // Retorna os dados em cache se disponíveis
                    return $cached_data;
                }
            }

            // Extrai os IDs exclusivos dos fornecedores dos produtos em destaque.
            $supplier_ids = implode(',', array_unique(array_filter(array_map(function ($item) {
                return isset($item->supplier_id) && $item->supplier_id !== '' ? $item->supplier_id : null;
            }, $products))));

            // Consulta SQL para recuperar informações dos fornecedores.
            $sql = "SELECT s.*, i.meta_value AS supplier_image FROM {$wpdb->prefix}postmeta AS i
            INNER JOIN (
                SELECT s.ID AS id, s.post_title AS supplier_name, s.post_name AS supplier_slug, sm.meta_value AS thumbnail_id FROM {$wpdb->prefix}posts AS s
                LEFT JOIN {$wpdb->prefix}postmeta AS sm ON (sm.post_id = s.ID AND sm.meta_key = '_thumbnail_id')
                WHERE s.ID IN($supplier_ids)
            ) AS s ON (s.thumbnail_id = i.post_id)
            WHERE i.meta_key = '_wp_attached_file'";

            // Executa a consulta SQL
            $results = $wpdb->get_results($sql);

            if (wp_using_ext_object_cache()) {
                // Armazena os resultados em cache por 1 hora (3600 segundos)
                wp_cache_set($cache_key, $results, '', 3600);
            }

            return $results;
        }

        public function remove_coupon_subscriptions()
        {

            // Verifica se o WooCommerce Subscriptions está ativo
            if (!class_exists('WC_Subscriptions_Product')) {
                return;
            }

            // Verifica se o carrinho contém assinaturas
            $has_subscription = false;

            foreach (WC()->cart->get_cart() as $cart_item) {
                $product_id = $cart_item['product_id'];
                if (WC_Subscriptions_Product::is_subscription($product_id)) {
                    $has_subscription = true;
                    break;
                }
            }

            // Se o carrinho tiver assinaturas, remove os cupons aplicados
            if ($has_subscription && WC()->cart->has_discount()) {
                // Limpar todas as notificações de cupons
                wc_clear_notices();

                // Remover os cupons aplicados
                WC()->cart->remove_coupons();

                // Adicionar a mensagem de erro
                wc_add_notice(__('Cupons não podem ser aplicados a produtos de assinatura.', 'centradacerveja'), 'error');
            }
        }

        /**
         * Obtém uma lista de produtos ativos vinculados a tickets com status 2 ou 4.
         *
         * Regras de Negócio:
         * - O controle de certificado expirado e estoque é realizado pelas funcionalidades 
         *   que alimentam e atualizam as tabelas `cdc_ticket_products` e `cdc_products`.
         * - A tabela `cdc_products` é alimentada automaticamente por uma procedure 
         *   sempre que um produto é cadastrado ou atualizado.
         *
         * Parâmetros:
         * @param string $type Tipo de filtro a ser aplicado na busca. Padrão: all.
         * - releases: Retorna produtos vinculados a tickets com data de aprovação mais recente.
         * - sales: Retorna produtos com promoção, ordenados aleatoriamente.
         * - featured: Retorna produtos em destaque, ordenados aleatoriamente.
         * @param int $limit Número máximo de registros a serem retornados. Padrão: 24.
         * @param array $remove_ids Array de IDs de produtos a serem excluídos dos resultados.
         *
         * Retorno:
         * @return array Lista de produtos ativos vinculados a tickets, estruturada como um array associativo. 
         *               Retorna um array vazio em caso de erro.
         */
        public function get_active_ticket_products(string $type = 'all', int $limit = 24, array $remove_ids = []): array
        {
            global $wpdb;

            // Sanitiza e valida os IDs de exclusão
            $sanitized_remove_ids = $this->sanitize_product_ids($remove_ids);

            // Chave de cache única considerando os IDs excluídos
            $remove_ids_hash = !empty($sanitized_remove_ids) ? md5(implode(',', $sanitized_remove_ids)) : 'none';
            $cache_key = "active_ticket_products_{$type}_{$limit}_{$remove_ids_hash}";

            // Tenta obter os dados do cache Redis
            $cached_data = wp_cache_get($cache_key, 'centraldacerveja');

            if ($cached_data !== false) {
                return $cached_data;
            }

            // Monta o filtro de exclusão de produtos
            $exclude_filter = $this->build_exclude_filter($sanitized_remove_ids);

            switch ($type) {
                case 'releases':
                    $filters = $exclude_filter;
                    $order_by = " ORDER BY `p`.`approved_date_product` DESC ";
                    break;
                case 'sales':
                    $filters = " AND (`pm_sale_price`.`meta_value` <> '' AND `pm_sale_price`.`meta_value` > 0)" . $exclude_filter;
                    $order_by = " ORDER BY RAND() ";
                    break;
                case 'featured':
                    $filters = " AND `p`.`id` IN ( SELECT `id` FROM `{$wpdb->prefix}featured_products` WHERE `status` = 'publish' AND `stock_status` = 'instock')" . $exclude_filter;
                    $order_by = " ORDER BY RAND() ";
                    break;
                default:
                    $filters = $exclude_filter;
                    $order_by = " ORDER BY p.created_at DESC ";
                    break;
            }

            try {
                $query = $wpdb->prepare("
                    WITH `tickets` AS (
                        SELECT DISTINCT `p`.`ID` AS `ticket_id` 
                        FROM `{$wpdb->prefix}posts` AS `p`
                        INNER JOIN `{$wpdb->prefix}postmeta` AS `pm` ON (
                            `p`.`ID` = `pm`.`post_id` 
                            AND `pm`.`meta_key` = 'ticket_status' 
                            AND `pm`.`meta_value` IN ('2', '4')
                        )
                        WHERE `p`.`post_type` = 'cdc_ticket' 
                        AND `p`.`post_status` = 'publish'
                    ),
                    `unique_products` AS (
                        SELECT DISTINCT
                            `p`.`id` AS `product_id`,
                            MIN(`t`.`ticket_id`) AS `primary_ticket_id`
                        FROM `tickets` AS `t`
                        INNER JOIN `{$wpdb->prefix}cdc_ticket_products` AS `tp` ON (
                            `t`.`ticket_id` = `tp`.`ticket_id`
                            AND `tp`.`status` = 'ativo'
                        )
                        INNER JOIN `{$wpdb->prefix}cdc_products` AS `p` ON (`p`.`id` = `tp`.`product_id`)
                        INNER JOIN `{$wpdb->prefix}cdc_stock_manager` AS `sm` ON (
                            `t`.`ticket_id` = `sm`.`ticket_id` 
                            AND `p`.`id` = `sm`.`product_id`
                            AND `sm`.`remaining_stock` > 0
                        )
                        WHERE `p`.`status` = 'publish'
                        GROUP BY `p`.`id`
                    ),
                    `reserved_totals` AS (
                        SELECT `product_id`, SUM(`stock_quantity`) AS `reserved_qty`
                        FROM `{$wpdb->prefix}wc_reserved_stock`
                        WHERE `expires` > NOW()
                        GROUP BY `product_id`
                    )
                    SELECT
                        `p`.`id`, 
                        `p`.`name`, 
                        `p`.`supplier_id`,
                        `p`.`sku`,
                        `p`.`slug`,
                        `p`.`type`, 
                        COALESCE(`pm_price`.`meta_value`, '0') AS `price`, 
                        COALESCE(NULLIF(`pm_sale_price`.`meta_value`, ''), '0') AS `sale_price`,
                        `p`.`status`,
                        `s`.`post_title` AS `supplier_name`,
                        `s`.`post_name` AS `supplier_slug`,
                        `img`.`guid` AS `supplier_image`,
                        `p`.`image`,
                        `p`.`country`,
                        `p`.`alcoholic_dosage`,
                        `p`.`excerpt`,
                        `p`.`volume`,
                        `p`.`style`,
                        `p`.`type`,
                        GREATEST(`sm`.`remaining_stock` - COALESCE(`rt`.`reserved_qty`, 0), 0) AS `remaining_stock`,
                        `p`.`created_at`, 
                        `p`.`updated_at`
                    FROM `unique_products` AS `up`
                    INNER JOIN `{$wpdb->prefix}cdc_products` AS `p` ON (`p`.`id` = `up`.`product_id`)
                    INNER JOIN `{$wpdb->prefix}cdc_stock_manager` AS `sm` ON (
                        `up`.`primary_ticket_id` = `sm`.`ticket_id` 
                        AND `p`.`id` = `sm`.`product_id`
                        AND `sm`.`remaining_stock` > 0
                    )
					LEFT JOIN `reserved_totals` AS `rt` ON (`p`.`id` = `rt`.`product_id`)
                    LEFT JOIN `{$wpdb->prefix}posts` AS `s` ON (
                        `p`.`supplier_id` = `s`.`ID` 
                        AND `s`.`post_type` = 'dwcc_supplier'
                        AND `s`.`post_status` = 'publish'
                    )
                    LEFT JOIN `{$wpdb->prefix}postmeta` AS `pm_thumb` ON (
                        `s`.`ID` = `pm_thumb`.`post_id` 
                        AND `pm_thumb`.`meta_key` = '_thumbnail_id'
                    )
                    LEFT JOIN `{$wpdb->prefix}posts` AS `img` ON (
                        `pm_thumb`.`meta_value` = `img`.`ID` 
                        AND `img`.`post_type` = 'attachment'
                    )
                    LEFT JOIN `{$wpdb->prefix}postmeta` AS `pm_price` ON (
                        `p`.`id` = `pm_price`.`post_id` 
                        AND `pm_price`.`meta_key` = '_regular_price'
                    )
                    LEFT JOIN `{$wpdb->prefix}postmeta` AS `pm_sale_price` ON (
                        `p`.`id` = `pm_sale_price`.`post_id` 
                        AND `pm_sale_price`.`meta_key` = '_sale_price'
                    )
                    WHERE 1=1 {$filters}
                    {$order_by}
                    LIMIT %d
                ", $limit);

                // Executa a query e obtém os resultados
                $results = $wpdb->get_results($query, ARRAY_A);

                if (empty($results)) {
                    return [];
                }

                // Aplica o filtro para o preço
                $results = array_map(function ($item) {
                    $item['price'] = $this->add_hook_product_price($item['id'], $item['price']);
                    $item['sale_price'] = $this->add_hook_product_price($item['id'], $item['sale_price']);
                    return $item;
                }, $results);

                // Armazena os resultados no cache Redis por 15 minutos (900 segundos)
                wp_cache_set($cache_key, $results, 'centraldacerveja', 900);

                return $results;
            } catch (Exception $e) {
                error_log("Erro na função get_active_ticket_products: " . $e->getMessage());
                return [];
            }
        }

        /**
         * Sanitiza e valida os IDs de produtos para exclusão
         * 
         * @param array $product_ids Array de IDs de produtos
         * @return array Array de IDs sanitizados
         */
        private function sanitize_product_ids(array $product_ids): array
        {
            if (empty($product_ids)) {
                return [];
            }

            return array_filter(
                array_map('intval', $product_ids),
                function ($id) {
                    return $id > 0;
                }
            );
        }

        /**
         * Constrói o filtro SQL para exclusão de produtos
         * 
         * @param array $sanitized_remove_ids Array de IDs sanitizados
         * @return string Filtro SQL
         */
        private function build_exclude_filter(array $sanitized_remove_ids): string
        {
            if (empty($sanitized_remove_ids)) {
                return '';
            }

            $ids_string = implode(',', $sanitized_remove_ids);
            return " AND `p`.`id` NOT IN ({$ids_string})";
        }

        /**
         * Adiciona o hook para o preço do produto, quando o mesmo é buscado diretamente do banco de dados.
         *
         * @param integer $product_id
         * @param float $price
         * @return void
         */
        public function add_hook_product_price(int $product_id, float $price)
        {
            return apply_filters('woocommerce_product_get_price', $price, wc_get_product($product_id));
        }

        /**
         * Adiciona um sufixo de tamanho à imagem antes da extensão. 
         * Se a URL da imagem for inválida ou vazia, retorna uma imagem padrão.
         * 
         * Obs: Os tamanhos são gerados automaticamente pelo WooCommerce via job nas ferramentas da loja.
         *
         * @param string $image_url URL da imagem original.
         * @param string $size Tamanho a ser adicionado antes da extensão (padrão: '300x300').
         * 
         * @return string URL da imagem com o tamanho adicionado ou a imagem padrão se inválida.
         */
        public function add_image_size_suffix($image_url, $size = '300x300')
        {
            // Define a imagem padrão caso a original seja inválida
            $default_image = "woocommerce-placeholder-{$size}.png";

            // Se a URL estiver vazia, retorna a imagem padrão
            if (empty($image_url)) {
                return $default_image;
            }

            // Obtém as partes do caminho da imagem (diretório, nome do arquivo e extensão)
            $path_parts = pathinfo($image_url);

            // Verifica se a imagem tem um nome de arquivo e uma extensão válida, retorna a default para imagens com o nome igual a -1
            if (!isset($path_parts['extension']) || empty($path_parts['filename'])) {
                return $default_image;
            }

            // Constrói a nova URL adicionando o sufixo do tamanho antes da extensão
            return $path_parts['dirname'] . '/' . $path_parts['filename'] . '-' . $size . '.' . $path_parts['extension'];
        }


        /**
         * Carrega um partial para exibir o card do produto usando buffer de saída.
         *
         * @param string $template_path Caminho do arquivo do partial (exemplo: 'partials/product-card.php').
         * @param array $data Dados do produto a serem passados para o template.
         *
         * @return string HTML gerado pelo template.
         */
        public function render_partial($template_path, $data = [])
        {
            // Verifica se o arquivo existe
            if (!file_exists($template_path)) {
                return '<!-- Template não encontrado: ' . esc_html($template_path) . ' -->';
            }

            // Extrai os dados para serem usados como variáveis no template
            extract($data);

            // Inicia o buffer de saída
            ob_start();

            // Inclui o template do card do produto
            include $template_path;

            // Retorna o conteúdo gerado pelo buffer e o limpa
            return ob_get_clean();
        }

        /**
         * Retorna a lista com nome e slug dos fornecedores que possuem produtos em estoque.
         *
         * @param integer $limit
         * @return void
         */
        public function get_suppliers_with_stock($limit = 0)
        {
            try {
                global $wpdb;

                $cache_key   = 'supplier_main_menu_' . intval($limit);
                $cache_group = 'centraldacerveja';
                $cache_ttl   = 60 * MINUTE_IN_SECONDS;

                $attr_vendor = wp_cache_get($cache_key, $cache_group);

                if ($attr_vendor === false) {
                    $limit_sql = $limit > 0 ? "LIMIT {$limit}" : "";

                    $query = "
                        SELECT s.ID, s.post_title, s.post_name
                        FROM {$wpdb->prefix}posts s
                        WHERE s.post_type = 'dwcc_supplier'
                        AND s.post_status = 'publish'
                        AND EXISTS (
                            SELECT 1
                            FROM {$wpdb->prefix}posts p
                            INNER JOIN {$wpdb->prefix}postmeta pm1 ON p.ID = pm1.post_id AND pm1.meta_key = '_supplier_id' AND pm1.meta_value = s.ID
                            INNER JOIN {$wpdb->prefix}postmeta pm2 ON p.ID = pm2.post_id AND pm2.meta_key = '_stock_status' AND pm2.meta_value = 'instock'
                            LEFT JOIN {$wpdb->prefix}postmeta pm3 ON p.ID = pm3.post_id AND pm3.meta_key = '_supplier_certificate_expired'
                            WHERE p.post_type = 'product'
                            AND p.post_status = 'publish'
                            AND (pm3.meta_value IS NULL OR pm3.meta_value != 1)
                            LIMIT 1
                        )
                        ORDER BY s.post_title ASC
                        {$limit_sql}
                    ";

                    $attr_vendor = $wpdb->get_results($query, ARRAY_A);

                    if (!is_wp_error($attr_vendor)) {
                        wp_cache_set($cache_key, $attr_vendor, $cache_group, $cache_ttl);
                    } else {
                        error_log('Erro ao executar consulta SQL em get_suppliers_with_stock: ' . print_r($attr_vendor, true));
                        return [];
                    }
                }

                return $attr_vendor;
            } catch (Exception $ex) {
                error_log('Falha ao buscar fornecedores no menu principal: ' . $ex->getMessage());
                return [];
            }
        }
        public function check_stock_products_checkout()
        {
            global $wpdb;
            foreach (WC()->cart->get_cart() as $cart_item) {
                $product_id = $cart_item['product_id'];
                $qty_in_cart = $cart_item['quantity'];

                $product = wc_get_product($product_id);

                $reserved_qty = (int) $wpdb->get_var(
                    $wpdb->prepare("
                        SELECT COALESCE(SUM(`stock_quantity`), 0)
                        FROM `{$wpdb->prefix}wc_reserved_stock`
                        WHERE `product_id` = %d
                        AND `expires` > NOW()
                    ", $product_id)
                );

                $available_stock = max($product->get_stock_quantity() - $reserved_qty, 0);

                if ($qty_in_cart > $available_stock) {
                    wc_clear_notices();
                    wc_add_notice(
                        sprintf(__('Sorry, we do not have enough "%1$s" in stock to fulfill your order (%2$s available). We apologize for any inconvenience caused.', 'woocommerce'), $product->get_name(), wc_format_stock_quantity_for_display($available_stock, $product)),
                        'error'
                    );
                    break;
                }
            }
        }

        public function custom_translate_woocommerce_strings($translated_text, $text, $domain)
        {
            if ($domain === 'woocommerce') {
                if ($text === 'There was an error processing your order. Please check for any charges in your payment method and review your <a href="%s">order history</a> before placing the order again.') {
                    $translated_text = 'Houve um erro ao processar seu pedido. Verifique se há cobranças no seu método de pagamento e revise seu <a href="%s">histórico de pedidos</a> antes de tentar novamente.';
                }
            }
            return $translated_text;
        }

        public function save_subscription_address($user_id, $address_type)
        {
            $users_subscriptions = wcs_get_users_subscriptions($user_id);

            foreach ($users_subscriptions as $subscription) {
                if ($subscription->has_status(array('active', 'on-hold'))) {
                    $subscription->update_meta_data('_' . $address_type . '_address_index', $_POST[$address_type . '_address_index']);
                    $subscription->update_meta_data('_' . $address_type . '_cpf', $_POST[$address_type . '_cpf']);
                    $subscription->update_meta_data('_' . $address_type . '_number', $_POST[$address_type . '_number']);
                    $subscription->update_meta_data('_' . $address_type . '_neighborhood', $_POST[$address_type . '_neighborhood']);
                    $subscription->save();
                }
            }
        }

        public function get_order_tracking($order_id)
        {
            $order = new WC_Order($order_id);
            echo "<pre>";
            print_r('teste');
            exit;
            $url = get_option('wc_settings_woocommercenfe_ambiente') == 1 ? 'https://api.centraldacerveja.com.br/v1/public/shipping/track' : 'http://localhost:8000/v1/public/shipping/track';
            $data = $this->data_for_tracking($order);
            
            $response = wp_remote_post(
                $url,
                [
                    'timeout' => 60,
                    'headers' => ['Content-type' => 'application/json'],
                    'body' => json_encode($data),
                ]
            );

            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body);

            $html = "<h2>Rastreamento</h2>";

            if (empty($data->events)) {
                $html .= "<p>Seu pedido ainda não foi coletado pela transportadora.</p>";
                echo $html;
                return;
            }

            $html .= "<p>Previsão de entrega: {$data->delivery_date}</p>";

            foreach ($data->events as $event) {
                $html .= "<p>{$event->Date}: {$event->Description}</p>";
            }

            echo $html;
            return;
        }

        private function data_for_tracking($order)
        {
            $nfes = apply_filters('get_nfes', $order->get_id());

            foreach ($nfes as $nfe) {
                if ($nfe['type'] == 2) {
                    $nfe_number = $nfe['n_nfe'];
                    $nfe_key = $nfe['chave_acesso'];
                    break;
                }
            }

            return array(
                'document' => '41679000000147',
                'nf_number' => $nfe_number,
                'nf_key' => $nfe_key
            );
        }
    }
}

return new Central_Da_Cerveja_WooCommerce();
