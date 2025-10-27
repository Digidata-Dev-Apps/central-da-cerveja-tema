/*********************************************
    TABELA RESPONSAVEL POR ARMAZENAR OS PRODUTOS

    ATENÇÃO:

    Substituir o alias das tabelas antes de rodar o comando

**********************************************/

DROP TABLE IF EXISTS `homolog_cdc_products`;
CREATE TABLE IF NOT EXISTS `homolog_cdc_products`(
	`id` BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `supplier_id` BIGINT NULL,
    `name` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `sku` VARCHAR(255) NULL,
    `excerpt` TEXT NULL,
    `description` TEXT NULL,
    `alcoholic_dosage` VARCHAR(255) NULL,
    `volume` VARCHAR(255) NULL,
    `transport_type` TINYINT NULL DEFAULT 1,
    `pasteurized` TINYINT NULL DEFAULT 1,
    `package` TINYINT NULL DEFAULT 1,
    `ibu` VARCHAR(255) NULL,
    `ideal_temperature` VARCHAR(255) NULL,
    `between` VARCHAR(255) NULL,
    `harmonizing_suggestion` VARCHAR(255) NULL,
    `bar_code` VARCHAR(255) NULL,
    `quantity_box` TINYINT NULL DEFAULT 0,
    `dheight` VARCHAR(255) NULL,
    `diameter` VARCHAR(255) NULL,
    `sold_type` TINYINT NULL DEFAULT 2,
    `commercialize_on_kit` VARCHAR(255) NULL,
    `approved_date_product` DATETIME NULL,
    `weight` DECIMAL(10,3) NULL DEFAULT 0,
    `length` DECIMAL(10,3) NULL DEFAULT 0,
    `width` DECIMAL(10,3) NULL DEFAULT 0,
    `height` DECIMAL(10,3) NULL DEFAULT 0,
    `thumbnail_id` BIGINT NULL,
    `image` VARCHAR(255) DEFAULT 'woocommerce-placeholder.png',
    `marketed_by` TINYINT NULL DEFAULT 1,
    `style` VARCHAR(255) NULL,
    `country` VARCHAR(255) NULL,
    `state` VARCHAR(255) NULL,
    `type` VARCHAR(255) NULL,
    `profile` VARCHAR(255) NULL,
    `status` VARCHAR(255) NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME
);

