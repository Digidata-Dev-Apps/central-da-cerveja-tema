<!DOCTYPE html>
<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="en">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
    <style>
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

        @media (max-width:520px) {
            .row-content {
                width: 100% !important;
            }

            .stack .column {
                width: 100%;
                display: block;
            }
        }

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
    </style>
</head>

<body style="background-color: #FFFFFF; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
    <table class="nl-container" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #FFFFFF;">
        <tbody>
            <tr>
                <td>
                    <table class="row row-1" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                        <tbody>
                            <tr>
                                <td>
                                    <table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 500px;" width="500">
                                        <tbody>
                                            <tr>
                                                <td class="column" width="100%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                    <table class="image_block" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                        <tr>
                                                            <td style="width:100%;padding-right:0px;padding-left:0px;">
                                                                <div style="line-height:10px"><img src="<?php echo get_template_directory_uri() . "/assets/img/CentralDaCerveja-Logo.png"; ?>" style="display: block; height: auto; border: 0; width: 155px; max-width: 100%;" width="155"></div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table class="heading_block" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                        <tr>
                                                            <td style="width:100%;text-align:center;">
                                                                <h1 style="margin: 0; color: #93583a; font-size: 23px; font-family: 'Gotham Bold', sans-serif; line-height: 120%; text-align: left; direction: ltr; font-weight: normal; letter-spacing: normal; margin-top: 0; margin-bottom: 0;"><strong>E-mail recebido pelo Fale Conosco</strong></h1>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table class="text_block" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                        <tr>
                                                            <td>
                                                                <div style="font-family: sans-serif">
                                                                    <div style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #393d47; line-height: 1.2; font-family: Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                                        <p style="margin: 0; font-size: 12px;"><span style="font-size:14px;"><strong>Nome: </strong><?php echo $_POST['name']; ?></span></p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table class="text_block" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                        <tr>
                                                            <td>
                                                                <div style="font-family: sans-serif">
                                                                    <div style="font-size: 14px; mso-line-height-alt: 16.8px; color: #393d47; line-height: 1.2; font-family: Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                                        <p style="margin: 0; font-size: 14px;"><strong>Telefone:</strong> <?php echo $_POST['phone']; ?></p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table class="text_block" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                        <tr>
                                                            <td>
                                                                <div style="font-family: sans-serif">
                                                                    <div style="font-size: 14px; mso-line-height-alt: 16.8px; color: #393d47; line-height: 1.2; font-family: Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                                        <p style="margin: 0; font-size: 14px;"><strong>E-mail:</strong> <?php echo $_POST['email']; ?></p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    
                                                    <table class="text_block" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                        <tr>
                                                            <td>
                                                                <div style="font-family: sans-serif">
                                                                    <div style="font-size: 14px; mso-line-height-alt: 16.8px; color: #393d47; line-height: 1.2; font-family: 'Gotham Bold', sans-serif;">
                                                                        <p style="margin: 0; font-size: 14px;"><strong>Mensagem:&nbsp;</strong></p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table class="text_block" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                        <tr>
                                                            <td>
                                                                <div style="font-family: sans-serif">
                                                                    <div style="font-size: 14px; mso-line-height-alt: 16.8px; color: #393d47; line-height: 1.2; font-family: Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                                        <p style="margin: 0; font-size: 14px;"><?php echo $_POST['message'] ?></p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <?php if (!empty($_POST['logged_user'])) : ?>
                                                        <table class="text_block" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                            <tr>
                                                                <td>
                                                                    <div style="font-family: sans-serif">
                                                                        <div style="font-size: 14px; mso-line-height-alt: 16.8px; color: #393d47; line-height: 1.2; font-family: Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                                            <p style="margin: 0; font-size: 14px;"><strong>Link do perfil:</strong> <a target="_blank" href="<?php echo home_url(); ?>/wp-admin/user-edit.php?user_id=<?php echo $_POST['logged_user']; ?>">Ver</a></p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    <?php endif; ?>
                                                    <table class="html_block" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                        <tr>
                                                            <td>
                                                                <div style="font-family:'Gotham Bold' sans-serif;text-align:center;" align="center">
                                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-4" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>
                                                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000;" width="500">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
                                                                                                    <table border="0" cellpadding="10" cellspacing="0" class="text_block" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <div style="font-family: 'Gotham bold', Calibri;">
                                                                                                                    <div style="font-size: 14px; mso-line-height-alt: 16.8px; color: #393d47; line-height: 1.2; font-family: 'Gotham bold', Calibri;">
                                                                                                                        <p style="margin: 0; font-size: 14px; text-align: center;"><span style="color:#93583a;font-size:14px;"><a href="http://www.centraldacerveja.com.br" style="color:#93583a;"><strong>www.centraldacerveja.com.br</strong></a></span></p>
                                                                                                                        <p style="margin: 0; font-size: 14px; text-align: center;"><span style="color:#696969;font-size:14px;">Contato:<strong> (41) 3019-9194</strong> OU <strong>atendimento@centraldacerveja.com.br</strong></span></p>
                                                                                                                    </div>
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