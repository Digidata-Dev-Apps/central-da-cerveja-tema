<?php

/**
 * Componente responsável por exibir a card de produtos
 */

// Verifica se o arquivo foi acessado diretamente
if (!defined('ABSPATH')) {
    exit;
}

global $central_da_cerveja;

if ($product->type == 'simple') {
    $attributes = array(
        array(
            'label' => 'Estilo',
            'value' => $product->style,
        ),
        array(
            'label' => 'Dosagem Alcoólica',
            'value' => $product->alcoholic_dosage,
        ),
        array(
            'label' => 'Volume',
            'value' => $product->volume,
        )
    );
} else {
    $attributes = array(
        array(
            'label' => 'Descrição',
            'value' => $product->excerpt,
        ),
    );
}


$product->country = $product->country ? $central_da_cerveja->utils->url_slug($product->country) . ".png" : "brasil.png";

$info = pathinfo($product->image);
$product->image = (isset($info['extension'])) ? "{$info['dirname']}/{$info['filename']}-300x300.{$info['extension']}" : "woocommerce-placeholder-300x300.png";
$product->attributes = $attributes;

if (isset($product->supplier_image) && !empty($product->supplier_image)) {
    $info = pathinfo($product->supplier_image);
    $product->supplier_image = (isset($info['extension'])) ? "{$info['dirname']}/{$info['filename']}-100x100.{$info['extension']}" : "woocommerce-placeholder-300x300.png";
} else {
    $product->supplier_image = "woocommerce-placeholder-300x300.png";
}


?>

<div class="cdc-product-card">
    <a href="<?php echo "/produto/{$product->slug}/"; ?>" class="cdc-product-card__link" title="<?php echo $product->name ?? ""; ?>">
        <div class="cdc-product-card__image">
            <img src="<?php echo "/wp-content/uploads/{$product->image}"; ?>" class="img-fluid" alt="<?php echo $product->name ?? ""; ?>" loading="lazy">
        </div>
        <div class="cdc-product-card__country">
            <img src="<?php echo "/wp-content/themes/central-da-cerveja/assets/img/icons/{$product->country}"; ?>" class="img-fluid" alt="<?php echo $product->name ?? ""; ?>" loading="lazy">
        </div>
        <h2 class="cdc-product-card__title"><?php echo $product->name ?? ""; ?></h2>
        <div class="cdc-product-card__attributes">
            <?php
            if (!empty($product->attributes)) {
                $truncate = ($product->type == "simple") ? "text-truncate" : "";
                $line_clamp = ($product->type == "simple") ? "" : "line-clamp-3";
                foreach ($product->attributes as $attribute) {
                    echo "<p class='{$truncate}'><span>{$attribute['label']}:&nbsp;</span><span class='{$line_clamp}'>{$attribute['value']}</span></p>";
                }
            }
            ?>
        </div>
        <div class="cdc-product-price">
            <?php if (!$product->sale_price || $product->sale_price == $product->regular_price || $product->sale_price == 0) { ?>
                <span class="cdc-product-price__regular">R$ <?php echo number_format($product->regular_price, 2, ',', '.'); ?></span>
            <?php } else { ?>
                <span class="cdc-product-price__regular"><del>R$ <?php echo number_format($product->regular_price, 2, ',', '.'); ?></del></span>
                <span class="cdc-product-price__sale">R$ <?php echo number_format($product->sale_price, 2, ',', '.'); ?></span>
            <?php } ?>
        </div>
    </a>
    <div class="cdc-product-card__quantity">
        <div class="input-group-button">
            <button type="button" class="button hollow circle disabled" data-quantity="minus" data-field="quantity">
                <i class="fa fa-minus click-area" aria-hidden="true"></i>
            </button>
        </div>
        <input class="input-group-field" type="number" readonly="readonly" name="quantity" min="1" max="<?php echo $product->stock ?? 1; ?>" value="1">
        <div class="input-group-button">
            <button type="button" class="button hollow circle" data-quantity="plus" data-field="quantity">
                <i class="fa fa-plus click-area" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <div class="cdc-product-card__action">
        <a href="?add-to-cart=<?php echo $product->id ?? ""; ?>" class="cdc-product-card__button <?php echo "product_type_{$product->type}"; ?> add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product->id ?? ""; ?>" data-product_sku="<?php echo $product->sku ?? ""; ?>" data-quantity="1">
            Comprar
        </a>
    </div>
    <div class="cdc-product-card__supplier">
        <span>Por:</span>
        <img src="/wp-content/uploads/<?php echo $product->supplier_image ?? ""; ?>" alt="<?php echo $product->supplier_name ?? ""; ?>">
        <span><a href="/por-cervejaria/<?php echo $product->supplier_slug ?? "#"; ?>"><?php echo $product->supplier_name ?? ""; ?></a></span>
    </div>
</div>
