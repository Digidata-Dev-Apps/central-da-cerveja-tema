<?php

// Verifica se o arquivo foi acessado diretamente
if (!defined('ABSPATH')) {
    exit;
}

class ShippingPolicies
{

    /**
     * URL base da API externa
     * 
     * @var string
     */
    private $api_base_url = '';

    /**
     * Chave da API para autenticação
     * 
     * @var string
     */
    private $api_key = '';

    public function __construct()
    {
        $this->api_base_url = get_option('api_endpoint', 'https://test.api.centraldacerveja.com.br');
        $this->api_key = get_option('api_token', '');
        $this->init();
    }

    /**
     * Inicializa a classe e registra os hooks
     * 
     * @return void
     */
    public function init()
    {
        add_action('admin_init', [$this, 'removeAllNotices'], PHP_INT_MAX);

        // Hooks para adicionar a aba nas configurações
        add_filter('woocommerce_settings_tabs_array', [$this, 'addSettingsTab'], 50);
        add_action('woocommerce_settings_tabs_shipping_policies', [$this, 'renderTabContent']);

        // Hooks para AJAX
        add_action('wp_ajax_sp_get_policies', [$this, 'ajaxGetPolicies']);
        add_action('wp_ajax_sp_add_policy', [$this, 'ajaxAddPolicy']);
        add_action('wp_ajax_sp_delete_policy', [$this, 'ajaxDeletePolicy']);
        add_action('wp_ajax_sp_get_available_states', [$this, 'ajaxGetAvailableStates']);

        // Enqueue scripts e styles
        add_action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
    }

    /**
     * Remove as notificações quando acessar a aba de políticas
     */
    public function removeAllNotices()
    {
        if (
            !is_admin() ||
            !isset($_GET['page'], $_GET['tab']) ||
            $_GET['page'] !== 'wc-settings' ||
            $_GET['tab'] !== 'shipping_policies'
        ) {
            return;
        }

        remove_all_actions('admin_notices');
        remove_all_actions('all_admin_notices');
        remove_all_actions('woocommerce_display_admin_notices');
    }

    /**
     * Adiciona a nova aba nas configurações do WooCommerce
     * 
     * @param array $settings_tabs Array com as abas existentes
     * @return array
     */
    public function addSettingsTab($settings_tabs)
    {
        $settings_tabs['shipping_policies'] = __('Políticas de Frete', 'central-da-cerveja');
        return $settings_tabs;
    }

    /**
     * Renderiza o conteúdo da aba
     * 
     * @return void
     */
    public function renderTabContent()
    {
?>
        <div id="shipping-policies-app" x-data="shippingPoliciesApp()" x-init="init()">

            <!-- Cabeçalho -->
            <h2><?php _e('Políticas de Frete por Estado', 'central-da-cerveja'); ?></h2>
            <p><?php _e('Este recurso permite configurar os descontos da política de frete da loja.', 'central-da-cerveja'); ?></p>

            <!-- Mensagens de feedback -->
            <div x-show="message"
                x-text="message"
                :class="messageType === 'success' ? 'notice-success' : 'notice-error'"
                class="notice is-dismissible" style="padding: 15px;font-size:13px;"
                x-transition>
            </div>

            <!-- Tabela de Políticas -->
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th colspan="5" class="border-b-none text-center">Valores para o desconto</th>
                    </tr>
                    <tr>
                        <th><?php _e('Estado', 'central-da-cerveja'); ?></th>
                        <th class="text-center"><?php _e('50%', 'central-da-cerveja'); ?></th>
                        <th class="text-center"><?php _e('75%', 'central-da-cerveja'); ?></th>
                        <th class="text-center"><?php _e('100%', 'central-da-cerveja'); ?></th>
                        <th class="text-end"></th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="policy in policies" :key="policy.uuid">
                        <tr>
                            <td class="text-start" x-text="policy.state_name"></td>
                            <td class="text-center" x-text="formatCurrency(policy.discount_50_threshold)"></td>
                            <td class="text-center" x-text="formatCurrency(policy.discount_75_threshold)"></td>
                            <td class="text-center" x-text="formatCurrency(policy.discount_100_threshold)"></td>
                            <td class="text-end">
                                <button type="button"
                                    class="button button-small button-link-delete"
                                    @click="deletePolicy(policy.uuid)"
                                    :disabled="loading" title="<?php _e('Excluir', 'central-da-cerveja'); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="loading">
                        <td colspan="5" class="text-center bg-white">
                            <?php _e('Carregando...', 'central-da-cerveja'); ?>
                        </td>
                    </tr>
                    <tr x-show="policies.length === 0 && loading === false">
                        <td colspan="5" class="text-center bg-white">
                            <?php _e('Nenhuma política cadastrada.', 'central-da-cerveja'); ?>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>
                            <select id="state_select" x-model="newPolicy.state_code" :disabled="loading">
                                <option value=""><?php _e('Selecione um estado', 'central-da-cerveja'); ?></option>
                                <template x-for="state in availableStates" :key="state.code">
                                    <option :value="state.code" x-text="state.name"></option>
                                </template>
                            </select>
                        </td>
                        <td>
                            <input type="text" inputmode="decimal" x-currency="newPolicy.discount_50_threshold" placeholder="R$ 0,00" :disabled="loading">
                        </td>
                        <td>
                            <input type="text" inputmode="decimal" x-currency="newPolicy.discount_75_threshold" placeholder="R$ 0,00" :disabled="loading">
                        </td>
                        <td>
                            <input type="text" inputmode="decimal" x-currency="newPolicy.discount_100_threshold" placeholder="R$ 0,00" :disabled="loading">
                        </td>
                        <td class="text-end">
                            <button type="button" class="button button-primary" @click="addPolicy()" :disabled="loading || !isFormValid()">
                                <?php _e('Adicionar', 'central-da-cerveja'); ?>
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <!-- Legenda -->
            <div class="shipping-policies-legend">
                <p><?php _e('Os descontos serão aplicados quando:', 'central-da-cerveja'); ?></p>
                <ul>
                    <li><strong>Desconto de 50%:</strong> <?php _e('Quando o valor do pedido ficou igual ou acima do especificado e abaixo do valor apontado para 75%.', 'central-da-cerveja'); ?></li>
                    <li><strong>Desconto de 75%:</strong> <?php _e('Quando o valor do pedido ficou igual ou acima do especificado e abaixo do valor apontado para 100%;', 'central-da-cerveja'); ?></li>
                    <li><strong>Desconto de 100%:</strong> <?php _e('Quando o valor do pedido ficou igual ou acima do especificado;', 'central-da-cerveja'); ?></li>
                </ul>
            </div>
        </div>
<?php
    }

