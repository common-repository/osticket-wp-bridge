<?php
/*
Template Name: db-settings-18
*/
?>
<?php 
# ==============================================================================================
# Connect to the database for the Email Templates - used in ost-emailtemp & ost-postreplymail
# ==============================================================================================
global $wpdb; 
$ostemail = $wpdb->prefix . "ost_emailtemp"; 
$adminreply=$wpdb->get_row("SELECT id,name,subject,$ostemail.text,created,updated FROM $ostemail where name = 'Admin-Response'"); 
$adminreply=$adminreply->text;
$arname='Admin-Response';

$postsubmail=$wpdb->get_row("SELECT id,name,$ostemail.subject,text,created,updated FROM $ostemail where name = 'Admin-Response'"); 
$postsubmail=$postsubmail->subject;

$newticket=$wpdb->get_row("SELECT id,name,subject,$ostemail.text,created,updated FROM $ostemail where name = 'New-Ticket'"); 
$newticket=$newticket->text; 
$ntname='New-Ticket';

$postconfirm=$wpdb->get_row("SELECT id,name,$ostemail.subject,$ostemail.text,created,updated FROM $ostemail where name = 'Post-Confirmation'"); 
$postconfirm=$postconfirm->text; 
$pcname='Post-Confirmation';

$poconsubmail=$wpdb->get_row("SELECT id,name,$ostemail.subject,text,created,updated FROM $ostemail where name = 'Post-Confirmation'"); 
$poconsubmail=$poconsubmail->subject;

# ==============================================================================================
# Open os_ticket_config in wp_options so we can connect to osTicket v1.8+
# ==============================================================================================
$config = get_option('os_ticket_config');
extract($config);
$ost_wpdb = new wpdb($username, $password, $database, $host);
global $ost;
$config_table="ost_config";
$dept_table="ost_department";
$topic_table="ost_help_topic";
$email_temp_table="ost_email_template";
$ticket_table="ost_ticket";
$ticket_event_table="ost_ticket_event";
$thread_table="ost_ticket_thread";
$priority_table="ost_ticket_priority";
$ticket_cdata="ost_ticket__cdata";
$staff_table="ost_staff";
$ost_user="ost_user";
$ost_useremail="ost_user_email";
$directory=$config['supportpage'];
$dirname = strtolower($directory);
$version=$config['version'];
$category=@$_GET['cat'];
$status_opt=@$_GET['status'];
$ticket=@$_GET['ticket'];

# ==============================================================================================
# Changed (id) -> (like) so we search for text in v1.8+
# ==============================================================================================
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

$admin_info=$ost_wpdb->get_row("SELECT firstname,lastname FROM $staff_table WHERE staff_id = 1");
$admin_fname=$admin_info->firstname;
$admin_lname=$admin_info->lastname;

$id_hidename=$ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%hide_staff_name%');");
$hidename=$ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id = $id_hidename");
$hidename=$hidename->value;

$id_replysep=$ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%reply_separator%');");
$reply_sep=$ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id = $id_replysep");
$reply_sep=$reply_sep->value;

$id_ticketreply=$ost_wpdb->get_var("SELECT id FROM $email_temp_table WHERE $email_temp_table.code_name like ('%ticket.reply%');");
$ticketreply=$ost_wpdb->get_row("SELECT id,tpl_id,code_name,subject,body,notes,created,updated FROM $email_temp_table where id = $id_ticketreply");
$ticketreply=$ticketreply->body;

# ==============================================================================================
# Collecting info needed for ticket count & search box
# ==============================================================================================
$ticket_count_all = $ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table ORDER BY ticket_id DESC");
$ticket_count_open = $ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table WHERE status='open'");
$ticket_count_closed = $ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table WHERE status='closed'");

