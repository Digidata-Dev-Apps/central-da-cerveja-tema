<?php
/*
 Template Name: Manutenção
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

                <div class="d-flex align-items-center justify-content-center">
                    <span style="font-family: 'Gotham Bold'; font-size: 20px;" class="text-light text-center text-size">Estamos atualizando a loja. Estaremos de volta às <?php echo get_option('maintenance_time') ?> horas.</span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>