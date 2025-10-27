<!DOCTYPE html>

<html lang="en" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <title></title>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css" />
    <!--<![endif]-->
    <style>
        @font-face {
            font-family: "Gotham bold";
            src: url("<?php echo get_template_directory_uri(); ?>/assets/fonts/gotham-fonts-master/Gotham-Bold.eot");
            src: local("Gotham-Bold"), url("<?php echo get_template_directory_uri(); ?>/assets/fonts/gotham-fonts-master/Gotham-Bold.eot?#iefix") format("embedded-opentype"),
                url("<?php echo get_template_directory_uri(); ?>/assets/fonts/gotham-fonts-master/Gotham-Bold.woff2") format("woff2"),
                url("<?php echo get_template_directory_uri(); ?>/assets/fonts/gotham-fonts-master/Gotham-Bold.woff") format("woff"),
                url("<?php echo get_template_directory_uri(); ?>/assets/fonts/gotham-fonts-master/Gotham-Bold.ttf") format("truetype"),
                url("<?php echo get_template_directory_uri(); ?>/assets/fonts/gotham-fonts-master/Gotham-Bold.svg#Gotham-Bold") format("svg");
            font-weight: bold;
            font-style: normal;
            font-display: block;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
        }

        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: inherit !important;
        }

        #MessageViewBody a {
            color: inherit;
            text-decoration: none;
        }

        p {
            line-height: inherit
        }

        @media (max-width:785px) {
            .row-content {
                width: 100% !important;
            }

            .stack .column {
                width: 100%;
                display: block;
            }
        }
    </style>
</head>

