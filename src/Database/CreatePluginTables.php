<?php
namespace WPLaravel\Database;

class CreatePluginTables
{
    public function up()
    {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        // Crear tabla de ejemplos
        $table_name = $wpdb->prefix . 'wp_laravel_examples';
        
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            content longtext,
            status varchar(50) NOT NULL DEFAULT 'active',
            meta_data longtext,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY status (status)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    public function down()
    {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'wp_laravel_examples';
        $wpdb->query("DROP TABLE IF EXISTS $table_name");
    }
}
