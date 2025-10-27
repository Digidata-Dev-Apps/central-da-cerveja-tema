<?php
/*
 Template Name: Clube de Assinaturas
 */
?>
<?php
get_header();
global $wpdb;

$template_directory_uri = get_template_directory_uri();

$day = date('d');
$subscription_day_limit = get_option('subscription_day_limit', 10);
$month = $day <= $subscription_day_limit ? date('m') - 1 : date('m');
$year = date('Y');
$month = strlen($month) == 2 ? $month : "0{$month}";
$year = $month - 1 == 0 ? $year - 1 : $year;
$month = $month - 1 == 0 ? 12 : $month;

$correct_month = $month - 1;
$upload_dir = wp_upload_dir();

// APRECIADORES
$sql = "SELECT historic.id, historic.products_image, product_id, product_name, product_code, product_price, cst_csosn FROM {$wpdb->prefix}subscription_historic historic
				INNER JOIN {$wpdb->prefix}subscription_products products ON historic.id = products.subscription_historic_id
				WHERE subscription_id = 6452 AND MONTH(historic.month_selection) = '{$correct_month}' AND YEAR(historic.month_selection) = '{$year}'
				AND products.deleted_at IS NULL
				ORDER BY product_name";
$apreciadores_plan_products = $wpdb->get_results($sql);

$sql = "SELECT MONTH(period) AS month, YEAR(period) AS year FROM {$wpdb->prefix}subscription_closing closing
            INNER JOIN {$wpdb->prefix}subscription_historic historic ON MONTH(period) = MONTH(month_selection) AND YEAR(period) = YEAR(month_selection)
            INNER JOIN {$wpdb->prefix}subscription_products products ON historic.id = products.subscription_historic_id
            WHERE (historic.products_image IS NOT NULL || products.product_id IS NOT NULL) AND products.deleted_at IS NULL AND historic.subscription_id = 6452
            GROUP BY month, year ORDER BY year, month";
$available_apreciadores = $wpdb->get_results($sql, ARRAY_A);

$available_apreciadores = array_filter($available_apreciadores, function ($item) use ($day, $subscription_day_limit) {
    return $item['year'] >= date('Y') && $item['month'] + 1 > date('m') && $day >= $subscription_day_limit ? false : true;
});
// FIM APRECIADORES

// IPA
$sql = "SELECT historic.id, historic.products_image, product_id, product_name, product_code, product_price, cst_csosn FROM {$wpdb->prefix}subscription_historic historic
				INNER JOIN {$wpdb->prefix}subscription_products products ON historic.id = products.subscription_historic_id
				WHERE subscription_id = 6454 AND MONTH(historic.month_selection) = '{$correct_month}' AND YEAR(historic.month_selection) = '{$year}'
				AND products.deleted_at IS NULL
				ORDER BY product_name";
$ipa_plan_products = $wpdb->get_results($sql);

$sql = "SELECT MONTH(period) AS month, YEAR(period) AS year FROM {$wpdb->prefix}subscription_closing closing
            INNER JOIN {$wpdb->prefix}subscription_historic historic ON MONTH(period) = MONTH(month_selection) AND YEAR(period) = YEAR(month_selection)
            INNER JOIN {$wpdb->prefix}subscription_products products ON historic.id = products.subscription_historic_id
            WHERE (historic.products_image IS NOT NULL || products.product_id IS NOT NULL) AND products.deleted_at IS NULL AND historic.subscription_id = 6454
            GROUP BY month, year ORDER BY year, month";
$available_ipa = $wpdb->get_results($sql, ARRAY_A);

$available_ipa = array_filter($available_ipa, function ($item) use ($day, $subscription_day_limit) {
    return $item['year'] >= date('Y') && $item['month'] + 1 > date('m') && $day >= $subscription_day_limit ? false : true;
});
// FIM IPA

// ENTUSIASTAS
$sql = "SELECT historic.id, historic.products_image, product_id, product_name, product_code, product_price, cst_csosn FROM {$wpdb->prefix}subscription_historic historic
				INNER JOIN {$wpdb->prefix}subscription_products products ON historic.id = products.subscription_historic_id
				WHERE subscription_id = 6456 AND MONTH(historic.month_selection) = '{$correct_month}' AND YEAR(historic.month_selection) = '{$year}'
				AND products.deleted_at IS NULL
				ORDER BY product_name";
$entusiastas_plan_products = $wpdb->get_results($sql);

