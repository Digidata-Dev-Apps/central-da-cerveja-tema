<?php
if (!defined('ABSPATH')) {
  exit;
}
global $central_da_cerveja;
?>

<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="profile" href="http://gmpg.org/xfn/11" />
  <?php if (!get_option('site_icon')) : ?>
    <link href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon.ico" rel="shortcut icon" />
  <?php endif; ?>
  <script src="https://www.google.com/recaptcha/api.js?render=6Lf1vDceAAAAACfQThQ_giVw6d0zuetRgNpcmhWQ"></script>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <header class="cdc-header">
    <div class="container">
      <div class="cdc-header__wrapper">
        <div class="cdc-logo">
          <a href="/">
            <?php
            $central_da_cerveja->utils->get_logo();
            ?>
          </a>
        </div>
        <?php if (!wp_is_mobile()) : ?>
          <div class="cdc-nav">
            <div class="cdc-nav__row">
              <div class="cdc-nav__wrapper">
                <div class="cdc-nav__main-menu">
                  <nav class="navbar">
                    <?php wp_nav_menu([
                      'theme_location' => 'principal_menu',
                      'menu_class' => 'cdc-navbar',
                      'container' => 'div',
                      'container_class' => 'nav-item',
                    ]) ?>
                  </nav>
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
                      <input type="search" autocomplete="off" id="woocommerce-product-search-field-<?php echo isset($index) ? absint($index) : 0; ?>" class="not_remove_element form-control search_field" value="<?php echo get_search_query(); ?>" name="s" />
                      <button type="submit" class="not_remove_element input-group-text"><img class="not_remove_element" src="<?php echo get_template_directory_uri() . "/assets/img/menu/lupa.png" ?>"></button>
                      <input type="hidden" name="post_type" value="product" />
                      <input type="hidden" name="orderby" value="price-desc" />
                    </form>
                    <!-- Search Results -->
                    <div class="cdc-search_products_by_name" style="display:none;">
                      <ul class="not_remove_element"></ul>
                    </div>
                  </div>
                  <div class="cdc-help">
                    <a href="/ajuda-e-suporte"><img src="<?php echo get_template_directory_uri() . "/assets/img/Extract/ask.png" ?>" alt=""></a>
                  </div>
                </div>
              </div>
              <div class="cdc-nav__tools">
                <div class="cdc-tools__item pe-1">
                  <a href="/minha-conta" title="<?php echo __('Minha Conta', 'central-da-cerveja') ?>">
                    <div class="cdc-icon">
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
                  <?php
                  $cart_product_qty = 0;
                  ?>
                  <a href="/cervejeira" title="<?php echo __('Cervejeira', 'central-da-cerveja') ?>">
                    <div class="cdc-icon cdc-icon--border">
                      <img id="header_cart_icon" src="<?php echo get_template_directory_uri() . "/assets/img/Extract/geladeira.png" ?>" class="img-fluid" title="<?php echo __('Cervejeira', 'central-da-cerveja'); ?>">
                      <div class="hide-counter-if-cart-empty" style="<?php echo $cart_product_qty > 0 ? '' : 'display:none;'; ?>">
                        <div id="cart_header_qty_background"></div>
                        <span class="cart_icon_product_qty">
                          <?php
                          echo $cart_product_qty > 0 ? $cart_product_qty : '';
                          ?>
                        </span>
                      </div>
                    </div>
                    <div class="cdc-tools__label">
                      <span><?php echo __('Cervejeira', 'central-da-cerveja') ?></span>
                    </div>
                  </a>
                </div>

              </div>
            </div>
            <div class="cdc-nav__row cdc-nav__row--mt-14">
              <div class="cdc-nav__wrapper">
                <div class="cdc-nav__sub-menu">
                  <div class="navbar" style="justify-content:space-around">
                    <div class="nav-item">
                      <ul class="cdc-navbar">
                        <li class="menu-item">
                          <a href="javascript:void(0);">Por Perfil</a>
                          <ul class="submenu">
                            <li class="submenu-item submenu-item__container">
                              <div class="submenu-item__header">
                                <h4 class="submenu-item__title"><?php echo __('Conheça as principais cervejas por perfil', 'central-da-cerveja'); ?></h4>
                              </div>
                              <div class="submenu-item__content">
                                <?php
                                $attr_profile = get_terms([
                                  'taxonomy' => 'pa_por-perfil',
                                  'order' => 'ASC',
                                  'hide_empty' => true,
                                  'orderby' => 'name',
                                  'number' => 30
                                ]);
                                if (!empty($attr_profile) && !isset($attr_profile->errors)) {
                                  $columns = array_chunk($attr_profile, 10);
                                  if (isset($columns[2][9])) {
                                    array_push($columns[2], [10]);
                                  }
                                  foreach ($columns as $colum) {
                                ?>
                                    <div class="submenu-item__column">
                                      <?php
                                      foreach ($colum as $item) {
                                        if (isset($item->name)) {
                                      ?>
                                          <a href="<?php echo get_term_link($item); ?>" class="submenu-item__link"><?php echo $item->name; ?></a>
                                        <?php
                                        } else { ?>
                                          <a href="/por-perfil" class="submenu-item__link">VER MAIS...</a>
                                      <?php }
                                      }
                                      ?>
                                    </div>
                                  <?php
                                  }
                                } else {
                                  ?>
                                  <p class="text-center text-dark mt-4 w-100"><?php echo __('Nenhum resultado encontrado!', 'central-da-cerveja'); ?></p>
                                <?php
                                }
                                ?>
                              </div>
                            </li>
                          </ul>
                        </li>
                        <li class="menu-item">
                          <a href="javascript:void(0);">Por Estilo</a>
                          <ul class="submenu">
                            <li class="submenu-item submenu-item__container">
                              <div class="submenu-item__header">
                                <h4 class="submenu-item__title"><?php echo __('Conheça as principais cervejas por estilo', 'central-da-cerveja'); ?></h4>
                              </div>
                              <div class="submenu-item__content">
                                <?php
                                $attr_style = get_terms([
                                  'taxonomy' => 'pa_por-estilo',
                                  'order' => 'ASC',
                                  'hide_empty' => true,
                                  'orderby' => 'name',
                                  'number' => 30
                                ]);
                                if (!empty($attr_style) && !isset($attr_style->errors)) {
                                  $columns = array_chunk($attr_style, 10);
                                  if (isset($columns[2][9])) {
                                    array_push($columns[2], [10]);
                                  }
                                  foreach ($columns as $colum) {
                                ?>
                                    <div class="submenu-item__column">
                                      <?php
                                      foreach ($colum as $item) {
                                        if (isset($item->name)) {
                                      ?>
                                          <a href="<?php echo get_term_link($item); ?>" class="submenu-item__link"><?php echo $item->name; ?></a>
                                        <?php
                                        } else { ?>
                                          <a href="/por-estilo" class="submenu-item__link">VER MAIS...</a>
                                      <?php }
                                      }
                                      ?>
                                    </div>
                                  <?php
                                  }
                                } else {
                                  ?>
                                  <p class="text-center text-dark mt-4 w-100"><?php echo __('Nenhum resultado encontrado!', 'central-da-cerveja'); ?></p>
                                <?php
                                }
                                ?>
                              </div>
                            </li>
                          </ul>
                        </li>
                        <li class="menu-item">
                          <a href="javascript:void(0);"><?php echo __('Por Local', 'central-da-cerveja'); ?></a>
                          <ul class="submenu">
                            <li class="submenu-item submenu-item__container">
                              <div class="submenu-item__header">
                                <h4 class="submenu-item__title"><?php echo __('Conheça as principais cervejas por', 'central-da-cerveja'); ?></h4>
                              </div>
                              <div class="menu-by-local__wrapper">
                                <div class="menu-by-local__div">
                                  <a class="menu-by-local" href="/por-pais"><?php echo __('País', 'central-da-cerveja'); ?></a>
                                  <div class="submenu-item__content">
                                    <?php
                                    $attr_country = get_terms([
                                      'taxonomy' => 'pa_por-pais',
                                      'order' => 'ASC',
                                      'hide_empty' => true,
                                      'orderby' => 'name',
                                      'number' => 30
                                    ]);
                                    if (!empty($attr_country) && !isset($attr_country->errors)) {
                                      $columns = array_chunk($attr_country, 10);
                                      if (isset($columns[2][9])) {
                                        array_push($columns[2], [10]);
                                      }
                                      foreach ($columns as $colum) {
                                    ?>
                                        <div class="submenu-item__column">
                                          <?php
                                          foreach ($colum as $item) {
                                            if (isset($item->name)) {
                                          ?>
                                              <a href="<?php echo get_term_link($item); ?>" class="submenu-item__link"><?php echo $item->name; ?></a>
                                            <?php
                                            } else { ?>
                                              <a href="/por-pais" class="submenu-item__link">VER MAIS...</a>
                                          <?php }
                                          }
                                          ?>
                                        </div>
                                      <?php
                                      }
                                    } else {
                                      ?>
                                      <p class="text-center text-dark mt-4 w-100"><?php echo __('Nenhum resultado encontrado!', 'central-da-cerveja'); ?></p>
                                    <?php
                                    }
                                    ?>
                                  </div>
                                </div>
                                <div class="menu-by-local__div">
                                  <a class="menu-by-local" href="/por-estado"><?php echo __('Estado', 'central-da-cerveja'); ?></a>
                                  <div class="submenu-item__content">
                                    <?php
                                    $attr_state = get_terms([
                                      'taxonomy' => 'pa_por-estado',
                                      'order' => 'ASC',
                                      'hide_empty' => true,
                                      'orderby' => 'name',
                                      'number' => 30
                                    ]);
                                    if (!empty($attr_state) && !isset($attr_state->errors)) {
                                      $columns = array_chunk($attr_state, 10);
                                      if (isset($columns[2][9])) {
                                        array_push($columns[2], [10]);
                                      }
                                      foreach ($columns as $colum) {
                                    ?>
                                        <div class="submenu-item__column">
                                          <?php
                                          foreach ($colum as $item) {
                                            if (isset($item->name)) {
                                          ?>
                                              <a href="<?php echo get_term_link($item); ?>" class="submenu-item__link"><?php echo $item->name; ?></a>
                                            <?php
                                            } else { ?>
                                              <a href="/por-estado" class="submenu-item__link">VER MAIS...</a>
                                          <?php }
                                          }
                                          ?>
                                        </div>
                                      <?php
                                      }
                                    } else {
                                      ?>
                                      <p class="text-center text-dark mt-4 w-100"><?php echo __('Nenhum resultado encontrado!', 'central-da-cerveja'); ?></p>
                                    <?php
                                    }
                                    ?>
                                  </div>
                                </div>
                              </div>
                            </li>
                          </ul>
                        </li>
                        <li class="menu-item">
                          <a href="javascript:void(0);"><?php echo __('Por Preço', 'central-da-cerveja'); ?></a>
                          <ul class="submenu">
                            <li class="submenu-item submenu-item__container">
                              <div class="submenu-item__header">
                                <h4 class="submenu-item__title"><?php echo __('Conheça as principais cervejas por preço', 'central-da-cerveja'); ?></h4>
                              </div>
                              <div class="menu-by-local__wrapper">
                                <div class="submenu-item__content">
                                  <div class="submenu-item__column">
                                    <a href="/loja?min_price=0&max_price=10" class="submenu-item__link">De R$ 0 à R$ 10,00</a>
                                    <a href="/loja?min_price=10&max_price=20" class="submenu-item__link">De R$ 10,00 à R$ 20,00</a>
                                    <a href="/loja?min_price=20&max_price=30" class="submenu-item__link">De R$ 20,00 à R$ 30,00</a>
                                    <a href="/loja?min_price=30&max_price=40" class="submenu-item__link">De R$ 30,00 à R$ 40,00</a>
                                    <a href="/loja?min_price=40&max_price=50" class="submenu-item__link">De R$ 40,00 à R$ 50,00</a>
                                    <a href="/loja?min_price=50&max_price=100" class="submenu-item__link">De R$ 50,00 à R$ 100,00</a>
                                  </div>
                                </div>
                              </div>
                            </li>
                          </ul>
                        </li>
                        <li class="menu-item">
                          <a href="/por-cervejaria"><?php echo __('Por Cervejaria', 'central-da-cerveja'); ?></a>
                          <ul class="submenu submenu_by_supplier">
                            <li class="submenu-item submenu-item__container">
                              <div class="submenu-item__header">
                                <h4 class="submenu-item__title"><?php echo __('Conheça as principais cervejas por fabricante', 'central-da-cerveja'); ?></h4>
                              </div>
                              <div class="submenu-item__content">
                                <?php
                                $attr_vendor = $central_da_cerveja->woocommerce->get_suppliers_with_stock();
                                if (!empty($attr_vendor)) {
                                  $columns = array_chunk($attr_vendor, 18);
                                  foreach ($columns as $colum) {
                                ?>
                                    <div class="submenu-item__column">
                                      <?php foreach ($colum as $item) { ?>
                                        <a href="<?php echo esc_url(home_url('/por-cervejaria/' . $item['post_name'])); ?>" class="submenu-item__link">
                                          <?php echo esc_html($item['post_title']); ?>
                                        </a>
                                      <?php } ?>
                                    </div>
                                  <?php } ?>
                                <?php } else { ?>
                                  <p class="text-center text-dark mt-4 w-100"><?php echo __('Nenhum resultado encontrado!', 'central-da-cerveja'); ?></p>
                                <?php } ?>
                              </div>
                            </li>
                          </ul>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="cdc-nav__tools">
                <div class="cdc-tools__item pe-1">
                  <a href="/seja-um-expositor" title="<?php echo __('Seja um Expositor', 'central-da-cerveja'); ?>">
                    <div class="cdc-icon scroll-icon">
                      <i class="fas fa-scroll"></i>
                    </div>
                    <div class="cdc-tools__label">
                      <span class="cdc-tools__label--size-12"><?php echo __('Seja um Expositor', 'central-da-cerveja') ?></span>
                    </div>
                  </a>
                </div>
                <div class="cdc-tools__item">
                  <a href="/blog-do-cervejeiro" title="<?php echo __('Blog', 'central-da-cerveja') ?>">
                    <div class="cdc-icon">
                      <i class="fa fa-solid fa-newspaper" style="font-size: 27px;"></i>
                    </div>
                    <div class="cdc-tools__label">
                      <span><?php echo __('Blog', 'central-da-cerveja') ?></span>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php else : ?>
      </div>
    <?php
          include('mobile-header.php');
        endif;
    ?>
    </div>
  </header>