# ==============================================================================================
# Collecting info for threads listed in ost-ticketview
# ==============================================================================================
$ticketinfo=$ost_wpdb->get_row("
	SELECT number,$ticket_table.user_id,$priority_table.priority_desc,status,$ticket_cdata.subject,$dept_table.dept_name,$ost_user.name,$ost_useremail.address,$ticket_table.created,$ticket_table.topic_id,$topic_table.topic 
	FROM $ticket_table 
	inner join $dept_table on $dept_table.dept_id = $ticket_table.dept_id 
	inner join $priority_table on $priority_table.priority_desc = $priority_table.priority_desc 
	inner join $ticket_cdata on $ticket_cdata.subject = $ticket_cdata.subject and $ticket_cdata.ticket_id=$ticket_table.ticket_id 
	inner join $ost_user on $ost_user.name = $ost_user.name and $ticket_table.user_id=$ost_user.id 
	inner join $ost_useremail on $ost_useremail.address = $ost_useremail.address and $ticket_table.user_id=$ost_useremail.user_id 
	inner join $topic_table on $topic_table.topic_id = $ticket_table.topic_id 
	where number = '$ticket'");

$threadinfo=$ost_wpdb->get_results("
	SELECT $thread_table.created,$thread_table.id,$thread_table.ticket_id,$thread_table.thread_type,body,poster 
	FROM $thread_table 
	inner join $ticket_table on $thread_table.ticket_id = $ticket_table.ticket_id 
	where number = '$ticket' 
	ORDER BY  $thread_table.id ASC");

$pri_opt = $ost_wpdb->get_results("SELECT priority_desc,priority_id FROM $priority_table");

# ==============================================================================================
# Searching for tickets to diplay in ost-tickets
# ==============================================================================================
if(isset($_REQUEST['search']))
{
$search=@$_REQUEST['tq'];
}
if(isset($_POST['action']))
$arr = explode('.', $_POST['action']);
$sql="
	SELECT $ticket_table.topic_id,number,$ticket_table.user_id,$ticket_cdata.subject,status,$topic_table.topic,$ticket_table.created,$ticket_table.updated,$thread_table.poster 
	FROM $ticket_table 
	inner join $ticket_cdata on $ticket_cdata.subject = $ticket_cdata.subject and $ticket_cdata.ticket_id=$ticket_table.ticket_id 
	inner join $ost_useremail on $ost_useremail.user_id = $ticket_table.user_id and $ost_useremail.address = $ost_useremail.address 
	inner join $topic_table on $topic_table.topic_id = $ticket_table.topic_id 
	left join $thread_table on ($thread_table.ticket_id = $ticket_table.ticket_id and $thread_table.thread_type='R') 
	where 1";
if($category && ($category!="all"))
$sql.=" and $topic_table.topic_id = '".$category."'";
if($status_opt && ($status_opt!="all"))
$sql.=" and $ticket_table.status = '".$status_opt."'";
if(@$search && ($search!=""))
$sql.=" and ($ticket_table.number like '%".$search."%' or $ticket_table.status like '%".$search."%' or $ticket_cdata.subject like '%".$search."%' or $topic_table.topic like '%".$search."%')";
$sql.=" GROUP BY $ticket_table.ticket_id";  
if(isset($_POST['action']) && $arr[0]=='ascen')
$sql.=" ORDER BY $arr[1] ASC, $ticket_table.created ASC";
else if(isset($_POST['action']) && $arr[0]=='desc')
$sql.=" ORDER BY $arr[1] DESC, $ticket_table.created DESC";
else
$sql.=" ORDER BY $ticket_table.ticket_id DESC";
@$numrows=mysql_num_rows(mysql_query($sql));
$rowsperpage = 7;
$totalpages = ceil($numrows / $rowsperpage);
if (isset($_REQUEST['currentpage']) && is_numeric($_REQUEST['currentpage'])) {
$currentpage = (int) $_GET['currentpage'];
} else {
$currentpage = 1;
}
if ($currentpage > $totalpages) {
$currentpage = $totalpages;
}
if ($currentpage < 1) {
$currentpage = 1;
}
$offset = ($currentpage - 1) * $rowsperpage;
$sql.=" LIMIT $offset, $rowsperpage";
$list_opt = $ost_wpdb->get_results($sql);

# ==============================================================================================
# Update Database - osT-Settings
# ==============================================================================================
if(isset($_REQUEST['ost-settings'])) { 
$online=$_POST['online'];
$title_name=$_POST['title_name'];
$max_open_tickets=$_POST['max_open_tickets'];
$reply_sep=$_POST['reply_sep'];
$hidename=$_POST['hidename'];
$admin_email=$_POST['admin_email'];
$admin_fname=$_POST['admin_fname'];
$admin_lname=$_POST['admin_lname'];
$adfullname=$_POST['adname'];
$ost_wpdb->update($config_table, array('value'=>$online), array('id'=>$id_isonline), array('%d'));
$ost_wpdb->update($config_table, array('value'=>$title_name), array('id'=>$id_helptitle), array('%s'));
$ost_wpdb->update($config_table, array('value'=>$max_open_tickets), array('id'=>$id_maxopen), array('%d'));
$ost_wpdb->update($config_table, array('value'=>$admin_email), array('id'=>$id_ademail), array('%s'));
$ost_wpdb->update($config_table, array('value'=>$reply_sep), array('id'=>$id_replysep), array('%s'));
$ost_wpdb->update($config_table, array('value'=>$hidename), array('id'=>$id_hidename), array('%d'));
$ost_wpdb->update($staff_table, array('firstname'=>$admin_fname), array('staff_id'=>1), array('%s'));
$ost_wpdb->update($staff_table, array('lastname'=>$admin_lname), array('staff_id'=>1), array('%s'));
$ost_wpdb->update($ost_user, array('name'=>$adfullname), array('id'=>1), array('%s'));
$ost_wpdb->update($ost_useremail, array('address'=>$admin_email), array('user_id'=>1), array('%s'));
?>
<p align="center"><i>Stand by while your <font color="green"><b>osTicket Settings</b></font> are being updated...</i><br /><center><script language="javascript" src="<?php echo plugin_dir_url(__FILE__).'../js/adminTB-sett.js';?>"></script></center></p>
<?php } ?>

<?php 
# ==============================================================================================
# Admin Post To Ticket Thread - used in ost-ticketveiw
# ==============================================================================================
if(isset($_REQUEST['ost-post-reply'])) { 
	if (($_REQUEST['message']==""))
	{
	echo '<div id="failed"><b>Error:</b> Message field cannot be empty, if you are closing the ticket, then enter: "Closing Ticket" in post a reply.</div><div style="clear: both"></div>';
	} else {
	require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/admin/ost-postreplymail.php' );
?>
<div id="succes" class="fade"><?php echo "Thread updated successfully...Stand by: for auto refresh!";?></div>
<div style="clear: both"></div>
<script type="text/javascript" charset="utf-8">
  window.setTimeout(function() {
    parent.location = "admin.php?page=ost-tickets&service=view&ticket=<?php echo $ticketinfo->number; ?>";
  }, 5050);
</script>
<?php } } ?>

<?php 
# ==============================================================================================
# Admin Post To Ticket Email Template w/message included - used in ost-emailtemp
# ==============================================================================================
require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/includes/functions.php' );
if(isset($_REQUEST['ost-admin-reply'])) { 
$form_admintreply=Format::stripslashes($_POST['form_admintreply']);
$etdate=date("Y-m-d, g:i:s");
$wpdb->update($ostemail, array('text'=>$form_admintreply,'updated'=>$etdate), array('name'=>$arname), array('%s'));
?>
<p align="center"><i>Stand by while your <font color="green"><b>Admin Response Email</b></font> is being updated...</i><br /><center><script language="javascript" src="<?php echo plugin_dir_url(__FILE__).'../js/adminTB-email.js';?>"></script></center></p>
<?php } ?>

<?php 
# ==============================================================================================
# New Ticket Email Template - sent to user w/message included - used in ost-emailtemp
# ============================================================================================== 
require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/includes/functions.php' );
if(isset($_REQUEST['ost-new-ticket'])) { 
$form_newticket=Format::stripslashes($_POST['form_newticket']);
$etdate=date("Y-m-d, g:i:s");
$wpdb->update($ostemail, array('text'=>$form_newticket,'updated'=>$etdate), array('name'=>$ntname), array('%s'));
?>
<p align="center"><i>Stand by while your <font color="green"><b>New Ticket Email</b></font> is being updated...</i><br /><center><script language="javascript" src="<?php echo plugin_dir_url(__FILE__).'../js/adminTB-email.js';?>"></script></center></p>
<?php } ?>

<?php 
# ==============================================================================================
# Post Confirmation Email Template - sent to user w/message included - used in ost-emailtemp
# ============================================================================================== 
require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/includes/functions.php' );
if(isset($_REQUEST['ost-post-confirmed'])) { 
$form_postconfirmed=Format::stripslashes($_POST['form_postconfirmed']);
$etdate=date("Y-m-d, g:i:s");
$wpdb->update($ostemail, array('text'=>$form_postconfirmed,'updated'=>$etdate), array('name'=>$pcname), array('%s'));
?>
<p align="center"><i>Stand by while your <font color="green"><b>User Post Confirmation Email</b></font> is being updated...</i><br /><center><script language="javascript" src="<?php echo plugin_dir_url(__FILE__).'../js/adminTB-email.js';?>"></script></center></p>
<?php } ?>