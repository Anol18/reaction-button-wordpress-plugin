<?php
    if(!defined('WP_UNINSTALL_PLUGIN')){
        header("Location: /");
        die();
    }

    global $wpdb, $table_prefix;

    $wp_reaction_table = $table_prefix.'reaction';

    $sql = "DROP TABLE `$wp_reaction_table`;";

    $wpdb->query($dql);
?>