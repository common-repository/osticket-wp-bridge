<?php
/*
Template Name: osticket-wp.php
*/
?>
<?php 
$config = get_option('os_ticket_config');
extract($config);
require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/includes/titles.php' ); 
require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/templates/header.php' );
?>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo plugin_dir_url(__FILE__).'css/style.css'; ?>" />
<div id="ost_container"><!--ost_container Start-->
<?php require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/includes/functions.php' ); ?>
<?php
global $wpdb;
$ostemail = $wpdb->prefix . "ost_emailtemp"; 
$newticket=$wpdb->get_row("SELECT id,name,$ostemail.subject,$ostemail.text,created,updated FROM $ostemail where name = 'New-Ticket'"); 
$newticket=$newticket->text;

$postsubmail=$wpdb->get_row("SELECT id,name,$ostemail.subject,text,created,updated FROM $ostemail where name = 'New-Ticket'"); 
$postsubmail=$postsubmail->subject; 

$postconfirm=$wpdb->get_row("SELECT id,name,$ostemail.subject,$ostemail.text,created,updated FROM $ostemail where name = 'Post-Confirmation'"); 
$postconfirm=$postconfirm->text; 
$pcname='Post-Confirmation';

$poconsubmail=$wpdb->get_row("SELECT id,name,$ostemail.subject,text,created,updated FROM $ostemail where name = 'Post-Confirmation'"); 
$poconsubmail=$poconsubmail->subject;

$ost_wpdb = new wpdb($username, $password, $database, $host);
global $current_user;
$config_table="ost_config";
$dept_table="ost_department";
$topic_table="ost_help_topic";
$ticket_table="ost_ticket";
$ticket_event_table="ost_ticket_event";
$priority_table="ost_ticket_priority";
$thread_table="ost_ticket_thread";
$ticket_cdata="ost_ticket__cdata";
$ost_user="ost_user";
$ost_useremail="ost_user_email";
$directory=$config['supportpage'];
$dirname = strtolower($directory);
$version=$config['version'];
$category=@$_GET['cat'];
$status_opt=@$_GET['status'];
$ticket=@$_GET['ticket'];
$parurl=$_SERVER['QUERY_STRING'];
get_currentuserinfo();
$user_email=$current_user->user_email;

$id_isonline=$ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%isonline%');");
$isactive=$ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id = $id_isonline");
$isactive=$isactive->value;

$id_helptitle=$ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%helpdesk_title%');");
$title_name=$ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id = $id_helptitle");
$title_name=$title_name->value;

$id_maxopen=$ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%max_open_tickets%');");
$max_open_tickets=$ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id = $id_maxopen");
$max_open_tickets=$max_open_tickets->value;

$id_ademail=$ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%admin_email%');");
$admin_email=$ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id = $id_ademail");
$admin_email=$admin_email->value;

$id_hidename=$ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%hide_staff_name%');");
$hidename=$ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id = $id_hidename");
$hidename=$hidename->value;

if($isactive!=1) { 
include WP_PLUGIN_DIR . '/osticket-wp-bridge/templates/message.php';
echo $offline; 
} else { 
if(isset($_REQUEST['post-reply'])) { 
require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/includes/postreplymail.php');
}
if(isset($_REQUEST['create-ticket'])) { 
require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/includes/newticketmail.php'); 
} 
if($parurl=="") { 
require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/templates/welcome.php'); 
} elseif (is_user_logged_in()) { 
require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/includes/versionData.php'); 
{
require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/templates/nav_bar.php'); 
}
if(isset($_GET['service']) && $_GET['service']=='new') { 
if($max_open_tickets==0 or $getNumOpenTickets<$max_open_tickets) { 
require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/templates/new_ticket.php'); 
} elseif ($getNumOpenTickets==$max_open_tickets) { 
include WP_PLUGIN_DIR . '/osticket-wp-bridge/templates/message.php'; 
echo $warning1; 
} elseif ($getNumOpenTickets>$max_open_tickets) { 
include WP_PLUGIN_DIR . '/osticket-wp-bridge/templates/message.php'; 
echo $warning2; 
} } 
if(isset($_GET['service']) && $_GET['service']=='view') { 
require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/templates/view_ticket.php'); 
} elseif (isset($_REQUEST['service']) && $_REQUEST['service']=='list') { 
require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/templates/list_tickets.php'); 
require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/templates/pagination.php'); 
} } else { 
require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/templates/nav_bar.php'); 
require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/templates/login.php'); 
} } 
?>
</div><!--ost_container End-->
<?php require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/templates/footer.php' ); ?>