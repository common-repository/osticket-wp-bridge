<?php
$topic_opt = $ost_wpdb->get_results("SELECT topic_id,dept_id, topic FROM $topic_table");
$pri_opt = $ost_wpdb->get_results("SELECT priority_desc,priority_id FROM $priority_table");
if($version!="17") { 
require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/includes/version18.php' ); 
} else { 
require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/includes/version17.php' ); 
} 
?>