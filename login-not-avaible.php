<?php
/*
Template Name: Login não permitido
*/
?>
<style>
    @import url('<?php echo get_template_directory_uri() ?>/assets/css/gotham.css');
    body, html {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    body {
        background: #f0f0f1;
        min-width: 0;
        color: #3c434a;
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
        font-size: 13px;
        line-height: 1.4;
    }
    .login-action-login {
        background-color: #1b1c1a;
        margin: auto;
    }

    #login h1 a, .login h1 a {
        background-image: url(http://centraldacerveja.local/wp-content/themes/central-da-cerveja/assets/img/af_marca_escuro.png);
        width: 320px;
        min-height: 208px;
        background-size: 380px;
        background-repeat: no-repeat;
        padding-bottom: 30px;
    }
    #login img {
        width: 979px;
    }

    #login div {
        text-align: center;
        color: white;
    }
    #login div h1 {
        font-size: 2rem;
        font-family: 'Gotham bold';
    }
    #login div h2 {
        font-size: 1.7rem;
        font-family: 'Gotham bold';
    }
</style>
<body class="login-action-login">
    <div id="login">
        <a href="/"><img src="<?php echo get_template_directory_uri() . "/assets/img/af_marca_escuro.png" ?>" alt=""></a>
        <div>
            <h1>A área administrativa não pode ser acessada por ambiente mobile.</h1>
            <h2>Utilize o navegador em ambiente desktop.</h2>
        </div>
        
        <!-- <h1><a href="http://centraldacerveja.local">Powered by WordPress</a></h1>
        <p id="backtoblog">
            <a href="http://centraldacerveja.local/">← Ir para Central da Cerveja</a>
        </p> -->
        <!-- <div class="privacy-policy-page-link"><a class="privacy-policy-link" href="http://centraldacerveja.local/politica-de-privacidade/">Política de privacidade</a></div> -->
    </div>
</body>