INSERT INTO homolog_cdc_products (
	`id`,`name`, `slug`, `excerpt`, `description`, `status`, `created_at`,`updated_at`, `sku`, `alcoholic_dosage`, `volume`,`supplier_id`, `thumbnail_id`, `type`, 
    `style`, `country`, `state`, `profile`, `transport_type`, `pasteurized`, `package`, `ibu`, `ideal_temperature`, `between`, 
    `harmonizing_suggestion`, `bar_code`, `quantity_box`, `dheight`, `diameter`, `sold_type`, `commercialize_on_kit`, 
    `approved_date_product`, `weight`, `length`, `width`, `height`, `marketed_by`, `image`
)
SELECT `products`.*, `postmeta`.`meta_value` AS `image_path` FROM (
	SELECT
		`p`.`id`, `p`.`name`, `p`.`slug`, `p`.`excerpt`,`p`.`description`, `p`.`status`, `p`.`created_at`, `p`.`updated_at`,
		MAX(CASE WHEN `pm`.`meta_key` = '_sku' THEN `pm`.`meta_value` END) AS `sku`,
		MAX(CASE WHEN `pm`.`meta_key` = '_alcoholic_dosage' THEN `pm`.`meta_value` END) AS `alcoholic_dosage`,
		MAX(CASE WHEN `pm`.`meta_key` = '_volume' THEN `pm`.`meta_value` END) AS `volume`,
		MAX(CASE WHEN `pm`.`meta_key` = '_supplier_id' THEN `pm`.`meta_value` END) AS `supplier_id`,
		MAX(CASE WHEN `pm`.`meta_key` = '_thumbnail_id' THEN `pm`.`meta_value` END) AS `thumbnail_id`,
		MAX(CASE WHEN `tt`.`taxonomy` = 'product_type' THEN `t`.`name` END) AS `product_type`,
		MAX(CASE WHEN `tt`.`taxonomy` = 'pa_por-estilo' THEN `t`.`name` END) AS `style`,
		MAX(CASE WHEN `tt`.`taxonomy` = 'pa_por-pais' THEN `t`.`name` END) AS `country`,
		MAX(CASE WHEN `tt`.`taxonomy` = 'pa_por-estado' THEN `t`.`name` END) AS `state`,
		GROUP_CONCAT(DISTINCT CASE WHEN `tt`.`taxonomy` = 'pa_por-perfil' THEN `t`.`name` END) AS `profile`,
		MAX(CASE WHEN `pm`.`meta_key` = '_transport_type' THEN `pm`.`meta_value` END) AS `transport_type`,
		MAX(CASE WHEN `pm`.`meta_key` = '_pasteurized' THEN `pm`.`meta_value` END) AS `pasteurized`,
		MAX(CASE WHEN `pm`.`meta_key` = '_package' THEN `pm`.`meta_value` END) AS `package`,
		MAX(CASE WHEN `pm`.`meta_key` = '_ibu' THEN `pm`.`meta_value` END) AS `ibu`,
		MAX(CASE WHEN `pm`.`meta_key` = '_ideal_temperature' THEN `pm`.`meta_value` END) AS `ideal_temperature`,
		MAX(CASE WHEN `pm`.`meta_key` = '_between' THEN `pm`.`meta_value` END) AS `between`,
		MAX(CASE WHEN `pm`.`meta_key` = '_harmonizing_suggestion' THEN `pm`.`meta_value` END) AS `harmonizing_suggestion`,
		MAX(CASE WHEN `pm`.`meta_key` = '_bar_code' THEN `pm`.`meta_value` END) AS `bar_code`,
		MAX(CASE WHEN `pm`.`meta_key` = '_quantity_box' THEN `pm`.`meta_value` END) AS `quantity_box`,
		MAX(CASE WHEN `pm`.`meta_key` = '_dheight' THEN `pm`.`meta_value` END) AS `dheight`,
		MAX(CASE WHEN `pm`.`meta_key` = '_diameter' THEN `pm`.`meta_value` END) AS `diameter`,
		MAX(CASE WHEN `pm`.`meta_key` = '_sold_type' THEN `pm`.`meta_value` END) AS `sold_type`,
		MAX(CASE WHEN `pm`.`meta_key` = '_commercialize_on_kit' THEN `pm`.`meta_value` END) AS `commercialize_on_kit`,
		MAX(CASE WHEN `pm`.`meta_key` = '_approved_date_product' THEN `pm`.`meta_value` END) AS `approved_date_product`,
		MAX(CASE WHEN `pm`.`meta_key` = '_weight' THEN `pm`.`meta_value` END) AS `weight`,
		MAX(CASE WHEN `pm`.`meta_key` = '_length' THEN `pm`.`meta_value` END) AS `length`,
		MAX(CASE WHEN `pm`.`meta_key` = '_width' THEN `pm`.`meta_value` END) AS `width`,
		MAX(CASE WHEN `pm`.`meta_key` = '_height' THEN `pm`.`meta_value` END) AS `height`,
		MAX(CASE WHEN `pm`.`meta_key` = '_marketed_by' THEN `pm`.`meta_value` END) AS `marketed_by`
	FROM
		(SELECT DISTINCT
			`p`.`ID` AS `id`,
			`p`.`post_title` AS `name`,
			`p`.`post_name` AS `slug`,
			`p`.`post_content` AS `description`,
			`p`.`post_excerpt` AS `excerpt`,
            `p`.`post_status` AS `status`,
            `p`.`post_date` AS `created_at`,
            `p`.`post_modified` AS `updated_at`
		FROM
			`homolog_posts` AS `p`
		LEFT JOIN `homolog_postmeta` AS `pm` ON (`p`.`ID` = `pm`.`post_id`)
		LEFT JOIN `homolog_postmeta` AS `pm1` ON (`p`.`ID` = `pm1`.`post_id` AND `pm1`.`meta_key` = '_supplier_certificate_expired')
		LEFT JOIN `homolog_postmeta` AS `pm2` ON (`p`.`ID` = `pm2`.`post_id`)
		WHERE
			(`p`.`ID` NOT IN (SELECT `object_id` FROM `homolog_term_relationships` WHERE `term_taxonomy_id` IN (356))) AND
			(`pm`.`meta_key` = '_stock_status' AND `pm`.`meta_value` = 'instock') AND
			(`pm1`.`post_id` IS NULL OR (`pm2`.`meta_key` = '_supplier_certificate_expired' AND `pm2`.`meta_value` != '1')) AND
			`p`.`post_type` = 'product' AND (`p`.`post_status` = 'publish')
		GROUP BY `p`.`ID`) AS `p`
	LEFT JOIN `homolog_postmeta` AS `pm` ON (`p`.`id` = `pm`.`post_id`)
	LEFT JOIN `homolog_term_relationships` AS `tr` ON (`p`.`id` = `tr`.`object_id`)
	LEFT JOIN `homolog_term_taxonomy` AS `tt` ON (`tr`.`term_taxonomy_id` = `tt`.`term_taxonomy_id`)
	LEFT JOIN `homolog_terms` AS `t` ON (`tt`.`term_id` = `t`.`term_id`)
	GROUP BY `id`) AS `products` 
