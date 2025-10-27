<?php

    $products = wc_get_products([
        'limit' => 10,
        'orderBy' => 'date',
        'order' => 'DESC'
    ]);

?>