<?php
/*
 Template Name: Atividades encerradas
 */
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="profile" href="http://gmpg.org/xfn/11" />
  <?php if (!get_option('site_icon')) : ?>
    <link href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon.ico" rel="shortcut icon" />
  <?php endif; ?>
  <?php wp_head(); ?>
</head>

<body style="background: #1b1c1a; margin-top: -2rem;" class="vh-100">
    <div class="container-fluid d-flex h-100">
        <div class="row d-flex align-items-center w-100">
            <div class="col-12 p-0 m-0">
                <div class="d-flex align-items-center justify-content-center">
                    <img style="width: 750px;" class="central-logo img-fluid" src="<?php echo get_template_directory_uri()."/assets/img/af_marca_escuro.png"; ?>">
                </div>

                <div style="font-size: 20px;" class="d-flex flex-column text-light text-center mx-auto w-50">
                    <p><b>Encerramos nossas atividades &#128532;</b></p>
                    <p>A Central da Cerveja encerrou oficialmente suas atividades em 31 de julho de 2026.</p>
                    <p>Agradecemos a todos os clientes, parceiros, cervejarias e amigos que fizeram parte da nossa história.</p>
                    <p>Foram muitos rótulos, brindes, descobertas e bons momentos compartilhados ao longo dessa caminhada.</p>
                    <p><b>Os produtos não estão mais disponíveis para compra.</b></p>
                    <p>Obrigado por fazer parte da Central da Cerveja. &#127866;</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>