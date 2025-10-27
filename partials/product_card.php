<div class="cdc-product-card">
    <div class="cdc-product-body">
        <a href="/produto/<?php echo $slug; ?>" class="cdc-product__link">
            <div class="cdc-product__image">
                <img src="<?php echo $image; ?>" alt="<?php echo $name ?? 'Desconhecido'; ?>">
            </div>
            <div class="cdc-product__country">
                <img src="<?php echo $country_icon; ?>" class="img-fluid" alt="<?php echo $country ?? 'Desconhecido'; ?>" loading="lazy">
            </div>
            <div class="cdc-product__name line-clamp-2">
                <?php echo $name ?? 'Desconhecido'; ?>
            </div>
            <?php
            if ($type == 'simple') {
            ?>
                <div class="cdc-product__attributes">
                    <div class="text-truncate"><span>Estilo:</span> <?php echo $style; ?></div>
                    <div><span>Dosagem Alcoólica:</span> <?php echo $alcoholic_dosage; ?></div>
                    <div><span>Volume:</span> <?php echo $volume; ?></div>
                </div>
            <?php
            } else {
            ?>
                <div class="cdc-product__description">
                    <div>Descrição:</div>
                    <?php echo $excerpt; ?>
                </div>
            <?php
            }
            ?>
            <div class="cdc-product__price">
                <?php
                if ($sale_price > 0 && $sale_price < $price) {
                ?>
                    <div class="cdc-product_old-value"><del>R$ <?php echo number_format($price, 2, ',', '.'); ?></del></div>
                    <div class="cdc-product_value">R$ <?php echo number_format($sale_price, 2, ',', '.'); ?></div>
                <?php
                } else {
                ?>
                    <div class="cdc-product_value">R$ <?php echo number_format($price, 2, ',', '.'); ?></div>
                <?php
                }
                ?>
            </div>
        </a>
    </div>
    <div class="cdc-product-footer" x-data="{ quantity: 1, limit: <?php echo $remaining_stock; ?>}">
        <div class="cdc-product__qty">
            <button 
                class="cdc-product__btn-qty cdc-product__minus" :class="{ 'disabled': quantity <= 1 }" @click="if(quantity > 1) quantity--" :disabled="quantity <= 1">
                <i class="fa fa-minus" aria-hidden="true"></i>
            </button>
            <div class="cdc-product__label" x-text="quantity"></div>
            <button class="cdc-product__btn-qty cdc-product__plus" :class="{ 'disabled': quantity >= limit }" @click="if(quantity < limit) quantity++" :disabled="quantity >= limit">
                <i class="fa fa-plus" aria-hidden="true"></i>
            </button>
        </div>
        <div class="cdc-product__action">
            <a href="?add-to-cart=<?php echo $id;?>" 
                class="cdc-product__add_to_cart ajax_add_to_cart add_to_cart_button" 
                :data-quantity="quantity"
                data-product_id="<?php echo $id;?>" 
                data-product_sku="<?php echo $sku;?>">
                <span class="button-text">Adicionar ao Carrinho</span>
                <span class="loading-icon"><i class="fa fa-spinner fa-spin"></i></span>
            </a>
        </div>
        <div class="cdc-product__supplier">
            <span>Por:</span>
            <img src="<?php echo $supplier_image; ?>" alt="<?php echo $supplier_name; ?>" loading="lazy">
            <a href="/por-cervejaria/<?php echo $supplier_slug; ?>"><?php echo $supplier_name; ?></a>
        </div>
    </div>

</div>