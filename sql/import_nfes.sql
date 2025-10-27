 DELIMITER $$
    CREATE PROCEDURE import_nfes()
    BEGIN
      INSERT INTO {$wpdb->prefix}nfes (order_id, nfe) 
      SELECT ID, meta_value FROM wp_posts INNER JOIN {$wpdb->prefix}postmeta ON ID = post_id
      WHERE post_type = 'shop_order' AND meta_key = 'nfe';
    END$$
DELIMITER ;