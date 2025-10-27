<?php

get_header();

// Obtém o ID do autor atual
$author_id = get_queried_object_id();

// Obtém os dados do autor
$author_data = get_userdata($author_id);
$author_name = $author_data->display_name;
$author_bio = $author_data->_complete_description;
$author_avatar = get_avatar($author_id, 200, '', $author_name);
?>
<!-- begin: Title -->
<div class="background-heighlitghs">
    <div class="container">
        <div class="row">
            <div class="col pt-3 font-heighlitghs">
                <h4>Colunista - <?php echo $author_name; ?></h4>
            </div>
        </div>
    </div>
</div>
<!-- end: Title -->

<!-- begin: Content -->
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center">
            <div class="author-avatar">
                <?php echo $author_avatar; ?>
            </div>
            <h2 class="author-name my-4"><?php echo $author_name; ?></h2>
            <p class="author-bio text-justify"><?php echo $author_bio; ?></p>
        </div>
    </div>
    <div class="row">
    	<div class="col-12 justify-content-end">
    		<a href="javascript:history.back();" class="text-dark" style="font-size: 1.3rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                </svg>
                Voltar
            </a>
    	</div>
    </div>
</div>
<!-- end: Content -->
<?php
get_footer();
?>