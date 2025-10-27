<?php
/*
 Template Name: Clube de Assinaturas - Pré Venda
 */
?>
<?php
get_header();

$template_directory_uri = get_template_directory_uri();
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
                        <img src="<?php echo "{$template_directory_uri}/assets/img/clube/clube_da_central.svg"; ?>" class="img-fluid" alt="Clube da Central">
                    </div>
                    <div class="cdc-clube-banner__description">
                        <p>Seja sócio e receba cervejas<br>exclusivas e benefícios todo mês</p>
                        <a href="#cdc-clube-form" class="btn cdc-clube__button">Faça o Pré-Cadastro Agora</a>
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
            <div class="col-12 col-md-5 text-end">
                <img src="<?php echo "{$template_directory_uri}/assets/img/clube/all_beers.png"; ?>" class="img-fluid" alt="Sobre o Clube">
            </div>
            <div class="col-12 col-md-7">
                <h2 class="cdc-clube-about__title">Uma Parceria da Central + All Beers</h2>
                <p class="cdc-clube-about__description">Nossa proposta é entregar a você, entusiasta da cerveja artesanal e cliente da Central da Cerveja, um <b>clube de assinantes</b> com rótulos diferenciados, escolhidos mensalmente com muito cuidado pelo <b>Raphael Rodrigues</b>, proprietário da mídia cervejeira <b>ALL BEERS | www.allbeers.com.br.</b></p>
                <p class="cdc-clube-about__description">Assinando nosso clube, as cervejas chegarão <b>mensalmente na sua casa</b>, sem esforço, sem preocupação, prontas para garantir sua experiência, com rótulos que podem vir de <b>todos os cantos do Brasil</b>.</p>
                <a href="#cdc-clube-form" class="cdc-clube__button" title="Faça o Pré-Cadastro Agora">Faça o Pré-Cadastro Agora</a>
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
                    <p class="cdc-clube-how-works__description">Nossa curadoria, em parceria com a all beers, fará uma seleção dos melhores rótulos disponíveis.</p>
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
                                        <p>Plano que oferece rótulos de qualidade e descomplicados. Ideal para quem está iniciando no mundo da cerveja artesanal.</p>
                                        <p><b>Composto por 4 rótulos de cerveja.</b></p>
                                        <h1><span>R$</span>78,00<span>/MÊS</span></h1>
                                        <a href="#cdc-clube-form" class="btn cdc-clube__button" title="Faça o Pré-Cadastro Agora">Faça o Pré-Cadastro Agora</a>
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
                                        <p>Plano destinado aos hoplovers, especializado em IPA's (India Pale Ale).</p>
                                        <p><b>Composto por 4 rótulos de cervejas, sempre dentro do estilo IPA e suas variantes.</b></p>
                                        <h1><span>R$</span>116,00<span>/MÊS</span></h1>
                                        <a href="#cdc-clube-form" class="btn cdc-clube__button" title="Faça o Pré-Cadastro Agora">Faça o Pré-Cadastro Agora</a>
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
                                        <p>Se você é um entusiasta de cervejas artesanais e aprecia rótulos mais complexos, este plano é ideal para você.</p>
                                        <p><b>Composto por 6 rótulos de cervejas.</b></p>
                                        <h1><span>R$</span>225,00<span>/MÊS</span></h1>
                                        <a href="#cdc-clube-form" class="btn cdc-clube__button" title="Faça o Pré-Cadastro Agora">Faça o Pré-Cadastro Agora</a>
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
        </div>
    </div>
</div>
<!-- end: Plans -->

<!-- begin: Email notification -->
<div class="cdc-clube-email-notification pt-4 pb-3" id="cdc-clube-form">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-1">
                <h1 class="cdc-clube-email-notification__title">Pré-Cadastro de Lançamento!</h1>
            </div>
            <div class="col-12">
                <p class="cdc-clube-email-notification__description">Garante o seu lugar antecipadamente no clube de assinatura de cerveja mais esperado do ano!</p>
                <p class="cdc-clube-email-notification__description">
                    Seja um dos <span class="cdc-clube-email-notification__span">primeiros 50</span> 
                    a se inscrever no Clube da Central e <span class="cdc-clube-email-notification__span">*ganhe uma taça personalizada de brinde!</span>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="cdc-clube-email-notification-div">
                <form id="clube_email_notification_form" method="POST">
                 	<?php wp_nonce_field('woocommerce-cdc-email-subscription-notification', 'woocommerce-cdc-email-subscription-notification-nonce'); ?>
                 	<input type="hidden" name="generate_token" id="generate_token">
                 	
                    <div class="mt-3 mb-3">
                        <input placeholder="Nome" type="text" name="clube_email_notification_name" id="clube_email_notification_name" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <input placeholder="Telefone" type="text" name="clube_email_notification_phone" id="clube_email_notification_phone" class="form-control" required>
                    </div>

                    <div class="mb-1">
                        <input placeholder="Email" type="email" name="clube_email_notification_email" id="clube_email_notification_email" class="form-control" required>
                    </div>
                    
                    <input type="checkbox" name="clube_email_notification_agree" id="clube_email_notification_agree" required>
                    <label class="clube-email-notification__agree mb-4" for="clube_email_notification_agree">Autorizo a Central da Cerveja a me ofertar produtos com desconto e vantagens exclusivas.</label>
                    

                    <div class="mb-3 cdc-clube-email-notification__submit-div">
                        <button type="button" class="btn cdc-clube-email-notification__submit">FAZER PRÉ-CADASTRO</button>
                    </div>
                </form>
                <div class="clube-email-notification__notice">
                    <span>* Oferta válida para os 50 primeiros que fizerem o pré-cadastro e efetivarem a assinatura de qualquer um dos planos do Clube da Centrall após o lançamento no dia 25/07/23</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end: Email notification -->

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
                                O valor do frete está incluído no preço do plano?
                            </button>
                        </h2>
                        <div id="box-2" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <p>
                                    Não. O preço do frete depende da localidade onde as cervejas serão entregues. Para saber o valor do frete para a sua região, 
                                    consulte a tabela abaixo.
                                </p>

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
                                            <td>20,00</td>
                                        </tr>
                                        <tr>
                                            <td>Demais Estados - entrega terrestre</td>
                                            <td>40,00</td>
                                        </tr>
                                        <tr>
                                            <td>Demais Estados - entrega aérea</td>
                                            <td>Sob Consulta</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#box-3">
                                Como cancelo a minha assinatura?
                            </button>
                        </h2>
                        <div id="box-3" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                Você pode cancelar sua assinatura, quando quiser, pelo nosso site, acessando "Minha Conta” > “Minhas Assinaturas".
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#box-4">
                                Como funciona o frete inteligente para a compra de outras cervejas?
                            </button>
                        </h2>
                        <div id="box-4" class="accordion-collapse collapse">
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
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#box-5">
                                Como aproveitar meus descontos exclusivos de lançamentos?
                            </button>
                        </h2>
                        <div id="box-5" class="accordion-collapse collapse">
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
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#box-6">
                                Quando é feita a cobrança da mensalidade?
                            </button>
                        </h2>
                        <div id="box-6" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                A cobrança é feita automaticamente no seu cartão de crédito no momento da efetivação da sua assinatura.
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
include get_template_directory(__DIR__)."/partials/clube_email_subscription_notification_modal.php";?>
<?php
get_footer();
?>