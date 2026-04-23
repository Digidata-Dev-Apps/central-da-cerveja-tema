/*****************************************
*   PROCEDURE: sp_filter_products_or_entity
*   DESCRIÇÃO: Busca produtos e fornecedores com base em um filtro de texto, otimizando a consulta para performance.
*   PARÂMETROS: 
*       p_filter - Filtro de texto para busca de produtos e fornecedores
*   RETORNO: Lista de produtos e fornecedores que correspondem ao filtro, incluindo detalhes como preço, imagem e informações do fornecedor.
*  
*   OBS: Substituir o prefixo 'qsar_' pelo prefixo de produção.
******************************************/


DELIMITER $$
CREATE PROCEDURE `sp_filter_products_or_entity`(IN `p_filter` VARCHAR(255))
BEGIN
    DECLARE v_like_filter VARCHAR(300);

    SET v_like_filter = CONCAT('%', p_filter, '%');

    /*
        =====================================================
        TEMP TABLE - FORNECEDORES
        =====================================================
    */
    CREATE TEMPORARY TABLE IF NOT EXISTS tmp_suppliers (
        supplier_id BIGINT PRIMARY KEY
    ) ENGINE=MEMORY;

    TRUNCATE TABLE tmp_suppliers;

    INSERT INTO tmp_suppliers (supplier_id)
    SELECT p.ID
    FROM qsar_posts p
    WHERE p.post_type = 'dwcc_supplier'
      AND p.post_title COLLATE utf8mb4_unicode_520_ci
          LIKE v_like_filter COLLATE utf8mb4_unicode_520_ci;


    /*
        =====================================================
        TEMP TABLE - PRODUTOS DOS FORNECEDORES
        =====================================================
    */
    CREATE TEMPORARY TABLE IF NOT EXISTS tmp_supplier_products (
        product_id BIGINT PRIMARY KEY
    ) ENGINE=MEMORY;

    TRUNCATE TABLE tmp_supplier_products;

    INSERT INTO tmp_supplier_products (product_id)
    SELECT DISTINCT cdc.id
    FROM qsar_cdc_products cdc
    INNER JOIN tmp_suppliers ts
        ON ts.supplier_id = cdc.supplier_id;


    /*
        =====================================================
        CONSULTA PRINCIPAL OTIMIZADA
        =====================================================
    */
    SELECT DISTINCT
        cdc.id AS ID,
        cdc.name AS post_title,
        cdc.slug AS post_name,

        sale.meta_value AS sale_price,
        regular.meta_value AS regular_price,

        cdc.image AS image,
        NULL AS kit_full_price,

        cdc.approved_date_product AS approved_date,

        supplier.post_title AS supplier_name,
        supplier_ipi.meta_value AS ipi

    FROM qsar_cdc_products cdc

    /*
        Compatibilidade com WordPress
    */
    INNER JOIN qsar_posts wp_post
        ON wp_post.ID = cdc.id
    
    /*
        Preços
    */
    LEFT JOIN qsar_postmeta sale
        ON sale.post_id = cdc.id AND sale.meta_key = '_sale_price'

    LEFT JOIN qsar_postmeta regular
        ON regular.post_id = cdc.id AND regular.meta_key = '_regular_price'
        

    /*
        Taxonomias
    */
    INNER JOIN qsar_term_relationships tr
        ON tr.object_id = cdc.id

    INNER JOIN qsar_term_taxonomy tt
        ON tt.term_taxonomy_id = tr.term_taxonomy_id

    INNER JOIN qsar_terms t
        ON t.term_id = tt.term_id

    /*
        Supplier
    */
    LEFT JOIN qsar_posts supplier
        ON supplier.ID = cdc.supplier_id

    LEFT JOIN qsar_postmeta supplier_ipi
        ON supplier_ipi.post_id = supplier.ID
        AND supplier_ipi.meta_key = '_ipi_tax'

    /*
        Produtos relacionados ao fornecedor filtrado
    */
    LEFT JOIN tmp_supplier_products tsp
        ON tsp.product_id = cdc.id

    WHERE
        wp_post.post_type = 'product'
        AND wp_post.post_status = 'publish'

        /*
            Produto ativo
        */
        AND (
            cdc.status IS NULL
            OR cdc.status != 'inactive'
        )

        /*
            Não comercializar kit
        */
        AND (
            cdc.commercialize_on_kit IS NULL
            OR cdc.commercialize_on_kit != '1'
        )

        /*
            Taxonomias válidas
        */
        AND tt.taxonomy IN (
            'pa_por-estilo',
            'pa_por-pais',
            'pa_por-estado',
            'pa_por-perfil',
            'pa_kit',
            'product_cat'
        )

        /*
            Busca principal
        */
        AND (
            cdc.name COLLATE utf8mb4_unicode_520_ci
                LIKE v_like_filter COLLATE utf8mb4_unicode_520_ci

            OR cdc.excerpt COLLATE utf8mb4_unicode_520_ci
                LIKE v_like_filter COLLATE utf8mb4_unicode_520_ci

            OR cdc.description COLLATE utf8mb4_unicode_520_ci
                LIKE v_like_filter COLLATE utf8mb4_unicode_520_ci

            OR cdc.style COLLATE utf8mb4_unicode_520_ci
                LIKE v_like_filter COLLATE utf8mb4_unicode_520_ci

            OR cdc.country COLLATE utf8mb4_unicode_520_ci
                LIKE v_like_filter COLLATE utf8mb4_unicode_520_ci

            OR cdc.state COLLATE utf8mb4_unicode_520_ci
                LIKE v_like_filter COLLATE utf8mb4_unicode_520_ci

            OR cdc.profile COLLATE utf8mb4_unicode_520_ci
                LIKE v_like_filter COLLATE utf8mb4_unicode_520_ci

            OR t.name COLLATE utf8mb4_unicode_520_ci
                LIKE v_like_filter COLLATE utf8mb4_unicode_520_ci

            OR tsp.product_id IS NOT NULL
        )

    LIMIT 10;


    /*
        =====================================================
        CLEANUP
        =====================================================
    */
    DROP TEMPORARY TABLE IF EXISTS tmp_suppliers;
    DROP TEMPORARY TABLE IF EXISTS tmp_supplier_products;
END$$
DELIMITER ;
