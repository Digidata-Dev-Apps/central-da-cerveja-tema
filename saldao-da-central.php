<?php
/*
 Template Name: Saldão da Central
 */
?>

<?php
get_header();
?>

<div class="background-heighlitghs">
    <div class="container">
        <div class="row">
            <div class="col pt-3 font-heighlitghs">
                <h4>Saldão da Central</h4>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 py-4 text-center">
        	<?php 
        	if(wp_is_mobile()){
        	    ?>
        	    <img src="<?php echo get_template_directory_uri() . "/assets/img/banner_saldao_da_central_mobile.jpg" ?>" alt="Saldão da Central" class="img-fluid">
        	    <?php 
        	}else{
        	    ?>
        	    <img src="<?php echo get_template_directory_uri() . "/assets/img/banner_saldao_da_central.jpg" ?>" alt="Saldão da Central" class="img-fluid">
        	    <?php 
        	}
        	?>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <div class="countdown-wrapper">
                <h1 class="text-white">AS OFERTAS SERÃO LIBERADAS EM:</h1>
                <div id="timer" class="countdown"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function countdown_time() {
        // Define a data e hora final
        let future = Date.parse("jul 8, 2022 00:00:00");
        // Armazena a data e hora atual
        let now = new Date();
        // Busca a data e hora restante até a data final
        let diff = future - now;

        // calcula o número de dias restantes
        let days = Math.floor(diff / (1000 * 60 * 60 * 24));
        // calcula o número de horas restantes
        let hours = Math.floor(diff / (1000 * 60 * 60));
        // calcula o número de minutos restantes
        let mins = Math.floor(diff / (1000 * 60));
        // calcula o número de segundos restantes
        let secs = Math.floor(diff / 1000);

        //
        let d = days;
        let h = hours - days * 24;
        let m = mins - hours * 60;
        let s = secs - mins * 60;

        // Adiciona o 0 a frente
        d = (d < 10) ? "0" + d : d;
        h = (h < 10) ? "0" + h : h;
        m = (m < 10) ? "0" + m : m;
        s = (s < 10) ? "0" + s : s;

        jQuery("#timer").html(`
            <div>${d}<span>Dias</span></div><div>${h}<span>Horas</span></div><div>${m}<span>Minutos</span></div><div>${s}<span>Segundos</span></div>`);
    }
    // Inicia o contador
    countdown_time();

    // Atualiza o contador
    setInterval('countdown_time()', 1000);
</script>

<?php
get_footer();
?>