<body style="background-color: #FFFFFF; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none; font-family:'Gotham bold', Calibri, sans-serif !important;">
    <table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #FFFFFF;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 765px;" width="765">
                                        <tbody>
                                            <tr>
                                                <td class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
                                                    <table border="0" cellpadding="0" cellspacing="0" class="image_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                                        <tr>
                                                            <td style="width:100%;padding-right:0px;padding-left:0px;">
                                                                <div style="line-height:10px"><img src="<?php echo get_template_directory_uri() . "/assets/img/CentralDaCerveja-Logo.png"; ?>" style="display: block; height: auto; border: 0; width: 100px; max-width: 100%;" width="100" /></div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
                                                        <tr>
                                                            <td style="padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:50px;">
                                                                <div style="font-family: Tahoma, Verdana, sans-serif">
                                                                    <div style="font-size: 16px; font-family: 'Gotham Bold', Calibri, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #93583a; line-height: 1.2;">
                                                                        <p style="margin: 0; font-size: 16px;">
                                                                            <span style="font-size:20px;">
                                                                                <?php if (count($data) > 1) : ?>
                                                                                    Foram encontrados <?php echo count($data); ?> produtos que
                                                                                    irão vencer no período de <?php echo empty(get_option('days_to_expire')) && get_option('days_to_expire') == '' ? 30 : get_option('days_to_expire'); ?> dia(s).
                                                                                <?php else : ?>
                                                                                    Foi encontrado <?php echo count($data); ?> produto que
                                                                                    irá vencer no período de <?php echo empty(get_option('days_to_expire')) && get_option('days_to_expire') == '' ? 30 : get_option('days_to_expire'); ?> dia(s).
                                                                                <?php endif;  ?>
                                                                            </span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table border="0" cellpadding="0" cellspacing="0" class="html_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                                        <tr>
                                                            <td style="padding-top:35px;">
                                                                <div align="center" style=" font-family: 'Gotham Bold', Calibri, sans-serif;">
                                                                    <table border="0" cellpadding="10" cellspacing="0" style="border: 1px solid rgba(0,0,0,.1); margin: 0 -1px 24px 0; text-align: left; width: 100%; border-collapse: separate; border-radius: 5px; border: 1px solid rgba(0, 0, 0, 0.1); margin: 0 -1px 24px 0; text-align: left; width: 100%; border-collapse: collapse; border-radius: 5px;">
                                                                        <thead>
                                                                            <tr style="background: #93583a; border: none !important; border-collapse: collapse; font-size: 16px;">
                                                                                <th align="center">
                                                                                    <div style="color: #fff; font-family: 'Gotham Bold', Calibri, sans-serif;">Produto
                                                                                    </div>
                                                                                </th>
                                                                                <?php if ($to_admin) : ?>
                                                                                    <th align="center">
                                                                                        <div style="color: #fff; font-family: 'Gotham Bold', Calibri, sans-serif;">Fornecedor
                                                                                        </div>
                                                                                    </th>
                                                                                <?php endif; ?>
                                                                                <th align="center">
                                                                                    <div style="color: #fff; font-family: 'Gotham Bold', Calibri, sans-serif;">Nº da Remessa
                                                                                    </div>
                                                                                </th>
                                                                                <th align="center">
                                                                                    <div style="color: #fff; font-family: 'Gotham Bold', Calibri, sans-serif;">Nº da NF
                                                                                    </div>
                                                                                </th>
                                                                                <th align="center">
                                                                                    <div style="color: #fff; font-family: 'Gotham Bold', Calibri, sans-serif;">Qtde à Vencer
                                                                                    </div>
                                                                                </th>
                                                                                <th align="center">
                                                                                    <div style="color: #fff; font-family: 'Gotham Bold', Calibri, sans-serif;">Data de Validade
                                                                                    </div>
                                                                                </th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody style="border-color: inherit; border-style: solid; border-width: 0;">

                                                                            <?php foreach ($data as $product) : ?>
                                                                                <tr style="font-size: 16px; font-family: Calibri, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #93583a; line-height: 1.2;">
                                                                                    <td align="center" data-title="Pedido" style="font-weight: bold; padding: 1em !important; font-family: 'Gotham Bold';  border: none !important; border-collapse: collapse;">
                                                                                        <p style="font-size: 16px; font-family: 'Gotham Bold', Calibri, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #93583a; line-height: 1.2; line-height: 1.5em; padding: 1em !important;">
                                                                                            <?php echo $product['product_name']; ?> </p>
                                                                                    </td>
                                                                                    <?php if ($to_admin) : ?>
                                                                                        <td align="center" data-title="Pedido" style="font-weight: bold; padding: 1em !important; font-family: 'Gotham Bold';  border: none !important; border-collapse: collapse;">
                                                                                            <p style="font-size: 16px; font-family: 'Gotham Bold', Calibri, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #93583a; line-height: 1.2; line-height: 1.5em; padding: 1em !important;">
                                                                                                <?php echo get_the_title($product['supplier_id']); ?> </p>
                                                                                        </td>
                                                                                    <?php endif; ?>
                                                                                    <td align="center" data-title="Status" style="font-weight: bold;padding: 1em !important; border: none !important; border-collapse: collapse;">
                                                                                        <p style="font-size: 16px; font-family: 'Gotham Bold', Calibri, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #93583a; line-height: 1.2;">
                                                                                            <span><?php echo $product['ticket']; ?></span>
                                                                                        </p>

                                                                                    </td>
                                                                                    <td align="center" data-title="Total" style="font-weight: bold; padding: 1em !important; border: none !important; border-collapse: collapse;">
                                                                                        <p style="font-size: 16px; font-family: 'Gotham Bold', Calibri, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #93583a; line-height: 1.2;">
                                                                                            <span><?php echo $product['nf_number']; ?></span>
                                                                                        </p>

                                                                                    </td>
                                                                                    <td align="center" data-title="qtd" style="font-weight: bold; padding: 1em !important; border: none !important; border-collapse: collapse;">
                                                                                        <p style="font-size: 16px; font-family: 'Gotham Bold', Calibri, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #93583a; line-height: 1.2;">
                                                                                            <span><?php echo $product['qty_to_expire']; ?></span>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td align="center" data-title="qtd" style="font-weight: bold; padding: 1em !important; border: none !important; border-collapse: collapse;">
                                                                                        <p style="font-size: 16px; font-family: 'Gotham Bold', Calibri, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #93583a; line-height: 1.2;">
                                                                                            <span><?php echo $product['valid_date']; ?></span>
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php endforeach; ?>
                                                                        </tbody>

                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table border="0" cellpadding="0" cellspacing="0" class="html_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                                        <tr>
                                                            <td>
                                                                <div align="center" style="font-family:Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table border="0" cellpadding="0" cellspacing="0" class="html_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                                        <tr>
                                                            <td>
                                                                <div align="center" style="font-family:Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-4" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>
                                                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000;" width="500">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
                                                                                                    <table border="0" cellpadding="10" cellspacing="0" class="text_block" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td>
                                                                                                                    <div style="font-family: sans-serif">
                                                                                                                        <div style="font-size: 14px; mso-line-height-alt: 16.8px; color: #393d47; line-height: 1.2; font-family: Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                                                                                            <p style="margin: 0; font-size: 14px; text-align: center;">
                                                                                                                                <span style="color:#93583a;font-size:14px;"><a href="http://www.centraldacerveja.com.br" style="color:#93583a;"><strong>www.centraldacerveja.com.br</strong></a></span>
                                                                                                                            </p>
                                                                                                                            <p style="margin: 0; font-size: 14px; text-align: center;">
                                                                                                                                <span style="color:#696969;font-size:14px;">Contato:<strong>
                                                                                                                                        (41)
                                                                                                                                        3019-9194</strong>
                                                                                                                                    OU
                                                                                                                                    <strong>atendimento@centraldacerveja.com.br</strong></span>
                                                                                                                            </p>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table><!-- End -->
</body>

</html>