<nav class="navbar navbar-expand-lg mobile-nav">
    <div class="container-fluid">
        <div class="cdc-nav__tools ms-auto">
            <div class="cdc-tools__item">
                <a href="/minha-conta" title="<?php echo __('Minha Conta', 'central-da-cerveja') ?>">
                    <div class="cdc-icon login-icon">
                        <img src="<?php echo get_template_directory_uri() . "/assets/img/Extract/login.png" ?>" class="img-fluid" title="<?php echo __('Minha Conta', 'central-da-cerveja'); ?>">
                    </div>
                    <div class="cdc-tools__label">
                        <?php
                        if (!is_user_logged_in()) {
                        ?>
                            <span class="cdc-tools__label--size-12">
                                <?php
                                echo __('Login ou Cadastre-se', 'central-da-cerveja');
                                ?>
                            </span>
                        <?php
                        } else {
                        ?>
                            <span class="cdc-tools__label--size-12" title="<?php echo __('Clique aqui para acessar seus dados.', 'central-da-cerveja') ?>">
                                <?php
                                printf(__('Olá, %s!', 'central-da-cerveja'), get_user_meta(get_current_user_id(), 'first_name', true));
                                ?>
                            </span>
                        <?php
                        }
                        ?>
                    </div>
                </a>
            </div>
            <div class="cdc-tools__item">
                <a href="/cervejeira" title="<?php echo __('Cervejeira', 'central-da-cerveja') ?>">
                    <div class="cdc-icon cdc-icon--border">
                        <img id="header_cart_icon" src="<?php echo get_template_directory_uri() . "/assets/img/Extract/geladeira.png" ?>" class="img-fluid" title="<?php echo __('Cervejeira', 'central-da-cerveja'); ?>">
                        <div class="hide-counter-if-cart-empty" style="<?php echo isset($cart_product_qty) && $cart_product_qty > 0 ? '' : 'display:none;'; ?>">
                            <div id="cart_header_qty_background"></div>
                            <span class="cart_icon_product_qty">
                                <?php
                                echo isset($cart_product_qty) && $cart_product_qty > 0 ? $cart_product_qty : '';
                                ?>
                            </span>
                        </div>
                    </div>
                    <div class="cdc-tools__label">
                        <span><?php echo __('Cervejeira', 'central-da-cerveja') ?></span>
                    </div>
                </a>
            </div>
            <div class="cdc-tools__item">
                <a href="/seja-um-expositor" title="<?php echo __('Seja um Expositor', 'central-da-cerveja'); ?>">
                    <div class="cdc-icon scroll-icon">
                        <i class="fas fa-scroll"></i>
                    </div>
                    <div class="cdc-tools__label">
                        <span><?php echo __('Seja um Expositor', 'central-da-cerveja') ?></span>
                    </div>
                </a>
            </div>
            <div class="cdc-tools__item">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0t">
                <li class="nav-item">
                    <a class="nav-link first-item" aria-current="page" href="/">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/por-perfil">Por Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/por-estilo">Por Estilo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/por-pais">Por País</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/por-estado">Por Estado</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/loja?filter=price">Por Preço</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/por-cervejaria">Por Cervejaria</a>
                </li>
                <div class="cdc_info">
                    <li class="nav-item">
                        <a class="nav-link" href="/contato">Contato</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ajuda-e-suporte">Ajuda e Suporte</a>
                    </li>
                </div>
            </ul>
        </div>
    </div>
    <div class="cdc-nav__search">
        <div class="cdc-search input-group search-box">
            <form class="cdc-search__form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <!-- Loading Indicator -->
                <div class="cdc-search__loading" style="display:none;">
                    <div class="cdc-search__loading-spinner">
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        <span class="cdc-search__loading-text"><?php echo __('Pesquisando...', 'central-da-cerveja'); ?></span>
                    </div>
                </div>
                <input type="search" id="woocommerce-product-search-field-<?php echo isset($index) ? absint($index) : 0; ?>" class="form-control search_field" value="<?php echo get_search_query(); ?>" name="s" />
                <button type="submit" class="input-group-text"><img src="<?php echo get_template_directory_uri() . "/assets/img/menu/lupa.png" ?>"></button>
                <input type="hidden" name="post_type" value="product" />
                <input type="hidden" name="orderby" value="price-desc" />
            </form>
        </div>
        <div class="cdc-search_products_by_name" style="display:none;">
            <ul class="not_remove_element"></ul>
        </div>
    </div>
</nav>