    /**
     * Enfileira os assets necessários
     * 
     * @param string $hook Hook da página atual
     * @return void
     */
    public function enqueueAssets($hook)
    {
        if ('woocommerce_page_wc-settings' !== $hook) {
            return;
        }

        if (!isset($_GET['tab']) || $_GET['tab'] !== 'shipping_policies') {
            return;
        }

        wp_enqueue_script(
            'simple-mask-money',
            get_template_directory_uri() . '/assets/vendors/alpinejs/simple-mask-money.min.js',
            [],
            time(),
            false
        );

        wp_enqueue_script(
            'alpinejs',
            get_template_directory_uri() . '/assets/vendors/alpinejs/alpinejs-3.14.8.min.js',
            [],
            '3.14.8',
            false
        );

        wp_enqueue_script(
            'shipping-policies-admin',
            get_template_directory_uri() . '/assets/js/shipping-policies-admin.js',
            [],
            time(),
            false
        );

        wp_localize_script('shipping-policies-admin', 'shippingPoliciesAjax', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('shipping_policies_nonce'),
            'i18n' => [
                'confirmDelete' => __('Tem certeza que deseja excluir esta política?', 'central-da-cerveja'),
                'errorGeneric' => __('Ocorreu um erro. Tente novamente.', 'central-da-cerveja'),
                'successAdd' => __('Política adicionada com sucesso!', 'central-da-cerveja'),
                'successDelete' => __('Política removida com sucesso!', 'central-da-cerveja'),
            ]
        ]);

