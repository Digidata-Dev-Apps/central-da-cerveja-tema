<?php
/**
 * Shipping Calculator
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/shipping-calculator.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_shipping_calculator' ); ?>

<?php if (is_cart()) : ?>

	<p class="woocommerce-shipping-destination">
		<span id="shipping_address">

		</span>
			</p>
		<?php endif; ?>

<form class="woocommerce-shipping-calculator" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
	<?php wp_nonce_field('woocommerce-shipping-calculator', 'woocommerce-shipping-calculator-nonce'); ?>
	<input type="hidden" name="calc_shipping_country" id="calc_shipping_country" value="BR">
				<?php
				$current_cc = WC()->customer->get_shipping_country();
				$current_r  = WC()->customer->get_shipping_state();
					?>
	<input type="hidden" name="calc_shipping_state" id="calc_shipping_state" value="<?php echo ($current_r) ? $current_r : null; ?>">
	<input type="hidden" name="calc_shipping_city" id="calc_shipping_city" value="<?php echo esc_attr(WC()->customer->get_shipping_city()); ?>" />
	<p class="text-danger font-weight-bold" style="font-size: 14px;">Os prazos de entrega são estimados</p>
	<p><?php echo __('Informe seu CEP de entrega para calcular o frete.', 'central-da-cerveja'); ?></p>
			<p class="form-row form-row-wide" id="calc_shipping_postcode_field" style="display:flex;">
				<input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_postcode() ); ?>" placeholder="<?php esc_attr_e( 'Postcode / ZIP', 'woocommerce' ); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
		<img style="height: 30px; width: 40px;margin-left:20px;" src="<?php echo get_template_directory_uri() . '/assets/img/truck.png' ?>">
			</p>
</form>

<?php do_action( 'woocommerce_after_shipping_calculator' ); ?>