LEFT JOIN `homolog_postmeta` AS `postmeta` ON (`products`.`thumbnail_id` = `postmeta`.`post_id` AND `postmeta`.`meta_key` = '_wp_attached_file')
ON DUPLICATE KEY UPDATE
    `name` = `products`.`name`,
    `slug` = `products`.`slug`,
    `excerpt` = `products`.`excerpt`,
    `description` =`products`.`description`,
    `sku` =`products`.`sku`,
    `alcoholic_dosage` =`products`.`alcoholic_dosage`,
    `volume` =`products`.`volume`,
    `supplier_id` =`products`.`supplier_id`,
    `thumbnail_id` =`products`.`thumbnail_id`,
    `type` =`products`.`product_type`,
    `style` =`products`.`style`,
    `country` =`products`.`country`,
    `state` =`products`.`state`,
    `profile` =`products`.`profile`,
    `transport_type` =`products`.`transport_type`,
    `pasteurized` =`products`.`pasteurized`,
    `package` =`products`.`package`,
    `ibu` =`products`.`ibu`,
    `ideal_temperature` =`products`.`ideal_temperature`,
    `between` =`products`.`between`,
    `harmonizing_suggestion` =`products`.`harmonizing_suggestion`,
    `bar_code` =`products`.`bar_code`,
    `quantity_box` =`products`.`quantity_box`,
    `dheight` =`products`.`dheight`,
    `diameter` =`products`.`diameter`,
    `sold_type` = `products`.`sold_type`,
    `commercialize_on_kit` = `products`.`commercialize_on_kit`,
    `approved_date_product` = `products`.`approved_date_product`,
    `weight` = `products`.`weight`,
    `length` = `products`.`length`,
    `width` = `products`.`width`,
    `height` = `products`.`height`,
    `marketed_by` = `products`.`marketed_by`,
    `status`	= `products`.`status`,
    `created_at` = `products`.`created_at`,
    `updated_at` = `products`.`updated_at`,
    `image` = `postmeta`.`meta_value`;




-- Procedure responsável por armazenar e atualizar os produtos em uma tabela isolada

DROP PROCEDURE IF EXISTS InsertOrUpdateProduct;

DELIMITER //

CREATE PROCEDURE InsertOrUpdateProduct(IN product_id INT, IN prefix VARCHAR(255))
BEGIN
SET @product_id = product_id;

-- TABELAS A SEREM UTILIZADAS
SET @table_cdc_products = CONCAT(prefix, 'cdc_products');
SET @table_posts = CONCAT(prefix, 'posts');
SET @table_postmeta = CONCAT(prefix, 'postmeta');
SET @table_term_relationships = CONCAT(prefix, 'term_relationships');
SET @table_term_taxonomy = CONCAT(prefix, 'term_taxonomy');
SET @table_terms = CONCAT(prefix, 'terms');