$sql = "SELECT MONTH(period) AS month, YEAR(period) AS year FROM {$wpdb->prefix}subscription_closing closing
            INNER JOIN {$wpdb->prefix}subscription_historic historic ON MONTH(period) = MONTH(month_selection) AND YEAR(period) = YEAR(month_selection)
            INNER JOIN {$wpdb->prefix}subscription_products products ON historic.id = products.subscription_historic_id
            WHERE (historic.products_image IS NOT NULL || products.product_id IS NOT NULL) AND products.deleted_at IS NULL AND historic.subscription_id = 6456
            GROUP BY month, year ORDER BY year, month";
$available_entusiastas = $wpdb->get_results($sql, ARRAY_A);

$available_entusiastas = array_filter($available_entusiastas, function ($item) use ($day, $subscription_day_limit) {
    return $item['year'] >= date('Y') && $item['month'] + 1 > date('m') && $day >= $subscription_day_limit ? false : true;
});
// FIM ENTUSIASTAS


$months_array = [
    '01' => 'Janeiro',
    '02' => 'Fevereiro',
    '03' => 'Março',
    '04' => 'Abril',
    '05' => 'Maio',
    '06' => 'Junho',
    '07' => 'Julho',
    '08' => 'Agosto',
    '09' => 'Setembro',
    '10' => 'Outubro',
    '11' => 'Novembro',
    '12' => 'Dezembro',
];

?>

<!-- begin: Banner -->
<div class="cdc-clube-banner">
    <!-- begin: Banner Item-->
    <div class="cdc-clube-banner__item">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 cdc-clube-banner__box">
                    <img src="<?php echo "{$template_directory_uri}/assets/img/clube/caixa.png"; ?>" class="img-fluid" alt="Clube da Central">
                </div>
                <div class="col-12 col-md-6 cdc-clube-banner__info">
                    <div class="cdc-clube-banner__clube-logo">
                        <img src="<?php echo "{$template_directory_uri}/assets/img/clube/clube_da_central.png"; ?>" class="img-fluid" alt="Clube da Central">
                    </div>
                    <div class="cdc-clube-banner__description">
                        <p>Seja sócio e receba cervejas<br>exclusivas e benefícios todo mês</p>
                        <a href="#cdc-clube-plans" class="btn cdc-clube__button">Assinar Agora</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- begin: Banner Item -->
</div>
<!-- end: Banner -->

<!-- begin: About -->
<div class="cdc-clube-about">
    <div class="container">
        <div class="row">
            <!-- <div class="col-12 col-md-5 text-end">
                <img src="" class="img-fluid" alt="Sobre o Clube">
            </div> -->
            <div class="col-12 cdc-clube-about-content-margin">
                <!-- <h2 class="cdc-clube-about__title">Uma Parceria da Central + All Beers</h2> -->
                <p class="cdc-clube-about__description">Nossa proposta é entregar a você, entusiasta da cerveja artesanal, um clube de assinantes com rótulos diferenciados, escolhidos mensalmente com muito cuidado pela curadoria da Central da Cerveja.</p>
                <p class="cdc-clube-about__description">Assinando nosso clube, as cervejas chegarão <b>mensalmente na sua casa</b>, sem esforço, sem preocupação, prontas para garantir sua experiência, com rótulos que podem vir de <b>todos os cantos do Brasil</b>.</p>
                <a href="#cdc-clube-plans" class="cdc-clube__button" title="Assinar Agora">Assinar Agora</a>
            </div>
        </div>
    </div>
</div>
<!-- end: About -->

<!-- begin: Benefits -->
<div class="cdc-clube-benefits">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="cdc-clube-benefits__item">
                    <img src="<?php echo "{$template_directory_uri}/assets/img/clube/descontos_exclusivos.webp"; ?>" class="img-fluid cdc-clube-benefits__icon" alt="Descontos Exclusivos">
                    <h4 class="cdc-clube-benefits__title">Descontos Exclusivos</h4>
                    <p class="cdc-clube-benefits__description">Descontos de 10% em todos os lançamentos disponibilizados no site durante 48hrs.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="cdc-clube-benefits__item">
                    <img src="<?php echo "{$template_directory_uri}/assets/img/clube/frete_inteligente.webp"; ?>" class="img-fluid cdc-clube-benefits__icon" alt="Descontos Exclusivos">
                    <h4 class="cdc-clube-benefits__title">Frete Inteligente</h4>
                    <p class="cdc-clube-benefits__description">Compre suas cervejas ao longo do mês e receba com o seu kit, sem acréscimo no valor do frete.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="cdc-clube-benefits__item">
                    <img src="<?php echo "{$template_directory_uri}/assets/img/clube/ofertas_exclusivas.webp"; ?>" class="img-fluid cdc-clube-benefits__icon" alt="Descontos Exclusivos">
                    <h4 class="cdc-clube-benefits__title">Ofertas especiais e cupons</h4>
                    <p class="cdc-clube-benefits__description">Ofertas especiais e cupons de desconto exclusivos para assinantes.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end: Benefits -->

