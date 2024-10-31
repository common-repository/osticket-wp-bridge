<?php
/*
Plugin Name: osTicket WP Bridge
Plugin URI: http://osticket-wp-bridge.a1-9.com
Description: Integrate osTicket (v1.7+) or (v1.8.1) into wordpress with our easy to use plugin bridge.
Version: 1.9.2
Author: Michael Bath
Author URI: http://a1-9.com
License: GPLv3
*/
?>
<?php
/*
Copyright (C) 2014  Michael Bath

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see http://www.gnu.org/licenses/
*/
?>
<?php
add_action('admin_menu', 'mb_admin_menu');
add_action('admin_head', 'mb_admin_css');

register_activation_hook(__FILE__,'mb_install');
register_uninstall_hook(__FILE__,'mb_uninstall');

register_activation_hook(__FILE__,'mb_table_install');
register_activation_hook(__FILE__,'mb_database_install');

function mb_settings_link($actions, $file) {
if(false !== strpos($file, 'ost-bridge'))
    $actions['settings'] = '<a href="admin.php?page=ost-config">Config</a>';
return $actions; 
}
add_filter('plugin_action_links', 'mb_settings_link', 2, 2);

function mb_admin_menu() { 
    $page_title = 'osTicket Configuration';
    $menu_title = 'osTicket';
    $capability = 'manage_options';
    $menu_slug = 'ost-config';
    $function = 'ost_config_page';
    $icon_url = plugin_dir_url( __FILE__ ) . 'images/status.png';
    $position = '33';
    add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);

    $sub_menu_title = 'osT-Config';
    add_submenu_page($menu_slug, $page_title, $sub_menu_title, $capability, $menu_slug, $function);

    $submenu_page_title = 'osTicket Settings';
    $submenu_title = 'osT-Settings';
    $submenu_slug = 'ost-settings';
    $submenu_function = 'ost_settings_page';
    add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, $submenu_function);

    $submenu_page_title = 'osTicket Email Templates';
    $submenu_title = 'Email Templates';
    $submenu_slug = 'ost-emailtemp';
    $submenu_function = 'ost_emailtemp_page';
    add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, $submenu_function);

    $submenu_page_title = 'osTicket - Support/Request List';
    $submenu_title = 'Support Tickets';
    $submenu_slug = 'ost-tickets';
    $submenu_function = 'ost_tickets_page';
    add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, $submenu_function); 
} 

function mb_admin_css() {
echo '<link rel="stylesheet" type="text/css" media="all" href="'.plugin_dir_url(__FILE__).'css/admin-style.css">';
}

function mb_install()
{
$host='localhost';
$database='';
$username='';
$password='';
$supportpage='Support';
$version='18';

$config=array('host'=>$host,'database'=>$database,'username'=>$username,'password'=>$password,'supportpage'=>$supportpage,'version'=>$version);
update_option( 'os_ticket_config', $config);
}

function mb_table_install() {
global $wpdb;
$table_name = $wpdb->prefix . "ost_emailtemp"; 
   
$sql = "CREATE TABLE $table_name (
id mediumint(9) NOT NULL AUTO_INCREMENT,
name varchar(32) NOT NULL,
subject varchar(255) NOT NULL DEFAULT '',
text text NOT NULL,
created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
updated datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
UNIQUE KEY id (id)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
}

function mb_database_install() {
   global $wpdb;
   $table_name = $wpdb->prefix . "ost_emailtemp";
   $id = '1';
   $name = "Admin-Response";
   $subject = "Ticket ID [#\$ticketid]";
   $text = "";
   $rows_affected = $wpdb->insert( 
   $table_name, 
   array(
   'id' => $id, 
   'name' => $name,
   'subject' => $subject,
   'text' => $text,
   'created' => current_time('mysql'), 
   'updated' => current_time('mysql') 
   ) );
   $id = '2';
   $name = "New-Ticket";
   $subject = "Ticket ID [#\$ticketid]";
   $text = "";
   $rows_affected = $wpdb->insert( 
   $table_name, 
   array( 
   'id' => $id,
   'name' => $name,
   'subject' => $subject,
   'text' => $text,
   'created' => current_time('mysql'), 
   'updated' => current_time('mysql') 
   ) ); 
   $id = '3';
   $name = "Post-Confirmation";
   $subject = "Ticket ID [#\$ticketid]";
   $text = "";
   $rows_affected = $wpdb->insert( 
   $table_name, 
   array( 
   'id' => $id,
   'name' => $name,
   'subject' => $subject,
   'text' => $text,
   'created' => current_time('mysql'), 
   'updated' => current_time('mysql') 
   ) ); 
}
function mb_uninstall() 
{
    delete_option('os_ticket_config');
    global $wpdb;
    $table = $wpdb->prefix."ost_emailtemp";
    $wpdb->query("DROP TABLE IF EXISTS $table");
}

function ost_config_page() {
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/admin/ost-config.php' );
}

add_filter( 'page_template', 'new_page_template' );

function new_page_template( $page_template ) {
    $config = get_option('os_ticket_config');
    if ( is_page( $config['supportpage'] ) ) {
    $page_template = dirname( __FILE__ ) . '/osticket-wp.php';
    }
    return $page_template;
}

function ost_settings_page() {
$config = get_option('os_ticket_config');
extract($config);
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    if (($database=="") || ($username=="") || ($password==""))
    {
    echo "<div class='headtitleerror'>osTicket Settings</div><div id='message' class='error'>" . __( '<p><b>Error:</b> You must complete "osTicket Data Configure" before this page will display... <a href="admin.php?page=ost-config">click here</a></p>', 'ost-menu' ) . "</div>";
    } else {
    require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/admin/ost-settings.php' );
    }
}

function ost_emailtemp_page() {
$config = get_option('os_ticket_config');
extract($config);
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    if (($database=="") || ($username=="") || ($password==""))
    {
    echo "<div class='headtitleerror'>osTicket Email Templates</div><div id='message' class='error'>" . __( '<p><b>Error:</b> You must complete "osTicket Data Configure" before this page will display... <a href="admin.php?page=ost-config">click here</a></p>', 'ost-menu' ) . "</div>";
    } else {
    require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/admin/ost-emailtemp.php' );
    }
}

function ost_tickets_page() {
$config = get_option('os_ticket_config');
extract($config);
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    if (($database=="") || ($username=="") || ($password==""))
    {
    echo "<div class='headtitleerror'>osTicket - Support/Request List</div><div id='message' class='error'>" . __( '<p><b>Error:</b> You must complete "osTicket Data Configure" before this page will display... <a href="admin.php?page=ost-config">click here</a></p>', 'ost-menu' ) . "</div>";
    } else { 
    if(isset($_REQUEST['service']) && $_REQUEST['service']=='view') 
    { 
    require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/admin/ost-ticketview.php' );
    } else { 
    require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/admin/ost-tickets.php' );
    }
  }
}
?>