        wp_enqueue_style(
            'shipping-policies-admin',
            get_template_directory_uri() . '/assets/css/shipping-policies-admin.css',
            ['woocommerce_admin_styles'],
            '1.0.0'
        );
    }

    /**
     * AJAX: Obtém lista de políticas
     * 
     * @return void
     */
    public function ajaxGetPolicies()
    {
        check_ajax_referer('shipping_policies_nonce', 'nonce');

        if (!current_user_can('manage_woocommerce')) {
            wp_die(__('Permissão negada', 'central-da-cerveja'));
        }

        $response = $this->apiRequest('GET', 'shipping-policies');

        if (is_wp_error($response)) {
            wp_send_json_error([
                'message' => $response->get_error_message()
            ]);
        }

        wp_send_json_success($response);
    }

    /**
     * AJAX: Adiciona nova política
     * 
     * @return void
     */
    public function ajaxAddPolicy()
    {
        check_ajax_referer('shipping_policies_nonce', 'nonce');

        if (!current_user_can('manage_woocommerce')) {
            wp_die(__('Permissão negada', 'central-da-cerveja'));
        }

        $state_code = isset($_POST['state_code']) ? sanitize_text_field($_POST['state_code']) : '';
        $discount_50_threshold = isset($_POST['discount_50_threshold']) ? floatval($_POST['discount_50_threshold']) : 0;
        $discount_75_threshold = isset($_POST['discount_75_threshold']) ? floatval($_POST['discount_75_threshold']) : 0;
        $discount_100_threshold = isset($_POST['discount_100_threshold']) ? floatval($_POST['discount_100_threshold']) : 0;

        if (empty($state_code)) {
            wp_send_json_error([
                'message' => __('Estado é obrigatório.', 'central-da-cerveja')
            ]);
        }

        if ($discount_50_threshold < 0 || $discount_75_threshold < 0 || $discount_100_threshold < 0) {
            wp_send_json_error([
                'message' => __('Os valores de desconto não podem ser negativos.', 'central-da-cerveja')
            ]);
        }

        $data = [
            'state' => $state_code,
            'discount_50_threshold' => $discount_50_threshold,
            'discount_75_threshold' => $discount_75_threshold,
            'discount_100_threshold' => $discount_100_threshold
        ];

        $response = $this->apiRequest('POST', 'shipping-policies', $data);

        if (is_wp_error($response)) {
            wp_send_json_error([
                'message' => $response->get_error_message()
            ]);
        }

        wp_send_json_success($response);
    }

    /**
     * AJAX: Remove política
     * 
     * @return void
     */
    public function ajaxDeletePolicy()
    {
        check_ajax_referer('shipping_policies_nonce', 'nonce');

        if (!current_user_can('manage_woocommerce')) {
            wp_die(__('Permissão negada', 'central-da-cerveja'));
        }

        $uuid = isset($_POST['uuid']) ? sanitize_text_field($_POST['uuid']) : '';

        if (empty($uuid)) {
            wp_send_json_error([
                'message' => __('Código do estado é obrigatório.', 'central-da-cerveja')
            ]);
        }

        $response = $this->apiRequest('DELETE', 'shipping-policies/' . $uuid);

        if (is_wp_error($response)) {
            wp_send_json_error([
                'message' => $response->get_error_message()
            ]);
        }

        wp_send_json_success([
            'message' => __('Política removida com sucesso.', 'central-da-cerveja')
        ]);
    }

    /**
     * AJAX: Obtém estados disponíveis
     * 
     * @return void
     */
    public function ajaxGetAvailableStates()
    {
        check_ajax_referer('shipping_policies_nonce', 'nonce');

        if (!current_user_can('manage_woocommerce')) {
            wp_die(__('Permissão negada', 'central-da-cerveja'));
        }

        $response = $this->apiRequest('GET', 'shipping-policies/available-states');

        if (is_wp_error($response)) {
            wp_send_json_error([
                'message' => $response->get_error_message()
            ]);
        }

        wp_send_json_success($response);
    }


    public function calculateDiscount(string $state, float $subtotal, float $shipping)
    {
        $response = $this->apiRequest('POST', 'shipping-policies/calculate', [
            'state'         => $state,
            'order_value'   => $subtotal,
            'shipping_cost' => $shipping
        ]);

        if (is_wp_error($response)) {
            return [];
        }

        return $response;
    }

    /**
     * Faz requisição para a API externa
     * 
     * @param string $method Método HTTP (GET, POST, DELETE, etc)
     * @param string $endpoint Endpoint da API
     * @param array $data Dados para enviar (opcional)
     * @return array|WP_Error
     */
    private function apiRequest($method, $endpoint, $data = [])
    {
        $url = $this->api_base_url . $endpoint;

        $args = [
            'method' => $method,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->api_key,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'timeout' => 30,
            'sslverify' => true,
        ];

        if (!empty($data) && in_array($method, ['POST', 'PUT', 'PATCH'])) {
            $args['body'] = json_encode($data);
        }

        $response = wp_remote_request($url, $args);

        if (is_wp_error($response)) {
            return $response;
        }

        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);

        if ($response_code >= 200 && $response_code < 300) {
            if ($response_code === 204) {
                return [
                    'success' => true,
                    'message' => __('Operação realizada com sucesso.', 'central-da-cerveja'),
                    'status_code' => 204
                ];
            }

            if (!empty($response_body)) {
                $decoded = json_decode($response_body, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    return new \WP_Error('json_decode_error', __('Erro ao decodificar resposta da API.', 'central-da-cerveja'));
                }

                return $decoded;
            } else {
                return [
                    'success' => true,
                    'message' => __('Operação realizada com sucesso.', 'central-da-cerveja'),
                    'status_code' => $response_code
                ];
            }
        }

        // Trata erros (status >= 300)
        $error_message = __('Erro na requisição à API.', 'central-da-cerveja');

        // Tenta extrair mensagem de erro da resposta se houver corpo
        if (!empty($response_body)) {
            $decoded = json_decode($response_body, true);

            if (isset($decoded['message'])) {
                $error_message = $decoded['message'];
            }
        }

        return new \WP_Error('api_error', $error_message, ['status_code' => $response_code]);
    }

    /**
     * Previne clonagem (Singleton)
     */
    private function __clone() {}

    /**
     * Previne unserialize (Singleton)
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
}

return new ShippingPolicies();