<div class="cdc-clube-how-to-subscribe">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="cdc-clube-how-to-subscribe__main-title">Como fazer parte do clube de assinantes</h1>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-12 col-md-4">
                <div class="cdc-clube-how-to-subscribe__item">
                    <img src="<?php echo "{$template_directory_uri}/assets/img/clube/escolha_seu_plano.webp"; ?>" alt="Acesse" class="cdc-clube-how-to-subscribe__icon img-fluid">
                    <h4 class="cdc-clube-how-to-subscribe__title">Acesse</h4>
                    <p class="cdc-clube-how-to-subscribe__description">Clicar na aba do clube do assinante e escolha o plano que mais lhe agrada.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="cdc-clube-how-to-subscribe__item">
                    <img src="<?php echo "{$template_directory_uri}/assets/img/clube/curadoria.webp"; ?>" alt="Cadastre-se" class="cdc-clube-how-to-subscribe__icon img-fluid">
                    <h4 class="cdc-clube-how-to-subscribe__title">Cadastre-se</h4>
                    <p class="cdc-clube-how-to-subscribe__description">Efetuar seu cadastro na Central da Cerveja, informando os seus dados e os dados para pagamento.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="cdc-clube-how-to-subscribe__item">
                    <img src="<?php echo "{$template_directory_uri}/assets/img/clube/receba.webp"; ?>" alt="Aguarde" class="cdc-clube-how-to-subscribe__icon img-fluid">
                    <h4 class="cdc-clube-how-to-subscribe__title">Aguarde</h4>
                    <p class="cdc-clube-how-to-subscribe__description">Confirmada a escolha do plano, basta aguardar o processamento e envio mensal da sua seleção de cervejas.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- begin: How it Works -->
<div class="cdc-clube-how-works">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="cdc-clube-how-works__main-title">Como Funciona o Clube da Central</h1>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-12 col-md-3">
                <div class="cdc-clube-how-works__item">
                    <img src="<?php echo "{$template_directory_uri}/assets/img/clube/escolha_seu_plano.webp"; ?>" alt="Escolha seu plano" class="cdc-clube-how-works__icon img-fluid">
                    <h4 class="cdc-clube-how-works__title">Escolha seu Plano</h4>
                    <p class="cdc-clube-how-works__description">São 3 opções de planos para diferentes perfis. Escolha o(s) plano(s) que é a sua cara.</p>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="cdc-clube-how-works__item">
                    <img src="<?php echo "{$template_directory_uri}/assets/img/clube/curadoria.webp"; ?>" alt="Escolha seu plano" class="cdc-clube-how-works__icon img-fluid">
                    <h4 class="cdc-clube-how-works__title">Curadoria</h4>
                    <p class="cdc-clube-how-works__description">Nossa curadoria fará uma seleção dos melhores rótulos disponíveis.</p>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="cdc-clube-how-works__item">
                    <img src="<?php echo "{$template_directory_uri}/assets/img/clube/receba.webp"; ?>" alt="Escolha seu plano" class="cdc-clube-how-works__icon img-fluid">
                    <h4 class="cdc-clube-how-works__title">Receeeeeba</h4>
                    <p class="cdc-clube-how-works__description">Sua seleção chega na sua casa todo mês, com conforto, comodidade e segurança.</p>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="cdc-clube-how-works__item">
                    <img src="<?php echo "{$template_directory_uri}/assets/img/clube/brinde.webp"; ?>" alt="Escolha seu plano" class="cdc-clube-how-works__icon img-fluid">
                    <h4 class="cdc-clube-how-works__title">Brinde</h4>
                    <p class="cdc-clube-how-works__description">Aproveite e deguste vivendo experiências com cervejas incríveis sem sair de casa.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end: How it Works -->

