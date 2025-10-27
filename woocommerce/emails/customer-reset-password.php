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
                                                            <div style="line-height:10px"><img src="<?php echo get_template_directory_uri() . "/assets/img/CentralDaCerveja-Logo.png"; ?>" style="display: block; height: auto; border: 0; width: 100px; max-width: 100%;" width="100" /></div>
															</td>
														</tr>
													</table>
													<table class="heading_block" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
														<tr>
															<td style="width:100%;text-align:center;padding-top:30px;">
																<h1 style="margin: 0; color: #93583a; font-size: 23px; font-family: 'Gotham Bold', Calibri, sans-serif; line-height: 120%; text-align: left; direction: ltr; font-weight: normal; letter-spacing: normal; margin-top: 0; margin-bottom: 0;">Redefinição de senha</h1>
															</td>
														</tr>
													</table>
													<table class="text_block" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
														<tr>
															<td style="padding-top:40px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
																<div style="font-family: 'Gotham Bold', Calibri, sans-serif">
																	<div style="font-size: 16px; mso-line-height-alt: 16.8px; color: #93583a; line-height: 1.2; font-family: 'Gotham Bold', Calibri, sans-serif;">
																		<p style="margin: 0; color: #696969; font-size: 16px;">Olá <?php $user_login ?>,<br><br>Você solicitou a redefinição de senha da sua conta.</p>
																		<p style="margin: 0; font-size: 16px; mso-line-height-alt: 16.8px;">&nbsp;</p>
																		<p style="margin: 0; font-size: 16px;">
                                                                            <a style="color:#93583a;font-size:16px;" href="<?php echo esc_url( add_query_arg( array( 'key' => $reset_key, 'id' => $user_id ), wc_get_endpoint_url( 'lost-password', '', wc_get_page_permalink( 'myaccount' ) ) ) ); ?>"><?php // phpcs:ignore ?>
                                                                                <?php esc_html_e( 'Clique aqui para redefinir a sua senha.', 'woocommerce' ); ?>
                                                                            </a><br><br>Se você não fez essa solicitação, ignore este e-mail.</p>
																	</div>
																</div>
															</td>
														</tr>
													</table>
													<table class="html_block" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
														<tr>
															<td>
																<div style="font-family:'Gotham Bold', Calibri, sans-serif;" align="center"><table border="0" cellpadding="10" cellspacing="0" class="divider_block" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                                        <tr>
                                                            <td>
                                                                <div>
                                                                    <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                                                        <tr>
                                                                            <td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #BBBBBB;">
                                                                                <span> </span></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table border="0" cellpadding="0" cellspacing="0" class="html_block" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                                        <tr>
                                                            <td>
                                                                <div style="font-family:'Gotham Bold', Calibri, sans-serif;">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table border="0" cellpadding="0" cellspacing="0" class="html_block" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                                        <tr>
                                                            <td>
                                                                <div style="font-family:'Gotham Bold', Calibri, sans-serif;">
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
                                                                                                                    <div style="font-family: 'Gotham Bold', Calibri, sans-serif">
                                                                                                                        <div style="font-size: 14px; mso-line-height-alt: 16.8px; color: #393d47; line-height: 1.2; font-family: 'Gotham Bold', Calibri, sans-serif;">
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
                                                    </table></div>
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