-- MONTAGEM DO SQL QUE IRA EFETUAR A BUSCA PELOS DADOS ESTATICOS DOS PRODUTOS
SET @sql_query = CONCAT("INSERT INTO ", @table_cdc_products, " (
	`id`,`name`, `slug`, `excerpt`, `description`, `status`, `created_at`, `updated_at`, `sku`, `alcoholic_dosage`, `volume`,`supplier_id`, `thumbnail_id`, `type`, 
    `style`, `country`, `state`, `profile`, `transport_type`, `pasteurized`, `package`, `ibu`, `ideal_temperature`, `between`, 
    `harmonizing_suggestion`, `bar_code`, `quantity_box`, `dheight`, `diameter`, `sold_type`, `commercialize_on_kit`, 
    `approved_date_product`, `weight`, `length`, `width`, `height`, `marketed_by`, `image`
)
SELECT `products`.*, `postmeta`.`meta_value` AS `image_path` FROM (
	SELECT
		`p`.`id`, `p`.`name`, `p`.`slug`, `p`.`excerpt`,`p`.`description`, `p`.`status`, `p`.`created_at`, `p`.`updated_at`,
		MAX(CASE WHEN `pm`.`meta_key` = '_sku' THEN `pm`.`meta_value` END) AS `sku`,
		MAX(CASE WHEN `pm`.`meta_key` = '_alcoholic_dosage' THEN `pm`.`meta_value` END) AS `alcoholic_dosage`,
		MAX(CASE WHEN `pm`.`meta_key` = '_volume' THEN `pm`.`meta_value` END) AS `volume`,
		MAX(CASE WHEN `pm`.`meta_key` = '_supplier_id' THEN `pm`.`meta_value` END) AS `supplier_id`,
		MAX(CASE WHEN `pm`.`meta_key` = '_thumbnail_id' THEN `pm`.`meta_value` END) AS `thumbnail_id`,
		MAX(CASE WHEN `tt`.`taxonomy` = 'product_type' THEN `t`.`name` END) AS `product_type`,
		MAX(CASE WHEN `tt`.`taxonomy` = 'pa_por-estilo' THEN `t`.`name` END) AS `style`,
		MAX(CASE WHEN `tt`.`taxonomy` = 'pa_por-pais' THEN `t`.`name` END) AS `country`,
		MAX(CASE WHEN `tt`.`taxonomy` = 'pa_por-estado' THEN `t`.`name` END) AS `state`,
		GROUP_CONCAT(DISTINCT CASE WHEN `tt`.`taxonomy` = 'pa_por-perfil' THEN `t`.`name` END) AS `profile`,
		MAX(CASE WHEN `pm`.`meta_key` = '_transport_type' THEN `pm`.`meta_value` END) AS `transport_type`,
		MAX(CASE WHEN `pm`.`meta_key` = '_pasteurized' THEN `pm`.`meta_value` END) AS `pasteurized`,
		MAX(CASE WHEN `pm`.`meta_key` = '_package' THEN `pm`.`meta_value` END) AS `package`,
		MAX(CASE WHEN `pm`.`meta_key` = '_ibu' THEN `pm`.`meta_value` END) AS `ibu`,
		MAX(CASE WHEN `pm`.`meta_key` = '_ideal_temperature' THEN `pm`.`meta_value` END) AS `ideal_temperature`,
		MAX(CASE WHEN `pm`.`meta_key` = '_between' THEN `pm`.`meta_value` END) AS `between`,
		MAX(CASE WHEN `pm`.`meta_key` = '_harmonizing_suggestion' THEN `pm`.`meta_value` END) AS `harmonizing_suggestion`,
		MAX(CASE WHEN `pm`.`meta_key` = '_bar_code' THEN `pm`.`meta_value` END) AS `bar_code`,
		MAX(CASE WHEN `pm`.`meta_key` = '_quantity_box' THEN `pm`.`meta_value` END) AS `quantity_box`,
		MAX(CASE WHEN `pm`.`meta_key` = '_dheight' THEN `pm`.`meta_value` END) AS `dheight`,
		MAX(CASE WHEN `pm`.`meta_key` = '_diameter' THEN `pm`.`meta_value` END) AS `diameter`,
		MAX(CASE WHEN `pm`.`meta_key` = '_sold_type' THEN `pm`.`meta_value` END) AS `sold_type`,
		MAX(CASE WHEN `pm`.`meta_key` = '_commercialize_on_kit' THEN `pm`.`meta_value` END) AS `commercialize_on_kit`,
		MAX(CASE WHEN `pm`.`meta_key` = '_approved_date_product' THEN `pm`.`meta_value` END) AS `approved_date_product`,
		MAX(CASE WHEN `pm`.`meta_key` = '_weight' THEN `pm`.`meta_value` END) AS `weight`,
		MAX(CASE WHEN `pm`.`meta_key` = '_length' THEN `pm`.`meta_value` END) AS `length`,
		MAX(CASE WHEN `pm`.`meta_key` = '_width' THEN `pm`.`meta_value` END) AS `width`,
		MAX(CASE WHEN `pm`.`meta_key` = '_height' THEN `pm`.`meta_value` END) AS `height`,
		MAX(CASE WHEN `pm`.`meta_key` = '_marketed_by' THEN `pm`.`meta_value` END) AS `marketed_by`
	FROM
		(SELECT DISTINCT
			`p`.`ID` AS `id`,
			`p`.`post_title` AS `name`,
			`p`.`post_name` AS `slug`,
			`p`.`post_content` AS `description`,
			`p`.`post_excerpt` AS `excerpt`,
            `p`.`post_status` AS `status`,
            `p`.`post_date` AS `created_at`,
            `p`.`post_modified` AS `updated_at`
		FROM
			", @table_posts, " AS `p`
		LEFT JOIN ", @table_postmeta, " AS `pm` ON (`p`.`ID` = `pm`.`post_id`)
		LEFT JOIN ", @table_postmeta, " AS `pm1` ON (`p`.`ID` = `pm1`.`post_id` AND `pm1`.`meta_key` = '_supplier_certificate_expired')
		LEFT JOIN ", @table_postmeta, " AS `pm2` ON (`p`.`ID` = `pm2`.`post_id`)
		WHERE
			(`p`.`ID` NOT IN (SELECT `object_id` FROM ", @table_term_relationships, " WHERE `term_taxonomy_id` IN (356))) AND
			(`pm`.`meta_key` = '_stock_status' AND `pm`.`meta_value` = 'instock') AND
			(`pm1`.`post_id` IS NULL OR (`pm2`.`meta_key` = '_supplier_certificate_expired' AND `pm2`.`meta_value` != '1')) AND
			`p`.`post_type` = 'product' AND (`p`.`post_status` = 'publish') AND `p`.`ID` = ?
		GROUP BY `p`.`ID`) AS `p`
	LEFT JOIN ", @table_postmeta, " AS `pm` ON (`p`.`id` = `pm`.`post_id`)
	LEFT JOIN ", @table_term_relationships, " AS `tr` ON (`p`.`id` = `tr`.`object_id`)
	LEFT JOIN ", @table_term_taxonomy, " AS `tt` ON (`tr`.`term_taxonomy_id` = `tt`.`term_taxonomy_id`)
	LEFT JOIN ", @table_terms, " AS `t` ON (`tt`.`term_id` = `t`.`term_id`)
	GROUP BY `id`) AS `products` 