<!-- begin: Plans -->
<div class="cdc-clube-plans" id="cdc-clube-plans">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="cdc-clube-plans__main-title">Escolha o seu plano</h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-pills cdc-clube-plans-nav">
                    <li class="nav-item" role="presentation">
                        <div class="cdc-clube-plans-nav__item active" id="plan_1" data-bs-toggle="pill">
                            <span class="cdc-clube-plans-nav__label">Plano 1</span>
                            <h3 class="cdc-clube-plans-nav__title">Apreciadores</h3>
                        </div>
                    </li>
                    <li class="nav-item" role="presentation">
                        <div class="cdc-clube-plans-nav__item" id="plan_2" data-bs-toggle="pill">
                            <span class="cdc-clube-plans-nav__label">Plano 2</span>
                            <h3 class="cdc-clube-plans-nav__title">100% IPA</h3>
                        </div>
                    </li>
                    <li class="nav-item" role="presentation">
                        <div class="cdc-clube-plans-nav__item" id="plan_3" data-bs-toggle="pill">
                            <span class="cdc-clube-plans-nav__label">Plano 3</span>
                            <h3 class="cdc-clube-plans-nav__title">Entusiastas</h3>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active">
            <div class="cdc-clube-plans-slider">
                <div class="container h-100">
                    <div id="carousel_plans" class="carousel slide h-100" data-bs-interval="false">
                        <div class="carousel-inner">
                            <div class="carousel-item active" data-carousel-id="plan_1">
                                <div class="cdc-clube-plans-slider__item">
                                    <div class="cdc-clube-plans-slider__image">
                                        <img src="<?php echo "{$template_directory_uri}/assets/img/clube/plano_1.webp"; ?>" alt="" class="img-fluid">
                                    </div>
                                    <div class="cdc-clube-plans-slider__description">
                                        <span>Plano 1</span>
                                        <h3>Estação Apreciadores</h3>
                                        <p>Oferece rótulos de qualidade, porém, descomplicados, ideal para quem está iniciando no mundo da cerveja artesanal.</p>
                                        <p><b>Composto por quatro rótulos de cervejas pasteurizadas.</b></p>
                                        <h1><span>R$</span>78,00<span>/MÊS</span></h1>
                                        <a href="?add-to-cart=6452&type=subscription" class="btn cdc-clube__button">Assinar Agora</a>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item" data-carousel-id="plan_2">
                                <div class="cdc-clube-plans-slider__item">
                                    <div class="cdc-clube-plans-slider__image">
                                        <img src="<?php echo "{$template_directory_uri}/assets/img/clube/plano_2.webp"; ?>" alt="" class="img-fluid">
                                    </div>
                                    <div class="cdc-clube-plans-slider__description">
                                        <span>Plano 2</span>
                                        <h3>Estação 100% IPA</h3>
                                        <p>Clube de assinatura especializado em IPA'S (India Pale Ale). Destinado aos hoplovers.</p>
                                        <p><b>Composto por quatro rótulos de cervejas, sempre dentro do estilo IPA (India Pale Ale) e suas variantes.</b></p>
                                        <h1><span>R$</span>116,00<span>/MÊS</span></h1>
                                        <a href="?add-to-cart=6454&type=subscription" class="btn cdc-clube__button">Assinar Agora</a>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item" data-carousel-id="plan_3">
                                <div class="cdc-clube-plans-slider__item">
                                    <div class="cdc-clube-plans-slider__image">
                                        <img src="<?php echo "{$template_directory_uri}/assets/img/clube/plano_3.webp"; ?>" alt="" class="img-fluid">
                                    </div>
                                    <div class="cdc-clube-plans-slider__description">
                                        <span>Plano 3</span>
                                        <h3>Estação Entusiastas</h3>
                                        <p>Se você é um entusiasta de cervejas artesanais, exigente, e gosta de descobrir novos estilos e sabores, sempre buscando o que há de melhor no universo cervejeiro, esse é o seu plano.</p>
                                        <p><b>Composto por seis rótulos de cervejas.</b></p>
                                        <h1><span>R$</span>225,00<span>/MÊS</span></h1>
                                        <a href="?add-to-cart=6456&type=subscription" class="btn cdc-clube__button">Assinar Agora</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev carousel-button" type="button" data-bs-target="#carousel_plans" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next carousel-button" type="button" data-bs-target="#carousel_plans" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="cdc-clube-plans-products active" data-plans-products-id="plan_1">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="cdc-clube-plans-products__title" id="apreciadores_title">Seleção Apreciadores de <?php echo $months_array[$month] . ' de ' . $year ?></h3>
                        </div>
                        <div class="col-12 col-md-6 offset-md-3">
                            <div class="cdc-clube-plans-products-thumbnail" id="apreciadores_thumbnail">
                                <?php if (isset($apreciadores_plan_products[0]) && !empty($apreciadores_plan_products[0]->products_image)) { ?>
                                    <img src="<?php echo $upload_dir['baseurl'] . $apreciadores_plan_products[0]->products_image; ?>" alt="produto" class="img-fluid">
                                <?php } ?>
                            </div>
                        </div>
                        <?php if (!empty($available_apreciadores)) { ?>
                            <div class="col-12 text-center">
                                <a class="btn cdc-clube__button view_month_selection closed">Visualizar meses anteriores</a>
                                <select class="form-control date-filter" name="date_filter" id="date_filter" data-plan-id="6452" style="display:none;">
                                    <option value="">Selecione...</option>
                                    <?php if (isset($available_apreciadores)) {
                                        foreach ($available_apreciadores as $date) {
                                            $year = $date['month'] + 1 == 13 ? $date['year'] + 1 : $date['year'];
                                            $month_apreciadores = $date['month'] + 1 == 13 ? 1 : $date['month'] + 1;
                                            $year_available = $year;
                                            $month_available = strlen(preg_replace('/\s+/', '', $month_apreciadores)) == 1 ? "0{$month_apreciadores}" : $month_apreciadores;
                                    ?>
                                            <option value="<?php echo $year_available . '-' . $month_available; ?>"><?php echo $months_array[$month_available] . " de " . $year_available; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        <?php } ?>
                    </div>
                    <div id="apreciadores">
                        <?php foreach ($apreciadores_plan_products as $key => $apreciadores) {
                            $style = array_shift(wc_get_product_terms($apreciadores->product_id, 'pa_por-estilo', array('fields' => 'names')));
                            $profile = wc_get_product_terms($apreciadores->product_id, 'pa_por-perfil', array('fields' => 'names'));
                            $country = array_shift(wc_get_product_terms($apreciadores->product_id, 'pa_por-pais'));
                            $state = array_shift(wc_get_product_terms($apreciadores->product_id, 'pa_por-estado', array('fields' => 'names')));
                            $temperature_start = get_post_meta($apreciadores->product_id, '_ideal_temperature', true);
                            $temperature_end = get_post_meta($apreciadores->product_id, '_between', true);
                            $package = get_post_meta($apreciadores->product_id, '_package', true) == 1 ? 'Garrafa' : 'Lata';
                            $volume = get_post_meta($apreciadores->product_id, '_volume', true);
                            $alcoholic_dosage = get_post_meta($apreciadores->product_id, '_alcoholic_dosage', true);
                        ?>
                            <div class="cdc-clube-plans-products__item row mt-4">
                                <div class="col-12 col-md-3 text-center">
                                    <img style="height:200px;" src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($apreciadores->product_id), 'single-post-thumbnail')[0]; ?> ?>" alt="produto" class="img-fluid">
                                </div>
                                <div class="col-12 col-md-9 d-flex flex-column justify-content-center">
                                    <div class="cdc-clube-plans-products__item-country">
                                        <img src="<?php echo "{$template_directory_uri}/assets/img/icons/{$country->slug}.png"; ?>" alt="Pais" class="img-fluid">
                                    </div>
                                    <h1 class="cdc-clube-plans-products__item-title"><?php echo $apreciadores->product_name ?></h1>

                                    <div class="cdc-clube-plans-products__item-info">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <b>Estilo: </b>
                                                <span><?php echo $style ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Por Perfil: </b>
                                                <span><?php echo empty($profile) ? '--' : implode(', ', $profile); ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Origem: </b>
                                                <span><?php echo empty($country->name) ? '--' : $country->name ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Estado: </b>
                                                <span><?php echo empty($state) ? '--' : $state  ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Temperatura Ideal: </b>
                                                <span>Entre <?php echo $temperature_start ?> E <?php echo $temperature_end ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Embalagem: </b>
                                                <span><?php echo $package ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Volume: </b>
                                                <span><?php echo $volume ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Dosagem Alcoólica: </b>
                                                <span><?php echo $alcoholic_dosage ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="cdc-clube-plans-products" data-plans-products-id="plan_2">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="cdc-clube-plans-products__title" id="ipa_title">Seleção 100% IPA de <?php echo $months_array[$month] . ' de ' . $year ?></h3>
                        </div>
                        <div class="col-12 col-md-6 offset-md-3">
                            <div class="cdc-clube-plans-products-thumbnail" id="ipa_thumbnail">
                                <?php if (isset($ipa_plan_products[0]) && !empty($ipa_plan_products[0]->products_image)) { ?>
                                    <img src="<?php echo $upload_dir['baseurl'] . $ipa_plan_products[0]->products_image; ?>" alt="produto" class="img-fluid">
                                <?php } ?>
                            </div>
                        </div>
                        <?php if (!empty($available_ipa)) { ?>
                            <div class="col-12 text-center">
                                <a class="btn cdc-clube__button view_month_selection closed">Visualizar meses anteriores</a>
                                <select class="form-control date-filter" name="date_filter" id="date_filter" data-plan-id="6454" style="display:none;">
                                    <option value="">Selecione...</option>
                                    <?php if (isset($available_ipa)) {
                                        foreach ($available_ipa as $date) {
                                            $year = $date['month'] + 1 == 13 ? $date['year'] + 1 : $date['year'];
                                            $month_ipa = $date['month'] + 1 == 13 ? 1 : $date['month'] + 1;
                                            $year_available = $year;
                                            $month_available = strlen(preg_replace('/\s+/', '', $month_ipa)) == 1 ? "0{$month_ipa}" : $month_ipa;
                                    ?>
                                            <option value="<?php echo $year_available . '-' . $month_available; ?>"><?php echo $months_array[$month_available] . " de " . $year_available; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        <?php } ?>
                    </div>
                    <div id="ipa">
                        <?php foreach ($ipa_plan_products as $key => $ipa) {
                            $style = array_shift(wc_get_product_terms($ipa->product_id, 'pa_por-estilo', array('fields' => 'names')));
                            $profile = wc_get_product_terms($ipa->product_id, 'pa_por-perfil', array('fields' => 'names'));
                            $country = array_shift(wc_get_product_terms($ipa->product_id, 'pa_por-pais'));
                            $state = array_shift(wc_get_product_terms($ipa->product_id, 'pa_por-estado', array('fields' => 'names')));
                            $temperature_start = get_post_meta($ipa->product_id, '_ideal_temperature', true);
                            $temperature_end = get_post_meta($ipa->product_id, '_between', true);
                            $package = get_post_meta($ipa->product_id, '_package', true) == 1 ? 'Garrafa' : 'Lata';
                            $volume = get_post_meta($ipa->product_id, '_volume', true);
                            $alcoholic_dosage = get_post_meta($ipa->product_id, '_alcoholic_dosage', true);
                        ?>
                            <div class="cdc-clube-plans-products__item row mt-4">
                                <div class="col-12 col-md-3 text-center">
                                    <img style="height:200px;" src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($ipa->product_id), 'single-post-thumbnail')[0]; ?>" alt="produto" class="img-fluid">
                                </div>
                                <div class="col-12 col-md-9 d-flex flex-column justify-content-center">
                                    <div class="cdc-clube-plans-products__item-country">
                                        <img src="<?php echo "{$template_directory_uri}/assets/img/icons/{$country->slug}.png"; ?>" alt="Pais" class="img-fluid">
                                    </div>
                                    <h1 class="cdc-clube-plans-products__item-title"><?php echo $ipa->product_name ?></h1>

                                    <div class="cdc-clube-plans-products__item-info">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <b>Estilo: </b>
                                                <span><?php echo $style ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Por Perfil: </b>
                                                <span><?php echo empty($profile) ? '--' : implode(', ', $profile); ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Origem: </b>
                                                <span><?php echo empty($country->name) ? '--' : $country->name ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Estado: </b>
                                                <span><?php echo empty($state) ? '--' : $state  ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Temperatura Ideal: </b>
                                                <span>Entre <?php echo $temperature_start ?> E <?php echo $temperature_end ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Embalagem: </b>
                                                <span><?php echo $package ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Volume: </b>
                                                <span><?php echo $volume ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Dosagem Alcoólica: </b>
                                                <span><?php echo $alcoholic_dosage ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="cdc-clube-plans-products" data-plans-products-id="plan_3">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="cdc-clube-plans-products__title" id="entusiastas_title">Seleção Entusiastas de <?php echo $months_array[$month] . ' de ' . $year ?></h3>
                        </div>
                        <div class="col-12 col-md-6 offset-md-3">
                            <div class="cdc-clube-plans-products-thumbnail" id="entusiastas_thumbnail">
                                <?php if (isset($entusiastas_plan_products[0]) && !empty($entusiastas_plan_products[0]->products_image)) { ?>
                                    <img src="<?php echo $upload_dir['baseurl'] . $entusiastas_plan_products[0]->products_image; ?>" alt="produto" class="img-fluid">
                                <?php } ?>
                            </div>
                        </div>
                        <?php if (!empty($available_entusiastas)) { ?>
                            <div class="col-12 text-center">
                                <a class="btn cdc-clube__button view_month_selection closed">Visualizar meses anteriores</a>
                                <select class="form-control date-filter" name="date_filter" id="date_filter" data-plan-id="6456" style="display:none;">
                                    <option value="">Selecione...</option>
                                    <?php if (isset($available_entusiastas)) {
                                        foreach ($available_entusiastas as $date) {
                                            $year = $date['month'] + 1 == 13 ? $date['year'] + 1 : $date['year'];
                                            $month_entusiastas = $date['month'] + 1 == 13 ? 1 : $date['month'] + 1;
                                            $year_available = $year;
                                            $month_available = strlen(preg_replace('/\s+/', '', $month_entusiastas)) == 1 ? "0{$month_entusiastas}" : $month_entusiastas;
                                    ?>
                                            <option value="<?php echo $year_available . '-' . $month_available; ?>"><?php echo $months_array[$month_available] . " de " . $year_available; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        <?php } ?>
                    </div>
                    <div id="entusiastas">
                        <?php foreach ($entusiastas_plan_products as $key => $entusiastas) {
                            $style = array_shift(wc_get_product_terms($entusiastas->product_id, 'pa_por-estilo', array('fields' => 'names')));
                            $profile = wc_get_product_terms($entusiastas->product_id, 'pa_por-perfil', array('fields' => 'names'));
                            $country = array_shift(wc_get_product_terms($entusiastas->product_id, 'pa_por-pais'));
                            $state = array_shift(wc_get_product_terms($entusiastas->product_id, 'pa_por-estado', array('fields' => 'names')));
                            $temperature_start = get_post_meta($entusiastas->product_id, '_ideal_temperature', true);
                            $temperature_end = get_post_meta($entusiastas->product_id, '_between', true);
                            $package = get_post_meta($entusiastas->product_id, '_package', true);
                            $package = empty($package) ? '--' : $package;
                            if ($package != '--') {
                                $package = $package == 1 ? 'Garrafa' : 'Lata';
                            }
                            $volume = get_post_meta($entusiastas->product_id, '_volume', true);
                            $alcoholic_dosage = get_post_meta($entusiastas->product_id, '_alcoholic_dosage', true);
                        ?>
                            <div class="cdc-clube-plans-products__item row mt-4">
                                <div class="col-12 col-md-3 text-center">
                                    <img style="height:200px;" src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($entusiastas->product_id), 'single-post-thumbnail')[0]; ?>" alt="produto" class="img-fluid">
                                </div>
                                <div class="col-12 col-md-9 d-flex flex-column justify-content-center">
                                    <div class="cdc-clube-plans-products__item-country">
                                        <img src="<?php echo "{$template_directory_uri}/assets/img/icons/{$country->slug}.png"; ?>" alt="Pais" class="img-fluid">
                                    </div>
                                    <h1 class="cdc-clube-plans-products__item-title"><?php echo $entusiastas->product_name ?></h1>

                                    <div class="cdc-clube-plans-products__item-info">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <b>Estilo: </b>
                                                <span><?php echo empty($style) ? '--' : $style  ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Por Perfil: </b>
                                                <span><?php echo empty($profile) ? '--' : implode(', ', $profile); ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Origem: </b>
                                                <span><?php echo empty($country->name) ? '--' : $country->name ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Estado: </b>
                                                <span><?php echo empty($state) ? '--' : $state  ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Temperatura Ideal: </b>
                                                <span><?php echo empty($temperature_start) ? '--' : 'Entre' . $temperature_start . 'E' . $temperature_end ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Embalagem: </b>
                                                <span><?php echo $package  ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Volume: </b>
                                                <span><?php echo empty($volume) ? '--' : $volume  ?></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <b>Dosagem Alcoólica: </b>
                                                <span><?php echo empty($alcoholic_dosage) ? '--' : $alcoholic_dosage  ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end: Plans -->

<!-- begin: FAQ -->
<div class="cdc-clube-faq mt-5 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="cdc-clube-faq__title">Perguntas Frequentes</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <div class="accordion mt-4" id="cdc-clube-faq">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#box-1">
                                Quando receberei minhas cervejas de cada mês?
                            </button>
                        </h2>
                        <div id="box-1" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                As cervejas serão despachadas, mensalmente, até o dia 15. Os prazos de recebimento variam de acordo com a localidade.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#box-2">
                                Quando posso me associar?
                            </button>
                        </h2>
                        <div id="box-2" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                A assinatura do clube pode ser realizada a qualquer momento. Assinaturas realizadas até o dia 10 estarão elegíveis para o recebimento da seleção do mês de adesão. Assinaturas realizadas após o dia 10 receberão a seleção do mês seguinte.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#box-3">
                                O valor do frete está incluído no preço do plano?
                            </button>
                        </h2>
                        <div id="box-3" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <p>
                                    Não. O preço do frete depende da localidade onde as cervejas serão entregues. Para saber o valor do frete para a sua região,
                                    consulte a tabela abaixo.
                                </p>

                                <p>IMPORTANTE:</p>

                                <p>Olha que legal! Ao se tornar um assinante do Clube, você paga este frete mas pode fazer infinitas compras ao longo do mês para que essas cervejas sejam entregues juntamente com o seu kit mensal, sem qualquer custo adicional! </p>

                                <table class="cdc-clube-faq__table">
                                    <tbody>
                                        <tr>
                                            <td>SP</td>
                                            <td>20,00</td>
                                        </tr>
                                        <tr>
                                            <td>RJ, PR, SC, RS e MG</td>
                                            <td>25,00</td>
                                        </tr>
                                        <tr>
                                            <td>ES, GO e DF</td>
                                            <td>40,00</td>
                                        </tr>
                                        <tr>
                                            <td>Demais Estados - Entrega Aérea</td>
                                            <td>Sob Consulta</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div style="font-size:15px;">*Assinantes que requeiram entregas imediatas em compras regulares feitas no site estão sujeitas a cobrança de frete à parte.</div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#box-4">
                                Como cancelo a minha assinatura?
                            </button>
                        </h2>
                        <div id="box-4" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                Você pode cancelar sua assinatura, quando quiser, pelo nosso site, acessando "Minha Conta” > “Minhas Assinaturas".
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#box-5">
                                Como funciona o frete inteligente para a compra de outras cervejas?
                            </button>
                        </h2>
                        <div id="box-5" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <p>
                                    Após a primeira cobrança da sua assinatura, você verá que a opção “entrega junto com o Clube” aparecerá no momento em
                                    que for concluir a sua compra. Isso significa que até o dia 25 de cada mês, incluindo outras compras à entrega do Clube,
                                    você as receberá junto com a seleção do mês vigente sem pagar a mais por esses fretes. Utilize este benefício sem qualquer moderação!
                                </p>
                                <p>
                                    IMPORTANTE: Você pode se associar em mais de um plano sem que haja a cobrança de fretes adicionais, desde que o
                                    endereço de entrega seja o mesmo.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#box-6">
                                Como aproveitar meus descontos exclusivos de lançamentos?
                            </button>
                        </h2>
                        <div id="box-6" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <p>
                                    Assinantes do clube têm desconto exclusivo ilimitado de 10% OFF em TODOS os lançamentos do site pelo prazo de 48 horas.
                                    O desconto será aplicado automaticamente em seu carrinho.
                                </p>
                                <p>
                                    Desconto não cumulativo com outras promoções.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#box-7">
                                Quando é feita a cobrança da mensalidade?
                            </button>
                        </h2>
                        <div id="box-7" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                A cobrança é feita automaticamente no seu cartão de crédito no momento da efetivação da sua assinatura.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#box-8">
                                É possível fazer uma assinatura para outra pessoa, utilizando seu cartão como meio de pagamento?
                            </button>
                        </h2>
                        <div id="box-8" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                Absolutamente, basta informar os dados do assinante e os dados do cartão da pessoa que está adquirindo um plano.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#box-9">
                                Posso trocar de plano de assinatura?
                            </button>
                        </h2>
                        <div id="box-9" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                Para trocar de plano basta alterar a opção na aba do clube de assinantes, e a alteração será válida após a entrega da seleção do mês subsequente.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end: FAQ -->
<?php
get_footer();
?>