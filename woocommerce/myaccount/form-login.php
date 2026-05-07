<?php

/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

do_action('woocommerce_before_customer_login_form');
?>

<div class="container-fluid p-0">
	<div id="form_auth_register_check">
		<div class="row">
			<div class="col-12 col-lg-6">
				<h2><?php esc_html_e('Login', 'woocommerce'); ?></h2>

				<form class="woocommerce-form woocommerce-form-login login" method="post">

					<?php do_action('woocommerce_login_form_start'); ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="username"><?php esc_html_e('E-mail', 'central-da-cerveja'); ?>&nbsp;<span class="required">*</span></label>
						<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine 
																																																																	?>
					</p>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="password"><?php esc_html_e('Senha', 'central-da-cerveja'); ?>&nbsp;<span class="required">*</span></label>
						<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
					</p>

					<?php do_action('woocommerce_login_form'); ?>

					<p class="form-row">
						<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
							<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
						</label>
						<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
						<button type="submit" class="woocommerce-button button woocommerce-form-login__submit<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="login" value="<?php esc_attr_e('Log in', 'woocommerce'); ?>"><?php esc_html_e('Log in', 'woocommerce'); ?></button>
					</p>
					<p class="woocommerce-LostPassword lost_password">
						<a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
					</p>

					<?php do_action('woocommerce_login_form_end'); ?>

				</form>
			</div>
			<div class="col-12 col-lg-6 woocommerce-account woocommerce_regiter_verify">
				<h2 class="woocommerce-title-register"><?php esc_html_e('Register', 'woocommerce'); ?></h2>
				<div class="row">
					<div class="col-12">
						<label for="email"><?php echo __('E-mail', 'central-da-cerveja'); ?>&nbsp;<span class="required">*</span></label>
						<input type="email" class="form-control form-control--woocommerce" name="email" id="email_check" required>
					</div>
				</div>
				<div class="form-row">
					<div class="col-12">
						<?php do_action('woocommerce_register_form'); ?>
					</div>
				</div>
				<div class="form-row">
					<div class="col-12">
						<button type="button" class="woocommerce-button button button_verify" id="button_verify">Verificar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="form_register" style="display:none;">
		<div class="row">
			<div class="col-12 container-fluid p-0">
				<form id="woocommerce_register" method="post">
					<div style="position:absolute; left:-10000px; top:auto; width:1px; height:1px; overflow:hidden;" aria-hidden="true">
						<label for="register_company"><?php echo __('Empresa', 'central-da-cerveja'); ?></label>
						<input type="text" name="register_company" id="register_company" tabindex="-1" autocomplete="off">
					</div>
					<?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
					<div class="row">
						<div class="col-12 mb-4">
							<h3 class="cdc-title"><?php echo __('Detalhes da Conta', 'central-da-cerveja'); ?></h3>
						</div>
					</div>
					
					<div class="row mb-3">
						<div class="col-12">
							<div id="register_message"></div>
						</div>
					</div>

					<div class="row mb-3">
						<div class="col-12 col-md-6">
							<label class="form-label" for="first_name"><?php echo __('Nome', 'central-da-cerveja'); ?>&nbsp;<span class="text-danger">*</span></label>
							<input type="text" class="form-control form-control--woocommerce" name="first_name" id="first_name" required>
						</div>
						<div class="col-12 col-md-6">
							<label class="form-label" for="last_name"><?php echo __('Sobrenome', 'central-da-cerveja'); ?>&nbsp;<span class="text-danger">*</span></label>
							<input type="text" class="form-control form-control--woocommerce" name="last_name" id="last_name" required>
						</div>
					</div>

					<div class="row mb-3">
						<div class="col-12 col-md-4">
							<label class="form-label" for="email"><?php echo __('E-mail', 'central-da-cerveja'); ?>&nbsp;<span class="text-danger">*</span></label>
							<input type="email" class="form-control form-control--woocommerce" name="email" id="email" readonly>
						</div>
						<div class="col-12 col-md-4">
							<label class="form-label" for="register_password"><?php echo __('Senha', 'central-da-cerveja'); ?>&nbsp;<span class="text-danger">*</span></label>
							<input type="password" class="form-control form-control--woocommerce" name="register_password" id="register_password" required>
							<span class="password-tip"></span>
						</div>
						<div class="col-12 col-md-4">
							<label class="form-label" for="password_confirm"><?php echo __('Confirmar Senha', 'central-da-cerveja'); ?>&nbsp;<span class="text-danger">*</span></label>
							<input type="password" class="form-control form-control--woocommerce" name="password_confirm" id="password_confirm" required>
						</div>
					</div>
					<div class="row my-4">
						<div class="col-12">
							<h3 class="cdc-title"><?php echo __('Endereço de Faturamento', 'central-da-cerveja'); ?></h3>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-12 col-md-4">
							<label class="form-label" for="cpf"><?php echo __('CPF', 'central-da-cerveja'); ?>&nbsp;<span class="text-danger">*</span></label>
							<input type="text" class="form-control form-control--woocommerce" name="cpf" id="cpf" required data-mask="000.000.000-00" data-reverse="true">
						</div>
						<div class="col-12 col-md-4">
							<label class="form-label" for="phone"><?php echo __('Telefone', 'central-da-cerveja'); ?>&nbsp;<span class="text-danger">*</span></label>
							<input type="text" class="form-control form-control--woocommerce" name="phone" id="phone" required>
						</div>
						<div class="col-12 col-md-4">
							<label class="form-label" for="mobile"><?php echo __('Celular', 'central-da-cerveja'); ?></label>
							<input type="text" class="form-control form-control--woocommerce" name="mobile" id="mobile" data-mask="(00) 00000-0000" data-reverse="true">
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-12 col-md-3">
							<label class="form-label" for="postcode"><?php echo __('CEP', 'central-da-cerveja'); ?>&nbsp;<span class="text-danger">*</span></label>
							<input type="text" class="form-control form-control--woocommerce" name="postcode" id="postcode" required data-mask="00000-000" data-reverse="true">
						</div>
						<div class="col-12 col-md-3">
							<label class="form-label" for="address"><?php echo __('Endereço', 'central-da-cerveja'); ?>&nbsp;<span class="text-danger">*</span></label>
							<input type="text" class="form-control form-control--woocommerce" name="address" id="address" required>
						</div>
						<div class="col-12 col-md-3">
							<label class="form-label" for="number"><?php echo __('Número', 'central-da-cerveja'); ?>&nbsp;<span class="text-danger">*</span></label>
							<input type="text" class="form-control form-control--woocommerce" name="number" id="number" required>
						</div>
						<div class="col-12 col-md-3">
							<label class="form-label" for="complement"><?php echo __('Complemento', 'central-da-cerveja'); ?></label>
							<input type="text" class="form-control form-control--woocommerce" name="complement" id="complement">
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-12 col-md-4">
							<label class="form-label" for="county"><?php echo __('Bairro', 'central-da-cerveja'); ?><span class="text-danger">*</span></label>
							<input type="text" class="form-control form-control--woocommerce" required name="county" id="county">
						</div>
						<div class="col-12 col-md-4">
							<label class="form-label" for="city"><?php echo __('Cidade', 'central-da-cerveja'); ?>&nbsp;<span class="text-danger">*</span></label>
							<input type="text" class="form-control form-control--woocommerce" name="city" id="city" required>
						</div>
						<div class="col-12 col-md-4">
							<?php
							$country = new WC_Countries();
							$states = $country->get_states('BR');
							?>
							<label class="form-label" for="state"><?php echo __('Estado', 'central-da-cerveja'); ?>&nbsp;<span class="text-danger">*</span></label>
							<select class="form-select form-control--woocommerce" name="state" id="state" required>
								<option value="" selected><?php echo __('Selecione...', 'central-da-cerveja'); ?></option>
								<?php
								if (!empty($states)) {
									foreach ($states as $key => $value) {
								?>
										<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
								<?php
									}
								}
								?>
							</select>
						</div>
					</div>

					<input type="checkbox" name="privacy_policy_register" id="privacy_policy_register" required>
					<label for="privacy_policy_register">Concordo com a Política de Privacidade da Central da Cerveja. <a id="privacy_policy_link" target="<?php echo !wp_is_mobile() ? '_blank' : ''; ?>" href="/politica-de-privacidade">Ver Política de Privacidade</a></label>

					<div class="row mb-3">
						<div class="col-12 d-flex justify-content-end">
							<div>
								<button type="button" class="btn btn--woocommerce" id="btn_register">Cadastrar</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php

do_action('woocommerce_after_customer_login_form');
