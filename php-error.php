
<!-- Para utilização desta página é necessaria a criação ou atualizacao dentro de wp-content/php-error.php -->
<?php
http_response_code(500);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Erro no site</title>
    <style>
        body { background: #f5f5f5; font-family: sans-serif; text-align: center; padding: 100px; }
        h1 { color: #c00; }
    </style>
</head>
<body>
    <body style="background: #1b1c1a; margin-top: -2rem;" class="vh-100">
        <div class="container-fluid d-flex h-100">
            <div class="row d-flex align-items-center w-100">
                <div class="col-12 p-0 m-0">
                    <div class="d-flex align-items-center justify-content-center">
                        <img style="width: 750px;" class="central-logo img-fluid" src="<?php echo get_template_directory_uri()."/assets/img/af_marca_escuro.png"; ?>">
                    </div>

                    <div class="d-flex align-items-center justify-content-center">
                        <span style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; font-size: 20px; color: white;">Estamos em manutenção. Em breve voltaremos.</span>
                    </div>
                </div>
            </div>
        </div>
    </body>
</body>
</html>