LEFT JOIN ", @table_postmeta, " AS `postmeta` ON (`products`.`thumbnail_id` = `postmeta`.`post_id` AND `postmeta`.`meta_key` = '_wp_attached_file')
ON DUPLICATE KEY UPDATE
    `name` = `products`.`name`,
    `slug` = `products`.`slug`,
    `excerpt` = `products`.`excerpt`,
    `description` =`products`.`description`,
    `sku` =`products`.`sku`,
    `alcoholic_dosage` =`products`.`alcoholic_dosage`,
    `volume` =`products`.`volume`,
    `supplier_id` =`products`.`supplier_id`,
    `thumbnail_id` =`products`.`thumbnail_id`,
    `type` =`products`.`product_type`,
    `style` =`products`.`style`,
    `country` =`products`.`country`,
    `state` =`products`.`state`,
    `profile` =`products`.`profile`,
    `transport_type` =`products`.`transport_type`,
    `pasteurized` =`products`.`pasteurized`,
    `package` =`products`.`package`,
    `ibu` =`products`.`ibu`,
    `ideal_temperature` =`products`.`ideal_temperature`,
    `between` =`products`.`between`,
    `harmonizing_suggestion` =`products`.`harmonizing_suggestion`,
    `bar_code` =`products`.`bar_code`,
    `quantity_box` =`products`.`quantity_box`,
    `dheight` =`products`.`dheight`,
    `diameter` =`products`.`diameter`,
    `sold_type` = `products`.`sold_type`,
    `commercialize_on_kit` = `products`.`commercialize_on_kit`,
    `approved_date_product` = `products`.`approved_date_product`,
    `weight` = `products`.`weight`,
    `length` = `products`.`length`,
    `width` = `products`.`width`,
    `height` = `products`.`height`,
    `marketed_by` = `products`.`marketed_by`,
    `status`	= `products`.`status`,
    `created_at` = `products`.`created_at`,
    `updated_at` = `products`.`updated_at`,
    `image` = `postmeta`.`meta_value`;");

PREPARE stmt FROM @sql_query;
EXECUTE stmt USING @product_id;
DEALLOCATE PREPARE stmt;

END //
DELIMITER ;