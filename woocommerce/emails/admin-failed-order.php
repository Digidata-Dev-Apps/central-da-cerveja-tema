<?php
/**
 * Admin failed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/admin-failed-order.php
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */
?>

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
    <table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #FFFFFF;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-1"
                        role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <table align="center" border="0" cellpadding="0" cellspacing="0"
                                        class="row-content stack" role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 765px;"
                                        width="765">
                                        <tbody>
                                            <tr>
                                                <td class="column"
                                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                                    width="100%">
                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                        class="image_block" role="presentation"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                        width="100%">
                                                        <tr>
                                                            <td style="width:100%;padding-right:0px;padding-left:0px;">
                                                                <div style="line-height:10px"><img src="<?php echo get_template_directory_uri() . "/assets/img/CentralDaCerveja-Logo.png"; ?>" style="display: block; height: auto; border: 0; width: 100px; max-width: 100%;" width="100" /></div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table border="0" cellpadding="0" cellspacing="0" class="text_block"
                                                        role="presentation"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                                        width="100%">
                                                        <tr>
                                                            <td
                                                                style="padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:50px;">
                                                                <div style="font-family: Tahoma, Verdana, sans-serif">
                                                                    <div
                                                                        style="font-size: 16px; font-family: 'Gotham Bold', Calibri, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #93583a; line-height: 1.2;">
                                                                        <p
                                                                            style="margin: 0; font-size: 16px; letter-spacing: 5px;">
                                                                            <span style="font-size:20px;">Pedido Malsucedido</span></p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>



                                                    <table border="0" cellpadding="0" cellspacing="0" class="html_block"
                                                        role="presentation"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                        width="100%">
                                                        <tr>
                                                            <td style="padding-top:35px;">
                                                                <div align="center"
                                                                    style=" font-family: 'Gotham Bold', Calibri, sans-serif;">
                                                                    <table border="0" cellpadding="10" cellspacing="0"
                                                                        style="border: 1px solid rgba(0,0,0,.1); margin: 0 -1px 24px 0; text-align: left; width: 100%; border-collapse: separate; border-radius: 5px; border: 1px solid rgba(0, 0, 0, 0.1); margin: 0 -1px 24px 0; text-align: left; width: 100%; border-collapse: collapse; border-radius: 5px;">
                                                                        <thead>
                                                                            <tr
                                                                                style="background: #93583a; border: none !important; border-collapse: collapse; font-size: 16px;">
                                                                                <th align="center">
                                                                                    <div style="color: #fff; font-family: 'Gotham Bold', Calibri, sans-serif;">Cervejaria
                                                                                    </div>
                                                                                </th>
                                                                                <th align="center">
                                                                                    <div style="color: #fff; font-family: 'Gotham Bold', Calibri, sans-serif;">Pedido
                                                                                    </div>
                                                                                </th>
                                                                                <th align="center">
                                                                                    <div style="color: #fff; font-family: 'Gotham Bold', Calibri, sans-serif;">Valor
                                                                                    </div>
                                                                                </th>
                                                                                <th align="center">
                                                                                    <div style="color: #fff; font-family: 'Gotham Bold', Calibri, sans-serif;">Qtd.
                                                                                    </div>
                                                                                </th>
                                                                                <th align="center">
                                                                                    <div style="color: #fff; font-family: 'Gotham Bold', Calibri, sans-serif;">Data de Validade
                                                                                    </div>
                                                                                </th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody
                                                                            style="border-color: inherit; border-style: solid; border-width: 0;">

                                                                            <?php foreach($order->get_items() as $item_id => $items): 
                                                                                $product = $items->get_product()?>
                                                                            <tr style="font-size: 16px; font-family: Calibri, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #93583a; line-height: 1.2;">
                                                                                <td align="center" data-title="Pedido"
                                                                                        style="font-weight: bold; padding: 1em !important; font-family: 'Gotham Bold';  border: none !important; border-collapse: collapse;">
                                                                                        <p 
                                                                                            style="font-size: 16px; font-family: 'Gotham Bold', Calibri, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #93583a; line-height: 1.2; line-height: 1.5em; padding: 1em !important;">
                                                                                            <?php  echo get_post( get_post_meta( $product->get_id(), '_supplier_id', true) )->post_title ?> </p>
                                                                                </td>
                                                                                <td align="center" data-title="Pedido"
                                                                                    style="font-weight: bold; padding: 1em !important; font-family: 'Gotham Bold';  border: none !important; border-collapse: collapse;">
                                                                                    <p 
                                                                                        style="font-size: 16px; font-family: 'Gotham Bold', Calibri, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #93583a; line-height: 1.2; line-height: 1.5em; padding: 1em !important;">
                                                                                        <?php  echo $items['name'] ?> </p>
                                                                                </td>
                                                                                <td align="center" data-title="Total"
                                                                                    style="font-weight: bold; padding: 1em !important; border: none !important; border-collapse: collapse;">
                                                                                    <p style="font-size: 16px; font-family: 'Gotham Bold', Calibri, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #93583a; line-height: 1.2;">
                                                                                        <span><?php echo wc_price( $product->get_price()) ?></span>
                                                                                    </p>
                                                                                   
                                                                                </td>
                                                                                <td align="center" data-title="qtd"
                                                                                    style="font-weight: bold; padding: 1em !important; border: none !important; border-collapse: collapse;">
                                                                                    <p style="font-size: 16px; font-family: 'Gotham Bold', Calibri, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #93583a; line-height: 1.2;">
                                                                                        <span><?php echo $order->get_item_meta($item_id, '_qty', true); ?></span>
                                                                                    </p>
                                                                                </td>
                                                                                <td align="center" data-title="qtd" style="font-weight: bold; padding: 1em !important; border: none !important; border-collapse: collapse;">
                                                                                    <p style="font-size: 16px; font-family: 'Gotham Bold', Calibri, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #93583a; line-height: 1.2;">
                                                                                        <span><?php do_action('valid_date_cart_action', $product->get_id()); ?></span>
                                                                                    </p>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                        <thead>
                                                                            <tr
                                                                                style="background: #93583a; border: none !important; border-collapse: collapse; font-size: 16px;">
                                                                                <th align="center">
                                                                                    <div
                                                                                        style="color: #fff; font-family: 'Gotham Bold', Calibri, sans-serif !important;">
                                                                                        Número do Pedido
                                                                                    </div>
                                                                                </th>
                                                                                <th align="center">
                                                                                    <div
                                                                                        style="color: #fff; font-family: 'Gotham Bold', Calibri, sans-serif !important;">
                                                                                        Status
                                                                                    </div>
                                                                                </th>
                                                                                <th align="center" colspan="2">
                                                                                    <div
                                                                                        style="color: #fff; font-family: 'Gotham Bold', Calibri, sans-serif !important;">
                                                                                        Total
                                                                                    </div>
                                                                                </th>
                                                                                <th align="center">
                                                                                    <div
                                                                                        style="color: #fff; font-family: 'Gotham Bold', Calibri, sans-serif !important;">
                                                                                        Qtd.
                                                                                    </div>
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tfoot
                                                                            style="border-color: inherit; border-style: solid; border-width: 0;">

                                                                            <tr style="font-size: 16px; font-family: Calibri, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #93583a; line-height: 1.2;">
                                                                                <td align="center" data-title="Pedido"
                                                                                    style="font-weight: bold; padding: 1em !important; font-family: 'Gotham Bold', Calibri, sans-serif;  border: none !important; border-collapse: collapse;">
                                                                                    <p 
                                                                                        style="font-size: 16px; font-family: 'Gotham Bold', Calibri, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #93583a; line-height: 1.2; line-height: 1.5em; padding: 1em !important;">
                                                                                        # <?php echo $order->ID ?> </p>
                                                                                </td>
                                                                                <td align="center" data-title="Status"
                                                                                    style="font-weight: bold;padding: 1em !important; border: none !important; border-collapse: collapse;">
                                                                                    <p style="font-size: 16px; font-family: 'Gotham Bold', Calibri, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #93583a; line-height: 1.2;"><?php echo wc_get_order_status_name( $order->get_status()) ?></p>
                                                                                  
                                                                                </td>
                                                                                <td align="center" data-title="Total"
                                                                                    style="font-weight: bold; padding: 1em !important; border: none !important; border-collapse: collapse;" colspan="2">
                                                                                    <p style="font-size: 16px; font-family: 'Gotham Bold', Calibri, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #93583a; line-height: 1.2;">
                                                                                    <span><br>SubTotal: <?php echo wc_price($order->get_subtotal()) ?></span>
                                                                                        <?php if($order->get_discount_total()): ?>
                                                                                            <br><span>Desconto: <?php echo wc_price($order->get_discount_total());  ?>
                                                                                        <?php endif; ?>
                                                                                        <br><span>Frete: <?php echo ($order->get_total_shipping() > 0) ? wc_price($order->get_total_shipping()) : '<font color="#FF0000">Frete Grátis</font>' ?></span>
                                                                                        <br><span>Total: <?php echo wc_price( $order->get_total());  ?> </p></span>
                                                                                    </p>
                                                                                   
                                                                                </td>
                                                                                <td align="center" data-title="qtd"
                                                                                    style="font-weight: bold; padding: 1em !important; border: none !important; border-collapse: collapse;">
                                                                                    <p style="font-size: 16px; font-family: 'Gotham Bold', Calibri, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #93583a; line-height: 1.2;">
                                                                                        <span><?php echo $order->get_item_count();  ?> </p></span><br>
                                                                                        
                                                                                    </p>
                                                                                </td>
                                                                            </tr>

                                                                        </tfoot>
                                                                        </tbody>

                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    
                                                    
                                                    
                                                    <table id="addresses" cellspacing="0" cellpadding="0" border="0"
                                                        style="box-sizing: border-box; width: 100%; vertical-align: top; margin-bottom: 40px; padding: 0;">
                                                        <tbody>
                                                            <tr style="box-sizing: border-box;">
                                                                <td valign="top" width="50%"
                                                                    style="box-sizing: border-box; text-align: left; font-family: 'Gotham Bold', Calibri, sans-serif !important; border: 0; padding: 0;">
                                                                    <h2
                                                                        style="box-sizing: border-box;  color: #93583a; display: block; font-family: 'Gotham Bold', Calibri, sans-serif !important; font-size: 18px; font-weight: bold; line-height: 130%; margin: 0 0 18px; text-align: left;">
                                                                        Endereço de faturamento</h2>

                                                                    <address class="address"
                                                                        style="box-sizing: border-box; padding: 12px; color: #636363; border: 1px solid #e5e5e5; font-size: 16px;">
                                                                        <?php echo $order->get_billing_first_name() . " " . $order->get_billing_last_name() ?><br
                                                                            style="box-sizing: border-box;"><br
                                                                            style="box-sizing: border-box;"><br
                                                                            style="box-sizing: border-box;"><?php echo $order->get_billing_city() ?>, <?php  echo $order->get_billing_state() ?>, <?php echo $order->get_billing_address_1(); ?>, <?php echo $order->get_meta('_billing_number', true ); ?><?php echo  !empty($order->get_billing_address_2()) ?", ".$order->get_billing_address_2() : "" ?><br
                                                                            style="box-sizing: border-box;"><?php  echo $order->get_billing_postcode() ?>
                                                                        <br style="box-sizing: border-box;"><?php echo  $order->get_billing_email() ?>
                                                                        <br style="box-sizing: border-box;"><?php echo  $order->get_billing_phone() ?>
                                                                    </address>
                                                                </td>
                                                                <td valign="top" width="50%"
                                                                    style="box-sizing: border-box; text-align: left; font-family: 'Gotham Bold', Calibri, sans-serif !important; padding: 0;">
                                                                    <h2
                                                                        style="box-sizing: border-box;  color: #93583a; display: block; font-family: 'Gotham Bold', Calibri, sans-serif !important; font-size: 18px; font-weight: bold; line-height: 130%; margin: 0 0 18px; text-align: left;">
                                                                        Endereço de entrega</h2>

                                                                        <address class="address"
                                                                        style="box-sizing: border-box; padding: 12px; color: #636363; border: 1px solid #e5e5e5; font-size: 16px;">
                                                                            <?php echo $order->get_shipping_first_name() . " " . $order->get_shipping_last_name() ?><br
                                                                            style="box-sizing: border-box;"><br
                                                                            style="box-sizing: border-box;"><br
                                                                            style="box-sizing: border-box;"><?php echo $order->get_shipping_city() ?>, <?php  echo $order->get_shipping_state() ?>, <?php echo $order->get_shipping_address_1(); ?>, <?php echo $order->get_meta('_shipping_number', true ); ?><?php echo  !empty($order->get_shipping_address_2()) ?", ".$order->get_shipping_address_2() : "" ?><br
                                                                            style="box-sizing: border-box;"><?php echo $order->get_shipping_postcode() ?>
                                                                            <br style="box-sizing: border-box;"><?php echo  $order->get_billing_email() ?>
                                                                    </address>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    
                                                    <table border="0" cellpadding="10" cellspacing="0"
                                                        class="divider_block" role="presentation"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                        width="100%">
                                                        <tr>
                                                            <td>
                                                                <div align="center">
                                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                                        role="presentation"
                                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                                        width="100%">
                                                                        <tr>
                                                                            <td class="divider_inner"
                                                                                style="font-size: 1px; line-height: 1px; border-top: 1px solid #BBBBBB;">
                                                                                <span> </span></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table border="0" cellpadding="0" cellspacing="0" class="html_block"
                                                        role="presentation"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                        width="100%">
                                                        <tr>
                                                            <td>
                                                                <div align="center"
                                                                    style="font-family:Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table border="0" cellpadding="0" cellspacing="0" class="html_block"
                                                        role="presentation"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                        width="100%">
                                                        <tr>
                                                            <td>
                                                                <div align="center"
                                                                    style="font-family:Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                                    <table align="center" border="0" cellpadding="0"
                                                                        cellspacing="0" class="row row-4"
                                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                                        width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>
                                                                                    <table align="center" border="0"
                                                                                        cellpadding="0" cellspacing="0"
                                                                                        class="row-content stack"
                                                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000;"
                                                                                        width="500">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td class="column"
                                                                                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                                                                                    width="100%">
                                                                                                    <table border="0"
                                                                                                        cellpadding="10"
                                                                                                        cellspacing="0"
                                                                                                        class="text_block"
                                                                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                                                                                        width="100%">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td>
                                                                                                                    <div
                                                                                                                        style="font-family: sans-serif">
                                                                                                                        <div
                                                                                                                            style="font-size: 14px; mso-line-height-alt: 16.8px; color: #393d47; line-height: 1.2; font-family: Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                                                                                            <p
                                                                                                                                style="margin: 0; font-size: 14px; text-align: center;">
                                                                                                                                <span
                                                                                                                                    style="color:#93583a;font-size:14px;"><a
                                                                                                                                        href="http://www.centraldacerveja.com.br"
                                                                                                                                        style="color:#93583a;"><strong>www.centraldacerveja.com.br</strong></a></span>
                                                                                                                            </p>
                                                                                                                            <p
                                                                                                                                style="margin: 0; font-size: 14px; text-align: center;">
                                                                                                                                <span
                                                                                                                                    style="color:#696969;font-size:14px;">Contato:<strong>
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